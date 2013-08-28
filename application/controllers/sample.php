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
 * Sample Controller
 *
 * Loads the Sample context and dictates buisness logic.
 *
 * @category    LIIS-Controller
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */

class Sample extends CI_Controller
{
    
    //Variable array that is to be passed to the views. See Constructor.
    protected $data = array();
    
    //Fields passed to search. See Constructor.
    protected $searchList;
    
    
    public function __construct()
    {
        parent::__construct();
        
        //Required Construct Variables
            if (!$this->session->userdata('logged_in')) {
                echo '<script>window.location="/login"</script>';
            } //!$this->session->userdata('logged_in')
            
            $this->load->helper('liis');
            
            // $this->output->enable_profiler(TRUE);
            
            //culture model
            $this->load->model('sample_model', 'sample');
            
            //Title
            //Used By: views/templates/header.php
            //The title of the page
            $this->data['title'] = 'LIIS - Sample - ';
            
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
        
        //Select List
        //Used By: sample_model/selectlist, views/main/search/sampleresults.php
        //The list used for the search results page
        $this->searchList = array(
            'SAMPLE.SAMP_EXP_ID',
            'SAMPLE.SAMP_ID',
            'SAMPLE.SAMP_TYPE',
            'SAMPLE.SAMP_PERIOD',
            'SAMPLE.SAMP_STOR_LOC',
            'SAMPLE.SAMP_DATE'
        );
        
        //Search Results
        //Used by: views/main/search/sampleresults.php
        $this->data['results'] = FALSE;
        
        //Record
        //Used by: view(), views/record/sample_accordian
        //Holds the record data for viewing
        $this->data['record'] = NULL;
        
        //Ids
        //Used by: do_create()
        //To identify the ID of each table
        $this->data['ids'] = array(
            'SAMPLE' => array(
                'SAMP_EXP_ID',
                'SAMP_ID'
            ),
            'SOURCE' => 'SOURCE_ID',
            'DNARNA' => 'DNARNA_ID'
        );
        
        //Required
        //Used by: do_create()
        //Holds the required fields for record creation
        $this->data['required']           = array();
        $this->data['required']['SAMPLE'] = array(
            'SAMP_ID',
            'SAMP_EXP_ID',
            'SAMP_DATE',
            'SAMP_STOR_LOC'
        );
        $this->data['required']['SOURCE'] = array(
            'SOURCE_NUM'
        );
        $this->data['required']['DNARNA'] = array(
            'DNARNA_ID',
            'DNARNA_TYPE',
            'DNARNA_DATE'
        );
        
        //Message
        //Used by: do_create(), views/main/create/errors
        //holds the errors for display
        $this->data['message'] = array();
        //set at the time of use
        
        //Create
        //Used by: do_create()
        //Holds the POST data from create form
        $this->data['create'] = NULL;
        //Set at time of use
        
        //Human
        //Used by: do_create()
        //Holds the human equivalants to the Database Field names.
        //Typically only needs to be set if the field is used in errors (ie. the required field errors).
        $this->data['human'] = array(
            'SAMP_ID' => 'Sample ID',
            'SAMP_EXP_ID' => 'Project Name',
            'SAMP_DATE' => 'Sample Date',
            'SAMP_STOR_LOC' => 'Storage Location',
            'SOURCE_NUM' => 'Source ID Number',
            'DNARNA_ID' => 'DNARNA ID',
            'DNARNA_TYPE' => 'DNARNA Type',
            'DNARNA_DATE' => 'DNARNA Date'
        );
    }
    
    /**
    * index
    *
    * Function called if no parameters are passed to the controller
    * Shows the search page.
    * 
    * @access   public   
    * @return   HTML Views
    */
    public function index()
    {
        $this->data['title'] = 'LIIS - Sample - Search';
        
        //Load Page
        $this->load->view('templates/header', $this->data);
        
        $this->load->view('templates/navbar', $this->data);
        $this->load->view('templates/container_start');
        $this->load->view('main/search/sample_searchbar');
        
        $this->load->view('templates/content_start');
        $this->load->view('main/search/welcome');
        $this->load->view('main/search/sample_sidebar');
        $this->load->view('templates/content_end');
        
        $this->load->view('templates/container_end');
        
        $this->load->view('templates/footer', $this->data);
    }
    
    /**
    * recent
    *
    * Shows the search page in preparation for loading the recent search. The URI of this method automatically
    * triggers the javascript responsible for the recent search.
    *
    * @access   public 
    * @return   HTML Views 
    */
    public function recent()
    {
        $this->data['title'] = 'LIIS - Sample - Recent';
        
        //Load page
        $this->load->view('templates/header', $this->data);
        
        $this->load->view('templates/navbar', $this->data);
        $this->load->view('templates/container_start');
        $this->load->view('main/search/sample_searchbar');
        
        $this->load->view('templates/content_start');
        $this->load->view('main/search/welcome');
        $this->load->view('main/search/sample_sidebar');
        $this->load->view('templates/content_end');
        
        $this->load->view('templates/container_end');
        
        $this->load->view('templates/footer', $this->data);
    }
    
