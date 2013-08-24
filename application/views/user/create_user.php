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
 * Create User
 *
 * The AJAX create user blank form (without wrapper divs)
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */
 -->

<form>
    <div class="span6" id="leftSide">
        <div class="head">
            User Info
        </div>
        <div class="tBoxContainer topContainer">
            <input type="text" class="tBox" name="user[NAME]" id="name" value="">
            &nbsp;Name
        </div>
        <div class="tBoxContainer">
            <input type="text" class="tBox" name="user[USER_NAME]" id="username" value="">
            &nbsp;Username
        </div>
        <div class="tBoxContainer">
            <input type="text" class="tBox" name="user[USER_PASS]" id="password" value="">
            &nbsp;Password
        </div>
    </div>
    <div class="span6" id="rightSide">
        <div class="head">
            User Type
        </div>
        <div class="Container topContainer">
            <label class="radio">
                <input type="radio" value="ADMIN" id="admin" name="user[USER_AUTH]">
                Admin
            </label>
        </div>
        <div class="permContainer">
            <label class="radio">
                <input type="radio" value="SPRUSER" id="superUser" name="user[USER_AUTH]">
                Super User
            </label>
        </div>
        <div class="permContainer">
            <label class="radio">
                <input type="radio" value="USER" id="user" name="user[USER_AUTH]">
                User
            </label>
        </div>
        <div class="permContainer">
            <label class="radio">
                <input type="radio" value="LIMITED" id="limited" name="user[USER_AUTH]" checked>
                Limited User
            </label>
        </div>
    </div>
</form>
<div class="row-fluid">
    <div class="span6" id="leftSide">
        <p class="muted">
            <a onclick="createUser()" class="btn btn-large btn-primary" id="createuser">Create</a>
        </p>
    </div>
    <div class="span6" id="rightSide">
        <p class="muted">
            <button onclick="clearForm()" class="btn btn-large btn-danger" id="canceluser">
                Cancel
            </button>
        </p>
    </div>
</div>