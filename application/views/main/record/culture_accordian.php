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
 * Culture Accordian
 *
 * The Accordian used on the Culture view page
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */
 -->

<div class="span7" data-position="right" data-intro="This is where you can see information about the record.<br> Click on the blue titles to expand them."
data-step="1">
    <!-- Record Accordian printed here -->
    <input type='hidden' id="cult_id" value="<?php echo $record['CULTURE']['CULT_ID']; ?>">
    <div class="recordid">
        <p>
            <strong>
                CULTURE:
            </strong>
            <?php echo $record[ 'CULTURE'][ 'CULT_LABNUM']; ?>
                <span class="pull-right">
                    <strong>
                        DATE:
                    </strong>
                    <?php echo $record[ 'CULTURE'][ 'CULT_DATE']; ?>
                </span>
        </p>
    </div>
    <div class="accordion" id="accordion">
        <!-- ACCORDIAN START -->
        <div class="accordion-group">
            <!-- Properties ------------------------------- -->
            <div class="accordion-heading">
                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#collapseOne"
                href="#collapseOne">
                <i class="icon-plus"></i>
                Properties
                </a>
            </div>
            <!-- /heading -->
            <div id="collapseOne" class="accordion-body collapse" style="height: 0px;">
                <div class="accordion-inner">
                    <p>
                        <strong>
                            Risk Group:
                        </strong>
                        <?php echo $record[ 'CULTURE'][ 'CULT_RISKG']; ?>
                            <br>
                            <strong>
                                Stored State:
                            </strong>
                            <?php echo $record[ 'CULTURE'][ 'CULT_STORED_STATE']; ?>
                                <br>
                                <strong>
                                    Location:
                                </strong>
                                <?php echo $record[ 'CULTURE'][ 'CULT_STOR_LOC']; ?>
                                    <br>
                                    <strong>
                                        Isolation Source:
                                    </strong>
                                    <?php echo $record[ 'CULTURE'][ 'CULT_ISO_SOURCE']; ?>
                                        <br>
                                        <strong>
                                            History:
                                        </strong>
                                        <?php echo $record[ 'CULTURE'][ 'CULT_HIST']; ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- /properties -->
        <div class="accordion-group">
            <!-- Sequence ------------------------------------- -->
            <div class="accordion-heading">
                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#collapseTwo"
                href="#collapseTwo">
                <i class="icon-plus"></i>
                Sequence
                </a>
            </div>
            <div id="collapseTwo" class="accordion-body collapse" style="height: 0px;">
                <div class="accordion-inner">
                    <?php echo $record[ 'CULTURE'][ 'CULT_RRNA_SEQ']; ?>
                </div>
            </div>
        </div>
        <!-- /sequence -->
        <div class="accordion-group">
            <!-- Taxonomy ------------------------------------- -->
            <div class="accordion-heading">
                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#collapseThree"
                href="#collapseThree">
                <i class="icon-plus"></i>
                Taxonomy
                </a>
            </div>
            <div id="collapseThree" class="accordion-body collapse" style="height: 0px;">
                <div class="accordion-inner">
                    <p>
                        <strong>
                            Domain:
                        </strong>
                        <?php echo $record[ 'TAXONOMY'][ 'TAX_DOMAIN']; ?>
                            <br>
                            <strong>
                                Kingdom:
                            </strong>
                            <?php echo $record[ 'TAXONOMY'][ 'TAX_KINGDOM']; ?>
                                <br>
                                <strong>
                                    Phylum:
                                </strong>
                                <?php echo $record[ 'TAXONOMY'][ 'TAX_PHYLUM']; ?>
                                    <br>
                                    <strong>
                                        Class:
                                    </strong>
                                    <?php echo $record[ 'TAXONOMY'][ 'TAX_CLASS']; ?>
                                        <br>
                                        <strong>
                                            Order:
                                        </strong>
                                        <?php echo $record[ 'TAXONOMY'][ 'TAX_ORDER']; ?>
                                            <br>
                                            <strong>
                                                Family:
                                            </strong>
                                            <?php echo $record[ 'TAXONOMY'][ 'TAX_FAMILY']; ?>
                                                <br>
                                                <strong>
                                                    Genus:
                                                </strong>
                                                <?php echo $record[ 'TAXONOMY'][ 'TAX_GENUS']; ?>
                                                    <br>
                                                    <strong>
                                                        Species:
                                                    </strong>
                                                    <?php echo $record[ 'TAXONOMY'][ 'TAX_SPECIES']; ?>
                                                        <br>
                                                        <strong>
                                                            Strain:
                                                        </strong>
                                                        <?php echo $record[ 'TAXONOMY'][ 'TAX_STRAIN']; ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- /taxonomy -->
        <div class="accordion-group">
            <!-- Vials ----------------------------------------- -->
            <div class="accordion-heading">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseFour" href="#collapseFour">
                <i class="icon-plus"></i>
                Vials
                </a>
            </div>
            <div id="collapseFour" class="accordion-body collapse">
                <div class="accordion-inner">
                    <?php if(!is_array($record[ 'VIAL'])){ echo $record[ 'VIAL']; }else{ $counter=0
                    ; foreach ($record[ 'VIAL'] as $vial){ echo '
                    <div class="accordion-group"> <!-- Vials -------------- -->
                    <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#collapse'.$counter.
                    '" href="#collapse'.$counter. '">
                    <i class="icon-plus"></i>
                    Vial Id: '.$vial[ 'VIAL_ID']. '
                    </a>'; if($this->
                        session->userdata('user_auth') === 'SPRUSER' || $this->session->userdata('user_auth')
                        === 'ADMIN'){ echo '
                        <div class="pull-right" style="margin-top: -29px; margin-right: 5px;">
                            <a href="/culture/delete/vial/'.$vial['VIAL_ID'].'" class="btn btn-danger btn-mini">Delete</a>
                        </div>
                        '; } echo '
                </div>
                <div id="collapse'.$counter.'" class="accordion-body collapse" style="height: 0px;">
                    <div class="accordion-inner">
                        <strong>
                            Growth Type:
                        </strong>
                        ' .$vial['VIAL_GROWTH_TYPE'].'
                        <br>
                        <strong>
                            Growth Temp:
                        </strong>
                        ' .$vial['VIAL_GROWTH_TEMP'].'
                        <br>
                        <strong>
                            Storage:
                        </strong>
                        ' .$vial['VIAL_STOR_LOC'].'
                        <br>
                        <strong>
                            Notes:
                        </strong>
                        ' .$vial['VIAL_NOTES'].'
                        <br>
                    </div>
                </div>
            </div>
            <!-- /Vial -->
            '; $counter++; } } ?>
        </div>
    </div>
</div>
<!-- /vials -->
<div class="accordion-group">
    <!-- DNARNA ------------------------------- -->
    <div class="accordion-heading">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseFive" href="#collapseFive">
        <i class="icon-plus"></i>
        DNA/RNA
        </a>
    </div>
    <div id="collapseFive" class="accordion-body collapse">
        <div class="accordion-inner">
            <!-- LOOP -->
            <?php if(!is_array($record[ 'DNARNA'])){ echo $record[ 'DNARNA']; }else{ foreach
            ($record[ 'DNARNA'] as $tube){ echo '
            <div class="accordion-group"> <!-- dnarna single -------------------------- -->
            <div class="accordion-heading">
            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#collapse'.$counter.
            '" href="#collapse'.$counter. '">
            <i class="icon-plus"></i>
            Id: '.$tube[ 'DNARNA_ID']. '
            </a>'; if($this->
                session->userdata('user_auth') === 'SPRUSER' || $this->session->userdata('user_auth')
                === 'ADMIN'){ echo '
                <div class="pull-right" style="margin-top: -29px; margin-right: 5px;">
                    <a href="/culture/delete/dnarna/'.$tube['DNARNA_ID'].'" class="btn btn-danger btn-mini">Delete</a>
                </div>
                '; } echo '
        </div>
        <div id="collapse'.$counter.'" class="accordion-body collapse" style="height: 0px;">
            <div class="accordion-inner">
                <strong>
                    Date Extracted:
                </strong>
                ' .$tube['DNARNA_DATE'].'
                <br>
                <strong>
                    Volume:
                </strong>
                ' .$tube['DNARNA_VOL'].'
                <br>
                <strong>
                    Concentration:
                </strong>
                ' .$tube['DNARNA_CONC'].'
                <br>
                <strong>
                    GenBank Number:
                </strong>
                ' .$tube['DNARNA_GBANKNUM'].'
                <br>
                <strong>
                    Notes:
                </strong>
                ' .$tube['DNARNA_NOTES'].'
                <br>
                <strong>
                    Image Caption:
                </strong>
                ' .(($tube['DNARNA_IMG_PATH'] != NULL) ? $tube['DNARNA_IMG_CAP'] : 'No Image Available')
                .'
            </div>
            <!-- DNARNA INNER END -->
            '; if(!is_null($tube['DNARNA_IMG_PATH'])){ echo '
            <div class="rdnathumb">
                <a class="thumbnail" target="_blank" href="'.$tube['DNARNA_IMG_PATH'].'"><img src="'.$tube['DNARNA_IMG_PATH'].'" alt="dna thumbnail" height="100px" width="100px"></a>
            </div>
            <!-- RDNA THUMB END -->
            '; } echo '
        </div>
        <!-- DNARNASINGLE INNER END -->
    </div>
    <!-- /dnarna single -->
    '; $counter++; } } ?>
</div>
<!-- COLLAPSEFIVE INNDER END -->
</div>
<!-- COLLAPSEFIVE END -->
</div>
<!-- DNARNA END -->
<div class="accordion-group">
    <!-- Reference ---------------------------------------- -->
    <div class="accordion-heading">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#collapseSix"
        href="#collapseSix">
        <i class="icon-plus"></i>
        Reference
        </a>
    </div>
    <!-- REFERENCE HEADING END -->
    <div id="collapseSix" class="accordion-body collapse" style="height: 0px;">
        <div class="accordion-inner">
            <p>
                <strong>
                    Owner:
                </strong>
                <?php echo $record[ 'CULTURE'][ 'CULT_OWNER'] ?>
                    <br>
                    <strong>
                        Reference Number:
                    </strong>
                    <?php echo $record[ 'CULTURE'][ 'CULT_REFNUM'] ?>
                        <br>
                        <strong>
                            External ID:
                        </strong>
                        <?php echo $record[ 'CULTURE'][ 'CULT_EXTERN_ID'] ?>
                            <br>
                            <strong>
                                Last Modified:
                            </strong>
                            <?php echo $record[ 'CULTURE'][ 'CULT_MODDATE'] ?>
            </p>
        </div>
        <!-- COLLAPSESIX INNDER END -->
    </div>
    <!-- COLLAPSESIX END -->
</div>
<!-- REFERENCE END -->
<div class="accordion-group">
    <!-- Notes --------------------------------------------- -->
    <div class="accordion-heading">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#collapseSeven"
        href="#collapseSeven">
        <i class="icon-plus"></i>
        Notes
        </a>
    </div>
    <!-- NOTES HEADING END -->
    <div id="collapseSeven" class="accordion-body collapse" style="height: 0px;">
        <div class="accordion-inner">
            <p>
                <?php echo $record[ 'CULTURE'][ 'CULT_NOTES'] ?>
            </p>
        </div>
        <!-- COLLAPSESEVEN INNDER END -->
    </div>
    <!-- COLLAPSESEVEN END -->
</div>
<!-- /notes -->
</div>
<!-- ACCORDIAN END -->
</div>
<!-- SPAN7 END -->
<script type="text/javascript">
    //Record
    //Toggle Accordian Icons - Has to be below the accordian
    $('.accordion').on('show hide', function(e) {
        $(e.target).siblings('.accordion-heading').find('.accordion-toggle i').toggleClass('icon-plus icon-minus', 200);
    });
</script>