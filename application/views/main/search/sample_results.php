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
 * Sample Results
 *
 * The results table used for the sample search
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
                    Project
                </th>
                <th>
                    Sample
                </th>
                <th>
                    Type
                </th>
                <th>
                    Period
                </th>
                <th>
                    Stored
                </th>
                <th>
                    Date
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row){ echo '<tr id="' . $row[ 'SAMP_EXP_ID']. '/' .$row[
            'SAMP_ID']. '" onclick="highlightCell(this)">'; echo '<td >'. $row[ 'SAMP_EXP_ID'] .
            '</td>'; echo '<td >'. $row[ 'SAMP_ID'] . '</td>'; echo '<td >'. $row[ 'SAMP_TYPE'] .
            '</td>'; echo '<td >'. $row[ 'SAMP_PERIOD'] . '</td>'; echo '<td >'. $row[
            'SAMP_STOR_LOC'] . '</td>'; echo '<td >'. $row[ 'SAMP_DATE'] . '</td>'; echo '</tr>'; } ?>
</div>
<!-- /span8 -->