    /**
    * do_search
    *
    * AJAX
    * Finds search results and then fills the search results template or shows the error template. 
    * 
    * Requires POST data.
    * 
    * @access   public    
    * @return   HTML View - sample_results OR error
    */
    public function do_search()
    {
        
        $this->data['query'] = $this->input->post('query');
        $userQuery           = createArray($this->input->post('query'));
        $activeFilter        = $this->input->post('filter');
        
        if (empty($this->data['query'])) {
            $this->load->view('main/search/error');
            return;
        } //empty($this->data['query'])
        
        $this->data['title'] = 'LIIS - Sample - Search: ' . $this->data['query'];
        
        switch ($activeFilter) {
            case 'sample':
                $sampleList            = array(
                    'SAMP_EXP_ID',
                    'SAMP_ID',
                    'SAMP_TYPE',
                    'SAMP_PERIOD',
                    'SAMP_STOR_LOC',
                    'SAMP_NOTES'
                );
                $this->data['results'] = $this->sample->search($userQuery, $sampleList, 'SAMPLE', $this->searchList);
                break;
            
            case 'daterange':
                $dateList              = array(
                    'SAMP_DATE'
                );

                if(sizeof($userQuery) > 2 ){
                    setMessage('Please provide one (1) or two (2) search parameters for the date search. (Remember spaces separate parameters)', 'warning', $this->data['message']);
                    $this->load->view('templates/message', $this->data);
                    $this->load->view('main/search/error');
                    return;
                }
                $this->data['results'] = $this->sample->search($userQuery, $dateList, 'SAMPLE', $this->searchList, 'range');
                break;
            
            case 'source':
                $custom                = 'SOURCE.SOURCE_ID = `SAMPLE`.`SOURCE_ID`';
                $sourceList            = array(
                    'SOURCE.SOURCE_NUM',
                    'SOURCE.SOURCE_TYPE',
                    'SOURCE.SOURCE_SUBTYPE',
                    'SOURCE.SOURCE_TREATMENT'
                );
                $this->data['results'] = $this->sample->search($userQuery, $sourceList, 'SOURCE, SAMPLE', $this->searchList, 'like', $custom);
                break;
            
            case 'site':
                $siteList              = array(
                    'SAMP_SITE',
                    'SAMP_SUBSITE'
                );
                $this->data['results'] = $this->sample->search($userQuery, $siteList, 'SAMPLE', $this->searchList);
                break;
            
            case 'recent':
                $recent = array(
                    'SAMP_MODDATE',
                    'SAMP_USER'
                );
                
                $this->data['results'] = $this->sample->search(array(
                    date('Y-m-d'),
                    $this->session->userdata('user_id')
                ), $recent, 'SAMPLE', $this->searchList);
                break;
            
            
            default:
                break;
        } //$activeFilter
        
        if ($this->data['results']) {
            $this->load->view('main/search/sample_results', $this->data);
        } //$this->data['results']
        else {
            $this->load->view('main/search/error');
        }
    }
    
    /**
    * view
    *
    * Loads the record view template with a record. If no ID passed then redirects to the index.
    *
    * @access   public
    * @param    proj    string  The project to view
    * @param    id      string  The sample to view
    * @return   HTML Views
    */
    public function view($proj, $id = NULL)
    {
        $this->data['title'] = 'LIIS - Sample - View: ' . $proj . '/' . $id;
        
        //If no id passed, redirect to search page
        if ($id === NULL) {
            redirect('/sample');
        } //$id === NULL
        
        $this->data['record'] = $this->sample->selectOne($proj, $id);
        
        //Load page
        $this->load->view('templates/header', $this->data);
        
        $this->load->view('templates/navbar', $this->data);
        $this->load->view('templates/container_start');
        
        $this->load->view('templates/content_start');
        $this->load->view('main/record/sample_accordian', $this->data);
        $this->load->view('main/record/sample_sidebar', $this->data);
        $this->load->view('templates/content_end');
        
        $this->load->view('templates/container_end');
        
        $this->load->view('templates/footer', $this->data);
    }
    
    /**
    * create
    *
    * Shows the create page. If passed a project and id, then prefills the inputs with the selected record (template).
    * If passed TRUE for the edit function, it edits the record passed (called through edit function);
    * 
    * @access   public
    * @param    proj    string    The project that you wish to template from
    * @param    id      string    The id you wish to template from
    * @param    edit    bool      If you want to edit the record passed instead of template (called through the edit function)
    * @return   HTML Views
    */
    public function create($proj = NULL, $id = NULL, $edit = FALSE)
    {
        
        $this->data['preset'] = FALSE;
        if ($id != NULL) {
            $this->data['record'] = $this->sample->selectOne($proj, $id);
            $this->data['preset'] = TRUE;
        } //$id != NULL
        
        if ($edit) {
            $this->data['title'] = 'LIIS - Sample - Edit';
            $this->data['name']  = 'Edit';
        } //$edit
        else {
            $this->data['title'] = 'LIIS - Sample - Create';
            $this->data['name']  = 'Create';
        }
        
        $this->load->view('templates/header', $this->data);
        
        $this->load->view('templates/navbar', $this->data);
        $this->load->view('templates/container_start');
        $this->load->view('templates/content_start');
        $this->load->view('main/create/sample_form', $this->data);
        
        if ($this->data['preset']) {
            //DNARNA
            $this->load->view('main/create/dnarna_start');
            if (is_array($this->data['record']['DNARNA'])) {
                $this->data['dnarnaNum'] = 1;
                foreach ($this->data['record']['DNARNA'] as $dnarna) {
                    $this->data['DNARNA'] = $dnarna;
                    $this->load->view('main/create/dnarna', $this->data);
                    $this->data['dnarnaNum']++;
                } //$this->data['record']['DNARNA'] as $dnarna
            } //is_array($this->data['record']['DNARNA'])
            else {
                $this->data['dnarnaNum'] = 1;
                $this->data['preset']    = FALSE; //temp
                $this->load->view('main/create/dnarna', $this->data);
                $this->data['preset'] = TRUE;
            }
            $this->load->view('templates/div_end');
            
        } //$this->data['preset']
        else {
            $this->load->view('main/create/dnarna_start');
            $this->data['dnarnaNum'] = 1;
            $this->load->view('main/create/dnarna', $this->data);
            $this->load->view('templates/div_end');
        }
        
        if ($edit) {
            $this->load->view('main/edit/sample_sidebar', $this->data);
        } //$edit
        else {
            $this->load->view('main/create/sample_sidebar', $this->data);
        }
        
        $this->load->view('main/create/form_end');
        $this->load->view('templates/content_end');
        
        $this->load->view('templates/container_end');
        
        $this->load->view('templates/footer', $this->data);
    }
    
