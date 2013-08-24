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
 * Update User
 *
 * The user form that has pre-loaded values for updating users
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
        <input type="hidden" name="user[USER_ID]" value="<?php echo $user['USER_ID'] ?>">
        <div class="tBoxContainer topContainer">
            <input type="text" class="tBox" name="user[NAME]" id="name" value="<?php echo $user['USER_FNAME'].' '.$user['USER_LNAME']?>">
            &nbsp;Name
        </div>
        <div class="tBoxContainer">
            <input type="text" class="tBox" name="user[USER_NAME]" id="username" value="<?php echo $user['USER_NAME']?>">
            &nbsp;Username
        </div>
        <div class="tBoxContainer">
            <input type="text" class="tBox" name="user[USER_PASS]" id="password" value="" placeholder="****">
            &nbsp;Password
        </div>
    </div>
    <div class="span6" id="rightSide">
        <div class="head">
            User Type
        </div>
        <div class="Container topContainer">
            <label class="radio">
                <input type="radio" value="ADMIN" id="admin" name="user[USER_AUTH]" <?php echo (($user[
                'USER_AUTH']=='ADMIN' ) ? 'checked' : NULL) ?>
                >Admin
            </label>
        </div>
        <div class="permContainer">
            <label class="radio">
                <input type="radio" value="SPRUSER" id="superUser" name="user[USER_AUTH]" <?php
                echo (($user[ 'USER_AUTH']=='SPRUSER' ) ? 'checked' : NULL) ?>
                >Super User
            </label>
        </div>
        <div class="permContainer">
            <label class="radio">
                <input type="radio" value="USER" id="user" name="user[USER_AUTH]" <?php echo (($user[
                'USER_AUTH']=='USER' ) ? 'checked' : NULL) ?>
                >User
            </label>
        </div>
        <div class="permContainer">
            <label class="radio">
                <input type="radio" value="LIMITED" id="limited" name="user[USER_AUTH]" <?php echo
                (($user[ 'USER_AUTH']=='LIMITED' ) ? 'checked' : NULL) ?>
                >Limited User
            </label>
        </div>
    </div>
</form>
<div class="row-fluid">
    <div class="span6" id="leftSide">
        <p class="muted">
            <a onclick="updateUser()" class="btn btn-large btn-primary" id="updateuser">Update</a>
        </p>
    </div>
    <div class="span6" id="rightSide">
        <p class="muted">
            <a data-toggle="modal" href="#deletewarning" class="btn btn-large btn-danger">Delete</a>
        </p>
    </div>
</div>