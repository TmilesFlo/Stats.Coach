<?php
namespace Table;


use CarbonPHP\Database;
use CarbonPHP\Entities;
use CarbonPHP\Interfaces\iRest;

class carbon_teams extends Entities implements iRest
{
    const PRIMARY = [
    'team_id',
    ];

    const COLUMNS = [
    'team_id','team_coach','parent_team','team_code','team_name','team_rank','team_sport','team_division','team_school','team_district','team_membership','team_photo',
    ];

    const VALIDATION = [];

    const BINARY = [
    'team_id','team_coach','parent_team','team_photo',
    ];

    /**
     * @param array $return
     * @param string|null $primary
     * @param array $argv
     * @return bool
     */
    public static function Get(array &$return, string $primary = null, array $argv) : bool
    {
        $get = isset($argv['select']) ? $argv['select'] : self::COLUMNS;
        $where = isset($argv['where']) ? $argv['where'] : [];

        $group = $sql = '';

        if (isset($argv['pagination'])) {
            if (!empty($argv['pagination']) && !is_array($argv['pagination'])) {
                $argv['pagination'] = json_decode($argv['pagination'], true);
            }
            if (isset($argv['pagination']['limit']) && $argv['pagination']['limit'] != null) {
                $pos = strrpos($argv['pagination']['limit'], "><");
                if ($pos !== false) { // note: three equal signs
                    substr_replace($argv['pagination']['limit'],',',$pos, 2);
                }
                $limit = ' LIMIT ' . $argv['pagination']['limit'];
            } else {
                $limit = '';
            }
        } else {
            $limit = ' LIMIT 100';
        }

        foreach($get as $key => $column){
            if (!empty($sql)) {
                $sql .= ', ';
                $group .= ', ';
            }
            if (in_array($column, self::BINARY)) {
                $sql .= "HEX($column) as $column";
                $group .= "$column";
            } else {
                $sql .= $column;
                $group .= $column;
            }
        }

        if (isset($argv['aggregate']) && (is_array($argv['aggregate']) || $argv['aggregate'] = json_decode($argv['aggregate'], true))) {
            foreach($argv['aggregate'] as $key => $value){
                switch ($key){
                    case 'count':
                        if (!empty($sql)) {
                            $sql .= ', ';
                        }
                        $sql .= "COUNT($value) AS count ";
                        break;
                    case 'AVG':
                        if (!empty($sql)) {
                            $sql .= ', ';
                        }
                        $sql .= "AVG($value) AS avg ";
                        break;
                    case 'MIN':
                        if (!empty($sql)) {
                            $sql .= ', ';
                        }
                        $sql .= "MIN($value) AS min ";
                        break;
                    case 'MAX':
                        if (!empty($sql)) {
                            $sql .= ', ';
                        }
                        $sql .= "MAX($value) AS max ";
                        break;
                }
            }
        }

        $sql = 'SELECT ' .  $sql . ' FROM statscoach.carbon_teams';

        $pdo = Database::database();

        if (empty($primary)) {
            if (!empty($where)) {
                $build_where = function (array $set, $join = 'AND') use (&$pdo, &$build_where) {
                    $sql = '(';
                    foreach ($set as $column => $value) {
                        if (is_array($value)) {
                            $sql .= $build_where($value, $join === 'AND' ? 'OR' : 'AND');
                        } else {
                            if (in_array($column, self::BINARY)) {
                                $sql .= "($column = UNHEX(" . $pdo->quote($value) . ")) $join ";
                            } else {
                                $sql .= "($column = " . $pdo->quote($value) . ") $join ";
                            }
                        }
                    }
                    return substr($sql, 0, strlen($sql) - (strlen($join) + 1)) . ')';
                };
                $sql .= ' WHERE ' . $build_where($where);
            }
        } else {
            $primary = $pdo->quote($primary);
            $sql .= ' WHERE  team_id=UNHEX(' . $primary .')';
        }

        if (isset($argv['aggregate'])) {
            $sql .= ' GROUP BY ' . $group . ' ';
        }

        $sql .= $limit;

        $return = self::fetch($sql);

        global $json;

        if (!isset($json['sql'])) {
            $json['sql'] = [];
        }
        $json['sql'][] = $sql;

        /**
        *   The next part is so every response from the rest api
        *   formats to a set of rows. Even if only one row is returned.
        *   You must set the third parameter to true, otherwise '0' is
        *   apparently in the self::COLUMNS
        */

        
        if (empty($primary) && count($return) && in_array(array_keys($return)[0], self::COLUMNS, true)) {  // You must set tr
            $return = [$return];
        }

        return true;
    }