    /**
    * do_create
    *
    * AJAX
    * Tests and Creates a record based on the POST data passed. If edit is TRUE, will edit the record passed instead of creating.
    *
    * Requires POST data.
    *
    * @access   public
    * @param    edit    bool    trigger to edit instead of create record
    * @return   HTML Views
    */
    public function do_create($edit = FALSE)
    {
        
        $this->data['create']['SAMPLE'] = $this->input->post('sample');
        $this->data['create']['SOURCE'] = $this->input->post('source');
        
        $this->data['create']['DNARNA'] = array();
        foreach ($this->input->post('dnarna') as $dnarna) {
            array_push($this->data['create']['DNARNA'], $dnarna);
        } //$this->input->post('dnarna') as $dnarna
        
        $this->data['editIds'] = $this->input->post('ids');
        
        
        //TESTS
        //unset empty arrays (except sample)
        $this->data['create']['DNARNA'] = remove_empty_arrays($this->data['create']['DNARNA']);
        if (isEmpty($this->data['create']['SOURCE'])) {
            $this->data['create']['SOURCE'] = array();
        } //isEmpty($this->data['create']['SOURCE'])
        
        $this->data['create'] = array_filter($this->data['create']);
        
        //create nulls
        createNulls($this->data['create']);
        
        //Check for required fields
        foreach ($this->data['create'] as $table => $fields) {
            
            $reqtable = $this->data['required'][$table];
            
            if (is_array(reset($fields))) {
                foreach ($fields as $entity) {
                    $keys = array_keys($entity);
                    
                    foreach ($keys as $key) {
                        if (in_array($key, $reqtable)) {
                            if (empty($entity[$key])) {
                                setMessage("<strong>Required:</strong> " . $this->data['human'][$key], 'warning', $this->data['message']);
                            } //empty($entity[$key])
                        } //in_array($key, $reqtable)
                    } //$keys as $key
                } //$fields as $entity
            } //is_array(reset($fields))
            else {
                $keys = array_keys($fields);
                
                foreach ($keys as $key) {
                    if (in_array($key, $reqtable)) {
                        if (empty($fields[$key])) {
                            setMessage("<strong>Required:</strong> " . $this->data['human'][$key], 'warning', $this->data['message']);
                        } //empty($fields[$key])
                    } //in_array($key, $reqtable)
                } //$keys as $key
            }
            
        } //$this->data['create'] as $table => $fields
        
        //Check for duplicate Keys
        if (isset($this->data['create']['DNARNA'])) {
            $dnarna_keys = array();
            foreach ($this->data['create']['DNARNA'] as $dnarna) {
                array_push($dnarna_keys, $dnarna['DNARNA_ID']);
            } //$this->data['create']['DNARNA'] as $dnarna
            if (checkDuplicates($dnarna_keys)) {
                setMessage("<strong>Error:</strong> There are duplicate DNARNA Keys!", 'error', $this->data['message']);
            } //checkDuplicates($dnarna_keys)
        } //isset($this->data['create']['DNARNA'])
        
        
        //Check for existing records
        foreach ($this->data['create'] as $table => $fields) {
            
            //Special Case - Sample: The user has direct access to the ID's of these records so a check for 
            //just the IDs is necessary to ensure primary key duplication errors do not surface.
            if ($table == "SAMPLE") {
                
                $keys   = 'SAMP_EXP_ID, SAMP_ID';
                $values = array(
                    $fields['SAMP_EXP_ID'],
                    $fields['SAMP_ID']
                );
                if ($result = $this->sample->search($values, $keys, $table, $this->data['ids'][$table])) {
                    $exists[$table] = $result[0];
                } //$result = $this->sample->search($values, $keys, $table, $this->data['ids'][$table])
                
            } //$table == "SAMPLE"
            else {
                
                //The User has direct access to the DNARNA ID's, so we check IDs for all arrays that are passed 
                //(Only DNARNA will have multiple instances per record)
                if (is_array(reset($fields))) {
                    foreach ($fields as $field) {
                        $keys   = $this->data['ids'][$table];
                        $values = $field[$this->data['ids'][$table]];
                        if ($result = $this->sample->search($values, $keys, $table, $this->data['ids'][$table])) {
                            if (!isset($exists[$table]))
                                $exists[$table] = array(); //for array_push
                            array_push($exists[$table], $result[0][$this->data['ids'][$table]]);
                        } //$result = $this->sample->search($values, $keys, $table, $this->data['ids'][$table])
                    } //$fields as $field
                } //is_array(reset($fields))
                else {
                    
                    $keys   = array_keys($fields);
                    $values = array_values($fields);
                    if ($result = $this->sample->search($values, $keys, $table, $this->data['ids'][$table])) {
                        $exists[$table] = array(); //for array_push
                        array_push($exists[$table], $result[0][$this->data['ids'][$table]]);
                    } //$result = $this->sample->search($values, $keys, $table, $this->data['ids'][$table])
                }
            }
        } //$this->data['create'] as $table => $fields

        if($edit){

            //foreign key
            if (isset($exists['SOURCE'])) {
                if (!in_array($exists['SOURCE'][0]['SOURCE_ID'], $this->data['editIds']['SOURCE'])) {
                    unset($this->data['create']['SOURCE']);
                    $this->data['create']['SAMPLE']['SOURCE_ID'] = $exists['SOURCE'][0]['SOURCE_ID'];
                } //!in_array($exists['SOURCE'][0]['SOURCE_ID'], $this->data['editIds']['SOURCE'])
            }
            elseif (isset($this->data['create']['SOURCE'])) {
                $this->data['create']['SAMPLE']['SOURCE_ID'] = $this->sample->create_source($this->data['create']['SOURCE']);
                unset($this->data['create']['SOURCE']);
            } //$edit && isset($this->data['create']['SOURCE'])

            if (isset($exists['SAMPLE'])) {
                 if (!in_array($exists['SAMPLE']['SAMP_ID'], $this->data['editIds']['SAMPLE'])) {
                    setMessage("<strong>Error:</strong> The Sample: " . $exists['SAMPLE']['SAMP_EXP_ID'] . " " . $exists['SAMPLE']['SAMP_ID'] . " already exists!", 'error', $this->data['message']);
                } //!in_array($exists['SAMPLE']['SAMP_ID'], $this->data['editIds']['SAMPLE'])
            }
            elseif (isset($this->data['create']['SAMPLE'])) {
                $this->sample->update_sample($this->data['editIds']['SAMPLE'][0], $this->data['editIds']['SAMPLE'][1], $this->data['create']['SAMPLE']);
            } //isset($this->data['create']['SAMPLE'])

            //multiple records
            if (isset($exists['DNARNA'])) {
                foreach ($this->data['create']['DNARNA'] as $dnarna => $attributes) {
                    if (!in_array($attributes['DNARNA_ID'], $this->data['editIds']['DNARNA'])) {
                        if (in_array($attributes['DNARNA_ID'], $exists['DNARNA'])) {
                            setMessage("<strong>Error:</strong> The Genetic Record: " . $attributes['DNARNA_ID'] . " already exists!", 'error', $this->data['message']);
                        } //in_array($attributes['DNARNA_ID'], $exists{'DNARNA'})
                        elseif (sizeof($this->data['message']) < 1) {
                            $attributes['SAMP_ID']     = $this->data['create']['SAMPLE']['SAMP_ID'];
                            $attributes['SAMP_EXP_ID'] = $this->data['create']['SAMPLE']['SAMP_EXP_ID'];

                            if(!empty($attributes['dnarna_old_id'])){
                                $temp = $attributes['dnarna_old_id'];
                                unset($attributes['dnarna_old_id']);
                                $this->sample->update_dnarna($temp, $attributes);
                            }else{
                                unset($attributes['dnarna_old_id']);
                                $this->sample->create_dnarna($attributes);
                            }

                            unset($this->data['create']['DNARNA'][$dnarna]);
                        } //sizeof($this->data['message']) < 1
                    } //!in_array($attributes['DNARNA_ID'], $this->data['editIds']['DNARNA'])
                    unset($this->data['create']['DNARNA'][$dnarna]['dnarna_old_id']);
                } //$this->data['create']['DNARNA'] as $dnarna => $attributes
            }
            elseif (isset($this->data['create']['DNARNA']) && (sizeof($this->data['message']) < 1)) {
                foreach ($this->data['create']['DNARNA'] as $dnarna => $attributes) {
                    $attributes['SAMP_EXP_ID'] = $this->data['create']['SAMPLE']['SAMP_EXP_ID'];
                    $attributes['SAMP_ID']     = $this->data['create']['SAMPLE']['SAMP_ID'];
                    if(!empty($attributes['dnarna_old_id'])){
                        $temp = $attributes['dnarna_old_id'];
                        unset($attributes['dnarna_old_id']);
                        $this->sample->update_dnarna($temp, $attributes);
                    }else{
                        unset($attributes['dnarna_old_id']);
                        $this->sample->create_dnarna($attributes);
                    }                            
                    unset($this->data['create']['DNARNA'][$dnarna]);
                } //$this->data['create']['DNARNA'] as $dnarna => $attributes
                unset($this->data['create']['DNARNA']);
            } //isset($this->data['create']['DNARNA'])

        }
        else{ //Create

            //foreign key
            if (isset($exists['SOURCE'])) {
                unset($this->data['create']['SOURCE']);
                $this->data['create']['SAMPLE']['SOURCE_ID'] = $exists['SOURCE'][0]['SOURCE_ID']; //Search returns an array of arrays
            }

            if (isset($exists['SAMPLE'])) {
                setMessage("<strong>Error:</strong> The Sample: " . $exists['SAMPLE']['SAMP_EXP_ID'] . " " . $exists['SAMPLE']['SAMP_ID'] . " already exists!", 'error', $this->data['message']);
            }

            //multiple records
            if (isset($exists['DNARNA'])) {
                foreach ($exists['DNARNA'] as $dnarna) {
                    setMessage("<strong>Error:</strong> The Genetic Record: " . $dnarna['DNARNA_ID'] . " already exists!", 'error', $this->data['message']);
                } //$exists['DNARNA'] as $dnarna
            }

        }
        
        //end tests
        
        
        if (sizeof($this->data['message']) > 0) {
            $this->load->view('templates/message', $this->data);
            return;
        } //sizeof($this->data['message']) > 0
        
        if ($edit) {
            $this->sample->editRow($this->data['create']['SAMPLE']['SAMP_EXP_ID'], $this->data['create']['SAMPLE']['SAMP_ID'], $this->data['create']);
            setMessage('<strong>Success!</strong> The Sample: ' . $this->data['create']['SAMPLE']['SAMP_EXP_ID'] . ' ' . $this->data['create']['SAMPLE']['SAMP_ID'] . ' has been edited.', 'success', $this->data['message']);
        } //$edit
        else {
            $this->sample->createRow($this->data['create']);
            setMessage('<strong>Success!</strong> The Sample: ' . $this->data['create']['SAMPLE']['SAMP_EXP_ID'] . ' ' . $this->data['create']['SAMPLE']['SAMP_ID'] . ' has been created.', 'success', $this->data['message']);
        }
        $this->load->view('templates/message', $this->data);
    }
    
