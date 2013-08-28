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
 * Loads the sidebar used the in the culture search
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */
 -->

<!-- Picture and notes sidebar -------------------------------- -->
<div class="fixed" id="selected">
    <!-- FIXED-->
    <div class="span4">
        <div class="well" id="topwell">
            <div id="imgnotes">
                <img src="/resources/img/liislogo.png" class="img-rounded" alt="record-img" id="rcdimg">
                <h5 id="notes">
                    Quick Reference:
                </h5>
                <div class="well" id="botwell" data-position="left" data-intro="This is a small explanation of each filter. <br>It shows the order in which multi term searches use."
                data-step="3">
                    <small>
                        <strong>
                            %
                        </strong>
                        : Wildcard field entry. Ex. %2 or 2%.
                        <br>
                        <strong>
                            -
                        </strong>
                        : Wildcard field entirely. Ex. 2 - 1
                        <br>
                        <strong>
                            Cult
                        </strong>
                        :L#,Ref#,GB#,Loc,Owner,Date
                        <br>
                        <strong>
                            Date
                        </strong>
                        : Y,M,D
                        <br>
                        <strong>
                            Strain
                        </strong>
                        :St,Sp,Ge,Fa,Or,Cl,Ph,Ki,Do,Li
                        <br>
                        <a href="#">See Help</a>
                        for more info.
                    </small>
                </div>
            </div>
        </div>
        <!-- Sidebar Buttons -->
        <div data-position="left" data-intro="Use the view button to view a search result after you have selected it.<br> The Create button lets you add to the database. <br><br><strong>Click on the grey and search the wildcard, '%', then select and view a <br>record that appears!</strong>"
        data-step="5">
            <p class="muted">
                <a href="#" id="view" class="btn btn-main btn-large  widebtn">View</a>
                Current selected record.
            </p>
            <p class="muted">
                <a href="/culture/create/" class="btn btn-main btn-large widebtn">Create</a> a new record from scratch.
            </p>
            <!-- Two dynamically colored buttons -->
            <p class="muted">
                <?php
                    if($this->session->userdata('user_auth') === 'LIMITED'){ 
                        echo '<a href="#" class="btn btn-large widebtn disabled">Import</a>
                                records from a csv.';
                    }else{
                       echo '<a href="/culture/import/" class="btn btn-large widebtn">Import</a>
                                records from a csv.';
                    }
                ?>
                
            </p>
            <!-- Two dynamically colored buttons -->
            <p class="muted">
            <?php
                if($this->session->userdata('user_auth') === 'LIMITED'){ 
                    echo '<a href="#" class="btn btn-large widebtn disabled">Export</a>
                            a project to a csv.';
                }else{
                   echo ' <a href="/culture/export/" class="btn btn-large widebtn">Export</a>
                            a project to a csv.';
                }
            ?>
                
            </p>
        </div>
    </div>
</div>