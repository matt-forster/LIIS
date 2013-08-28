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
 * Update Controller
 *
 * Controls the logic involved in the updates after the first installation of the LIIS
 *
 * @category    LIIS-Controller
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */

class Update extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

        if($this->session->userdata('user_auth') === 'ADMIN'){ 
            redirect('/login/do_logout');
        }

		//Required Construct Variables
            $this->load->helper('liis');
            
            // $this->output->enable_profiler(TRUE);
            
            //sample model
            $this->load->model('update_model', 'update');
            
            //Title
            //Used By: views/templates/header.php
            //The title of the page
            $this->data['title'] = 'LIIS - Update';
            
            //CSS Files (Order matters)
            //Used by: views/templates/header.php
            //Use the name only, as the templates add the extension.
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


	}

    /**
    * index
    *
    * Function called if no parameters are passed to the controller
    * 
    * @access   public   
    * @return   HTML Views
    */
	public function index()
	{

	}

	
    /**
    * update
    *
    * Upated the database. Uses the codeigniter migration class.
    * application/migrations/
    * 
    * 
    * @access   public   
    * @return   HTML Views
    */
	public function update()
	{
		//migration
	}



}