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
 * Culture Sidebar
 *
 * Addition to the Culture Accordian that loads the sidebar used in the Culture Record View
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */
 -->

<!-- Sidebar -->
<div class="fixed" id="record-mgmt">
    <div class="span4">
        <div class="well" data-position="left" data-intro="Here we see either the LIIS logo or the Culture image,<br> depending on the context."
        data-step="2">
            <?php echo (($record[ 'CULTURE'][ 'CULT_IMG_PATH'] !=NULL) ?
            '<a class="thumbnail" target="_blank" href="'.$record[ 'CULTURE'][ 'CULT_IMG_PATH']. '">' : '<a class="thumbnail" target="_blank" href="'.site_url('resources/img/liislogo.png').'">') ?>
                <img <?php echo (($record[ 'CULTURE'][ 'CULT_IMG_PATH'] !=NULL) ? 'src="'.$record['CULTURE'][ 'CULT_IMG_PATH']. '"' : 'src="'.site_url('resources/img/liislogo.png')."') ?>
                 alt="Culture Image or LIIS Logo" class="img-rounded" height="300px" id="rcdimg">
                </a>
                <h5 id="notes">
                    <?php echo (($record[ 'CULTURE'][ 'CULT_IMG_PATH'] !=NULL) ? 'Caption' : ' '); ?>
                </h5>
                <div class="well">
                    <?php echo (($record[ 'CULTURE'][ 'CULT_IMG_PATH'] !=NULL) ? $record[ 'CULTURE']['CULT_IMG_CAP'] : 'No Culture image available. Find the thumbnails for each DNA/RNA under the dropdowns.'); ?>
                </div>
        </div>
        <p class="muted" data-position="left" data-intro="Hit this button to add images!"
        data-step="3">
            <?php
                if($this->session->userdata('user_auth') === 'LIMITED'){ 
                    echo '<a class="btn btn-large disabled"> Add Images    </a>
                            to record.';
                }else{
                   echo '<a class="btn btn-large" id="addcultureimage"> Add Images    </a>
                        to record.';
                }
            ?>
        </p>
        <p class="muted" data-position="left" data-intro="Hit this button to expand all the information!"
        data-step="3">
            <a href="#" class="btn btn-large" onclick="$('.collapse').not('.in').collapse('show');return false;"> Expand    </a>
            all information.
        </p>
        <p class="muted" data-position="left" data-intro="Hit this button to collapse all the information!"
        data-step="4">
            <a href="#" class="btn btn-large" onclick="$('.collapse.in').collapse('hide');return false;"> Collapse  </a>
            all information.
        </p>
        <p class="muted" data-position="left" data-intro="Pressing this button brings you to the create page with<br> all the fields filled with data from this record."
        data-step="5">
            <?php
                if($this->session->userdata('user_auth') === 'LIMITED'){ 
                    echo '<a class="btn disabled btn-large"> Template  </a>
                         Use for new record.';
                }else{
                   echo '<a href='.site_url('culture/create/').'/'.$record['CULTURE']['CULT_ID'].'" class="btn btn-main btn-large"> Template  </a>
                         Use for new record.';
                }
            ?>
            
        </p>
        <p class="muted" data-position="left" data-intro="Pressing this button allows you to edit the information on this page.<br><br> <strong>Expand some of the information,<br> then click this button to edit the record you selected!</strong>"
        data-step="6">
            <?php
                if($this->session->userdata('user_auth') === 'LIMITED'){ 
                    echo ' <a class="btn disabled btn-large">Edit</a>
                        Change current record.';
                }else{
                   echo ' <a href="'.site_url('culture/edit/').'/'.$record['CULTURE']['CULT_ID'].'" class="btn btn-main btn-large" id="editbtn">Edit</a>
                        Change current record.';
                }
            ?>
        </p>
        <br>
        <br>
        <?php if($this->session->userdata('user_auth') === 'SPRUSER' || $this->session->userdata('user_auth') === 'ADMIN'){ 
            echo '
            <div class="alert alert-danger">
                <h5 style="margin-top: -5px;">
                    Danger
                </h5>
                <p class="muted">
                    <a href="'.site_url('culture/delete/culture/').'/'.$record['CULTURE']['CULT_ID'].'" class="btn btn-danger">Delete</a>
                    record.
                </p>
            </div>
            '; } ?>
    </div>
    <!-- /span4 -->
</div>
<!-- /record mgmt -->