    /**
    * edit
    *
    * Calls the create function with the edit flagged as TRUE
    *
    * @access   public
    * @param    proj    string    The project to edit
    * @param    id      string    The sample to edit
    * @return   
    */
    public function edit($proj, $id)
    {
        if($this->session->userdata('user_auth') === 'LIMITED'){ 
            redirect('/login/do_logout');
        }

        $this->create($proj, $id, TRUE);
    }
    
    /**
    * do_edit
    *
    * AJAX
    * Calls the do_create function with the edit flagged as TRUE
    *
    * Required POST data.
    *
    * @access   public
    * @return   
    */
    public function do_edit()
    {   
        if($this->session->userdata('user_auth') === 'LIMITED'){ 
            redirect('/login/do_logout');
        }

        $this->do_create(TRUE);
    }
    
    /**
    * upload_image
    *
    * Calls the upload image form used to add an image to dnarna of the record passed
    *
    * @access   public
    * @param    proj    string    The project to add an image to
    * @param    id      string    The sample to add an image to
    * @return   HTML Views
    */
    public function upload_image($proj, $id)
    {
        if($this->session->userdata('user_auth') === 'LIMITED'){ 
            redirect('/login/do_logout');
        }

        $this->data['title'] = 'LIIS - Sample - Upload Image';
        
        $this->data['SAMPLE'] = $this->sample->get_sample($proj, $id);
        $this->data['DNARNA'] = $this->sample->get_dnarna($proj, $id);
        
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/container_start');
        $this->load->view('templates/content_start');
        $this->load->view('main/image/sample_image_form', $this->data);
        $this->load->view('templates/content_end');
        $this->load->view('templates/content_start');
        $this->load->view('main/image/span4');
        $this->load->view('templates/message', $this->data);
        $this->load->view('templates/div_end');
        $this->load->view('templates/content_end');
        $this->load->view('templates/container_end');
        $this->load->view('templates/footer', $this->data);
    }
    
