<?php

namespace Depotwarehouse\OAuth2\Client\Entity;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class WowUser implements ResourceOwnerInterface
{

    /**
     * An array representation of the data received about the WoW character.
     * @var array $data
     */
    private $img_url;
    public $data;

    public function __construct(array $attributes, $region)
    {
        $this->img_url = "http://render-api-{$region}.worldofwarcraft.com/static-render/{$region}/";
        $this->img_baseurl = "http://{$region}.battle.net/wow/static/images/2d/avatar/";
        
        
        $this->data = $attributes;
        if(!$this->data) return;
        
        foreach($this->data as $index=>$char)
        {
            if($this->data[$index]['level'] >= 10)
            {
                $this->data[$index]['thumbnail'] = $this->img_url.$char['thumbnail'];
            }
            else
            {
                $this->data[$index]['thumbnail'] = $this->img_baseurl.$char['race'].'-'.$char['gender'].'.jpg';
            }
        }
    }

    public function toArray()
    {
        return $this->data;
    }

    public function getId()
    {
        return $this->data[0]['id'];
    }
}
