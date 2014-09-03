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
 * Import Sidebar
 *
 * Addition to Import Status that shows the sidebar used for sample and culture imports
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */
 -->

<div class="span5" id="sidebar" style="margin-left:580px; margin-top: 50px;">
    <div class="well">
        <h3>
            Select File
        </h3>
        <form>
            <input type="file" id="userfile" required multiple/>
            <a id="startimport" class="btn btn-main">Start</a>
        </form>
        <div>
            <p class="small">Download import template: 
                <a href="<?php echo site_url('resources/download/LIIS_sample_import.TEMPLATE.csv'); ?>" target="_blank">sample</a> or
                <a href="<?php echo site_url('resources/download/LIIS_culture_import.TEMPLATE.csv'); ?>" target="_blank">culture</a>
        </div>
    </div>
    <div class="progress progress-striped active" id="progbar">
        <div class="bar" style="width: 100%;">
            Working
        </div>
    </div>
</div>
