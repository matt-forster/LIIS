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
 * Main Login View
 *
 * Loads the Login page
 *
 * @category    LIIS-View
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */
 -->

<div class='container higher'>
    <div class='row'>
        <div class='span12' id='space'>
        </div>
    </div>
    <div class='row center'>
        <div class='span12'>
            <div id="liislogo">
                <img src='<?php echo site_url('resources/img/liislogo.png'); ?>' alt='LIIS Logo' width='60%' height='60%'>
            </div>
        </div>
    </div>
    <div class='row center'>
        <div class='span12'>
            <h3 class="muted">
                Laboratory Information Indexing System
            </h3>
            <br>
            <p class="muted version">
                v
                <?php echo $version ?>
            </p>
        </div>
    </div>
    <div class='row'>
        <div class='span12' id='space'>
        </div>
    </div>
    <div class='row'>
        <div class="span3">
        </div>
        <div class="span6">
            <div class="well">
                <h3>
                    Login
                </h3>
                <form class="form-horizontal" action="" method="post" onsubmit="return false;" id="loginForm">
                    <input type='hidden' name="type" value='main' />
                    <div class="control-group">
                        <label class="control-label" for="user_name">
                            Username:
                        </label>
                        <div class="controls">
                            <input id='firstinput' type='text' name='user[USER_NAME]' value="" autofocus />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="user_pass">
                            Password:
                        </label>
                        <div class="controls">
                            <input type='password' name='user[USER_PASS]' value="" />
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <input type='submit' class='btn btn-large btn-primary button' value='Login' id="submitLogin"
                            />
                            <span>
                                or
                            </span>
                            <a data-toggle="modal" href="#usermgmt" id="usermgmtlink" class="">User Management</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="span3">
        </div>
    </div>
    <div class="row">
        <div class="span3">
        </div>
        <div class="span6" id="message">
        </div>
        <div class="span3">
        </div>
    </div>
    <div class='row'>
        <div class="span3">
        </div>
        <div class='span6 center'>
            <div>
            </div>
        </div>
        <div class="span3">
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#firstinput').focus();
        });

        $("#usermgmt").on('shown', function() {
            $('#mgmtUser').focus();
        });

        $("#usermgmt").on('hidden', function() {
            $('#firstinput').focus();
        });
    </script>