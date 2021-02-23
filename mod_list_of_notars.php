<?php
/**
 * @package    List of Notars Module
 *
 * @author     nx-designs | Marco Rensch <support@nx-designs.ch>
 * @copyright  Copyright© 2021 by nx-designs
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       http://www.nx-designs.ch
 */

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;


require 'helper.php';

defined('_JEXEC') or die;
$tableId = 'nxtable'.$module->id;
$lastChange = '';

//Scripts
$document = Factory::getDocument();
// Load UIkit
$uikit = $params->get('uikit','3.6.16');
if($uikit !== '-1'){
    $document->addStyleSheet(Juri::root() . 'modules/mod_list_of_notars/tmpl/assets/uikit/'.$uikit.'/css/uikit.min.css');
    $document->addScript(Juri::root() . 'modules/mod_list_of_notars/tmpl/assets/uikit/'.$uikit.'/js/uikit.min.js');
    $document->addScript(Juri::root() . 'modules/mod_list_of_notars/tmpl/assets/uikit/'.$uikit.'/js/uikit-icons.min.js');
}

if($params->get('tbl_sorting',1)){
    $document->addScript(Juri::root() . 'modules/mod_list_of_notars/tmpl/assets/js/sortTable.js?v='.rand(0,100));
    $document->addStyleDeclaration('.nx-table th{cursor:pointer;}');
    $document->addStyleDeclaration('
        .noselect {
          -webkit-touch-callout: none; /* iOS Safari */
            -webkit-user-select: none; /* Safari */
             -khtml-user-select: none; /* Konqueror HTML */
               -moz-user-select: none; /* Old versions of Firefox */
                -ms-user-select: none; /* Internet Explorer/Edge */
                    user-select: none; /* Non-prefixed version, currently
                                          supported by Chrome, Edge, Opera and Firefox */
        }
        .nx-text-bold{
            font-weight:bolder !important;
        }
        .sorting-container{
            /*
            width: 10px;
            height:10px;
            background:red;
            margin-left:5px;
            */
        }'
    );
}


$notars = ModListOfNotarsHelper::getActiveNotars($params);
if($params->get('show_lastupdated',1)) {
    $lastChange = ModListOfNotarsHelper::getLastChange($notars, $params);
    $lastChangeText = $params->get('last_updated_txt','Last updated: %date');
    $dateString = HTMLHelper::date($lastChange, Text::_('DATE_FORMAT_FILTER_DATE'));
    $lastChangeText = str_replace('%date',$dateString,$lastChangeText);
}

// The below line is no longer used in Joomla 4
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require ModuleHelper::getLayoutPath('mod_list_of_notars', $params->get('layout', 'default'));