    /**
    * do_upload_image
    *
    * AJAX
    * Adds the image passed to the dnarna selected from upload_image
    * 
    * Required POST data (incl. FILES)
    *
    * @access   public
    * @return   HTML Views
    */
    public function do_upload_image()
    {
        if($this->session->userdata('user_auth') === 'LIMITED'){ 
            redirect('/login/do_logout');
        }

        $image = array();
        $post  = $this->input->post();
        $proj  = $post['SAMP_EXP_ID'];
        $id    = $post['SAMP_ID'];
        
        
        $config['upload_path'] = realpath(dirname(dirname(dirname(__FILE__)))) . '/resources/upload/';
        
        if (isset($_FILES['userfile'])) {
            
            $file_name = $_FILES['userfile']['name'];
            $ext       = '.' . end(explode('.', $file_name));
            
            //upload picture
            
            $config['allowed_types'] = 'gif|jpg|png';
            $config['file_name']     = $post['DNARNA_ID'] . $ext;
            
            $this->load->library('upload', $config);
            
            
            if (!$this->upload->do_upload()) {
                setMessage($this->upload->display_errors(), 'error', $this->data['message']);
                $this->upload_image($proj, $id);
            } //!$this->upload->do_upload()
            else {
                $upload                   = $this->upload->data();
                $image['DNARNA_IMG_CAP']  = $post['SAMP_IMG_CAP'];
                $image['DNARNA_IMG_PATH'] = '/resources/upload/' . $upload['raw_name'] . $upload['file_ext'];
                $image['DNARNA_MODDATE']  = date('Y-m-d');
                $image['DNARNA_USER']     = $this->session->userdata('USER_ID');
                $this->sample->update_dnarna($post['DNARNA_ID'], $image);
                
                setMessage('<strong>Success!</strong> The file has been uploaded.', 'success', $this->data['message']);
                $this->upload_image($proj, $id);
            }
        } //isset($_FILES['userfile'])
    }
    
    /**
    * delete
    *
    * Deletes the record passed, whether it be a sample, source or dnarna
    *
    * @access   public
    * @param    table   string    The table to remove the record from
    * @param    proj    string    The project to remove the record from
    * @param    id      string    The sample to remove
    * @return   Javascript history back
    */
    public function delete($table, $id, $proj = NULL)
    {
        if($this->session->userdata('user_auth') === 'LIMITED'){ 
            redirect('/login/do_logout');
        }
        
        switch ($table) {
            case 'sample':
                $this->sample->delete_sample($proj, $id);
                echo '<script>window.location="/sample/"</script>';
                break;
            case 'source':
                $this->sample->delete_source($id);
                echo '<script>history.go(-1);</script>';
                break;
            case 'dnarna':
                $this->sample->delete_dnarna($id);
                echo '<script>window.location.replace(document.referrer);</script>';
                break;
            default:
                throw new Exception('Class: sample Method: delete - (1) Invalid Table');
        } //$table
    }
    
    /**
    * import
    *
    * Loads the page used for importing CSV files
    *
    * @access   public
    * @return   HTML Views
    */
    public function import()
    {
        $this->data['title'] = 'LIIS - Sample - Import CSV';
        
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/navbar', $this->data);
        $this->load->view('templates/container_start');
        $this->load->view('templates/content_start');
        $this->load->view('main/import/status.php');
        $this->load->view('main/import/sidebar.php');
        $this->load->view('templates/content_end');
        $this->load->view('templates/container_end');
        $this->load->view('templates/footer', $this->data);
    }
    
