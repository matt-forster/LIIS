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
 * Table
 *
 * The INITIAL users list table
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */
 -->

<div class="span6 list higher">
    <h1>
        Users
    </h1>
    <div id="userTable">
        <table class="table table-striped table-hover">
            <?php foreach($users as $user){ 
            echo '<tr id="'.$user[ 'USER_ID']. '"  onclick="selectUser(this)">
            <td>
            '.$user[ 'USER_FNAME']. ' '.$user[ 'USER_LNAME']. ' 
            </td>
            </tr>'; } ?>
        </table>
    </div>
</div>