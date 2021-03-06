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
?>
<?php
if(strlen($notar->zip)): ?>
    <span class="notar-zip"><?php echo $notar->zip;?></span>&nbsp;
<?php endif; ?>
<?php
if(strlen($notar->town)): ?>
    <span class="notar-town"><?php echo $notar->town;?></span>
<?php endif; ?>
