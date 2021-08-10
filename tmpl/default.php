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
use Joomla\CMS\Language\Text;
use Joomla\CMS\Date\Date;

defined('_JEXEC') or die;

// Access to module parameters

// echo '<pre>' . var_export($notars,1) . '</pre>';

$columns = $params->get('columns',array());
$onclick = '';      // will be filled with JS onclick in foreach when active

$stacked = $params->get('responsive_table','stacked') === 'stacked' ? 'uk-table-responsive' : '';

$simpleTemplates = array('title','firstname','lastname','street','birthday_year','company');

$lastUpdatedDate = new Date($params->get('last_updated_date','2012-12-1 15:20:00'))

?>
<div class="uk-scope">
    <div class="uk-width-1-1 uk-margin uk-position-relative nx-extension nx-list-of-notars">
        <?php if($params->get('responsive_table','stacked') === 'overflow'):?>
        <div class="uk-overflow-auto">
        <?php endif;?>
            <table id="<?php echo $tableId;?>" class="nx-table <?php echo htmlspecialchars($params->get('table_classes','')) . ' ' . $stacked;?>" <?php echo htmlspecialchars($params->get('table_attributes',''));?>>
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

                        <th <?php echo $onclick;?> class="noselect <?php echo htmlspecialchars($column->col_cls);?>">
                            <?php
                            $key = strtoupper(htmlspecialchars($column->column_title));
                            $value = Text::_($key);
                            $label = $key !== $value ? $value : htmlspecialchars($column->column_title);
                            echo $label;
                            ?>
                        </th>

                        <?php
                        $i++;
                    endforeach;?>
                </tr>
                </thead>

                <tbody>
                <?php if($notars && count($notars)):
                    foreach($notars as $notar): ?>
                        <tr>
                            <?php foreach ($columns as $col): ?>
                            <td class="<?php echo htmlspecialchars($col->field_classes);?>">
                                <?php
                                if (in_array($col->column, $simpleTemplates)) {
                                    include 'parts/simple.php';
                                } else {
                                    include 'parts/' . $col->column . '.php';
                                }
                                ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php
                    endforeach;
                endif;
                ?>
                </tbody>
            </table>
    <?php if($params->get('responsive_table',1)):?>
        </div>
    <?php endif;?>
        <?php if($params->get('show_lastupdated',1)):?>
            <div class="uk-width-1-1 uk-text-center">
                <span class="uk-text-meta nx-footer-text"><?php echo text::sprintf('MOD_LON_FE_TXT_LAST_CHANGED', htmlHelper::date($lastUpdatedDate, Text::_('DATE_FORMAT_LC4')));?></span>
            </div>
        <?php endif;?>
    </div>
</div>


