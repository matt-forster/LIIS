<!-- /**
 * Laboratory Information Indexing System
 *
 * An open source mini LIMS for metadata organisation and archival purposes
 *
 * @author      Matt Forster / @frostyforster
 * @copyright   Copyright (c) 2013, Matthew S. Forster
 * @license     MIT (./license.txt)
 * @link        http://github.com/forstermatth/liis
 * @since       Version 1.0
 * @filesource
 */ 

// ------------------------------------------------------------------------

/**
 * Culture Vial Form
 *
 * Addition to the Culture Form which loads the initial Vial subforms
 * See main.js for the dynamically added code
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @author      Graham Fluet
 * @link        http://github.com/forstermatth/liis
 */
 -->

<legend>
    Vial
    <?php echo $vialNum; ?>
</legend>
<input type="hidden" name="ids[VIAL][]" value="<?php echo (($preset) ? $VIAL['VIAL_ID'] : NULL) ?>">
<input type="hidden" name="vial[<?php echo $vialNum; ?>][vial_old_id]" value="<?php echo (($preset) ? $VIAL['VIAL_ID'] : NULL) ?>">
<div class="row">
    <div class="span2">
        <label>
            Vial ID
        </label>
        <div id="">
            <input type="text" onblur="" style="width:120px;" name="vial[<?php echo $vialNum; ?>][VIAL_ID]"
            maxlength="10" value="<?php echo (($preset) ? $VIAL['VIAL_ID'] : NULL) ?>">
        </div>
    </div>
    <div class="span3">
        <label>
            Vial Storage location
        </label>
        <div id="">
            <input type="text" onblur="" name="vial[<?php echo $vialNum; ?>][VIAL_STOR_LOC]"
            maxlength="20" value="<?php echo (($preset) ? $VIAL['VIAL_STOR_LOC'] : NULL) ?>">
        </div>
    </div>
    <div class="span3">
        <label>
            Growth Temperature
        </label>
        <div id="">
            <input type="text" onblur="" name="vial[<?php echo $vialNum; ?>][VIAL_GROWTH_TEMP]"
            maxlength="20" value="<?php echo (($preset) ? $VIAL['VIAL_GROWTH_TEMP'] : NULL) ?>">
        </div>
    </div>
</div>
<div class="row">
    <div class="span9">
        <label>
            Growth Type
        </label>
        <div id="">
            <input type="text" onblur="" style="width:686px;" name="vial[<?php echo $vialNum; ?>][VIAL_GROWTH_TYPE]"
            maxlength="60" value="<?php echo (($preset) ? $VIAL['VIAL_GROWTH_TYPE'] : NULL) ?>">
        </div>
    </div>
</div>
<div class="row">
    <div class="span9">
        <label>
            Vial Notes
        </label>
        <textarea rows="1" name="vial[<?php echo $vialNum; ?>][VIAL_NOTES]" style=" width: 686px; resize:vertical;"><?php echo (($preset) ? $VIAL[ 'VIAL_NOTES'] : NULL) ?></textarea>
    </div>
</div>