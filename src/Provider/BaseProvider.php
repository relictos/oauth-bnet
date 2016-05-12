<?php

namespace Depotwarehouse\OAuth2\Client\Provider;

use Depotwarehouse\OAuth2\Client\Entity\BasicUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;

class BaseProvider extends BattleNet
{

    protected $game = "sc2";

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        $locale = \Session::get('locale');
        return "https://{$this->region}.api.battle.net/account/user?access_token={$token}&locale={$locale}";
    }

    protected function createResourceOwner(array $response, AccessToken $token)
    {
        $response = (array)($response);

        $user = new BasicUser($response, $this->region);

        return $user;
    }


}