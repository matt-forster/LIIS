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
 * Culture Create Form
 *
 * Loads the Create form used in Culture Creation and Editing
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @author      Graham Fluet
 * @link        http://github.com/forstermatth/liis
 */
 -->

<div class="span9 higher">
    <h1 data-position="bottom" data-intro="Below is the form where you fill out the info to put in the system."
    data-step="1">
        <?php echo $name ?>
            Culture
    </h1>
    <form id="createForm" action="#" method="post" onsubmit="" ENCTYPE="multipart/form-data">
        <!-- Table IDS -->
        <input type="hidden" name="ids[CULTURE][]" value="<?php echo (($preset) ? $record['CULTURE']['CULT_ID'] : NULL) ?>">
        <input type="hidden" name="ids[CULTURE][]" value="<?php echo (($preset) ? $record['CULTURE']['CULT_LABNUM'] : NULL) ?>">
        <input type="hidden" name="ids[TAXONOMY][]" value="<?php echo (($preset) ? $record['TAXONOMY']['TAX_ID'] : NULL) ?>">
        <input type="hidden" name="culture[CULT_ID]" value="<?php echo (($preset) ? $record['CULTURE']['CULT_ID'] : NULL) ?>">
        <!-- ------------------ CULTURE----------------------- -->
        <legend>
            Culture
        </legend>
        <div class="row" data-position="bottom" data-intro="<strong>Click in the grey, and try to make a record! <br>Afterwards, click the recent button to view your record.</strong><br><br> This is the end of the tutorial, keep exploring the site<br> or go to the help to answer any further questions that you have. <br><br><strong>To turn these messages off, go back to the help page <br>and click the link that you started from.</strong>"
        data-step="7">
            <div class="span" style="width:175px;">
                <label>
                    Laboratory Number
                </label>
                <div id="">
                    <input type="text" onblur="" name="culture[CULT_LABNUM]" maxlength="15" style="width:160px;"
                    value="<?php echo (($preset) ? $record['CULTURE']['CULT_LABNUM'] : NULL) ?>">
                </div>
            </div>
            <div class="span">
                <label>
                    Storage Location
                </label>
                <div id="">
                    <input type="text" onblur="" name="culture[CULT_STOR_LOC]" maxlength="20" style="width:160px;"
                    value="<?php echo (($preset) ? $record['CULTURE']['CULT_STOR_LOC'] : NULL) ?>">
                </div>
            </div>
            <div class="span">
                <label>
                    Stored State
                </label>
                <div id="">
                    <input type="text" onblur="" name="culture[CULT_STORED_STATE]" maxlength="20" style="width:160px;"
                    value="<?php echo (($preset) ? $record['CULTURE']['CULT_STORED_STATE'] : NULL) ?>">
                </div>
            </div>
            <div class="span">
                <label>
                    Date
                </label>
                <div id="">
                    <input type="text" onblur="" name="culture[CULT_DATE]" style="width:100px;" maxlength="10"
                    placeholder="YYYY-MM-DD" value="<?php echo (($preset) ? $record['CULTURE']['CULT_DATE'] : NULL) ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span">
                <label>
                    Reference Number
                </label>
                <div id="">
                    <input type="text" onblur="" name="culture[CULT_REFNUM]" style="width:355px;" maxlength="40"
                    value="<?php echo (($preset) ? $record['CULTURE']['CULT_REFNUM'] : NULL) ?>">
                </div>
            </div>
            <div class="span">
                <label>
                    Owner
                </label>
                <div id="">
                    <input type="text" onblur="" name="culture[CULT_OWNER]" maxlength="20" style="width:160px;"
                    value="<?php echo (($preset) ? $record['CULTURE']['CULT_OWNER'] : NULL) ?>">
                </div>
            </div>
            <div class="span">
                <label>
                    Risk Group
                </label>
                <div id="">
                    <input type="text" onblur="" name="culture[CULT_RISKG]" style="width:100px;" maxlength="10"
                    value="<?php echo (($preset) ? $record['CULTURE']['CULT_RISKG'] : NULL) ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span">
                <label>
                    External Database ID
                </label>
                <div id="">
                    <input type="text" onblur="" name="culture[CULT_EXTERN_ID]" maxlength="40" style="width:355px;"
                    placeholder="ATTC, etc" value="<?php echo (($preset) ? $record['CULTURE']['CULT_RISKG'] : NULL) ?>">
                </div>
            </div>
            <div class="span">
                <label>
                    Isolation Source
                </label>
                <div id="">
                    <input type="text" onblur="" name="culture[CULT_ISO_SOURCE]" maxlength="20" style="width:160px;"
                    value="<?php echo (($preset) ? $record['CULTURE']['CULT_ISO_SOURCE'] : NULL) ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span9">
                <label>
                    rRNA source
                </label>
                <div id="">
                    <textarea rows="2" name="culture[CULT_RRNA_SEQ]" style="width: 686px; resize:vertical;">
                        <?php echo (($preset) ? $record[ 'CULTURE'][ 'CULT_RRNA_SEQ'] : NULL) ?>
                    </textarea>
                </div>
            </div>
            <div class="span9">
                <label>
                    History
                </label>
                <div id="">
                    <textarea rows="2" name="culture[CULT_HIST]" style="width: 686px; resize:vertical;">
                        <?php echo (($preset) ? $record[ 'CULTURE'][ 'CULT_HIST'] : NULL) ?>
                    </textarea>
                </div>
            </div>
            <div class="span9">
                <label>
                    Culture Notes
                </label>
                <div id="">
                    <textarea rows="2" name="culture[CULT_NOTES]" style="width: 686px; resize:vertical;"><?php echo (($preset) ? $record[ 'CULTURE'][ 'CULT_NOTES'] : NULL) ?></textarea>
                </div>
            </div>
        </div>
        <!-- ------------------TAXONOMY----------------- -->
        <legend>
            Taxonomy
        </legend>
        <div class="row">
            <div class="span4p">
                <label>
                    Domain
                </label>
                <div id="">
                    <input type="text" onblur="" maxlength="40" style="width:325px;" name="taxonomy[TAX_DOMAIN]"
                    value="<?php echo (($preset) ? $record['TAXONOMY']['TAX_DOMAIN'] : NULL) ?>">
                </div>
            </div>
            <div class="span4p">
                <label>
                    Kingdom
                </label>
                <div id="">
                    <input type="text" onblur="" maxlength="40" style="width:325px;" name="taxonomy[TAX_KINGDOM]"
                    value="<?php echo (($preset) ? $record['TAXONOMY']['TAX_KINGDOM'] : NULL) ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span4p">
                <label>
                    Phylum
                </label>
                <div id="">
                    <input type="text" onblur="" maxlength="40" style="width:325px;" name="taxonomy[TAX_PHYLUM]"
                    value="<?php echo (($preset) ? $record['TAXONOMY']['TAX_PHYLUM'] : NULL) ?>">
                </div>
            </div>
            <div class="span4p">
                <label>
                    Class
                </label>
                <div id="">
                    <input type="text" onblur="" maxlength="40" style="width:325px;" name="taxonomy[TAX_CLASS]"
                    value="<?php echo (($preset) ? $record['TAXONOMY']['TAX_CLASS'] : NULL) ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span4p">
                <label>
                    Order
                </label>
                <div id="">
                    <input type="text" onblur="" maxlength="40" style="width:325px;" name="taxonomy[TAX_ORDER]"
                    value="<?php echo (($preset) ? $record['TAXONOMY']['TAX_ORDER'] : NULL) ?>">
                </div>
            </div>
            <div class="span4p">
                <label>
                    Family
                </label>
                <div id="">
                    <input type="text" onblur="" maxlength="40" style="width:325px;" name="taxonomy[TAX_FAMILY]"
                    value="<?php echo (($preset) ? $record['TAXONOMY']['TAX_FAMILY'] : NULL) ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span4p">
                <label>
                    Genus
                </label>
                <div id="">
                    <input type="text" onblur="" maxlength="40" style="width:325px;" name="taxonomy[TAX_GENUS]"
                    value="<?php echo (($preset) ? $record['TAXONOMY']['TAX_GENUS'] : NULL) ?>">
                </div>
            </div>
            <div class="span4p">
                <label>
                    Species
                </label>
                <div id="">
                    <input type="text" onblur="" maxlength="40" style="width:325px;" name="taxonomy[TAX_SPECIES]"
                    value="<?php echo (($preset) ? $record['TAXONOMY']['TAX_SPECIES'] : NULL) ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span4p">
                <label>
                    Strain
                </label>
                <div id="">
                    <input type="text" onblur="" maxlength="40" style="width:325px;" name="taxonomy[TAX_STRAIN]"
                    id="" value="<?php echo (($preset) ? $record['TAXONOMY']['TAX_STRAIN'] : NULL) ?>">
                </div>
            </div>
        </div>