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
 * Modals
 *
 * The delete user confirmation modal
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */
 -->

<div class="container">
    <div id="deletewarning" class="modal hide fade in" style="display: none; ">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3>
                Delete User
            </h3>
        </div>
        <div class="modal-body">
            Are you sure you want to delete this user?
        </div>
        <div class="modal-footer">
            <button class="btn btn-danger" onclick="deleteUser()" data-dismiss="modal" id="deleteconfirm">
                Yes
            </button>
            <a class="btn" data-dismiss="modal">No - Close this window</a>
        </div>
        </form>
    </div>
    <p>
</div>