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
 * User box
 *
 * The INITIAL user form with the wrapper divs
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */
 -->

<div class="span6">
    <div class="progress progress-striped active" id="progbar" style="width: 300px; margin-top: -40px; margin-left: 80px; border-radius: 5px;">
        <div class="bar" style="width: 100%;">
            Loading
        </div>
    </div>
    <div class="row-fluid well" id="userbox">
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
    </div>
    <div class="row-fluid">
        <div id="createButton">
            <p class="muted">
                <button class="btn btn-large btn-primary button" id="clear-btn">
                    Clear Form
                </button>
                to create New User.
            </p>
        </div>
        <div id="userfeedback">
        </div>
    </div>