    /**
    * @param array $argv
    * @return bool|mixed
    */
    public static function Post(array $argv)
    {
        $sql = 'INSERT INTO statscoach.carbon_teams (team_id, team_coach, parent_team, team_code, team_name, team_rank, team_sport, team_division, team_school, team_district, team_membership, team_photo) VALUES ( UNHEX(:team_id), UNHEX(:team_coach), UNHEX(:parent_team), :team_code, :team_name, :team_rank, :team_sport, :team_division, :team_school, :team_district, :team_membership, UNHEX(:team_photo))';
        $stmt = sDatabaseelf::database()->prepare($sql);

        global $json;

        if (!isset($json['sql'])) {
            $json['sql'] = [];
        }
        $json['sql'][] = $sql;

            $team_id = $id = isset($argv['team_id']) ? $argv['team_id'] : self::new_entity('carbon_teams');
            $stmt->bindParam(':team_id',$team_id, 2, 16);
            
                $team_coach = $argv['team_coach'];
                $stmt->bindParam(':team_coach',$team_coach, 2, 16);
                    
                $parent_team = isset($argv['parent_team']) ? $argv['parent_team'] : null;
                $stmt->bindParam(':parent_team',$parent_team, 2, 16);
                    
                $team_code = $argv['team_code'];
                $stmt->bindParam(':team_code',$team_code, 2, 225);
                    
                $team_name = $argv['team_name'];
                $stmt->bindParam(':team_name',$team_name, 2, 225);
                    
                $team_rank = isset($argv['team_rank']) ? $argv['team_rank'] : '0';
                $stmt->bindParam(':team_rank',$team_rank, 2, 11);
                    
                $team_sport = isset($argv['team_sport']) ? $argv['team_sport'] : 'Golf';
                $stmt->bindParam(':team_sport',$team_sport, 2, 225);
                    
                $team_division = isset($argv['team_division']) ? $argv['team_division'] : null;
                $stmt->bindParam(':team_division',$team_division, 2, 225);
                    
                $team_school = isset($argv['team_school']) ? $argv['team_school'] : null;
                $stmt->bindParam(':team_school',$team_school, 2, 225);
                    
                $team_district = isset($argv['team_district']) ? $argv['team_district'] : null;
                $stmt->bindParam(':team_district',$team_district, 2, 225);
                    
                $team_membership = isset($argv['team_membership']) ? $argv['team_membership'] : null;
                $stmt->bindParam(':team_membership',$team_membership, 2, 225);
                    
                $team_photo = isset($argv['team_photo']) ? $argv['team_photo'] : null;
                $stmt->bindParam(':team_photo',$team_photo, 2, 16);
        
        return $stmt->execute() ? $id : false;

    }