    /**
    * do_import
    *
    * AJAX
    * Takes the csv file uploaded from the import() form and adds it to the database after testing
    *
    * Requires POST data
    *
    * @access   public
    * @return   echo strings (log)
    */
    public function do_import()
    {
        echo '<br><br><span class="success">beginning script:</span>';
        if (!$_FILES) {
            echo '<br><span class="error">  error: No file selected!</span>';
            return;
        } //!$_FILES
        
        foreach ($_FILES as $file) {
            echo '<br>starting upload:';
            $fields = array();
            $insert = array();
            $rows   = array();
            $test   = array( //order matters
                'project_name',
                'sample_name',
                'collection_date',
                'collection_time',
                'collection_timezone',
                'samp_store_loc',
                'samp_period',
                'biome',
                'material',
                'samp_type',
                'feature_primary',
                'feature_secondary',
                'samp_lat',
                'samp_lon',
                'geo_loc_name',
                'country',
                'env_package',
                'notes',
                'source_subject_id',
                'source_name_primary',
                'source_name_secondary',
                'source_treatment'
            );
            
            $ext = end(explode('.', $file['name']));
            if ($ext !== 'csv') {
                echo '<br><span class="error">  error: wrong file type. only "csv" allowed.</span>';
                return;
            } //$ext !== 'csv'
            
            // echo '<pre>';
            // print_r($file);
            // echo '</pre>';
            
            $row = 1;
            echo '<br>opening file "' . $file['name'] . '"';
            if (($handle = fopen($file['tmp_name'], "r")) !== FALSE) {
                echo '<br>parsing';
                while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                    
                    $num = count($data);
                    
                    if ($row == 1) {
                        echo '<br>finding field names';
                        echo '<br>found:';
                        for ($i = 0; $i < $num; $i++) {
                            if (requiredError($data[$i], $test[$i])) {
                                $fields[$i] = $data[$i];
                                echo "<br>\t - " . $fields[$i];
                            } //requiredError($data[$i], $test[$i])
                            else {
                                return;
                            }
                        } //$i = 0; $i < $num; $i++
                        
                        $row++;
                        continue;
                    } //$row == 1
                    elseif ($row == 2) {
                        $row++;
                        continue;
                    } //$row == 2
                    else {
                        if ($row == 3)
                            echo '<br>adding rows:';
                        echo '<br> - ' . $row;
                        for ($i = 0; $i < $num; $i++) {
                            $data[$i] = trim($data[$i]);
                            switch ($fields[$i]) {
                                case 'project_name':
                                    if (strlen($data[$i]) > 10) {
                                        echo '<br><span class="error">  error: "project_name" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 10
                                    if (empty($data[$i])) {
                                        echo '<br><span class="error">  error: "project_name" on row ' . $row . ' is required.</span>';
                                        return;
                                    } //empty($data[$i])
                                    
                                    $insert['SAMP_EXP_ID'] = $data[$i];
                                    break;
                                
                                case 'sample_name':
                                    if (empty($data[$i])) {
                                        echo '<br><span class="error">  error: "sample_name" on row ' . $row . ' is required.</span>';
                                        return;
                                    } //empty($data[$i])
                                    if (!is_numeric($data[$i])) {
                                        echo '<br><span class="error">  error: "sample_name" on row ' . $row . ' is the wrong type.</span>';
                                        return;
                                    } //!is_numeric($data[$i])
                                    
                                    $insert['SAMP_ID'] = (int) $data[$i];
                                    break;
                                
                                case 'collection_date':
                                    if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $data[$i], $datebit)) {
                                        if(!checkdate($datebit[2] , $datebit[3] , $datebit[1])){
                                             echo '<br><span class="error">  error: "collection_date" on row ' . $row . ' has invalid date.</span>';
                                        }
                                    } else {
                                        echo '<br><span class="error">  error: "collection_date" on row ' . $row . ' is wrong format (yyyy-mm-dd required).</span>';
                                        return false;
                                    }
                                    
                                    if (empty($data[$i])) {
                                        echo '<br><span class="error">  error: "collection_date" on row ' . $row . ' is required.</span>';
                                        return;
                                    } //empty($data[$i])
                                    
                                    $insert['SAMP_DATE'] = $data[$i];
                                    break;
                                
                                case 'collection_time':
                                    if (!empty($data[$i]) && !preg_match('/^([01]\d|2[0123]):([0-5]\d):([0-5]\d)$/', $data[$i])) {
                                        echo '<br><span class="error">  error: "collection_time" on row ' . $row . ' is wrong format (hh:mm:ss required).</span>';
                                        return;
                                    } 
                                    
                                    $insert['SAMP_TIME'] = $data[$i];
                                    break;
                                
                                case 'collection_timezone':
                                    if (strlen($data[$i]) > 10) {
                                        echo '<br><span class="error">  error: "collection_timezone" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 10
                                    
                                    $insert['SAMP_TMZ'] = $data[$i];
                                    break;
                                
                                case 'samp_period':
                                    if (!empty($data[$i]) && !is_numeric($data[$i])) {
                                        echo '<br><span class="error">  error: "samp_period" on row ' . $row . ' is the wrong type.</span>';
                                        return;
                                    } //!empty($data[$i]) && !is_numeric($data[$i])
                                    
                                    $insert['SAMP_PERIOD'] = (int) $data[$i];
                                    break;
                                
                                case 'samp_store_loc':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "samp_store_loc" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    if (empty($data[$i])) {
                                        echo '<br><span class="error">  error: "samp_store_loc" on row ' . $row . ' is required.</span>';
                                        return;
                                    } //empty($data[$i])
                                    
                                    $insert['SAMP_STOR_LOC'] = $data[$i];
                                    break;
                                
                                case 'biome':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "biome" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert['SAMP_BIOME'] = $data[$i];
                                    break;
                                
                                case 'material':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "material" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert['SAMP_MAT'] = $data[$i];
                                    break;
                                
                                case 'samp_type':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "samp_type" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert['SAMP_TYPE'] = $data[$i];
                                    break;
                                
                                case 'feature_primary':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "feature_primary" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert['SAMP_SITE'] = $data[$i];
                                    break;
                                
                                case 'feature_secondary':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "feature_secondary" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert['SAMP_SUBSITE'] = $data[$i];
                                    break;
                                
                                case 'samp_lat':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "samp_lat" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert['SAMP_GEO_LAT'] = $data[$i];
                                    break;
                                
                                case 'samp_lon':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "samp_lon" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert['SAMP_GEO_LONG'] = $data[$i];
                                    break;
                                
                                case 'geo_loc_name':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "geo_loc_name" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert['SAMP_GEO_DESC'] = $data[$i];
                                    break;
                                
                                case 'env_package':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "env_package" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert['SAMP_ENVPKG'] = $data[$i];
                                    break;
                                
                                case 'country':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "country" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert['SAMP_COUNTRY'] = $data[$i];
                                    break;
                                
                                case 'notes':
                                    
                                    $insert['SAMP_NOTES'] = $data[$i];
                                    break;
                                
                                case 'source_subject_id':
                                    if (empty($data[$i])) {
                                        echo '<br><span class="error">  error: "source_subject_id" on row ' . $row . ' is required.</span>';
                                        return;
                                    } //empty($data[$i])
                                    if (!is_numeric($data[$i])) {
                                        echo '<br><span class="error">  error: "source_subject_id" on row ' . $row . ' is the wrong type. (integer expected)</span>';
                                        return;
                                    } //!is_numeric($data[$i])
                                    
                                    $insert['SOURCE_NUM'] = (int) $data[$i];
                                    break;
                                
                                case 'source_name_primary':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "source_name_primary" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert['SOURCE_TYPE'] = $data[$i];
                                    break;
                                
                                case 'source_name_secondary':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "source_name_secondary" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert['SOURCE_SUBTYPE'] = $data[$i];
                                    break;
                                
                                case 'source_treatment':
                                    if (strlen($data[$i]) > 60) {
                                        echo '<br><span class="error">  error: "source_treatment" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 60
                                    
                                    $insert['SOURCE_TREATMENT'] = $data[$i];
                                    break;
                                
                                default:
                                    echo '<br><span class="error">  error: unrecognised field</span>';
                                    return;
                            } //$fields[$i]
                            
                        } //$i = 0; $i < $num; $i++
                        array_push($rows, $insert);
                        $row++;
                    }
                } //($data = fgetcsv($handle, 10000, ",")) !== FALSE
                
                echo '<br>closing file "' . $file['name'] . '"';
                fclose($handle);
            } //($handle = fopen($file['tmp_name'], "r")) !== FALSE
            
            echo '<br>preparing rows for insert:';
            echo '<br> - checking for duplicate keys';
            $sample_keys = array();
            foreach ($rows as $sample) {
                array_push($sample_keys, $sample['SAMP_EXP_ID'] . ' ' . $sample['SAMP_ID']);
            } //$rows as $sample
            if (checkDuplicates($sample_keys)) {
                echo '<span class="error"><br>error: duplicate primary keys present in file (SAMP_EXP_ID, SAMP_ID)</span>';
                return;
            } //checkDuplicates($sample_keys)
            
            $row = 1;
            foreach ($rows as &$sample) {
                createNulls($sample);
                
                echo '<br>' . $row . ' - checking for existing IDs';
                $source = array(
                    'SAMP_EXP_ID',
                    'SAMP_ID'
                );
                $query  = array(
                    $sample['SAMP_EXP_ID'],
                    $sample['SAMP_ID']
                );
                if ($result = $this->sample->search($query, $source, 'SAMPLE', 'SAMP_EXP_ID, SAMP_ID')) {
                    echo '<span class="error"><br>error: record ' . $sample['SAMP_EXP_ID'] . ' ' . $sample['SAMP_ID'] . ' already exists</span>';
                    return;
                } //$result = $this->sample->search($query, $source, 'SAMPLE', 'SAMP_EXP_ID, SAMP_ID')
                
                echo '<br>' . $row . ' - resolving foreign keys';
                $source = array(
                    'SOURCE_NUM',
                    'SOURCE_TYPE',
                    'SOURCE_SUBTYPE',
                    'SOURCE_TREATMENT'
                );
                $query  = array(
                    $sample['SOURCE_NUM'],
                    $sample['SOURCE_TYPE'],
                    $sample['SOURCE_SUBTYPE'],
                    $sample['SOURCE_TREATMENT']
                );
                if ($result = $this->sample->search($query, $source, 'SOURCE', 'SOURCE_ID')) {
                    echo '<br>' . $row . ' - found existing source record';
                    $sample['SOURCE_ID'] = $result[0]['SOURCE_ID'];
                    unset($sample['SOURCE_NUM']);
                    unset($sample['SOURCE_TYPE']);
                    unset($sample['SOURCE_SUBTYPE']);
                    unset($sample['SOURCE_TREATMENT']);
                } //$result = $this->sample->search($query, $source, 'SOURCE', 'SOURCE_ID')
                else {
                    $query = array(
                        'SOURCE_NUM' => $sample['SOURCE_NUM'],
                        'SOURCE_TYPE' => $sample['SOURCE_TYPE'],
                        'SOURCE_SUBTYPE' => $sample['SOURCE_SUBTYPE'],
                        'SOURCE_TREATMENT' => $sample['SOURCE_TREATMENT']
                    );
                    echo '<br>' . $row . ' - creating new source record';
                    $id                  = $this->sample->create_source($query);
                    $sample['SOURCE_ID'] = $id;
                    unset($sample['SOURCE_NUM']);
                    unset($sample['SOURCE_TYPE']);
                    unset($sample['SOURCE_SUBTYPE']);
                    unset($sample['SOURCE_TREATMENT']);
                }
                $row++;
            } //$rows as &$sample
            
            echo '<br>performing batch insert';
            $this->sample->import($rows);
            echo '<pre>';
            print_r($rows);
            echo '</pre>';
            
        } //$_FILES as $file
        
        
        
        // echo '<span class="error">  Error: blahdy blah blah</span>';
        echo '<br><span class="success">Complete!</span>';
    }
    
