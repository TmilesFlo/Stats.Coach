<?php
/**
 * Created by IntelliJ IDEA.
 * User: Miles
 * Date: 7/21/17
 * Time: 1:24 PM
 */

namespace Model;


use Model\Helpers\GlobalMap;
use CarbonPHP\Helpers\Bcrypt;
use Tables\carbon_photos as Photos;
use Tables\carbon_teams as Teams;
use Tables\carbon_users as Users;
use Tables\carbon_team_members as TeamMembers;
use CarbonPHP\Error\PublicAlert;
use CarbonPHP\Singleton;

class Team extends GlobalMap
{
    use Singleton;

    /**
     * @param string $teamIdentifier
     * @return bool
     * @throws \RuntimeException
     * @throws \CarbonPHP\Error\PublicAlert
     */
    public function team(string $team_id)
    {
        global $json;

        $this->team[$team_id] = [];


        $json['myTeam'] = &$this->team[$team_id];

        if (!Teams::get($this->team[$team_id], $team_id, [])
            || empty($this->team[$team_id])) {
            PublicAlert::warning('Failed to lookup team id.');
            return startApplication( 'Home/' );
        }

        $json['imTheCoach'] = $_SESSION['id'] === $json['myTeam']['team_coach'];

        $json['myTeam']['members']=[];

        if(!TeamMembers::get($json['myTeam']['members'], null, [
            'where' => [
                'team_id' => $team_id
            ]
        ])) {
            PublicAlert::danger('Failed to lookup team members.');
            return startApplication( 'Home/' );
        }

        $json['members'] = count($json['myTeam']['members']);

        $json['rounds'] = 2;

       // sortDump($json);
        $json['imTheCoach'] = $_SESSION['id'];

        //sortDump($json);
        /*$rounds = $tournaments = $strokes = $FFS = $GIR = $putts = 0;

        foreach ($myTeam['members'] as $an => $id) {
            $an = $this->user[$id]['stats'] ?? false;
            if (!$an) continue;
            $rounds += $an['stats_rounds'];
            $tournaments += $an['stats_tournaments'];
            $strokes += $an['stats_strokes'];
            $FFS = $an['stats_ffs'];
            $GIR = $an['stats_gnr'];
            $putts = $an['stats_putts'];
        }*/


        /*if (($team_photo ?? false ) && $team['team_coach'] == $_SESSION['id']) {
            // unlink( $team->photo_path ); TODO - Delete photo from db
            Photos::add( $team, $team_id, [
                'photo_path' => "$team_photo",
                'photo_description' => "profile pic"] );
        }

        if (isset( $this->user[$this->team[$team_id]['team_coach']] )) {
            return true;
        }

        if ($team['team_coach'] === null) {
            throw new \RuntimeException( 'Why is there no coach?' );
        }*/

        // Users::Get( $this->user[$team['team_coach']], $team['team_coach'] );

        return true;
    }


    /**
     * @param $teamName
     * @param null $schoolName
     * @throws PublicAlert
     */
    public function createTeam($teamName, $schoolName = null)
    {
        if (!Teams::Post([
            'team_name' => $teamName,
            'team_school'=> $schoolName,
            'team_coach' => $_SESSION['id'],
            'team_code' => Bcrypt::genRandomHex( 20 )
        ])) {
            throw new PublicAlert( 'Sorry, we we\'re unable to create your team at this time.' );
        }

        $return = [];

        if (!Users::Put($return, $_SESSION['id'], [
            'user_type' => 'Coach'
        ])) {
            throw new PublicAlert('Sorry, we we\'re unable to create your team at this time.');
        }

        self::commit();

        PublicAlert::success( "We successfully created `$teamName`!" );

        return startApplication(true);
    }

    /**
     * @param $teamCode
     * @throws PublicAlert
     */
    public function joinTeam($teamCode)
    {
        $team = [];

        if (!Teams::get($team, null, [
            'where' => [
                'team_code' => $teamCode
            ],
            'pagination' => [
                'limit' => 1
            ]
        ])) {
            throw new PublicAlert( 'We failed to lookup the team. Please try again later.', 'warning' );
        }

        if (empty($team)) {
            throw new PublicAlert( 'The team code you provided appears to be invalid.', 'warning' );
        }

        $member = [];

        if (!TeamMembers::get($member, null, [
            'where' => [
                'team_id' => $team['team_id'],
                'user_id' => $_SESSION['id'],
                'accepted' => 0
            ]
        ])) {
            throw new PublicAlert('We failed to lookup the membership history. Please try again later.', 'danger');
        }

        if (!empty($member)) {
            throw new PublicAlert( 'It appears you are already a member of this team.', 'warning' );
        }

        if (!TeamMembers::Post([
            'user_id' => $_SESSION['id'],
            'team_id' => $team['team_id']
        ])) {
            throw new PublicAlert('Failed to update team status. Please try again later.', 'danger');
        }

        self::commit();

        PublicAlert::success( 'We successfully add you!' );

        return startApplication( true );
    }
}