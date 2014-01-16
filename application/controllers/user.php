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
 * User Controller
 *
 * Loads the User Management page and dicates related scripts
 *
 * @category    LIIS-Controller
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */

class User extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        //Required Construct Variables
            if (!$this->session->userdata('logged_in') || !$this->session->userdata('usermgmt')) {
                echo '<script>window.location="/login"</script>';
            } //$this->session->userdata('logged_in')
            
            $this->load->helper('liis');
            
            // $this->output->enable_profiler(TRUE);
            
            //sample model
            $this->load->model('user_model', 'user');
            
            //Title
            //Used By: views/templates/header.php
            //The title of the page
            $this->data['title'] = 'LIIS - User Management';
            
            
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
        
        //Message
        //Used by: views/templates/message
        //holds the errors for display
        //an array of arrays with the subkeys 'Message' and 'Type'
        //Format: array( array('Message' => '', 'Type' => ''), array('Message' =>...), ...)
        //Type can be: warning, error, success. Defaults warning.
        $this->data['message'] = array();
        //set at the time of use
        
        //Required
        //Used by: do_create()
        //Holds the required fields for record creation
        $this->data['required'] = array(
            'NAME',
            'USER_NAME',
            'USER_PASS',
            'USER_AUTH'
        );
        
        //Human
        //Used by: do_create()
        //Holds the human equivalants to the Database Field names.
        //Typically only needs to be set if the field is used in errors (ie. the required field errors).
        $this->data['human'] = array(
            'NAME' => 'Name',
            'USER_NAME' => 'Username',
            'USER_PASS' => 'User Password',
            'USER_AUTH' => 'User Authentication Level'
        );
    }
    
    /**
    * index
    *
    * Function called if no parameters are passed to the controller
    * Shows the basic user management page with the users listed
    * 
    * @access   public   
    * @return   HTML Views
    */
    public function index()
    {
        $this->data['users'] = $this->user->listUsers();
        
        //Load Page
        $this->load->view('templates/header', $this->data);
        
        $this->load->view('templates/usernav', $this->data);
        $this->load->view('templates/container_start');
        
        $this->load->view('templates/content_start');
        $this->load->view('user/table', $this->data);
        $this->load->view('user/userbox');
        $this->load->view('user/modals');
        $this->load->view('templates/content_end');
        
        $this->load->view('templates/container_end');
        
        $this->load->view('templates/footer', $this->data);
    }
    
    /**
    * listUsers
    *
    * AJAX
    * Shows the user table with the users populated
    * 
    * @access   public   
    * @return   HTML Views
    */
    public function listUsers()
    {
        $this->data['users'] = $this->user->listUsers();
        $this->load->view('user/user_table', $this->data);
    }
    
    /**
    * create
    *
    * AJAX
    * Loads the blank create user form
    * 
    * @access   public   
    * @return   HTML Views
    */
    public function create()
    {
        $this->load->view('user/create_user');
    }
    
    /**
    * do_create
    *
    * AJAX
    * Tests and creates a user based on the data passed from the user form. 
    *
    * Required POST data
    * 
    * @access   public   
    * @return   HTML Views
    */
    public function do_create()
    {
        $this->data['create'] = $this->input->post('user');
        
        
        foreach ($this->data['create'] as $field => $value) {
            
            $reqtable = $this->data['required'];
            
            if (in_array($field, $reqtable)) {
                if (empty($value)) {
                    setMessage("<strong>Required:</strong> " . $this->data['human'][$field], 'warning', $this->data['message']);
                } //empty($value)
            } //in_array($field, $reqtable)
            
            if ($field == 'USER_NAME') {
                try {
                    $user = $this->user->selectUser($value, 'USER_NAME');
                }
                catch (Exception $e) {
                    echo 'Something went Wrong';
                }
                if (!empty($user)) {
                    setMessage('<strong>Error:</strong> The user name: ' . $value . ' is already in use.', 'error', $this->data['message']);
                } //empty($user)
            } //$field == 'USER_NAME'
        } //$this->data['create'] as $field => $value
        
        if (sizeof($this->data['message']) > 0) {
            $this->load->view('templates/message', $this->data);
            return;
        } //sizeof($this->data['message']) > 0
        
        $this->data['create']['USER_PASS'] = md5($this->data['create']['USER_PASS']);
        $this->user->createUser($this->data['create']);
        setMessage('<strong>Success!</strong> The user: ' . $this->data['create']['USER_NAME'] . ' has been created.', 'success', $this->data['message']);
        $this->load->view('templates/message', $this->data);
    }
    
    /**
    * do_delete
    *
    * AJAX
    * Deletes the user record with the ID passed
    * 
    * @access   public   
    * @param    id      int     The user ID to be deleted
    * @return   HTML Views
    */
    public function do_delete($id)
    {
        if (sizeof($this->user->listUsers()) < 2) {
            $this->setMessage("Cannot delete the last user!", 'error', $this->data['message']);
        } //sizeof($this->user->listUsers()) < 2
        
        if (sizeof($this->data['message']) > 0) {
            $this->load->view('templates/message', $this->data);
            return;
        } //sizeof($this->data['message']) > 0
        
        $this->user->deleteUser($id);
        setMessage('<strong>Success!</strong> The user has been deleted.', 'success', $this->data['message']);
        $this->load->view('templates/message', $this->data);
    }
    
    /**
    * update
    *
    * AJAX
    * Loads the user update form with the inputs filled by the user ID passed
    * 
    * @access   public   
    * @param    id      int     The user ID to be updated
    * @return   HTML Views
    */
    public function update($id)
    {
        $this->data['user'] = reset($this->user->selectUser($id));
        $this->load->view('user/update_user', $this->data);
    }
    
    /**
    * do_update
    *
    * AJAX
    * updates the user based on the data passed from the user form
    *
    * Requires POST data 
    * 
    * @access   public   
    * @return   HTML Views
    */
    public function do_update()
    {
        $this->data['update'] = $this->input->post('user');
        if (!empty($this->data['update']['USER_PASS'])) {
            $this->data['update']['USER_PASS'] = md5($this->data['update']['USER_PASS']);
        } //empty($this->data['update']['USER_PASS'])
        else {
            unset($this->data['update']['USER_PASS']);
        }
        
        foreach ($this->data['update'] as $field => $value) {
            $reqtable = $this->data['required'];
            
            if (in_array($field, $reqtable)) {
                if ($field != 'USER_PASS' && empty($value)) {
                    setMessage("<strong>Required:</strong> " . $this->data['human'][$field], 'warning', $this->data['message']);
                } //$field != 'USER_PASS' && empty($value)
            } //in_array($field, $reqtable)
        } //$this->data['update'] as $field => $value
        
        if (sizeof($this->data['message']) > 0) {
            $this->load->view('templates/message', $this->data);
            return;
        } //sizeof($this->data['message']) > 0
        
        $this->user->updateUser($this->data['update']['USER_ID'], $this->data['update']);
        setMessage('<strong>Success!</strong> The user: ' . $this->data['update']['USER_NAME'] . ' has been updated.', 'success', $this->data['message']);
        $this->load->view('templates/message', $this->data);
    }
}