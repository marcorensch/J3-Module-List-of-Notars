<?php
/**
 * @package    List of Notars Module
 *
 * @author     nx-designs | Marco Rensch <support@nx-designs.ch>
 * @copyright  Copyright© 2021 by nx-designs
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       http://www.nx-designs.ch
 */

use Joomla\CMS\HTML\HTMLHelper;

defined('_JEXEC') or die;

$active_column = $col->column;

if(property_exists($col,'button') && $col->button){
    $btnCls = 'uk-button uk-button-'. $col->buttonsize . ' uk-button-'.$col->buttonstyle;
    if($col->icon_button){
        $lbl = '<i uk-icon="icon: world" class="uk-preserve-width"></i>';
    }else{
        $lbl = \Joomla\CMS\Language\Text::_('WEBSITE_NOTAR');
    }

}else{
    $btnCls = '';
    $lbl = $notar->$active_column;
}
$html = '<a target="_blank" class="uk-text-nowrap '.$btnCls.'" href="'.$notar->$active_column.'">' .$lbl. '</a>';

if(strlen($notar->$active_column)):
?>

<span class="notar-<?php echo $col->column;?>"><?php echo $html;?></span>

<?php endif;?>
