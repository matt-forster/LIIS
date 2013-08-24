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
 * Export Sample Sidebar
 *
 * Addition to Export Status that loads the sidebar used by the sample context
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */
 -->

<div class="span5" id="sidebar" style="margin-left:580px; margin-top: 50px;">
    <div class="well">
        <h3>
            Select Project
        </h3>
        <p class="small muted">
            Select a project to export to a csv:
        </p>
        <form id="projectform" onsubmit="return false;">
            <select name="project">
                <option value="">
                    Choose One
                </option>
                <?php foreach ($projects as $project) { echo '<option value="' . $project . '">'
                . $project . '</option>'; } ?>
            </select>
            <a id="startexport" class="btn btn-main" style="margin-top: -10px; margin-left: 10px;">Start</a>
        </form>
        <p class="small muted">
        </p>
    </div>
    <div class="progress progress-striped active" id="progbar">
        <div class="bar" style="width: 100%;">
            Working
        </div>
    </div>
</div>