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
 * Culture Results
 *
 * The results table for the culture search
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */
 -->

<!-- Results Area -------------------------------- -->
<div class="span8">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>
                    Lab #
                </th>
                <th>
                    Reference #
                </th>
                <th>
                    External #
                </th>
                <th>
                    Location
                </th>
                <th>
                    Owner
                </th>
                <th>
                    Date
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row){ echo '<tr id="' . $row[ 'CULT_ID'] .
            '" onclick="highlightCell(this)">'; echo '<td >'. $row[ 'CULT_LABNUM'] . '</td>'; echo '<td >'. $row[
            'CULT_REFNUM'] . '</td>'; echo '<td >'. $row[ 'CULT_EXTERN_ID'] . '</td>'; echo '<td >'. $row[
            'CULT_STOR_LOC'] . '</td>'; echo '<td >'. $row[ 'CULT_OWNER'] . '</td>'; echo '<td >'. $row[
            'CULT_DATE'] . '</td>'; echo '</tr>'; } ?>
</div>
<!-- /span8 -->