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

// Access to module parameters

// echo '<pre>' . var_export($notars,1) . '</pre>';

$fieldCls =  htmlspecialchars($params->get('field_classes', ''));
$nameCls = htmlspecialchars($params->get('field_classes_name', ''));
$bdayCls = htmlspecialchars($params->get('field_classes_birthday', ''));
$examCls = htmlspecialchars($params->get('field_classes_exam', ''));
$fromCls = htmlspecialchars($params->get('field_classes_from', ''));
$tillCls = htmlspecialchars($params->get('field_classes_till', ''));

$columns = array('name','birthday','exam','from','till');
$onclick = '';      // will be filled with JS onclick in foreach when active
?>
<div class="uk-scope">
    <div class="uk-width-1-1 uk-margin uk-position-relative nx-extension nx-list-of-notars">
        <?php if($params->get('responsive_table',1)):?>
        <div class="uk-overflow-auto">
        <?php endif;?>
        <table id="<?php echo $tableId;?>" class="nx-table <?php echo htmlspecialchars($params->get('table_classes',''));?>" <?php echo htmlspecialchars($params->get('table_attributes',''));?>>
            <thead>
                <tr>
                    <?php
                    $i = 0;
                    foreach($columns as $column):
                        // Table Sorting
                        if($params->get('tbl_sorting',1)){
                            $onclick = "onclick='sortTable($i, \"$tableId\", this)'";
                        }
                        ?>
                        <?php if(strlen($params->get('col_title_'.$column,''))):?>
                            <th <?php echo $onclick;?> class="noselect <?php echo htmlspecialchars($params->get('col_cls_'.$column,''));?>">
                                <?php echo htmlspecialchars($params->get('col_title_'.$column,''));?>
                            </th>
                        <?php endif;?>
                    <?php
                    $i++;
                    endforeach;?>
                </tr>
            </thead>
            <tbody>
            <?php
            if($notars && count($notars)):
                foreach($notars as $notar):
                ?>
                <tr>
                    <td class="<?php echo $fieldCls . ' ' . $nameCls;?>">
                        <span class="notar-name">
                            <span class="notar-title"><?php echo $notar->title;?> </span>
                            <span class="notar-firstname"><?php echo $notar->firstname;?> </span>
                            <span class="notar-lastname"><?php echo $notar->lastname;?></span>
                        </span><br>
                        <?php if (strlen($notar->company)) echo '<span class="notar-company">'.$notar->company.'</span><br>';?>
                        <span class="notar-street"><?php echo $notar->street;?></span><br>
                        <span class="notar-zip"><?php echo $notar->zip;?></span>&nbsp;<span class="notar-town"><?php echo $notar->town;?></span>
                        <?php if(strlen($notar->phone)) echo '<br><span class="notar-phone">'.$notar->phone.'</span>';?>
                        <?php if(strlen($notar->email)) echo '<br><span class="notar-email">'.$notar->email.'</span>';?>
                        <?php if(strlen($notar->website)) echo '<br><a href="'.$notar->website.'" target="_blank" title="Website '.$notar->lastname.'" class="notar-website">'.$notar->website.'</a>';?>
                    </td>
                    <?php if(strlen($params->get('col_title_birthday',''))):?>
                    <td class="<?php echo $fieldCls . ' ' . $bdayCls;?>">
                        <span class="notar-birthday"><?php echo $notar->birthday_year;?></span>
                    </td>
                    <?php endif; ?>
                    <?php if(strlen($params->get('col_title_exam',''))):?>
                    <td class="<?php echo $fieldCls . ' ' . $examCls;?>">
                        <span class="notar-exam"><?php echo HtmlHelper::date($notar->examdate, 'd.m.Y');?></span>
                    </td>
                    <?php endif; ?>
                    <?php if(strlen($params->get('col_title_from',''))):?>
                    <td class="<?php echo $fieldCls . ' ' . $fromCls;?>">
                        <span class="notar-from"><?php echo HtmlHelper::date($notar->active_from, 'd.m.Y');?></span>
                    </td>
                    <?php endif; ?>
                    <?php if(strlen($params->get('col_title_till',''))):?>
                    <td class="<?php echo $fieldCls . ' ' . $tillCls;?>">
                        <?php
                            echo '<span class="notar-till">';
                                if(strlen($notar->active_till) && $notar->active_till !== '0000-00-00 00:00:00') echo HtmlHelper::date($notar->active_till, 'd.m.Y');
                            echo '</span>';
                        ?>
                    </td>
                    <?php endif; ?>
                </tr>
            <?php
            endforeach;
            endif;
            ?>
            </tbody>
            <?php if($params->get('show_lastupdated',1)):?>
            <tfooter>
                <tr>
                    <td colspan="5">
                        <div class="uk-width-1-1 uk-text-center">
                            <span class="uk-text-meta nx-footer-text"><?php echo $lastChangeText;?></span>
                        </div>
                    </td>
                </tr>
            </tfooter>
            <?php
                endif;
            ?>
        </table>
        <?php if($params->get('responsive_table',1)):?>
        </div>
        <?php endif;?>
    </div>
</div>