    /**
    * export
    *
    * Loads the page used for exporting CSV files
    *
    * @access   public
    * @return   HTML Views
    */
    public function export()
    {
        $this->data['title'] = 'LIIS - Sample - Export CSV';
        
        $raw_projects           = $this->sample->select_field('SAMP_EXP_ID');
        $this->data['projects'] = array();
        foreach ($raw_projects as $project) {
            array_push($this->data['projects'], $project['SAMP_EXP_ID']);
        } //$raw_projects as $project
        
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/navbar', $this->data);
        $this->load->view('templates/container_start');
        $this->load->view('templates/content_start');
        $this->load->view('main/export/status.php');
        $this->load->view('main/export/sample_sidebar.php', $this->data);
        $this->load->view('templates/content_end');
        $this->load->view('templates/container_end');
        $this->load->view('templates/footer', $this->data);
    }
    
    /**
    * do_export
    *
    * AJAX
    * takes the selected project from export() and creates the csv file
    *
    * Requires POST data
    *
    * @access   public
    * @return   echo strings (log)
    */
    public function do_export()
    {
        echo '<br><br><span class="success">beginning script:</span>';
        if (!$project = $this->input->post('project')) {
            echo '<br><span class="error">  error: no project selected!</span>';
            return;
        } //!$project = $this->input->post('project')
        
        //the order in which the elements are selected matter. Template does not match the internal database unfortunately.
        $select = 'SAMP_EXP_ID, SAMP_ID, SAMP_DATE, SAMP_TIME, SAMP_TMZ, SAMP_STOR_LOC, SAMP_PERIOD, SAMP_BIOME, SAMP_MAT, SAMP_TYPE, SAMP_SITE, SAMP_SUBSITE, SAMP_GEO_LAT, SAMP_GEO_LONG, SAMP_GEO_DESC, SAMP_COUNTRY, SAMP_ENVPKG, SAMP_NOTES';
        
        $records = $this->sample->search($project, 'SAMP_EXP_ID', 'SAMPLE', $select);
        if (!$records) {
            echo '<br><span class="error">  error: no records found</span>';
            return;
        } //!$records
        
        $path     = realpath(dirname(dirname(dirname(__FILE__)))) . '/resources/download/';
        $filename = $path . $project . '_export.csv';
        $downloadpath = '/resources/download/' . $project . '_export.csv';
        
        echo '<br>creating file: ' . $project . '_export.csv';
        $file = fopen($filename, 'w');
        
        //Fields and descriptions are related directly by their order.
        $fields = array(
            'project_name',
            'sample_name',
            'collection_date',
            'collection_time',
            'collection_timezone',
            'samp_store_loc',
            'samp_period',
            'biome',
            'material',
            'samp_type',
            'feature_primary',
            'feature_secondary',
            'samp_lat',
            'samp_lon',
            'geo_loc_name',
            'country',
            'env_package',
            'notes',
            'source_subject_id',
            'source_name_primary',
            'source_name_secondary',
            'source_treatment'
        );
        $field  = implode(',', $fields);
        $field .= PHP_EOL;
        
        $descriptions = array(
            '* The Experiment/Project Identifcation number identifies each experiment and the samples it owns',
            '* Sample Identification Number uniquely identifies each sample within an experiment',
            '* The date of genesis',
            'The time of genesis',
            'The timezone genesis occurred in',
            '* The storage location of the sample',
            'The period of the sample',
            'The biome genesis occurred in',
            'The material displaced by the sample when taken',
            'The primary type classification (liquid solid gaseous)',
            'The site of origin',
            'The subsite of origin',
            'The latitude of genesis',
            'The longitude of genesis',
            'The description of the latitude and longitude',
            'The country of genesis',
            'The GSC defined environmental package',
            'Any notes / extra observations and fields',
            'The identification number of the source from which the sample came from',
            'The primary type classification of the source',
            'The secondary type classification of the source',
            'The treatment of the source pertaining to the experiment (diet controls etc)'
        );
        $description  = implode(',', $descriptions);
        $description .= PHP_EOL;
        
        echo '<br> adding headers';
        fputs($file, $field);
        fputs($file, $description);
        
        echo '<br>populating file';
        foreach ($records as $record) {
            
            $source                     = $this->sample->get_source($record['SAMP_EXP_ID'], $record['SAMP_ID']);
            $record['SOURCE_NUM']       = $source['SOURCE_NUM'];
            $record['SOURCE_TYPE']      = $source['SOURCE_TYPE'];
            $record['SOURCE_SUBTYPE']   = $source['SOURCE_SUBTYPE'];
            $record['SOURCE_TREATMENT'] = $source['SOURCE_TREATMENT'];
            
            fputcsv($file, $record);
        } //$records as $record
        
        echo '<br>closing file..';
        fclose($file);
        
        echo '<br><span class="success">Complete!</span>';
        echo '<br>download file: <a target="_blank" href="'.$downloadpath.'">'. $project . '_export.csv'.'</a>';
    }
    
    
}

/* End of file sample.php */
/* Location: ./application/controllers/sample.php */