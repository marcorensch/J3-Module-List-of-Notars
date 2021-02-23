<?php
/**
 * @package    List of Notars Module
 *
 * @author     nx-designs | Marco Rensch <support@nx-designs.ch>
 * @copyright  Copyright© 2021 by nx-designs
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       http://www.nx-designs.ch
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Date\Date;

defined('_JEXEC') or die;

class ModListOfNotarsHelper{
    private static function refineByLatestActiveFrom($notarActivityPeriod,$params){
        $notars = array();
        foreach($notarActivityPeriod as $activeNotar){
            if(array_key_exists($activeNotar->id, $notars)){
                if($activeNotar->active_from > $notars[$activeNotar->id]->active_from){
                    $notars[$activeNotar->id] = $activeNotar;
                }
            }else{
                $notars[$activeNotar->id] = $activeNotar;
            }
        }

        return $notars;
    }
    public static function getActiveNotars($params){
        $date = Date::getInstance();
        $timezone = Factory::getUser()->getTimezone();
        $date->setTimezone($timezone);

        $sorting = $params->get('sort_by','name') . ' ' . $params->get('sort_dir','ASC');

        $db = Factory::getDbo();

        $query = $db->getQuery(true);

        $query->select(
            array(
                'a.notar','a.active_from','a.active_till',
                'b.*'
            )
        );
        $query->from($db->quoteName('#__notarmanager_registration','a'))
        ->join('INNER', $db->quoteName('#__notarmanager_notar', 'b') . ' ON ' . $db->quoteName('a.notar') . ' = ' . $db->quoteName('b.id'));
        $query->where(
            [
                $db->quoteName('b.published') . ' = 1',
                $db->quoteName('a.active_from') . ' <= ' . $db->quote($date->toSQL())
            ]
        )
        ->andWhere(
            [
                $db->quoteName('a.active_till') . ' = ' . $db->quote('') ,
                $db->quoteName('a.active_till') . ' > ' . $db->quote($date->toSQL())
            ]
        );
        $query->group($db->quoteName('a.id'));
        $query->order($sorting);

        if($params->get('debug',0)) echo '<pre>' . var_export($sorting,1) . '</pre>';

        $db->setQuery($query);
        $results = $db->loadObjectList();

        if($results && count($results)){
            $notars = ModListOfNotarsHelper::refineByLatestActiveFrom($results,$params);
        }else{
            return false;
        }

        if($params->get('debug',0)) echo '<pre>' . var_export($notars,1) . '</pre>';

        if(count((array) $params->get('rules',array()))){
            ModListOfNotarsHelper::customRules($notars,$params);
        }

        return $notars;


    }

    public static function getLastChange($notars,$params){
        // Get last modified
        usort($notars, function($a, $b) {return strcmp($a->created, $b->created);});
        $lastChange = $notars[0]->created;
        // Check for modifications
        usort($notars, function($a, $b) {return strcmp($a->modified, $b->modified);});
        if($notars[0]->modified > $lastChange){
            $lastChange = $notars[0]->modified;
        }

        // and sort it back as needed
        //usort($notars, function($a, $b) {return strcmp($a->name, $b->name);});


        return $lastChange;
    }

    private static function customRules(&$notars, $params){
        $rules = $params->get('rules',array());
        if($params->get('debug',0)) echo '<pre>' . var_export($rules,1) . '</pre>';
        foreach($rules as $rule){
            $trgt = $rule->rule_target;
            foreach($notars as $notar){
                switch($rule->rule_type){
                    case 'replace':
                        $notar->$trgt = str_replace($rule->rule_replace_what,$rule->rule_replace_with, $notar->$trgt);
                        break;
                }
            }
        }
    }
}
