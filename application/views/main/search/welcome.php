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
 * Welcome
 *
 * The message shown if no search has been made
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */
 -->

<div class="span8">
    <h3>
        Search
    </h3>
    <div class="progress progress-striped active" id="progbar" style="margin-top: 50px; margin-left: 100px; width: 400px;">
        <div class="bar" style="width: 100%;">
            Searching
        </div>
    </div>
    <div id="results" data-position="bottom" data-intro="This is where your search terms will show up.<br> Click on a row to select it for viewing."
    data-step="4">
        <div class="span8">
            <p>
                Enter your search in the bar above.
                <br>
                For instructions on use, please
                <a href="<?php echo site_url('help/main'); ?>">visit the help page.</a>
            </p>
        </div>
    </div>
</div>