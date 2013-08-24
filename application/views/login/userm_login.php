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
 * User Management Login
 *
 * Loads the user management login modal
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */
 -->

<div class="container">
    <div id="usermgmt" class="modal hide" style="display: none; ">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3>
                User Management
            </h3>
        </div>
        <div class="modal-body">
            <h4>
                Login
            </h4>
            <form class="form-horizontal" action="" method="post" onsubmit="return false;" id="userForm">
                <input type='hidden' name="type" value='user' />
                <div class="control-group">
                    <label class="control-label" for="user_name">
                        Username:
                    </label>
                    <div class="controls">
                        <input type="text" id="mgmtUser" placeholder="username" name="user[USER_NAME]" autofocus>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="user_pass">
                        Password:
                    </label>
                    <div class="controls">
                        <input type="password" id="mgmtPass" placeholder="password" name="user[USER_PASS]">
                    </div>
                </div>
        </div>
        <div class="modal-footer">
            <button id="submitUserLogin" type="submit" class="btn btn-primary" name="type" value="user">
                Login
            </button>
            <a href="#" class="btn" data-dismiss="modal">Close</a>
        </div>
        </form>
    </div>
    <p>
</div>
</div>