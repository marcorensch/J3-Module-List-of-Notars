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
    $btnCls = 'uk-button uk-button-small';
    $lbl = \Joomla\CMS\Language\Text::_('SEND_EMAIL_TO_NOTAR');
}else{
    $btnCls = '';
    $lbl = $notar->$active_column;
}
$html = '<a class="'.$btnCls.'" href="mailto:'.$notar->$active_column.'">' .$lbl. '</a>';
?>

<span class="notar-<?php echo $col->column;?>"><?php echo $notar->$active_column;?></span>
