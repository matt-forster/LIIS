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
 * Sample Accordian
 *
 * The Accordian used for the Sample Record view
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */
 -->

<div class="span7" data-position="right" data-intro="This is where you can see information about the record.<br> Click on the blue titles to expand them."
data-step="1">
    <!-- Record Accordian printed here -->
    <input type='hidden' id="samp_exp_id" value="<?php echo $record['SAMPLE']['SAMP_EXP_ID']; ?>">
    <input type='hidden' id="samp_id" value="<?php echo $record['SAMPLE']['SAMP_ID']; ?>">
    <div class="recordid">
        <p>
            <strong>
                PROJECT:
            </strong>
            <?php echo $record[ 'SAMPLE'][ 'SAMP_EXP_ID']; ?>
            <strong>
                SAMPLE:
            </strong>
            <?php echo $record[ 'SAMPLE'][ 'SAMP_ID']; ?>
            <span class="pull-right">
                <strong>
                    DATE:
                    <?php echo $record[ 'SAMPLE'][ 'SAMP_DATE']; ?>
                </strong>
            </span>
        </p>
    </div>
    <div class="accordion" id="accordion">
        <div class="accordion-group">
            <!-- Properties ------------------ -->
            <div class="accordion-heading">
                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#collapseOne"
                href="#collapseOne">
                <i class="icon-plus"></i>
                Properties
                </a>
            </div>
            <div id="collapseOne" class="accordion-body collapse" style="height: 0px;">
                <div class="accordion-inner">
                    <p>
                        <strong>
                            Type:
                        </strong>
                        <?php echo $record[ 'SAMPLE'][ 'SAMP_TYPE']; ?>
                        <br>
                        <strong>
                            Material:
                        </strong>
                        <?php echo $record[ 'SAMPLE'][ 'SAMP_MAT']; ?>
                        <br>
                        <strong>
                            Location:
                        </strong>
                        <?php echo $record[ 'SAMPLE'][ 'SAMP_STOR_LOC']; ?>
                        <br>
                        <strong>
                            Period:
                        </strong>
                        <?php echo $record[ 'SAMPLE'][ 'SAMP_PERIOD']; ?>
                        <br>
                        <strong>
                            Material:
                        </strong>
                        <?php echo $record[ 'SAMPLE'][ 'SAMP_MAT']; ?>
                        <br>
                        <strong>
                            Time:
                        </strong>
                        <?php echo $record[ 'SAMPLE'][ 'SAMP_TIME']. ' '.$record[ 'SAMPLE'][ 'SAMP_TMZ'];?>
                        <br>
                        <strong>
                            Country:
                        </strong>
                        <?php echo $record[ 'SAMPLE'][ 'SAMP_COUNTRY']; ?>
                        <br>
                        <strong>
                            Biome:
                        </strong>
                        <?php echo $record[ 'SAMPLE'][ 'SAMP_BIOME']; ?>
                        <br>
                        <br>
                        <strong>
                            Environmental Package:
                        </strong>
                        <?php echo $record[ 'SAMPLE'][ 'SAMP_ENVPKG']; ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- /properties -->
        <div class="accordion-group">
            <!-- Animal -------------------------- -->
            <div class="accordion-heading">
                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#collapseTwo"
                href="#collapseTwo">
                <i class="icon-plus"></i>
                Source
                </a>
            </div>
            <div id="collapseTwo" class="accordion-body collapse" style="height: 0px;">
                <div class="accordion-inner">
                    <p>
                        <strong>
                            Number:
                        </strong>
                        <?php echo $record[ 'SOURCE'][ 'SOURCE_NUM']; ?>
                        <br>
                        <strong>
                            Type:
                        </strong>
                        <?php echo $record[ 'SOURCE'][ 'SOURCE_TYPE']; ?>
                        <br>
                        <strong>
                            Subtype:
                        </strong>
                        <?php echo $record[ 'SOURCE'][ 'SOURCE_SUBTYPE']; ?>
                        <br>
                        <strong>
                            Treatment:
                        </strong>
                        <?php echo $record[ 'SOURCE'][ 'SOURCE_TREATMENT']; ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- /animal -->
        <div class="accordion-group">
            <!-- sampsite -------------------------- -->
            <div class="accordion-heading">
                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#collapseThree"
                href="#collapseFour">
                <i class="icon-plus"></i>
                Site
                </a>
            </div>
            <div id="collapseFour" class="accordion-body collapse" style="height: 0px;">
                <div class="accordion-inner">
                    <p>
                        <strong>
                            Site:
                        </strong>
                        <?php echo $record[ 'SAMPLE'][ 'SAMP_SITE']; ?>
                        <br>
                        <strong>
                            Subsite:
                        </strong>
                        <?php echo $record[ 'SAMPLE'][ 'SAMP_SUBSITE']; ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- /sampsite -->
        <div class="accordion-group">
            <!-- Geo Location ------------------------ -->
            <div class="accordion-heading">
                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#collapseThree"
                href="#collapseThree">
                <i class="icon-plus"></i>
                Geographic Location
                </a>
            </div>
            <div id="collapseThree" class="accordion-body collapse" style="height: 0px;">
                <div class="accordion-inner">
                    <p>
                        <strong>
                            Latitude:
                        </strong>
                        <?php echo $record[ 'SAMPLE'][ 'SAMP_GEO_LAT']; ?>
                        <br>
                        <strong>
                            Longitude:
                        </strong>
                        <?php echo $record[ 'SAMPLE'][ 'SAMP_GEO_LONG']; ?>
                        <br>
                        <strong>
                            Description:
                        </strong>
                        <?php echo $record[ 'SAMPLE'][ 'SAMP_GEO_DESC']; ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- /geolocation -->
        <div class="accordion-group">
            <!-- DNARNA -------------------------------- -->
            <div class="accordion-heading">
                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#collapseThree"
                href="#collapseFive">
                <i class="icon-plus"></i>
                DNA/RNA
                </a>
            </div>
            <div id="collapseFive" class="accordion-body collapse" style="height: 0px;">
                <div class="accordion-inner">
                    <p>
                        <?php if (!is_array($record[ 'DNARNA'])){ echo $record[ 'DNARNA']; }else{ $counter=0
                        ; foreach ($record[ 'DNARNA'] as $tube){ echo
                        "<input type='hidden' class='dnarnaid' value='".$tube[ 'DNARNA_ID']. "'>"; echo '
                        <div class="accordion-group"> <!-- dnarna single ---------------------------------- -->
                        <div class="accordion-heading">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#collapse'.$counter. '" href="#collapse'.$counter. '">
                        <i class="icon-plus"></i>
                        Id: '.$tube[ 'DNARNA_ID']. ' Type: '.$tube[ 'DNARNA_TYPE']. '
                        </a>
                        '; if($this->
                            session->userdata('user_auth') === 'SPRUSER' || $this->session->userdata('user_auth')
                            === 'ADMIN'){ echo '
                            <div class="pull-right" style="margin-top: -29px; margin-right: 5px;">
                                <a href="'.site_url('sample/delete/dnarna/').$tube['DNARNA_ID'].'" class="btn btn-danger btn-mini">Delete</a>
                            </div>
                            '; } echo '
                </div>
                <div id="collapse'.$counter.'" class="accordion-body collapse" style="height: 0px;">
                    <div class="accordion-inner">
                        <strong>
                            Date Extracted:
                        </strong>
                        '.$tube['DNARNA_DATE'].'
                        <br>
                        <strong>
                            Volume:
                        </strong>
                        '.$tube['DNARNA_VOL'].'
                        <br>
                        <strong>
                            Concentration:
                        </strong>
                        '.$tube['DNARNA_CONC'].'
                        <br>
                        <strong>
                            External ID:
                        </strong>
                        '.$tube['DNARNA_GBANKNUM'].'
                        <br>
                        <strong>
                            Notes:
                        </strong>
                        '.$tube['DNARNA_NOTES'].'
                        <br>
                        <strong>
                            Image Caption:
                        </strong>
                        '.(($tube['DNARNA_IMG_PATH'] != NULL) ? $tube['DNARNA_IMG_CAP'] : 'No Image Available.').'
                    </div>
                    '; if(!is_null($tube['DNARNA_IMG_PATH'])){ echo '
                    <div class="rdnathumb">
                        <a class="thumbnail" target="_blank" href="'.$tube['DNARNA_IMG_PATH'].'"><img src="'.$tube['DNARNA_IMG_PATH'].'" alt="dna thumbnail" height="100px" width="100px"></a>
                    </div>
                    '; } echo '
                </div>
            </div>
            <!-- /dnarna single -->
            '; $counter++; } }?>
            </p>
        </div>
    </div>
</div>
<!-- /DNARNA -->
<div class="accordion-group">
    <!-- Reference -------------------------------- -->
    <div class="accordion-heading">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#collapseSix"
        href="#collapseSix">
        <i class="icon-plus"></i>
        Reference
        </a>
    </div>
    <div id="collapseSix" class="accordion-body collapse" style="height: 0px;">
        <div class="accordion-inner">
            <p>
                <strong>
                    Last Modified:
                </strong>
                <?php echo $record[ 'SAMPLE'][ 'SAMP_MODDATE']; ?>
            </p>
        </div>
    </div>
</div>
<!-- /reference -->
<div class="accordion-group">
    <!-- Notes ------------------------------------- -->
    <div class="accordion-heading">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#collapseSeven"
        href="#collapseSeven">
        <i class="icon-plus"></i>
        Notes
        </a>
    </div>
    <div id="collapseSeven" class="accordion-body collapse" style="height: 0px;">
        <div class="accordion-inner">
            <p>
                <?php echo $record[ 'SAMPLE'][ 'SAMP_NOTES']; ?>
            </p>
        </div>
    </div>
</div>
<!-- /Notes -->
</div>
<!-- /accordian -->
</div>
<script type="text/javascript">
    //Record
    //Toggle Accordian Icons - Has to be below the accordian.
    $('.accordion').on('show hide', function(e) {
        $(e.target).siblings('.accordion-heading').find('.accordion-toggle i').toggleClass('icon-plus icon-minus', 200);
    });
</script>