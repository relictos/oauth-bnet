<?php

namespace Depotwarehouse\OAuth2\Client\Entity;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class SC2User implements ResourceOwnerInterface
{

    public $id;
    public $realm;
    public $name;
    public $display_name;
    public $clan_name;
    public $clan_tag;
    public $profile_url;
    public $race;
    public $league;
    public $terran_wins;
    public $protoss_wins;
    public $zerg_wins;
    public $season_total_games;
    public $highest_league;
    public $career_total_games;
    public $portrait_url;

    public function __construct(array $attributes, $region)
    {
        $this->id = $attributes['id'];
        $this->realm = $attributes['realm'];
        $this->name = $attributes['name'];
        $this->display_name = $attributes['displayName'];
        $this->clan_name = (isset($attributes['clanName'])) ? $attributes['clanName'] : null;
        $this->clan_tag = (isset($attributes['clanTag'])) ? $attributes['clanTag'] : null;
        $this->profile_url = "http://{$region}.battle.net/sc2{$attributes['profilePath']}";
        
        $achievements = (is_object($attributes['achievements'])) ? (array)$attributes['achievements'] : $attributes['achievements']; 
        $this->achievement_points = (isset($achievements['points'])) ? $achievements['points']['totalPoints'] : null;
        
        $levels =  (is_object($attributes['swarmLevels'])) ? (array)$attributes['swarmLevels'] : $attributes['swarmLevels']; 
        $this->level = (isset($levels['level'])) ? $levels['level'] : null; 
        
        // Portrait URL links to a sheet of portraits, so we construct the proper one.
        if (isset($attributes['avatar'])) {
            $this->portrait_url = $attributes['avatar']['url'];
        }

        if (isset($attributes['career'])) {
            $career = (is_object($attributes['career'])) ? (array)$attributes['career'] : $attributes['career'];
            $this->race = (isset($career['primaryRace'])) ? $career['primaryRace'] : null;
            $this->league = (isset($career['league'])) ? $career['league'] : null;
            $this->terran_wins = (isset($career['terranWins'])) ? $career['terranWins'] : null;
            $this->protoss_wins = (isset($career['protossWins'])) ? $career['protossWins'] : null;
            $this->zerg_wins = (isset($career['zergWins'])) ? $career['zergWins'] : null;
            $this->highest_league = (isset($career['highest1v1Rank'])) ? $career['highest1v1Rank'] : null;
            $this->season_total_games = (isset($career['seasonTotalGames'])) ? $career['seasonTotalGames'] : null;
            $this->career_total_games = (isset($career['careerTotalGames'])) ? $career['careerTotalGames'] : null;
        }
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'realm' => $this->realm,
            'name' => $this->name,
            'display_name' => $this->display_name,
            'clan_name' => $this->clan_name,
            'clan_tag' => $this->clan_tag,
            'profile_url' => $this->profile_url,
        ];
    }
    public function getId()
    {
        return $this->id;
    }
}
