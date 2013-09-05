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
 * Sample Form
 *
 * Main sample form used in Creation and Edit functions
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
            Sample
    </h1>
    <form id="createForm" action="#" method="post" onsubmit="" ENCTYPE="multipart/form-data">
        <input type="hidden" name="ids[SAMPLE][]" value="<?php echo (($preset) ? $record['SAMPLE']['SAMP_EXP_ID'] : NULL) ?>">
        <input type="hidden" name="ids[SAMPLE][]" value="<?php echo (($preset) ? $record['SAMPLE']['SAMP_ID'] : NULL) ?>">
        <input type="hidden" name="ids[SOURCE][]" value="<?php echo (($preset) ? $record['SOURCE']['SOURCE_ID'] : NULL) ?>">
        <!-- ------------------ Sample----------------------- -->
        <legend>
            Sample
        </legend>
        <div class="row" data-position="bottom" data-intro="<strong>Click in the grey, and try to make a record! <br>Afterwards, click the recent button to view your record.</strong><br><br> This is the end of the tutorial, keep exploring the site<br> or go to the help to answer any further questions that you have. <br><br><strong>To turn these messages off, go back to the help page <br>and click the link that you started from.</strong>"
        data-step="6">
            <div class="span" style="width:100px;">
                <label>
                    Project Name
                </label>
                <div id="">
                    <input type="text" onblur="" name="sample[SAMP_EXP_ID]" maxlength="16" style="width:95px; "
                    placeholder="" value="<?php echo (($preset) ? $record['SAMPLE']['SAMP_EXP_ID'] : NULL) ?>">
                </div>
            </div>
            <div class="span" style="width:100px;">
                <label>
                    Sample ID
                </label>
                <div id="">
                    <input type="text" onblur="" name="sample[SAMP_ID]" maxlength="16" style="width:95px; "
                    placeholder="" value="<?php echo (($preset) ? $record['SAMPLE']['SAMP_ID'] : NULL) ?>">
                </div>
            </div>
            <div class="span">
                <label>
                    Date
                </label>
                <div id="">
                    <input type="text" onblur="" name="sample[SAMP_DATE]" style="width:100px;" maxlength="10"
                    placeholder="YYYY-MM-DD" value="<?php echo (($preset) ? $record['SAMPLE']['SAMP_DATE'] : NULL) ?>">
                </div>
            </div>
            <div class="span">
                <label>
                    Storage location
                </label>
                <div id="">
                    <input type="text" onblur="" name="sample[SAMP_STOR_LOC]" style="width:160px;" maxlength="20"
                    value="<?php echo (($preset) ? $record['SAMPLE']['SAMP_STOR_LOC'] : NULL) ?>">
                </div>
            </div>
            <div class="span">
                <label>
                    Period
                </label>
                <div id="">
                    <input type="text" onblur="" name="sample[SAMP_PERIOD]" maxlength="10" style="width:115px;"
                    value="<?php echo (($preset) ? $record['SAMPLE']['SAMP_PERIOD'] : NULL) ?>">
                </div>
            </div>
            <div class="span3">
                <label>
                    Sample Time
                </label>
                <div id="">
                    <input type="text" onblur="" name="sample[SAMP_TIME]" maxlength="40" value="<?php echo (($preset) ? $record['SAMPLE']['SAMP_TIME'] : NULL) ?>">
                </div>
            </div>
            <div class="span3">
                <label>
                    Sample Time Zone
                </label>
                <div id="">
                    <input type="text" onblur="" name="sample[SAMP_TMZ]" maxlength="40" value="<?php echo (($preset) ? $record['SAMPLE']['SAMP_TMZ'] : NULL) ?>">
                </div>
            </div>
            <div class="span3">
                <label>
                    Sample Environment Package
                </label>
                <div id="">
                    <select onblur="" name="sample[SAMP_ENVPKG]">
                        <option value="none" <?php if($preset && $record['SAMPLE']['SAMP_ENVPKG'] == 'none') echo 'selected'; ?> >
                            -- None
                        </option>
                        <option value="air" <?php if($preset && $record['SAMPLE']['SAMP_ENVPKG'] == 'air') echo 'selected'; ?> >
                            Air
                        </option>
                        <option value="host-associated" <?php if($preset && $record['SAMPLE']['SAMP_ENVPKG'] == 'host-associated') echo 'selected'; ?> >
                            Host Associated
                        </option>
                        <option value="microbial mat/biofilm" <?php if($preset && $record['SAMPLE']['SAMP_ENVPKG'] == 'microbial mat/biofilm') echo 'selected'; ?> >
                            Microbial Material / Biofilm
                        </option>
                        <option value="plant-associated" <?php if($preset && $record['SAMPLE']['SAMP_ENVPKG'] == 'plant-associated') echo 'selected'; ?> >
                            Plant Associated
                        </option>
                        <option value="sediment" <?php if($preset && $record['SAMPLE']['SAMP_ENVPKG'] == 'sediment') echo 'selected'; ?> >
                            Sediment
                        </option>
                        <option value="soil" <?php if($preset && $record['SAMPLE']['SAMP_ENVPKG'] == 'soil') echo 'selected'; ?> >
                            Soil
                        </option>
                        <option value="wastewater/sludge" <?php if($preset && $record['SAMPLE']['SAMP_ENVPKG'] == 'wastewater/sludge') echo 'selected'; ?> >
                            Waste Water / Sludge
                        </option>
                        <option value="water" <?php if($preset && $record['SAMPLE']['SAMP_ENVPKG'] == 'water') echo 'selected'; ?> >
                            Water
                        </option>
                        <option value="human-associated" <?php if($preset && $record['SAMPLE']['SAMP_ENVPKG'] == 'human-associated') echo 'selected'; ?> >
                            Human Associated
                        </option>
                        <option value="human-gut" <?php if($preset && $record['SAMPLE']['SAMP_ENVPKG'] == 'human-gut') echo 'selected'; ?> >
                            Human Gut
                        </option>
                        <option value="human-oral" <?php if($preset && $record['SAMPLE']['SAMP_ENVPKG'] == 'human-oral') echo 'selected'; ?> >
                            Human Oral
                        </option>
                        <option value="human-skin" <?php if($preset && $record['SAMPLE']['SAMP_ENVPKG'] == 'human-skin') echo 'selected'; ?> >
                            Human Skin
                        </option>
                        <option value="human-vaginal" <?php if($preset && $record['SAMPLE']['SAMP_ENVPKG'] == 'human-vaginal') echo 'selected'; ?> >
                            Human Vaginal
                        </option>
                        <option value="misc natural/artificial" <?php if($preset && $record['SAMPLE']['SAMP_ENVPKG'] == 'misc natural/artificial') echo 'selected'; ?> >
                            Misc Natural or Artifical
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span3">
                <label>
                    Sample Type
                </label>
                <div id="">
                    <input type="text" onblur="" name="sample[SAMP_TYPE]" maxlength="20" id="" value="<?php echo (($preset) ? $record['SAMPLE']['SAMP_TYPE'] : NULL) ?>">
                </div>
            </div>
            <div class="span3">
                <label>
                    Site
                </label>
                <div id="">
                    <input type="text" onblur="" name="sample[SAMP_SITE]" maxlength="20" value="<?php echo (($preset) ? $record['SAMPLE']['SAMP_SITE'] : NULL) ?>">
                </div>
            </div>
            <div class="span3">
                <label>
                    Subsite
                </label>
                <div id="">
                    <input type="text" onblur="" name="sample[SAMP_SUBSITE]" maxlength="20" value="<?php echo (($preset) ? $record['SAMPLE']['SAMP_SUBSITE'] : NULL) ?>">
                </div>
            </div>
            <div class="span3">
                <label>
                    Sample Material
                </label>
                <div id="">
                    <input type="text" onblur="" name="sample[SAMP_MAT]" maxlength="40" value="<?php echo (($preset) ? $record['SAMPLE']['SAMP_MAT'] : NULL) ?>">
                </div>
            </div>
            <div class="span3">
                <label>
                    Sample Biome
                </label>
                <div id="">
                    <input type="text" onblur="" name="sample[SAMP_BIOME]" maxlength="40" value="<?php echo (($preset) ? $record['SAMPLE']['SAMP_BIOME'] : NULL) ?>">
                </div>
            </div>
            <div class="span3">
                <label>
                    Sample Country
                </label>
                <div id="">
                    <input type="text" onblur="" name="sample[SAMP_COUNTRY]" maxlength="40" value="<?php echo (($preset) ? $record['SAMPLE']['SAMP_COUNTRY'] : NULL) ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span">
                <label>
                    Notes
                </label>
                <div id="">
                    <textarea rows="1" name="sample[SAMP_NOTES]" style=" width: 686px; resize:vertical;"><?php echo (($preset) ? $record[ 'SAMPLE'][ 'SAMP_NOTES'] : NULL) ?></textarea>
                </div>
            </div>
        </div>
        <!--Source-->
        <legend>
            Source
        </legend>
        <div class="row">
            <div class="span3">
                <label>
                    Source ID Number
                </label>
                <div id="">
                    <input type="text" onblur="" name="source[SOURCE_NUM]" maxlength="10" value="<?php echo (($preset) ? $record['SOURCE']['SOURCE_NUM'] : NULL) ?>">
                </div>
            </div>
            <div class="span3">
                <label>
                    Type of source
                </label>
                <div id="">
                    <input type="text" onblur="" name="source[SOURCE_TYPE]" maxlength="20" value="<?php echo (($preset) ? $record['SOURCE']['SOURCE_TYPE'] : NULL) ?>">
                </div>
            </div>
            <div class="span3">
                <label>
                    Subtype of source
                </label>
                <div id="">
                    <input type="text" onblur="" name="source[SOURCE_SUBTYPE]" maxlength="20" value="<?php echo (($preset) ? $record['SOURCE']['SOURCE_SUBTYPE'] : NULL) ?>">
                </div>
            </div>
            <div class="span">
                <label>
                    Treatment
                </label>
                <div id="">
                    <input type="text" onblur="" name="source[SOURCE_TREATMENT]" style="width:686px;"
                    maxlength="60" value="<?php echo (($preset) ? $record['SOURCE']['SOURCE_TREATMENT'] : NULL) ?>">
                </div>
            </div>
        </div>
        <!-- ------------------Geo location------------------------ -->
        <legend>
            Geological Location
        </legend>
        <div class="row">
            <div class="span">
                <label>
                    Longitude
                </label>
                <div id="">
                    <input type="text" onblur="" name="sample[SAMP_GEO_LONG]" style="width:160px;" maxlength="20"
                    value="<?php echo (($preset) ? $record['SAMPLE']['SAMP_GEO_LONG'] : NULL) ?>">
                </div>
            </div>
            <div class="span">
                <label>
                    Latitude
                </label>
                <div id="">
                    <input type="text" onblur="" name="sample[SAMP_GEO_LAT]" style="width:160px;" maxlength="20"
                    value="<?php echo (($preset) ? $record['SAMPLE']['SAMP_GEO_LAT'] : NULL) ?>">
                </div>
            </div>
            <div class="span">
                <label>
                    Description
                </label>
                <div id="">
                    <input type="text" onblur="" name="sample[SAMP_GEO_DESC]" style="width:295px;" maxlength="40"
                    value="<?php echo (($preset) ? $record['SAMPLE']['SAMP_GEO_DESC'] : NULL) ?>">
                </div>
            </div>
        </div>