    /**
    * @param array $return
    * @param string $primary
    * @param array $argv
    * @return bool
    */
    public static function Put(array &$return, string $primary, array $argv) : bool
    {
        foreach ($argv as $key => $value) {
            if (!in_array($key, self::COLUMNS)){
                unset($argv[$key]);
            }
        }

        $sql = 'UPDATE statscoach.carbon_teams ';

        $sql .= ' SET ';        // my editor yells at me if I don't separate this from the above stmt

        $set = '';

        if (isset($argv['team_id'])) {
            $set .= 'team_id=UNHEX(:team_id),';
        }
        if (isset($argv['team_coach'])) {
            $set .= 'team_coach=UNHEX(:team_coach),';
        }
        if (isset($argv['parent_team'])) {
            $set .= 'parent_team=UNHEX(:parent_team),';
        }
        if (isset($argv['team_code'])) {
            $set .= 'team_code=:team_code,';
        }
        if (isset($argv['team_name'])) {
            $set .= 'team_name=:team_name,';
        }
        if (isset($argv['team_rank'])) {
            $set .= 'team_rank=:team_rank,';
        }
        if (isset($argv['team_sport'])) {
            $set .= 'team_sport=:team_sport,';
        }
        if (isset($argv['team_division'])) {
            $set .= 'team_division=:team_division,';
        }
        if (isset($argv['team_school'])) {
            $set .= 'team_school=:team_school,';
        }
        if (isset($argv['team_district'])) {
            $set .= 'team_district=:team_district,';
        }
        if (isset($argv['team_membership'])) {
            $set .= 'team_membership=:team_membership,';
        }
        if (isset($argv['team_photo'])) {
            $set .= 'team_photo=UNHEX(:team_photo),';
        }

        if (empty($set)){
            return false;
        }

        $sql .= substr($set, 0, strlen($set)-1);

        $db = Database::database();

        
        $primary = $db->quote($primary);
        $sql .= ' WHERE  team_id=UNHEX(' . $primary .')';

        $stmt = $db->prepare($sql);

        global $json;

        if (!isset($json['sql'])) {
            $json['sql'] = [];
        }
        $json['sql'][] = $sql;


        if (isset($argv['team_id'])) {
            $team_id = 'UNHEX('.$argv['team_id'].')';
            $stmt->bindParam(':team_id', $team_id, 2, 16);
        }
        if (isset($argv['team_coach'])) {
            $team_coach = 'UNHEX('.$argv['team_coach'].')';
            $stmt->bindParam(':team_coach', $team_coach, 2, 16);
        }
        if (isset($argv['parent_team'])) {
            $parent_team = 'UNHEX('.$argv['parent_team'].')';
            $stmt->bindParam(':parent_team', $parent_team, 2, 16);
        }
        if (isset($argv['team_code'])) {
            $team_code = $argv['team_code'];
            $stmt->bindParam(':team_code',$team_code, 2, 225);
        }
        if (isset($argv['team_name'])) {
            $team_name = $argv['team_name'];
            $stmt->bindParam(':team_name',$team_name, 2, 225);
        }
        if (isset($argv['team_rank'])) {
            $team_rank = $argv['team_rank'];
            $stmt->bindParam(':team_rank',$team_rank, 2, 11);
        }
        if (isset($argv['team_sport'])) {
            $team_sport = $argv['team_sport'];
            $stmt->bindParam(':team_sport',$team_sport, 2, 225);
        }
        if (isset($argv['team_division'])) {
            $team_division = $argv['team_division'];
            $stmt->bindParam(':team_division',$team_division, 2, 225);
        }
        if (isset($argv['team_school'])) {
            $team_school = $argv['team_school'];
            $stmt->bindParam(':team_school',$team_school, 2, 225);
        }
        if (isset($argv['team_district'])) {
            $team_district = $argv['team_district'];
            $stmt->bindParam(':team_district',$team_district, 2, 225);
        }
        if (isset($argv['team_membership'])) {
            $team_membership = $argv['team_membership'];
            $stmt->bindParam(':team_membership',$team_membership, 2, 225);
        }
        if (isset($argv['team_photo'])) {
            $team_photo = 'UNHEX('.$argv['team_photo'].')';
            $stmt->bindParam(':team_photo', $team_photo, 2, 16);
        }

        if (!$stmt->execute()){
            return false;
        }

        $return = array_merge($return, $argv);

        return true;

    }

    /**
    * @param array $remove
    * @param string|null $primary
    * @param array $argv
    * @return bool
    */
    public static function Delete(array &$remove, string $primary = null, array $argv) : bool
    {
        return \Table\carbon::Delete($remove, $primary, $argv);
    }
}