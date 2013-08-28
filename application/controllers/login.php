<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
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
 * Login Controller
 *
 * Loads the login page and dictates the login and logout scripts
 *
 * @category    LIIS-Controller
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */

class Login extends CI_Controller
{
    
    //Variable array that is passed to the views
    protected $data = array();
    
    
    
    public function __construct()
    {
        parent::__construct();
        
        //Required Construct Variables
            $this->load->helper('liis');
            
            // $this->output->enable_profiler(TRUE);
            
            //sample model
            $this->load->model('user_model', 'user');
            
            //Title
            //Used By: views/templates/header.php
            //The title of the page
            $this->data['title'] = 'LIIS - Login';
            
            //CSS Files (Order matters)
            //Used by: views/templates/header.php
            //Use the name only, as the template add the extension.
            $this->data['cssList'] = array(
                'bootstrap',
                'main',
                'sample'
            );
            
            //Javascript files (Order matters)
            //Used by: views/templates/header.php
            //Use the name only, as the template add the extension.
            $this->data['scriptList'] = array(
                'jquery',
                'bootstrap',
            );
            // !! MAIN.JS IS LOADED IN views/templates/footer.php
            
            //Context set
            //Used by: views/templates/navbar.php
            //To tell the navbar which menu item to highlight
            $this->data['sample']  = 'active';
            $this->data['culture'] = '';
            
            //Current Version
            //Used by: views/templates/navbar.php
            $this->data['version'] = $this->config->item('version');
            
        $this->data['message'] = array();
    }
    
    /**
    * index
    *
    * Function called if no parameters are passed to the controller
    * Shows the login page
    * 
    * @access   public   
    * @return   HTML Views
    */
    public function index()
    {
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/container_start', $this->data);
        $this->load->view('templates/content_start', $this->data);
        $this->load->view('login/main_login', $this->data);
        $this->load->view('login/userm_login', $this->data);
        $this->load->view('templates/content_end', $this->data);
        $this->load->view('templates/container_end', $this->data);
        $this->load->view('templates/footer', $this->data);
    }
    
    /**
    * do_login
    *
    * AJAX
    * Uses the login data from index() to log into the application
    *
    * Requires POST data
    * 
    * @access   public   
    * @return   HTML Views
    */
    public function do_login()
    {
        
        $this->data['user']              = $this->input->post('user');
        $this->data['user']['USER_PASS'] = md5($this->data['user']['USER_PASS']);
        $type                            = $this->input->post('type');
        
        $user = $this->user->selectUser($this->data['user']['USER_NAME'], 'USER_NAME');
        if ($user)
            $user = reset($user);
        
        if (!$user) {
            setMessage("Invalid User.", 'error', $this->data['message']);
            $this->load->view('templates/message', $this->data);
            return;
        } //!$user
        if ($user['USER_PASS'] != $this->data['user']['USER_PASS']) {
            setMessage("Invalid Password.", 'error', $this->data['message']);
            $this->load->view('templates/message', $this->data);
            return;
        } //$user['USER_PASS'] != $this->data['user']['USER_PASS']
        
        if ($type == 'main') {
            $session = array(
                'logged_in' => 1,
                'user_id' => $user['USER_ID'],
                'user' => $user['USER_FNAME'],
                'tutorial' => FALSE,
                'user_auth' => $user['USER_AUTH']
            );
            
            $this->session->set_userdata($session);
            echo '<script>window.location="/sample/"</script>';
        } //$type == 'main'
        elseif ($type == 'user') {
            if ($user['USER_AUTH'] == 'ADMIN') {
                $session = array(
                    'logged_in' => 1,
                    'user' => $user['USER_FNAME'],
                    'user_id' => $user['USER_ID'],
                    'tutorial' => FALSE,
                    'user_auth' => $user['USER_AUTH'],
                    'usermgmt' => TRUE
                );
                $this->session->set_userdata($session);
                echo '<script>window.location="/user/"</script>';
            } //$user['USER_AUTH'] == 'ADMIN'
            else {
                setMessage('Unauthorized.', 'error', $this->data['message']);
                $this->load->view('templates/message', $this->data);
                return;
            }
        } //$type == 'user'  
    }
    
    /**
    * do_logout
    *
    * Destroys session and redirects to login page
    * 
    * @access   public   
    * @return   
    */
    public function do_logout()
    {
        $this->session->sess_destroy();
        echo '<script>window.location="/login"</script>';
    }
    
}