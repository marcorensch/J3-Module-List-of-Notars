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

<div class="notar-name">
    <span class="notar-title"><?php echo $notar->title;?> </span>
    <span class="notar-firstname"><?php echo $notar->firstname;?> </span>
    <span class="notar-lastname"><?php echo $notar->lastname;?></span><br>
    <?php if (strlen($notar->company)) { echo '<span class="notar-company">'.$notar->company.'</span><br>';} ?>
    <span class="notar-street"><?php echo $notar->street;?></span><br>
    <span class="notar-zip"><?php echo $notar->zip;?></span>&nbsp;<span class="notar-town"><?php echo $notar->town;?></span>
</div>
