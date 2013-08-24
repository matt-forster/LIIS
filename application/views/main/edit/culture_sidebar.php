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
 * Culture Edit sidebar
 *
 * Addition to the Culture Create Form which adds the sidebar used in edit functions
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @author      Graham Fluet
 * @link        http://github.com/forstermatth/liis
 */
 -->

<div class="span3" id="sidebar">
    <div class="well text-center">
        <a class="btn btn-main btn-large" id="editCulture" data-position="left" data-intro="Click this button to record your data!"
        data-step="2">Save Culture 	</a>
        </br>
        </br>
        <a class="btn btn-large" id="addvial" data-position="left" data-intro="Click this button to add another vial to the culture."
        data-step="3">Add Vial			</a>
        </br>
        </br>
        <a class="btn btn-large" id="adddnarna" data-position="left" data-intro="Click this button to add DNA or RNA to the culture."
        data-step="4">Add DNA/RNA	</a>
        </br>
        </br>
        <div class="row" style="padding-left: 20px;">
            <a class="btn btn-danger" type="button" onClick="javascript:window.history.go(-1)"
            data-position="left" data-intro="Click this to return to the last page,<br> without saving your data."
            data-step="5">Cancel</a>
            <span style="">
            </span>
            <a class="btn btn-info" href="/culture/recent/" data-position="left" data-intro="Click this button to view the entries you made today!"
            data-step="6">Recent</a>
        </div>
    </div>

    <!-- loading bar -->
    <div class="progress progress-striped active" id="progbar">
        <div class="bar" style="width: 100%;">
            Loading
        </div>
    </div>
    <div id="messagearea" data-position="left" data-intro="Any errors that need correcting will show here."
    data-step="7">
        <div id="message">
        </div>
    </div>
</div>