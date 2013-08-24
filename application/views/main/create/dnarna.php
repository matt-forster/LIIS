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
 * DNARNA Form
 *
 * Addition to the Culture and Sample forms which provides the initial DNARNA Forms
 * See main.js for the dynamically added code
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @author      Graham Fluet
 * @link        http://github.com/forstermatth/liis
 */
 -->

<legend>
    Genetic Information
    <?php echo $dnarnaNum ?>
</legend>
<input type="hidden" name="ids[DNARNA][]" value="<?php echo (($preset) ? $DNARNA['DNARNA_ID'] : NULL) ?>">
<div class="row">
    <div class="span" style="width: 260px;">
        <label>
            Identification Number
        </label>
        <div id="">
            <input type="text" onblur="" name="dnarna[<?php echo $dnarnaNum ?>][DNARNA_ID]"
            maxlength="10" value="<?php echo (($preset) ? $DNARNA['DNARNA_ID'] : NULL) ?>">
        </div>
    </div>
    <div class="span1">
        <div class="row">
            <label class="radio inline">
                <input type="radio" name="dnarna[<?php echo $dnarnaNum ?>][DNARNA_TYPE]" id="optionsRadios1"
                value="DNA" checked>
                DNA
            </label>
        </div>
        <div class="row">
            <label class="radio inline">
                <input type="radio" name="dnarna[<?php echo $dnarnaNum ?>][DNARNA_TYPE]" id="optionsRadios2"
                value="RNA">
                RNA
            </label>
        </div>
    </div>
    <div class="span" style="width:330px;">
        <label>
            Gen Bank Number
        </label>
        <div id="">
            <input type="text" onblur="" style="width:325px;" maxlength="40" name="dnarna[<?php echo $dnarnaNum ?>][DNARNA_GBANKNUM]"
            value="<?php echo (($preset) ? $DNARNA['DNARNA_GBANKNUM'] : NULL) ?>">
        </div>
    </div>
</div>
<div class="row">
    <div class="span3">
        <label>
            Date of Extraction
        </label>
        <div id="">
            <input type="text" onblur="" maxlength="10" name="dnarna[<?php echo $dnarnaNum ?>][DNARNA_DATE]"
            placeholder="YYYY-MM-DD" value="<?php echo (($preset) ? $DNARNA['DNARNA_DATE'] : NULL) ?>">
        </div>
    </div>
    <div class="span3">
        <label>
            Volume of Solution
        </label>
        <div id="">
            <input type="text" onblur="" maxlength="10" name="dnarna[<?php echo $dnarnaNum ?>][DNARNA_VOL]"
            value="<?php echo (($preset) ? $DNARNA['DNARNA_VOL'] : NULL) ?>">
        </div>
    </div>
    <div class="span3">
        <label>
            Concentration of Solution
        </label>
        <div id="">
            <input type="text" onblur="" maxlength="10" name="dnarna[<?php echo $dnarnaNum ?>][DNARNA_CONC]"
            value="<?php echo (($preset) ? $DNARNA['DNARNA_CONC'] : NULL) ?>">
        </div>
    </div>
</div>
<div class="row">
    <div class="span9">
        <label>
            Comments
        </label>
        <div id="">
            <textarea rows="1" name="dnarna[<?php echo $dnarnaNum ?>][DNARNA_NOTES]" style="width: 686px; resize:vertical;"><?php echo (($preset) ? $DNARNA[ 'DNARNA_NOTES'] : NULL) ?></textarea>
        </div>
    </div>
</div>