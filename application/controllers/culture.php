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
 * Culture Controller
 *
 * Loads the Culture context and dictates buisness logic.
 *
 * @category    LIIS-Controller
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */

class Culture extends CI_Controller
{
    
    //Variable array that is to be passed to the views. See Constructor.
    protected $data = array();
    
    //Fields passed to search. See Constructor.
    protected $searchList;
    
    //Inital page that uses the 'searchintro' view to welcome users
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
            $this->load->model('culture_model', 'culture');
            
            //Title
            //Used By: views/templates/header.php
            //The title of the page
            $this->data['title'] = 'LIIS - Culture - ';
            
            //CSS Files (Order matters)
            //Used by: views/templates/header.php
            //Use the name only, as the template add the extension.
            $this->data['cssList'] = array(
                'bootstrap',
                'main',
                'culture'
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
            $this->data['sample']  = '';
            $this->data['culture'] = 'active';
        
        //Select List
        //Used By: culture_model/search, views/main/search/cultureresults.php
        //The list used for the search results page
        $this->searchList = array(
            'CULTURE.CULT_ID',
            'CULTURE.CULT_LABNUM',
            'CULTURE.CULT_REFNUM',
            'CULTURE.CULT_EXTERN_ID',
            'CULTURE.CULT_STOR_LOC',
            'CULTURE.CULT_OWNER',
            'CULTURE.CULT_DATE'
        );
        
        //Search Results
        //Used by: search.php, searchresults.php
        $this->data['results'] = FALSE;
        //set at the time of use	
        
        //Query
        //Used by: culture_searchbar.php
        //Holds the user query for display
        $this->data['query'] = NULL;
        //set at the time of use
        
        //Redirect
        //Used by: view(), views/templates/redirect
        //page passed to redirect html
        $this->data['redirect'] = NULL;
        //set at the time of use
        
        //Record
        //Used by: view(), views/main/record/culture_accordian
        //Holds the record data for viewing
        $this->data['record'] = NULL;
        //set at the time of use
        
        //Ids
        //Used by: do_create()
        //To identify the ID of each table
        //Used to return the IDs of the tables during form validation
        $this->data['ids'] = array(
            'CULTURE' => array(
                'CULT_ID',
                'CULT_LABNUM'
            ),
            'TAXONOMY' => 'TAX_ID',
            'DNARNA' => 'DNARNA_ID',
            'VIAL' => 'VIAL_ID'
        );
        
        //Required
        //Used by: do_create()
        //Holds the required fields for record creation
        $this->data['required']             = array();
        $this->data['required']['CULTURE']  = array(
            'CULT_LABNUM',
            'CULT_DATE',
            'CULT_RISKG'
        );
        $this->data['required']['TAXONOMY'] = array();
        $this->data['required']['VIAL']     = array(
            'VIAL_ID',
            'VIAL_STOR_LOC'
        );
        $this->data['required']['DNARNA']   = array(
            'DNARNA_ID',
            'DNARNA_TYPE',
            'DNARNA_DATE'
        );
        
        //Message
        //Used by: do_create(), views/main/create/errors
        //holds the errors for display
        //an array of arrays with the subkeys 'Message' and 'Type'
        //Format: array( array('Message' => '', 'Type' => ''), array('Message' =>...), ...)
        //Type can be: warning, error, success. Defaults warning.
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
            'CULT_LABNUM' => 'Culture Lab Number',
            'CULT_DATE' => 'Culture Date',
            'CULT_RISKG' => 'Culture Risk Group',
            'VIAL_ID' => 'Vial ID',
            'VIAL_STOR_LOC' => 'Vial Storage Location',
            'DNARNA_ID' => 'DNARNA ID',
            'DNARNA_TYPE' => 'DNARNA Type',
            'DNARNA_DATE' => 'DNARNA Date'
        );
    }
    
    //Initial Search Welcome Page
    public function index()
    {
        $this->data['title'] = 'LIIS - Culture - Welcome';
        
        //Load page
        $this->load->view('templates/header', $this->data);
        
        $this->load->view('templates/navbar', $this->data);
        $this->load->view('templates/container_start');
        $this->load->view('main/search/culture_searchbar');
        
        $this->load->view('templates/content_start');
        $this->load->view('main/search/welcome');
        $this->load->view('main/search/culture_sidebar');
        $this->load->view('templates/content_end');
        
        $this->load->view('templates/container_end');
        
        $this->load->view('templates/footer', $this->data);
    }
    
    public function recent()
    {
        $this->data['title'] = 'LIIS - Culture - Recent';
        
        //Load page
        $this->load->view('templates/header', $this->data);
        
        $this->load->view('templates/navbar', $this->data);
        $this->load->view('templates/container_start');
        $this->load->view('main/search/culture_searchbar');
        
        $this->load->view('templates/content_start');
        $this->load->view('main/search/welcome');
        $this->load->view('main/search/culture_sidebar');
        $this->load->view('templates/content_end');
        
        $this->load->view('templates/container_end');
        
        $this->load->view('templates/footer', $this->data);
    }
    
    //AJAX
    public function do_search()
    {
        
        $this->data['query'] = $this->input->post('query');
        $userQuery           = createArray($this->data['query']);
        $activeFilter        = $this->input->post('filter');
        
        if (empty($this->data['query'])) {
            $this->load->view('main/search/error');
            return;
        } //empty($this->data['query'])
        
        $this->data['title'] = 'LIIS - Culture - Search: ' . $this->data['query'];
        
        switch ($activeFilter) {
            case 'culture':
                $cultureList = array(
                    'CULT_LABNUM',
                    'CULT_REFNUM',
                    'CULT_EXTERN_ID',
                    'CULT_STOR_LOC',
                    'CULT_OWNER',
                    'CULT_DATE'
                );
                
                $this->data['results'] = $this->culture->search($userQuery, $cultureList, 'CULTURE', $this->searchList);
                break;
            
            case 'daterange':
                $dateList = array(
                    'CULT_DATE'
                );
                
                $this->data['results'] = $this->culture->search($userQuery, $dateList, 'CULTURE', $this->searchList, 'range');
                break;
            
            case 'strain':
                $strainList            = array(
                    'TAX_STRAIN',
                    'TAX_SPECIES',
                    'TAX_GENUS',
                    'TAX_FAMILY',
                    'TAX_ORDER',
                    'TAX_CLASS',
                    'TAX_PHYLUM',
                    'TAX_KINGDOM',
                    'TAX_DOMAIN',
                    'TAX_LIFE'
                );
                $custom                = 'TAXONOMY.TAX_ID = `CULTURE`.`TAX_ID`';
                $this->data['results'] = $this->culture->search($userQuery, $strainList, 'TAXONOMY, CULTURE', $this->searchList, 'like', $custom);
                break;
            
            case 'recent':
                $recent = array(
                    'CULT_MODDATE',
                    'CULT_USER'
                );
                
                $this->data['results'] = $this->culture->search(array(
                    date('Y-m-d'),
                    $this->session->userdata('user_id')
                ), $recent, 'CULTURE', $this->searchList);
                break;
            
            default:
                break;
        } //$activeFilter
        
        if ($this->data['results']) {
            $this->load->view('main/search/culture_results', $this->data);
        } //$this->data['results']
        else {
            $this->load->view('main/search/error');
        }
    }
    
    public function view($id = NULL)
    {
        $this->data['title'] = 'LIIS - Culture - View: ' . $id;
        
        //If no id passed, redirect to search page
        if ($id === NULL) {
            redirect('/culture');
        } //$id === NULL
        
        $this->data['record'] = $this->culture->selectOne($id);
        
        //Load page
        $this->load->view('templates/header', $this->data);
        
        $this->load->view('templates/navbar', $this->data);
        $this->load->view('templates/container_start');
        
        $this->load->view('templates/content_start');
        $this->load->view('main/record/culture_accordian', $this->data);
        $this->load->view('main/record/culture_sidebar', $this->data);
        $this->load->view('templates/content_end');
        
        $this->load->view('templates/container_end');
        
        $this->load->view('templates/footer', $this->data);
    }
    
    public function create($id = NULL, $edit = FALSE)
    {
        $this->data['preset'] = FALSE;
        if ($id != NULL) {
            $this->data['record'] = $this->culture->selectOne($id);
            $this->data['preset'] = TRUE;
        } //$id != NULL
        
        if ($edit) {
            $this->data['title'] = 'LIIS - Culture - Edit';
            $this->data['name']  = 'Edit';
        } //$edit
        else {
            $this->data['title'] = 'LIIS - Culture - Create';
            $this->data['name']  = 'Create';
        }
        
        //Load page
        $this->load->view('templates/header', $this->data);
        
        $this->load->view('templates/navbar', $this->data);
        $this->load->view('templates/container_start');
        $this->load->view('templates/content_start');
        $this->load->view('main/create/culture_form', $this->data);
        
        
        if ($this->data['preset']) {
            
            //VIAL
            $this->load->view('main/create/culture_vial_start');
            if (is_array($this->data['record']['VIAL'])) {
                $this->data['vialNum'] = 1;
                foreach ($this->data['record']['VIAL'] as $vial) {
                    $this->data['VIAL'] = $vial;
                    $this->load->view('main/create/culture_vial', $this->data);
                    $this->data['vialNum']++;
                } //$this->data['record']['VIAL'] as $vial
            } //is_array($this->data['record']['VIAL'])
            else {
                $this->data['vialNum'] = 1;
                $this->data['preset']  = FALSE; //temp
                $this->load->view('main/create/culture_vial', $this->data);
                $this->data['preset'] = TRUE;
            }
            $this->load->view('templates/div_end');
            
            
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
            $this->data['dnarnaNum'] = 1;
            $this->load->view('main/create/dnarna_start');
            $this->load->view('main/create/dnarna', $this->data);
            $this->load->view('templates/div_end');
            $this->data['vialNum'] = 1;
            $this->load->view('main/create/culture_vial_start');
            $this->load->view('main/create/culture_vial', $this->data);
            $this->load->view('templates/div_end');
        }
        
        if ($edit) {
            $this->load->view('main/edit/culture_sidebar', $this->data);
        } //$edit
        else {
            $this->load->view('main/create/culture_sidebar', $this->data);
        }
        
        $this->load->view('main/create/form_end');
        $this->load->view('templates/content_end');
        
        $this->load->view('templates/container_end');
        
        $this->load->view('templates/footer', $this->data);
        
        //javascript posts the form to method: do_create
        //do_create loads messages (errors or success) in div above form
        
        //javascript input validation separate from php post?
        //if all green then record should be okay, but ID could still be duplicate
        //if that error occurs, it is shown in the messages.
        //perhaps use php to set that field red after submission?
    }
    
    //AJAX
    public function do_create($edit = FALSE)
    {

        $this->data['create']['CULTURE']  = $this->input->post('culture');
        $this->data['create']['TAXONOMY'] = $this->input->post('taxonomy');
        
        $this->data['create']['VIAL']   = array();
        $this->data['create']['DNARNA'] = array();
        foreach ($this->input->post('vial') as $vial) {
            array_push($this->data['create']['VIAL'], $vial);
        } //$this->input->post('vial') as $vial
        foreach ($this->input->post('dnarna') as $dnarna) {
            array_push($this->data['create']['DNARNA'], $dnarna);
        } //$this->input->post('dnarna') as $dnarna
        
        $this->data['editIds'] = $this->input->post('ids');
        
        //TESTS
        //Unset empty arrays
        $this->data['create']['VIAL']   = remove_empty_arrays($this->data['create']['VIAL']);
        $this->data['create']['DNARNA'] = remove_empty_arrays($this->data['create']['DNARNA']);
        if (is_array($this->data['create']['TAXONOMY'])) {
            if (isEmpty($this->data['create']['TAXONOMY'])) {
                $this->data['create']['TAXONOMY'] = array();
            } //isEmpty($this->data['create']['TAXONOMY'])
        } //is_array($this->data['create']['TAXONOMY'])
        
        $this->data['create'] = array_filter($this->data['create']);
        
        //create nulls
        createNulls($this->data['create']);
        
        //Check required fields
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
        
        if (isset($this->data['create']['VIAL'])) {
            $vial_keys = array();
            foreach ($this->data['create']['VIAL'] as $vial) {
                array_push($vial_keys, $vial['VIAL_ID']);
            } //$this->data['create']['VIAL'] as $vial
            if (checkDuplicates($vial_keys)) {
                setMessage("<strong>Error:</strong> There are duplicate Vial Keys!", 'error', $this->data['message']);
            } //checkDuplicates($vial_keys)
        } //isset($this->data['create']['VIAL'])
        
        
        //Check existing records
        foreach ($this->data['create'] as $table => $fields) {
            
            
            
            //Special Case - Culture: duplicate LABNUMS are allowed in database, but if they are the exact same record it throws an error.
            // Enforcing unique LABNUMS reduces confusion, and if you have more than one it is suggested they have different labnums.
            // Ex. 'LABNUM01a', 'LABNUM01b'
            //just the IDs is necessary to ensure primary key duplication errors do not surface.
            if ($table == 'CULTURE') {
                
                $keys   = 'CULT_LABNUM';
                $values = array(
                    $fields['CULT_LABNUM']
                );
                if ($result = $this->culture->search($values, $keys, $table, $this->data['ids'][$table])) {
                    $exists[$table] = $result[0];
                } //$result = $this->culture->search($values, $keys, $table, $this->data['ids'][$table])
                
            } //$table == 'CULTURE'
            else {
                
                //The User has direct access to the DNARNA/VIAL ID's, so we check IDs for all arrays that are passed 
                //(Only DNARNA and VIAL will have multiple instances per record)
                if (is_array(reset($fields))) {
                    foreach ($fields as $field) {
                        $keys   = $this->data['ids'][$table];
                        $values = $field[$this->data['ids'][$table]];
                        if ($result = $this->culture->search($values, $keys, $table, $this->data['ids'][$table])) {
                            if (!isset($exists[$table]))
                                $exists[$table] = array(); //for array_push
                            array_push($exists[$table], $result[0][$this->data['ids'][$table]]);
                        } //$result = $this->culture->search($values, $keys, $table, $this->data['ids'][$table])
                    } //$fields as $field
                } //is_array(reset($fields))
                else {
                    $keys   = array_keys($fields);
                    $values = array_values($fields);
                    if ($result = $this->culture->search($values, $keys, $table, $this->data['ids'][$table])) {
                        $exists[$table] = array();
                        array_push($exists[$table], $result[0][$this->data['ids'][$table]]);
                    } //$result = $this->culture->search($values, $keys, $table, $this->data['ids'][$table])
                }
            }
        } //$this->data['create'] as $table => $fields
        
        //Foreign key check
        //Culture table foreign keys: Tax
        if (isset($exists['TAXONOMY'])) {
            if ($edit) {
                if (!in_array($exists['TAXONOMY'][0]['TAX_ID'], $this->data['editIds']['TAXONOMY'])) {
                    unset($this->data['create']['TAXONOMY']);
                    $this->data['create']['CULTURE']['TAX_ID'] = $exists['TAXONOMY'][0]['TAX_ID']; //Search returns an array of arrays
                } //!in_array($exists['TAXONOMY'][0]['TAX_ID'], $this->data['editIds']['TAXONOMY'])
            } //$edit
            else {
                unset($this->data['create']['TAXONOMY']);
                $this->data['create']['CULTURE']['TAX_ID'] = $exists['TAXONOMY'][0]['TAX_ID']; //Search returns an array of arrays
            }
        } //isset($exists['TAXONOMY'])
        elseif ($edit && isset($this->data['create']['TAXONOMY'])) {
            $this->data['create']['CULTURE']['TAX_ID'] = $this->culture->create_tax($this->data['create']['TAXONOMY']);
            unset($this->data['create']['TAXONOMY']);
        } //$edit && isset($this->data['create']['TAXONOMY'])
        
        //Explicit Error Messages
        if (isset($exists['CULTURE'])) {
            if ($edit) {
                if (!in_array($exists['CULTURE']['CULT_LABNUM'], $this->data['editIds']['CULTURE'])) {
                    setMessage("<strong>Error:</strong> The Culture: " . $exists['CULTURE']['CULT_LABNUM'] . " already exists!", 'error', $this->data['message']);
                } //!in_array($exists['CULTURE']['CULT_LABNUM'], $this->data['editIds']['CULTURE'])
            } //$edit
            else {
                setMessage("<strong>Error:</strong> The Culture: " . $exists['CULTURE']['CULT_LABNUM'] . " already exists!", 'error', $this->data['message']);
            }
        } //isset($exists['CULTURE'])
        elseif ($edit) {
            $this->culture->update_culture($this->data['create']['CULTURE']['CULT_ID'], $this->data['create']['CULTURE']);
        } //$edit
        
        if (isset($exists['DNARNA'])) {
            if ($edit) {
                foreach ($this->data['create']['DNARNA'] as $dnarna => $attributes) {
                    if (!in_array($attributes['DNARNA_ID'], $this->data['editIds']['DNARNA'])) {
                        if (in_array($attributes['DNARNA_ID'], $exists{'DNARNA'})) {
                            setMessage("<strong>Error:</strong> The Genetic Record: " . $attributes['DNARNA_ID'] . " already exists!", 'error', $this->data['message']);
                        } //in_array($attributes['DNARNA_ID'], $exists{'DNARNA'})
                        elseif (sizeof($this->data['message']) < 1) {
                            $attributes['CULT_ID'] = $this->data['create']['CULTURE']['CULT_ID'];
                            $this->culture->create_dnarna($attributes);
                            unset($this->data['create']['DNARNA'][$dnarna]);
                        } //sizeof($this->data['message']) < 1
                    } //!in_array($attributes['DNARNA_ID'], $this->data['editIds']['DNARNA'])
                } //$this->data['create']['DNARNA'] as $dnarna => $attributes
            } //$edit
            else {
                foreach ($exists['DNARNA'] as $dnarna) {
                    setMessage("<strong>Error:</strong> The Genetic Record: " . $dnarna['DNARNA_ID'] . " already exists!", 'error', $this->data['message']);
                } //$exists['DNARNA'] as $dnarna
            }
        } //isset($exists['DNARNA'])
        elseif ($edit && isset($this->data['create']['DNARNA'])) {
            foreach ($this->data['create']['DNARNA'] as $dnarna => $attributes) {
                $attributes['CULT_ID'] = $this->data['create']['CULTURE']['CULT_ID'];
                $this->culture->create_dnarna($attributes);
            } //$this->data['create']['DNARNA'] as $dnarna => $attributes
            unset($this->data['create']['DNARNA']);
        } //$edit && isset($this->data['create']['DNARNA'])
        
        if (isset($exists['VIAL'])) {
            if ($edit) {
                foreach ($this->data['create']['VIAL'] as $vial => $attributes) {
                    if (!in_array($attributes['VIAL_ID'], $this->data['editIds']['VIAL'])) {
                        if (in_array($attributes['VIAL_ID'], $exists{'VIAL'})) {
                            setMessage("<strong>Error:</strong> The Vial: " . $attributes['VIAL_ID'] . " already exists!", 'error', $this->data['message']);
                        } //in_array($attributes['VIAL_ID'], $exists{'VIAL'})
                        elseif (sizeof($this->data['message']) < 1) {
                            $attributes['CULT_ID'] = $this->data['create']['CULTURE']['CULT_ID'];
                            $this->culture->create_vial($attributes);
                            unset($this->data['create']['VIAL'][$vial]);
                        } //sizeof($this->data['message']) < 1
                    } //!in_array($attributes['VIAL_ID'], $this->data['editIds']['VIAL'])
                } //$this->data['create']['VIAL'] as $vial => $attributes
            } //$edit
            else {
                foreach ($exists['VIAL'] as $vial) {
                    setMessage("<strong>Error:</strong> The Vial: " . $vial['VIAL_ID'] . " already exists!", 'error', $this->data['message']);
                } //$exists['VIAL'] as $vial
            }
        } //isset($exists['VIAL'])
        elseif ($edit && isset($this->data['create']['VIAL'])) {
            foreach ($this->data['create']['VIAL'] as $vial => $attributes) {
                $attributes['CULT_ID'] = $this->data['create']['CULTURE']['CULT_ID'];
                $this->culture->create_vial($attributes);
            } //$this->data['create']['VIAL'] as $vial => $attributes
            unset($this->data['create']['VIAL']);
        } //$edit && isset($this->data['create']['VIAL'])
        
        //end tests
        
        if (sizeof($this->data['message']) > 0) {
            $this->load->view('templates/message', $this->data);
            return;
        } //sizeof($this->data['message']) > 0
        
        if ($edit) {
            $this->culture->editRow($this->data['create']['CULTURE']['CULT_ID'], $this->data['create']);
            setMessage('<strong>Success!</strong> The Culture: ' . $this->data['create']['CULTURE']['CULT_LABNUM'] . ' has been edited.', 'success', $this->data['message']);
        } //$edit
        else {
            $this->culture->createRow($this->data['create']);
            setMessage('<strong>Success!</strong> The Culture: ' . $this->data['create']['CULTURE']['CULT_LABNUM'] . ' has been created.', 'success', $this->data['message']);
        }
        $this->load->view('templates/message', $this->data);
    }
    
    public function edit($id)
    {   
        if($this->session->userdata('user_auth') === 'LIMITED'){ 
            redirect('/login/do_logout');
        }

        $this->create($id, TRUE);
    }
    
    //AJAX
    public function do_edit()
    {
        if($this->session->userdata('user_auth') === 'LIMITED'){ 
            redirect('/login/do_logout');
        }

        $this->do_create(TRUE);
    }
    
    public function upload_image($id)
    {
        if($this->session->userdata('user_auth') === 'LIMITED'){ 
            redirect('/login/do_logout');
        }

        $this->data['title'] = 'LIIS - Culture - Upload Image';
        
        $this->data['CULTURE'] = $this->culture->get_culture($id);
        $this->data['DNARNA']  = $this->culture->get_dnarna($id);
        
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/container_start');
        $this->load->view('templates/content_start');
        $this->load->view('main/image/culture_image_form', $this->data);
        $this->load->view('templates/content_end');
        $this->load->view('templates/content_start');
        $this->load->view('main/image/span4');
        $this->load->view('templates/message', $this->data);
        $this->load->view('templates/div_end');
        $this->load->view('templates/content_end');
        $this->load->view('templates/container_end');
        $this->load->view('templates/footer', $this->data);
    }
    
    //AJAX
    public function do_upload_image()
    {
        if($this->session->userdata('user_auth') === 'LIMITED'){ 
            redirect('/login/do_logout');
        }

        $image = array();
        $post  = $this->input->post();
        $id    = $post['CULT_ID'];
        $type  = $post['type'];
        
        
        $config['upload_path'] = realpath(dirname(dirname(dirname(__FILE__)))) . '/resources/upload/';
        
        if (isset($_FILES['userfile'])) {
            
            $file_name = $_FILES['userfile']['name'];
            $ext       = '.' . end(explode('.', $file_name));
            
            //upload picture
            
            $config['allowed_types'] = 'gif|jpg|png';
            if ($type == 'CULTURE') {
                $config['file_name'] = $post['CULT_ID'] . '_' . $post['CULT_LABNUM'] . $ext;
            } //$type == 'CULTURE'
            elseif ($type == 'DNARNA') {
                $config['file_name'] = $post['DNARNA_ID'] . $ext;
            } //$type == 'DNARNA'
            
            
            $this->load->library('upload', $config);
            
            
            if (!$this->upload->do_upload()) {
                setMessage($this->upload->display_errors(), 'error', $this->data['message']);
                $this->upload_image($id);
            } //!$this->upload->do_upload()
            else {
                $upload = $this->upload->data();
                if ($type == 'CULTURE') {
                    $image['CULT_IMG_CAP']  = $post['CULT_IMG_CAP'];
                    $image['CULT_IMG_PATH'] = '/resources/upload/' . $upload['raw_name'] . $upload['file_ext'];
                    $image['CULT_MODDATE']  = date('Y-m-d');
                    $image['CULT_USER']     = $this->session->userdata('USER_ID');
                    $this->culture->update_culture($id, $image);
                } //$type == 'CULTURE'
                elseif ($type == 'DNARNA') {
                    $image['DNARNA_IMG_CAP']  = $post['CULT_IMG_CAP'];
                    $image['DNARNA_IMG_PATH'] = '/resources/upload/' . $upload['raw_name'] . $upload['file_ext'];
                    $image['DNARNA_MODDATE']  = date('Y-m-d');
                    $image['DNARNA_USER']     = $this->session->userdata('USER_ID');
                    $this->culture->update_dnarna($post['DNARNA_ID'], $image);
                } //$type == 'DNARNA'
                setMessage('<strong>Success!</strong> The file has been uploaded.', 'success', $this->data['message']);
                $this->upload_image($id);
            }
        } //isset($_FILES['userfile'])
    }
    
    public function delete($table, $id)
    {   
        if($this->session->userdata('user_auth') === 'LIMITED'){ 
            redirect('/login/do_logout');
        }

        switch ($table) {
            case 'culture':
                $this->culture->delete_culture($id);
                echo '<script>window.location="/culture/"</script>';
                break;
            case 'taxonomy':
                $this->culture->delete_tax($id);
                echo '<script>history.go(-1);</script>';
                break;
            case 'dnarna':
                $this->culture->delete_dnarna($id);
                echo '<script>history.go(-1);</script>';
                break;
            case 'vial':
                $this->culture->delete_vial($id);
                echo '<script>history.go(-1);</script>';
                break;
            default:
                throw new Exception('Class: culture Method: delete - (1) Invalid Table');
        } //$table
    }
    
    public function import()
    {   
        $this->data['title'] = 'LIIS - Culture - Import CSV';
        
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
    
    //AJAX
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
                'CULT_LABNUM',
                'CULT_DATE',
                'CULT_RISKG',
                'CULT_REFNUM',
                'CULT_STOR_LOC',
                'CULT_STORED_STATE',
                'CULT_OWNER',
                'CULT_HIST',
                'CULT_ISO_SOURCE',
                'CULT_RRNA_SEQ',
                'CULT_EXTERN_ID',
                'CULT_NOTES',
                'TAX_DOMAIN',
                'TAX_KINGDOM',
                'TAX_PHYLUM',
                'TAX_CLASS',
                'TAX_ORDER',
                'TAX_FAMILY',
                'TAX_GENUS',
                'TAX_SPECIES',
                'TAX_STRAIN'
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
                            echo '<br>parsing rows: <br>';
                        echo ' - ' . $row;
                        for ($i = 0; $i < $num; $i++) {
                            $data[$i] = trim($data[$i]);
                            switch ($fields[$i]) {
                                case 'CULT_LABNUM':
                                    if (strlen($data[$i]) > 20) {
                                        echo '<br><span class="error">  error: "CULT_LABNUM" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 20
                                    if (empty($data[$i])) {
                                        echo '<br><span class="error">  error: "CULT_LABNUM" on row ' . $row . ' is required.</span>';
                                        return;
                                    } //empty($data[$i])
                                    
                                    $insert[$fields[$i]] = $data[$i];
                                    break;
                                
                                case 'CULT_DATE':
                                    if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $data[$i], $datebit)) {
                                        if(!checkdate($datebit[2] , $datebit[3] , $datebit[1])){
                                             echo '<br><span class="error">  error: "CULT_DATE" on row ' . $row . ' has invalid date.</span>';
                                        }
                                    } else {
                                        echo '<br><span class="error">  error: "CULT_DATE" on row ' . $row . ' is wrong format (yyyy-mm-dd required).</span>';
                                        return false;
                                    }
                                                                    
                                    if (empty($data[$i])) {
                                        echo '<br><span class="error">  error: "CULT_DATE" on row ' . $row . ' is required.</span>';
                                        return;
                                    } //empty($data[$i])
                                    
                                    $insert[$fields[$i]] = $data[$i];
                                    break;
                                
                                case 'CULT_RISKG':
                                    if (empty($data[$i]) && $data[$i] != 0) {
                                        echo '<br><span class="error">  error: "CULT_RISKG" on row ' . $row . ' is required.</span>';
                                        return;
                                    } //empty($data[$i]) && $data[$i] != 0
                                    if (!is_numeric($data[$i])) {
                                        echo '<br><span class="error">  error: "CULT_RISKG" on row ' . $row . ' is the wrong type.</span>';
                                        return;
                                    } //!is_numeric($data[$i])
                                    
                                    $insert[$fields[$i]] = (int) $data[$i];
                                    break;
                                
                                case 'CULT_REFNUM':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "CULT_REFNUM" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert[$fields[$i]] = $data[$i];
                                    break;
                                
                                case 'CULT_STOR_LOC':
                                    if (strlen($data[$i]) > 20) {
                                        echo '<br><span class="error">  error: "CULT_STOR_LOC" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 20
                                    
                                    $insert[$fields[$i]] = $data[$i];
                                    break;
                                
                                case 'CULT_STORED_STATE':
                                    if (strlen($data[$i]) > 20) {
                                        echo '<br><span class="error">  error: "CULT_STOR_LOC" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 20
                                    
                                    $insert[$fields[$i]] = $data[$i];
                                    break;
                                
                                case 'CULT_OWNER':
                                    if (strlen($data[$i]) > 20) {
                                        echo '<br><span class="error">  error: "SAMP_STOR_LOC" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 20
                                    
                                    $insert[$fields[$i]] = $data[$i];
                                    break;
                                
                                case 'CULT_HIST':
                                    
                                    $insert[$fields[$i]] = $data[$i];
                                    break;
                                
                                case 'CULT_ISO_SOURCE':
                                    if (strlen($data[$i]) > 20) {
                                        echo '<br><span class="error">  error: "CULT_ISO_SOURCE" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 20
                                    
                                    $insert[$fields[$i]] = $data[$i];
                                    break;
                                
                                case 'CULT_RRNA_SEQ':
                                    
                                    $insert[$fields[$i]] = $data[$i];
                                    break;
                                
                                case 'CULT_EXTERN_ID':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "CULT_EXTERN_ID" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert[$fields[$i]] = $data[$i];
                                    break;
                                
                                case 'CULT_NOTES':
                                    
                                    $insert[$fields[$i]] = $data[$i];
                                    break;
                                
                                case 'TAX_DOMAIN':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "TAX_DOMAIN" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert[$fields[$i]] = $data[$i];
                                    break;
                                
                                case 'TAX_KINGDOM':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "TAX_KINGDOM" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert[$fields[$i]] = $data[$i];
                                    break;
                                
                                case 'TAX_PHYLUM':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "TAX_PHYLUM" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert[$fields[$i]] = $data[$i];
                                    break;
                                
                                case 'TAX_CLASS':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "TAX_CLASS" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert[$fields[$i]] = $data[$i];
                                    break;
                                
                                case 'TAX_ORDER':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "TAX_ORDER" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert[$fields[$i]] = $data[$i];
                                    break;
                                
                                case 'TAX_FAMILY':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "TAX_FAMILY" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert[$fields[$i]] = (int) $data[$i];
                                    break;
                                
                                case 'TAX_GENUS':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "TAX_GENUS" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert[$fields[$i]] = $data[$i];
                                    break;
                                
                                case 'TAX_SPECIES':
                                    if (strlen($data[$i]) > 40) {
                                        echo '<br><span class="error">  error: "TAX_SPECIES" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 40
                                    
                                    $insert[$fields[$i]] = $data[$i];
                                    break;
                                
                                case 'TAX_STRAIN':
                                    if (strlen($data[$i]) > 60) {
                                        echo '<br><span class="error">  error: "TAX_STRAIN" on row ' . $row . ' exceeded set length.</span>';
                                        return;
                                    } //strlen($data[$i]) > 60
                                    
                                    $insert[$fields[$i]] = $data[$i];
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
            $culture_keys = array();
            foreach ($rows as $culture) {
                array_push($culture_keys, $culture['CULT_LABNUM']);
            } //$rows as $culture
            if (checkDuplicates($culture_keys)) {
                echo '<span class="error"><br>error: duplicate keys present in file (CULT_LABNUM)</span>';
                return;
            } //checkDuplicates($culture_keys)
            
            $row = 1;
            foreach ($rows as &$culture) {
                createNulls($culture);
                
                echo '<br>' . $row . ' - checking for existing IDs';
                $source = array(
                    'CULT_LABNUM'
                );
                $query  = array(
                    $culture['CULT_LABNUM']
                );
                if ($result = $this->culture->search($query, $source, 'CULTURE', 'CULT_LABNUM')) {
                    echo '<span class="error"><br>error: record ' . $culture['CULT_LABNUM'] . ' already exists</span>';
                    return;
                } //$result = $this->culture->search($query, $source, 'CULTURE', 'CULT_LABNUM')
                
                echo '<br>' . $row . ' - resolving foreign keys';
                $source = array(
                    'TAX_LIFE',
                    'TAX_DOMAIN',
                    'TAX_KINGDOM',
                    'TAX_PHYLUM',
                    'TAX_CLASS',
                    'TAX_ORDER',
                    'TAX_FAMILY',
                    'TAX_GENUS',
                    'TAX_SPECIES',
                    'TAX_STRAIN'
                );
                $query  = array(
                    $culture['TAX_LIFE'],
                    $culture['TAX_DOMAIN'],
                    $culture['TAX_KINGDOM'],
                    $culture['TAX_PHYLUM'],
                    $culture['TAX_CLASS'],
                    $culture['TAX_ORDER'],
                    $culture['TAX_FAMILY'],
                    $culture['TAX_GENUS'],
                    $culture['TAX_SPECIES'],
                    $culture['TAX_STRAIN']
                );
                if ($result = $this->culture->search($query, $source, 'TAXONOMY', 'TAX_ID')) {
                    echo '<br>' . $row . ' - found existing taxonomy record';
                    $culture['TAX_ID'] = $result[0]['TAX_ID'];
                    unset($culture['TAX_LIFE']);
                    unset($culture['TAX_DOMAIN']);
                    unset($culture['TAX_KINGDOM']);
                    unset($culture['TAX_PHYLUM']);
                    unset($culture['TAX_CLASS']);
                    unset($culture['TAX_ORDER']);
                    unset($culture['TAX_FAMILY']);
                    unset($culture['TAX_GENUS']);
                    unset($culture['TAX_SPECIES']);
                    unset($culture['TAX_STRAIN']);
                } //$result = $this->culture->search($query, $source, 'TAXONOMY', 'TAX_ID')
                else {
                    $query = array(
                        'TAX_LIFE' => $culture['TAX_LIFE'],
                        'TAX_DOMAIN' => $culture['TAX_DOMAIN'],
                        'TAX_KINGDOM' => $culture['TAX_KINGDOM'],
                        'TAX_PHYLUM' => $culture['TAX_PHYLUM'],
                        'TAX_CLASS' => $culture['TAX_CLASS'],
                        'TAX_ORDER' => $culture['TAX_ORDER'],
                        'TAX_FAMILY' => $culture['TAX_FAMILY'],
                        'TAX_GENUS' => $culture['TAX_GENUS'],
                        'TAX_SPECIES' => $culture['TAX_SPECIES'],
                        'TAX_STRAIN' => $culture['TAX_STRAIN']
                    );
                    echo '<br>' . $row . ' - creating new taxonomy record';
                    $id                = $this->culture->create_tax($query);
                    $culture['TAX_ID'] = $id;
                    unset($culture['TAX_LIFE']);
                    unset($culture['TAX_DOMAIN']);
                    unset($culture['TAX_KINGDOM']);
                    unset($culture['TAX_PHYLUM']);
                    unset($culture['TAX_CLASS']);
                    unset($culture['TAX_ORDER']);
                    unset($culture['TAX_FAMILY']);
                    unset($culture['TAX_GENUS']);
                    unset($culture['TAX_SPECIES']);
                    unset($culture['TAX_STRAIN']);
                }
                $row++;
            } //$rows as &$culture
            
            echo '<br>performing batch insert';
            $this->culture->import($rows);
            echo '<pre>';
            print_r($rows);
            echo '</pre>';
            
        } //$_FILES as $file
        
        echo '<br><span class="success">Complete!</span>';
    }
    
    public function export()
    {
        $this->data['title'] = 'LIIS - Culture - Export CSV';
        
        $this->load->view('templates/header', $this->data);
        $this->load->view('templates/navbar', $this->data);
        $this->load->view('templates/container_start');
        $this->load->view('templates/content_start');
        $this->load->view('main/export/status.php');
        $this->load->view('main/export/culture_sidebar.php');
        $this->load->view('templates/content_end');
        $this->load->view('templates/container_end');
        $this->load->view('templates/footer', $this->data);
    }
    
    public function do_export()
    {
        
        echo '<br><br><span class="success">beginning script:</span>';
        if (!$labnum = $this->input->post('labnum')) {
            echo '<br><span class="error">  error: No labnumber selected!</span>';
            return;
        } //!$labnum = $this->input->post('labnum')
        
        $wc_labnum = '%' . $labnum . '%';
        //the order in which the elements are selected matter. Template does not match the internal database unfortunately.
        $select    = 'CULT_ID, CULT_LABNUM, CULT_DATE, CULT_RISKG, CULT_REFNUM, CULT_STOR_LOC, CULT_STORED_STATE, CULT_OWNER, CULT_HIST, CULT_ISO_SOURCE, CULT_RRNA_SEQ, CULT_EXTERN_ID, CULT_NOTES';
        
        $records = $this->culture->search($wc_labnum, 'CULT_LABNUM', 'CULTURE', $select);
        if (!$records) {
            echo '<br><span class="error">  error: no records found</span>';
            return;
        } //!$records
        
        $path     = realpath(dirname(dirname(dirname(__FILE__)))) . '/resources/download/';
        $filename = $path . $labnum . '_export.csv';
        $downloadpath = '/resources/download/'  . $labnum . '_export.csv';
        
        echo '<br>creating file: ' . $labnum . '_export.csv';
        if (!$file = fopen($filename, 'w')) {
            echo '<br><span class="error">  error: file is busy! the server has this file open already</span>';
            return;
        } //!$file = fopen($filename, 'w')
        
        //Fields and descriptions are related directly by their order
        $fields = array(
            'CULT_LABNUM',
            'CULT_DATE',
            'CULT_RISKG',
            'CULT_REFNUM',
            'CULT_STOR_LOC',
            'CULT_STORED_STATE',
            'CULT_OWNER',
            'CULT_HIST',
            'CULT_ISO_SOURCE',
            'CULT_RRNA_SEQ',
            'CULT_EXTERN_ID',
            'CULT_NOTES',
            'TAX_DOMAIN',
            'TAX_KINGDOM',
            'TAX_PHYLUM',
            'TAX_CLASS',
            'TAX_ORDER',
            'TAX_FAMILY',
            'TAX_GENUS',
            'TAX_SPECIES',
            'TAX_STRAIN'
        );
        $field  = implode(',', $fields);
        $field .= PHP_EOL;
        
        $descriptions = array(
            '* The unique identification of the culture within the lab',
            '* the date of culture genesis',
            '* the risk group the culture belongs to',
            'the reference number for the culture',
            'the storage location of the culture',
            'the state which the culture is stored under',
            'the owner of the culture',
            'the history of the culture',
            'the isolation source of the culture',
            'the RRNA sequence of the culture',
            'the external ID that belongs to the culture',
            'Any extra fields / obervations that belong to the culture',
            'the Domain taxinomic classification',
            'the Kingdom taxinomic classification',
            'the Phylum taxinomic classification',
            'the Class taxinomic classification',
            'the Order taxinomic classification',
            'the Family taxinomic classification',
            'the Genus taxinomic classification',
            'the Species taxinomic classification',
            'the Strain taxinomic classification'
        );
        $description  = implode(',', $descriptions);
        $description .= PHP_EOL;
        
        echo '<br>adding headers';
        fputs($file, $field);
        fputs($file, $description);
        
        echo '<br>populating file';
        foreach ($records as $record) {
            
            $tax = $this->culture->get_tax($record['CULT_ID']);
            unset($record['CULT_ID']);
            $record['TAX_DOMAIN']  = $tax['TAX_DOMAIN'];
            $record['TAX_KINGDOM'] = $tax['TAX_KINGDOM'];
            $record['TAX_PHYLUM']  = $tax['TAX_PHYLUM'];
            $record['TAX_CLASS']   = $tax['TAX_CLASS'];
            $record['TAX_ORDER']   = $tax['TAX_ORDER'];
            $record['TAX_FAMILY']  = $tax['TAX_FAMILY'];
            $record['TAX_GENUS']   = $tax['TAX_GENUS'];
            $record['TAX_SPECIES'] = $tax['TAX_SPECIES'];
            $record['TAX_STRAIN']  = $tax['TAX_STRAIN'];
            
            fputcsv($file, $record);
        } //$records as $record
        
        echo '<br>closing file..';
        fclose($file);
        
        echo '<br><span class="success">Complete!</span>';
        echo '<br>download file: <a target="_blank" href="'.$downloadpath.'">'. $labnum . '_export.csv'.'</a>';
    }
    
    
}

/* End of file culture.php */
/* Location: ./application/controllers/culture.php */