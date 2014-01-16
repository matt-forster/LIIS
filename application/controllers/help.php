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
 * Help Controller
 *
 * Loads the help pages for both the main functions and the user management
 *
 * @category    LIIS-Controller
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */

class Help extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        //Required Construct Variables
            if (!$this->session->userdata('logged_in')) {
                echo '<script>window.location="/login"</script>';
            } //$this->session->userdata('logged_in')
            
            $this->load->helper('liis');
            
            // $this->output->enable_profiler(TRUE);
            
            //culture model
            $this->load->model('culture_model', 'culture');
            
            //Title
            //Used By: views/templates/header.php
            //The title of the page
            $this->data['title'] = 'LIIS - Culture - Help';
            
            //CSS Files (Order matters)
            //Used by: views/templates/header.php
            //Use the name only, as the template add the extension.
            $this->data['cssList'] = array(
                'bootstrap',
                'main',
                'sample'
            );
            
            //Javascript files
            //Used by: views/templates/header.php
            //Use the name only, as the template add the extension.
            $this->data['scriptList'] = array(
                'jquery',
                'bootstrap',
            );
            // !! MAIN.JS IS LOADED IN views/templates/footer.php
            
            //Current Version
            //Used by: views/templates/navbar.php
            $this->data['version'] = $this->config->item('version');
        
            //Context set
            //Used by: views/templates/navbar.php
            //To tell the navbar which menu item to highlight
            $this->data['sample']  = 'active';
            $this->data['culture'] = '';

            $this->load->add_package_path(APPPATH.'third_party/parsedown/');
            $this->load->library('Parsedown');
            $this->load->remove_package_path();
        
    }
    
    /**
    * index
    *
    * Function called if no parameters are passed to the controller
    * calls the function main()
    * 
    * @access   public   
    * @return   
    */
    public function index()
    {
        $this->main();
    }
    
    /**
    * main
    *
    * Shows the main help.
    * 
    * @access   public   
    * @return   HTML Views
    */
    public function main()
    {
        $this->data['title'] = 'LIIS - Help';
        $markdown = $this->load->file(APPPATH.'views/help/main.md', TRUE);
        
        $this->data['help_main'] = $this->parsedown->parse($markdown);

        //Load page
        $this->load->view('templates/header', $this->data);
        
        $this->load->view('templates/navbar', $this->data);
        $this->load->view('templates/container_start');
        
        $this->load->view('templates/content_start');
        $this->load->view('help/help_main', $this->data);
        $this->load->view('templates/content_end');
        
        $this->load->view('templates/container_end');
        
        $this->load->view('templates/footer', $this->data);
    }
    
    /**
    * user
    *
    * Shows the user help.
    * 
    * @access   public   
    * @return   HTML Views
    */
    public function user()
    {
        $this->data['title'] = 'LIIS - User - Help';
        $markdown = $this->load->file(APPPATH.'views/help/user.md', TRUE);
        
        $this->data['help_user'] = $this->parsedown->parse($markdown);

        //Load page
        $this->load->view('templates/header', $this->data);
        
        $this->load->view('templates/usernav', $this->data);
        $this->load->view('templates/container_start');
        
        $this->load->view('templates/content_start');
        $this->load->view('help/help_user', $this->data);
        $this->load->view('templates/content_end');
        
        $this->load->view('templates/container_end');
        
        $this->load->view('templates/footer', $this->data);
    }
    
}