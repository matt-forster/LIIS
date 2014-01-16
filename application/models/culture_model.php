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
 * Culture Model
 *
 * Loads the LIISDATA database and provides logic for manipulating the CULTURE 
 * and related tables
 *
 * @category    LIIS-Model
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */

class Culture_model extends CI_Model
{
    
    //CONSTRUCTOR
    
    public function __construct()
    {
        
        parent::__construct();
        
        //Load the LIISDATA database for use (see database config 'config/database.php')
        $this->load->database('data');
    }
    
    //PUBLIC
    
    //create

    /**
    * createRow
    *
    * Required an associative array arranged as: array(table => array(field => value, field => value, ...), table => array(...), ...)
    * Valid tables are: CULTURE, TAXONOMY, DNARNA, VIAL 
    * See database schema for valid fields.
    * 
    * @access   public   
    * @param    data    array   The array that holds the record data.
    * @return   1 if succesful, negative number if not. -1 taxonomy fail, -2 culture fail, -3 dnarna fail, -4 vial fail.
    */
    public function createRow($data)
    {
        $tables = array_keys($data);
        
        createNulls($data);
        
        if (in_array('TAXONOMY', $tables)) {
            
            if(!$id = $this->create_tax($data['TAXONOMY'], 'TAXONOMY')){
                return -1;
            }
            
            if (in_array('CULTURE', $tables)) {
                $data['CULTURE']['TAX_ID'] = $id;
            } //in_array('CULTURE', $tables)
        } //in_array('TAXONOMY', $tables)
        
        if (in_array('CULTURE', $tables)) {
            
            if(!$insert = $this->create_culture($data['CULTURE'])){
                return -2;
            }
            
            if (in_array('DNARNA', $tables) && $insert) {
                foreach ($data['DNARNA'] as &$dnarna) {
                    $dnarna['CULT_ID'] = $insert;
                } //$data['DNARNA'] as &$dnarna
                unset($dnarna);
            } //in_array('DNARNA', $tables) && $insert
            if (in_array('VIAL', $tables) && $insert) {
                foreach ($data['VIAL'] as &$vial) {
                    $vial['CULT_ID'] = $insert;
                } //$data['VIAL'] as &$vial
                unset($vial);
            } //in_array('VIAL', $tables) && $insert
        } //in_array('CULTURE', $tables)
        
        if (in_array('DNARNA', $tables)) {
            foreach ($data['DNARNA'] as $dnarna) {
                if(!$this->create_dnarna($dnarna)){
                    return -3;
                }
            } //$data['DNARNA'] as $dnarna
        } //in_array('DNARNA', $tables)
        if (in_array('VIAL', $tables)) {
            foreach ($data['VIAL'] as $vial) {
                if(!$this->create_vial($vial)){
                    return -4;
                }
            } //$data['VIAL'] as $vial
        } //in_array('VIAL', $tables)

        return 1;
    }
    
    /**
    * create_culture
    *
    * Create a record in the culture table. Requires an associative array arranged as: array(field => value, field => value, ...)
    * See database schema for valid field names and types
    * 
    * @access   public   
    * @param    data    array   an associative array holding the field names and values of the data to insert.
    * @return   Returns the record ID if successful, false if not.
    */
    public function create_culture($data)
    {
        $data['CULT_USER']    = $this->session->userdata('user_id');
        $data['CULT_MODDATE'] = date("Y-m-d");
        
        return $this->create($data, 'CULTURE');
    }
    
    /**
    * create_tax
    *
    * Create a record in the taxomomy table. Requires an associative array arranged as: array(field => value, field => value, ...)
    * See database schema for valid field names and types
    * 
    * @access   public   
    * @param    data    array   an associative array holding the field names and values of the data to insert.
    * @return   Returns the record ID if successful, false if not.
    */
    public function create_tax($data)
    {
        $data['TAX_USER']    = $this->session->userdata('user_id');
        $data['TAX_MODDATE'] = date("Y-m-d");
        
        return $this->create($data, 'TAXONOMY');
    }
    
    /**
    * create_vial
    *
    * Create a record in the vial table. Requires an associative array arranged as: array(field => value, field => value, ...)
    * See database schema for valid field names and types
    * 
    * @access   public   
    * @param    data    array   an associative array holding the field names and values of the data to insert.
    * @return   Returns true if successful, false if not.
    */
    public function create_vial($data)
    {
        $data['VIAL_USER']    = $this->session->userdata('user_id');
        $data['VIAL_MODDATE'] = date("Y-m-d");
        
        return $this->create($data, 'VIAL');
    }
    
    /**
    * create_dnarna
    *
    * Create a record in the dnarna table. Requires an associative array arranged as: array(field => value, field => value, ...)
    * See database schema for valid field names and types
    * 
    * @access   public   
    * @param    data    array   an associative array holding the field name and values of the data to insert.
    * @return   Returns true if successful, false if not.
    */
    public function create_dnarna($data)
    {
        $data['DNARNA_USER']    = $this->session->userdata('user_id');
        $data['DNARNA_MODDATE'] = date("Y-m-d");
        
        return $this->create($data, 'DNARNA');
    }
    
    /**
    * import
    *
    * Create multiple culture records. Requires a multidimensional associative array arranged as: array( array(field => value, field => value, ...), array(...), ...)
    * See database schema for valid field names and types
    * 
    * @access   public   
    * @param    data    array   an associative array holding the field name and values of the data to insert.
    * @param    table   string  the primary table to import into
    * @return   Returns true if successful, false if not.
    */
    public function import($array, $table = 'CULTURE')
    {
        foreach ($array as &$culture) {
            $culture['CULT_USER']    = $this->session->userdata('user_id');
            $culture['CULT_MODDATE'] = date("Y-m-d");
        } //$array as &$culture
        
        try {
            $this->create_batch($array, $table);
            return TRUE;
        }
        catch (Exception $e) {
            return FALSE;
        }
    }
    
    //read

    /**
    * search
    *
    * Searches the specified table for the keywords against the fields. Returns the fields specified under the keys parameter.
    * Has two types, 'like' and 'range', where like is a basic search against fields and range is a search between two points (like dates)
    * Can be passed a custom string that will execute any custom *where* clauses you may want.
    * 
    * @access   public   
    * @param    keywords    array or string   an array or comma delimited string holding the keywords to search for. eg. array('1', 'two') or '1, two'
    * @param    fields      array or string   an array or comma delimited string holding the fields to search against. eg. array('field1', 'field2') or 'field1, field2'
    * @param    table       string            the name of the table you want to search
    * @param    key         string            a comma delimited string that specifies which fields to return. eg. 'field1, field2'
    * @param    type        string            which type of search to perform. valid types are 'like' and 'range'
    * @param    custom      string            A custom where clause to add the the query. Must be a valid MySQL comparison. eg. '`field1` is NULL'
    * @return   Returns the array of search results if successful, false if not.
    */
    public function search($keywords, $fields, $table = 'CULTURE', $key = 'CULT_ID', $type = 'like', $custom = NULL)
    {
        
        if (!is_array($fields)) {
            $fields = explode(', ', $fields);
        } //is_array($fields)
        
        if (!is_array($keywords)) {
            $keywords = explode(', ', $keywords);
        } //is_array($keywords)
        
        $conditions = array();
        
        switch ($type) {
            case 'like':
                if (sizeof($keywords) == 1) {
                    foreach ($fields as $field) {
                        $conditions[$field] = $keywords[0];
                    } //$fields as $field
                    
                    try {
                        return $this->selectLike($conditions, $table, $key, $custom);
                    }
                    catch (Exception $e) {
                        return FALSE;
                    }
                } //sizeof($keywords) == 1
                else {
                    $i = 0;
                    foreach ($keywords as $keyword) {
                        if ($keyword == '-') {
                            $i++;
                            continue;
                        } //$keyword == '-'
                        elseif ($i == sizeof($fields)) {
                            break;
                        } //$i == sizeof($fields)
                        $conditions[$fields[$i]] = $keyword;
                        $i++;
                    } //$keywords as $keyword
                    
                    try {
                        return $this->selectLike($conditions, $table, $key, $custom, 'and');
                    }
                    catch (Exception $e) {
                        return FALSE;
                    }
                }
                
                break;
            
            case 'range':
                if (sizeof($keywords) == 1) {
                    foreach ($fields as $field) {
                        $conditions[$field] = $keywords[0];
                    } //$fields as $field
                    
                    try {
                        return $this->selectLike($conditions, $table, $key, $custom);
                    }
                    catch (Exception $e) {
                        return FALSE;
                    }
                    
                    
                } //sizeof($keywords) == 1
                elseif (sizeof($keywords) == 2) {
                    $conditions['before'] = $keywords[0];
                    $conditions['after']  = $keywords[1];
                    
                    try {
                        return $this->selectRange($conditions, 'CULT_DATE', $table, $key, $custom);
                    }
                    catch (Exception $e) {
                        return FALSE;
                    }
                    
                } //sizeof($keywords) == 2
                else {
                    throw new Exception('Class: Culture_model Method: search Case: "range" - (1) to many keywords passed');
                }
                
                break;
            
            default:
                throw new Exception('Class: Culture_model Method: search - (2) Invalid Type');
                break;
        } //$type
    }
    
    /**
    * selectOne
    *
    * Selects and returns one fully resolved culture record (includes all lookup tables and other related records)
    * 
    * @access   public   
    * @param    id      int (string)      the ID of the culture to select
    * @return   Returns an array of results. (Can be elements will be false if record does not exist)
    */
    public function selectOne($id)
    {
        $record = array();
        
        try {
            $record['CULTURE'] = $this->get_culture($id);
        }
        catch (Exception $e) {
            throw $e;
        }
        
        try {
            $record['TAXONOMY'] = $this->get_tax($id);
        }
        catch (Exception $e) {
            throw $e;
        }
        
        try {
            $record['VIAL'] = $this->get_vials($id);
        }
        catch (Exception $e) {
            throw $e;
        }
        
        try {
            $record['DNARNA'] = $this->get_dnarna($id);
        }
        catch (Exception $e) {
            throw $e;
        }
        
        return $record;
    }
    
    /**
    * get_culture
    *
    * Selects and returns the a culture record without any resolved foreign keys
    * 
    * @access   public   
    * @param    id      int (string)     the ID of the culture to select
    * @return   Returns an array of results if successful, a message string if not.
    */
    public function get_culture($id)
    {
        
        if (!isset($id)) {
            throw new Exception('Class: Culture_model Method: get_culture - (1) id paramater required');
        } //isset($id)
        
        try {
            $results = $this->select($id, 'CULTURE');
            
        }
        catch (Exception $e) {
            return 'No Culture available. It seems as though this culture does not exist. ';
        }

        if($results[0]){ //should only be one element of the query array returned.
            return $results[0];
        }else{
            return 'No Culture available. It seems as though this culture does not exist. ';
        } 
    }

    
    /**
    * get_tax
    *
    * Selects and returns the taxonomy record associated with the culture id passed 
    * 
    * @access   public   
    * @param    id      int (string)     the ID of the **culture** record you want to resolve the taxonomy from.
    * @return   Returns an array of results if successful, false if not.
    */
    public function get_tax($id)
    {
        
        if (!isset($id)) {
            throw new Exception('Class: Culture_model Method: get_tax - (1) id paramater required');
        } //isset($id)
        
        //First, get taxonomy ID from the Culture table.
        try {
            $culture = $this->select($id);
        }
        catch (Exception $e) {
            return 'No Culture available.';
        }

        if($culture){
            $taxid = $culture[0]['TAX_ID']; //element 0 should be the only one. Reduce the dimension of the array.
        }else{
            return 'No Culture available. It seems as though this culture does not exist. ';
        }
        
        
        
        //Second, grab the taxonomy row and return.
        try {
            $results = $this->select($taxid, 'TAXONOMY', 'TAX_ID');
        }
        catch (Exception $e) {
            return 'No Taxonomy available.';
        }

        if($results[0]){ //should only be one element of the query array returned.
            return $results[0];
        }else{
            return false;
        } 
    }
    
    /**
    * get_vials
    *
    * Selects and returns an array of all the vials associated with the culture id passed
    * 
    * @access   public   
    * @param    id      int (string)     the ID of the **culture** record you want to resolve the vials from
    * @return   Returns an array of results if successful, a message string if not.
    */
    public function get_vials($id)
    {
        
        if (!isset($id)) {
            throw new Exception('Class: Culture_model Method: get_vials - (1) id paramater required');
        } //isset($id)
        
        try {
            $vials = $this->select($id, 'VIAL');
        }
        catch (Exception $e) {
            return 'No Vials available.';
        }
        
        if($vials){
            return $vials;
        }else{
            return 'No Vials available.';
        }
    }
    
    /**
    * get_vials
    *
    * Selects and returns an array of all the dna/rna associated with the culture id passed
    * 
    * @access   public   
    * @param    id      int (string)    the ID of the **culture** record you want to resolve the dnarna from
    * @return   Returns an array of results if successful, a message string if not.
    */
    public function get_dnarna($id)
    {
        
        if (!isset($id)) {
            throw new Exception('Class: Culture_model Method: get_dnarna - (1) id paramater required');
        } //isset($id)
        
        try {
            $results = $this->select($id, 'DNARNA'); //multiple results can be expected
        }
        catch (Exception $e) {
            return 'No DNA / RNA information available.';
        }

        if($results){
            return $results;
        }else{
            return 'No DNA / RNA information available.';
        }
    }
        
    //update

    /**
    * editRow
    *
    * Updates the row id specified with the data that is passed. The data should be an associative array
    * arranged like: array(table => array(field => name, field => name, ...), table => array(...), ...)
    * valid tables are: CULTURE, TAXONOMY, VIAL, DNARNA
    * See database schema for valid field names and types.
    * 
    * @access   public   
    * @param    id      int (string)    the ID of the **culture** record you want to edit
    * @param    data    array           an array holding the data you want to update the record with
    * @return   an array of booleans, where true entries are successful updates and false entries are not.
    */
    public function editRow($id, $data)
    {
        if (!isset($id)) {
            throw new Exception('Class: Culture_model Method: editRow - (1) Param $id required.');
        } //isset($id)
        if (!isset($data) || !is_array($data)) {
            throw new Exception('Class: Culture_model Method: editRow - (1) Param $data (Array) required.');
        } //isset($data) || !is_array($data)
        
        $record = array();
        $tables = array_keys($data);
        
        try {
            if (in_array('CULTURE', $tables)) {
                $record['CULTURE'] = $this->update_culture($id, $data['CULTURE']);
            } //in_array('CULTURE', $tables)
        }
        catch (Exception $e) {
            throw $e;
        }
        
        try {
            if (in_array('TAXONOMY', $tables)) {
                $record['TAXONOMY'] = $this->update_tax($id, $data['TAXONOMY']);
            } //in_array('TAXONOMY', $tables)
        }
        catch (Exception $e) {
            throw $e;
        }
        
        if (in_array('VIAL', $tables)) {
            foreach ($data['VIAL'] as $vial) {
                try {
                    $record['VIAL'][] = $this->update_vial($vial['VIAL_ID'], $vial);
                }
                catch (Exception $e) {
                    throw $e;
                }
            } //$data['VIAL'] as $vial
        } //in_array('VIAL', $tables)
        
        if (in_array('DNARNA', $tables)) {
            foreach ($data['DNARNA'] as $dnarna) {
                try {
                    $record['DNARNA'][] = $this->update_dnarna($dnarna['DNARNA_ID'], $dnarna);
                }
                catch (Exception $e) {
                    throw $e;
                }
            } //$data['DNARNA'] as $dnarna
        } //in_array('DNARNA', $tables)
        
        return $record;
    }
    
    /**
    * update_culture
    *
    * Updates a culture record with the fields given
    * Fields to update should be specified in the fields array: array( field => value, field => value, ...)
    * 
    * @access   public   
    * @param    id      int (string)    the id of the culture you want to update.
    * @param    fields  array           associative array holding the field => value pairs to update the record with
    * @return   Returns true if successful, false if not.
    */
    public function update_culture($id, $fields)
    {
        
        if (!isset($id)) {
            throw new Exception('Class: Culture_model Method: update_culture - (1) Param $id required.');
        } //isset($id)
        if (!isset($fields) || !is_array($fields)) {
            throw new Exception('Class: Culture_model Method: update_culture - (1) Param $fields (Array) required.');
        } //isset($fields) || !is_array($fields)
        
        try {
            $fields['CULT_USER']    = $this->session->userdata('user_id');
            $fields['CULT_MODDATE'] = date("Y-m-d");
            return $this->update($id, $fields, 'CULTURE', 'CULT_ID');
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    /**
    * update_tax
    *
    * Updates a taxonomy record associated with the culture ID passed
    * Fields to update should be specified in the fields array: array( field => value, field => value, ...)
    * 
    * @access   public   
    * @param    id      int (string)    the ID of the **culture** record you want update the taxonomy for
    * @param    fields  array           associative array holding the field => value pairs to update the record with
    * @return   Returns true if successful, false if not.
    */
    public function update_tax($id, $fields)
    {
        
        if (!isset($id)) {
            throw new Exception('Class: Culture_model Method: update_culture - (1) Param $id required.');
        } //isset($id)
        if (!isset($fields) || !is_array($fields)) {
            throw new Exception('Class: Culture_model Method: update_culture - (1) Param $fields (Array) required.');
        } //isset($fields) || !is_array($fields)
        
        try {
            $culture = $this->select($id);
        }
        catch (Exception $e) {
            throw $e;
        }
        
        $taxid = $culture[0]['TAX_ID'];
        
        try {
            $fields['TAX_USER']    = $this->session->userdata('user_id');
            $fields['TAX_MODDATE'] = date("Y-m-d");
            return $this->update($taxid, $fields, 'TAXONOMY', 'TAX_ID');
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    /**
    * update_vial
    *
    * Updates a single vial record with the fields passed
    * Fields to update should be specified in the fields array: array( field => value, field => value, ...)
    * 
    * @access   public   
    * @param    id      int (string)    the ID of the vial you want to update
    * @param    fields  array           associative array holding the field => value pairs to update the record with      
    * @return   Returns true if successful, false if not.
    */
    public function update_vial($id, $fields)
    {
        
        if (!isset($id)) {
            throw new Exception('Class: Culture_model Method: update_culture - (1) Param $id required.');
        } //isset($id)
        if (!isset($fields) || !is_array($fields)) {
            throw new Exception('Class: Culture_model Method: update_culture - (1) Param $fields (Array) required.');
        } //isset($fields) || !is_array($fields)
        
        try {
            $fields['VIAL_USER']    = $this->session->userdata('user_id');
            $fields['VIAL_MODDATE'] = date("Y-m-d");
            return $this->update($id, $fields, 'VIAL', 'VIAL_ID');
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    /**
    * update_dnarna
    *
    * Updates a single dnarna record with the fields passed
    * Fields to update should be specified in the fields array: array( field => value, field => value, ...)
    * 
    * @access   public   
    * @param    id      int (string)    the ID of the dnarna record you want to update
    * @param    fields  array           associative array holding the field => value pairs to update the record with
    * @return   Returns true if successful, false if not.
    */
    public function update_dnarna($id, $fields)
    {
        
        if (!isset($id)) {
            throw new Exception('Class: Culture_model Method: update_culture - (1) Param $id required.');
        } //isset($id)
        if (!isset($fields) || !is_array($fields)) {
            throw new Exception('Class: Culture_model Method: update_culture - (1) Param $fields (Array) required.');
        } //isset($fields) || !is_array($fields)
        
        try {
            $fields['DNARNA_USER']    = $this->session->userdata('user_id');
            $fields['DNARNA_MODDATE'] = date("Y-m-d");
            $this->update($id, $fields, 'DNARNA', 'DNARNA_ID');
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    //delete

    /**
    * delete_culture
    *
    * Deletes a culture record and the records associated with it (cascading delete in mysql)
    * 
    * @access   public   
    * @param    id      int (string)    the ID of the culture you want to delete
    * @return   Returns true if successful, false if not.
    */
    public function delete_culture($id)
    {
        return $this->delete($id);
    }
    
    /**
    * delete_tax
    *
    * Deletes a taxonomy record 
    * 
    * @access   public   
    * @param    id      int (string)    the ID of the taxonomy you want to delete
    * @return   Returns true if successful, false if not.
    */
    public function delete_tax($id)
    {
        return $this->delete($id, 'TAXONOMY', 'TAX_ID');
    }
    
    /**
    * delete_dnarna
    *
    * Deletes a dnarna record
    * 
    * @access   public   
    * @param    id      int (string)    the ID of the dnarna record you want to delete
    * @return   Returns true if successful, false if not.
    */
    public function delete_dnarna($id)
    {
        return $this->delete($id, 'DNARNA', 'DNARNA_ID');
    }
    
    /**
    * delete_vial
    *
    * Deletes a vial record
    * 
    * @access   public   
    * @param    id      int (string)    the ID of the vial you want to delete
    * @return   Returns true if successful, false if not.
    */
    public function delete_vial($id)
    {
        return $this->delete($id, 'VIAL', 'VIAL_ID');
    }
    

    //PRIVATES
    
    /**
    * select
    *
    * selects records based on the id, but can be used to select other fields as well
    * 
    * @access   private   
    * @param    id      string     the value of the field you want to select
    * @param    table   string     the table you wish to select from
    * @param    key     string     the field you wish to return (select) 
    * @param    custom  string     a custom where clause if needed
    * @return   Returns an array of results if successful , false if not.
    */
    private function select($id = NULL, $table = 'CULTURE', $key = 'CULT_ID', $custom = NULL)
    {
        
        //returns full table with unresolved keys
        if ($id === NULL) {
            if ($custom != NULL) {
                $this->db->where($custom);
            } //$custom != NULL
            $query = $this->db->get($table);
            
            if ($query->num_rows() > 0) {
                return $query->result_array();
            } //$query->num_rows() > 0
            return FALSE;
        } //$id === NULL
        
        //returns table row(s) that matches id passed
        if ($custom != NULL) {
            $this->db->where($custom);
        } //$custom != NULL
        $query = $this->db->get_where($table, array(
            $key => $id
        ));
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } //$query->num_rows() > 0
        return FALSE;
    }
    
    /**
    * selectLike
    *
    * selects records based on keywords, can be set to use OR or AND clauses
    * $conditions is an associative array containing field => value pairs
    * constructed like 'Field' => 'word'
    *                   Field IS LIKE word
    * 
    * @access   private   
    * @param    conditions      array      array of field => value pairs
    * @param    table           string     the table you wish to select from
    * @param    key             string     the field you wish to return (select)
    * @param    custom          string     a custom where clause if needed
    * @param    type            string     either 'or' or 'and' to select different clauses
    * @return   Returns an array of results if successful , false if not.
    */
    private function selectLike($conditions, $table = 'CULTURE', $key = 'CULT_ID', $custom = NULL, $type = 'or')
    {
        
        //$conditions = array('Field' => 'word', ...)
        //				   'Field' is like 'Word'
        
        $fields = array_keys($conditions);
        $words  = array_values($conditions);
        
        for ($x = 0; $x < sizeof($fields); $x++) {
            $statements[$x] = array(
                'field' => $fields[$x],
                'word' => $words[$x]
            );
        } //$x = 0; $x < sizeof($fields); $x++
        
        $this->db->select($key)->distinct();
        $this->db->from($table);
        if ($custom != NULL) {
            $this->db->where($custom);
        } //$custom != NULL
        
        $i          = 0;
        $wheregroup = '(';
        foreach ($statements as $statement) {
            if ($type == 'or') {
                if ($statement['word'] === NULL) {
                    if ($i == 0) {
                        $wheregroup .= $statement['field'] . ' IS NULL';
                    } //$i == 0
                    else {
                        $wheregroup .= ' OR ' . $statement['field'] . ' IS NULL';
                    }
                } //$statement['word'] === NULL
                else {
                    if ($i == 0) {
                        $wheregroup .= $statement['field'] . ' LIKE \'' . (string) $statement['word'] . '\'';
                    } //$i == 0
                    else {
                        $wheregroup .= ' OR ' . $statement['field'] . ' LIKE \'' . (string) $statement['word'] . '\'';
                    }
                }
            } //$type == 'or'
            elseif ($type == 'and') {
                if ($statement['word'] === NULL) {
                    if ($i == 0) {
                        $wheregroup .= $statement['field'] . ' IS NULL';
                    } //$i == 0
                    else {
                        $wheregroup .= ' AND ' . $statement['field'] . ' IS NULL';
                    }
                } //$statement['word'] === NULL
                else {
                    if ($i == 0) {
                        $wheregroup .= $statement['field'] . ' LIKE \'' . (string) $statement['word'] . '\'';
                    } //$i == 0
                    else {
                        $wheregroup .= ' AND ' . $statement['field'] . ' LIKE \'' . (string) $statement['word'] . '\'';
                    }
                }
            } //$type == 'and'
            else {
                throw new Exception('Class: Culture_model Method: selectLike - (1) invalid $type');
            }
            $i++;
        } //$statements as $statement
        $wheregroup .= ')';
        $this->db->where($wheregroup, '', FALSE);
        
        if ($table == 'CULTURE')
            $this->db->order_by('CULT_LABNUM', 'asc');
        $query = $this->db->get();
        
        if ($query->num_rows > 0) {
            return $query->result_array();
        } //$query->num_rows > 0
        return FALSE;
    }
    
    /**
    * selectRange
    * 
    * For dates and other values
    * selects records between two points
    * $conditions is an associative array containing two specific keys: 'before' and 'after'
    * constructed like 'before' => '1', 'after' => '2'
    *                   where field > 1
    *                   where field < 2
    * 
    * @access   private   
    * @param    range      array      array of two elements, 'before' and 'after'
    * @param    field      string     the field you wish to select the range from
    * @param    table      string     the table you wish to select from
    * @param    key        string     the field you wish to return (select)
    * @param    custom     string     a custom where clause if needed
    * @return   Returns an array of results if successful, false if not.
    */
    private function selectRange($range, $field = 'CULT_DATE', $table = 'CULTURE', $key = 'CULT_ID', $custom = NULL)
    {
        
        //$range = array('before' => 'value', 'after' => 'value')
        //where $field > before and where $field < after
        
        if (sizeof($range) != 2) {
            throw new Exception('Class: Culture_model Method: selectRange - (1) $range param is required to be an array of two elements: "before" and "after"');
        } //sizeof($range) != 2
        elseif (!isset($range['before']) || !isset($range['after'])) {
            throw new Exception('Class: Culture_model Method: selectRange - (2) $range param is required to be an array of two elements: "before" and "after"');
        } //isset($range['before']) || !isset($range['after'])
        
        $fields = explode(', ', $field);
        //$field = NULL; //clear for future use
        
        $this->db->select($key)->distinct();
        $this->db->from($table);
        foreach ($fields as $feild) {
            $this->db->where($field . ' >', $range['before']);
            $this->db->where($field . ' <', $range['after']);
        } //$fields as $feild
        if ($custom != NULL) {
            $this->db->where($custom);
        } //$custom != NULL
        $query = $this->db->get();
        
        if ($query->num_rows > 0) {
            return $query->result_array();
        } //$query->num_rows > 0
        return FALSE;
    }
    
    /**
    * update
    * 
    * updates the record specified with the fields given within $data
    * $data should be constructed like: array(field => value, field => value, ...)
    * 
    * @access   private   
    * @param    id         string     the id of the record you with to update
    * @param    data       string     the assocative array holding field => value pairs
    * @param    table      string     the table which holds the record to be updated
    * @param    key        string     the field which the id matches
    * @param    custom     string     a custom where clause if needed
    * @return   Returns true if successful, false if not.
    */
    private function update($id, $data, $table = 'CULTURE', $key = 'CULT_ID', $custom = NULL)
    {
        if (!is_array($data)) {
            throw new Exception('Class: Culture_model Method: update - (1) Param $data required to be array.');
        } //is_array($data)
        
        $this->db->where($key, $id);
        if ($custom) {
            $this->db->where($custom);
        } //$custom
        if ($this->db->update($table, $data)) {
            return TRUE;
        } //$this->db->update($table, $data)
        return FALSE;
    }
    
    /**
    * create
    * 
    * Create a record within the table specified
    * fields are passed through the associative array: array( field => value, field => value, ...)
    * 
    * @access   private   
    * @param    data       array      associative array of field => value pairs used to create the record
    * @param    table      string     the table to create the record in
    * @return   if successful can return the ID of the record created (if not available, then TRUE), false if not.
    */
    private function create($data, $table = 'CULTURE')
    {
        if (!is_array($data)) {
            throw new Exception('Class: Culture_model Method: Create - (1) Param $data required to be array.');
        } //is_array($data)
        
        if ($this->db->insert($table, $data)) {
            if ($this->db->insert_id())
                return $this->db->insert_id();
            return TRUE;
        } //$this->db->insert($table, $data)
        return FALSE;
    }
    
    /**
    * create_batch
    * 
    * Create multiple records within the table specified
    * fields are passed through the associative data array: array( array(field => value, field => value, ...), array(...), ...)
    * 
    * @access   private   
    * @param    data      array      associative array of field => value pairs used to create the record
    * @param    table     string     table which to create the records in
    * @return   Returns true successful, false if not.
    */
    private function create_batch($data, $table = 'CULTURE')
    {
        if (!is_array($data)) {
            throw new Exception('Class: Culture_model Method: create_batch - (1) Param $data required to be array.');
        } //is_array($data)
        
        if ($this->db->insert_batch($table, $data)) {
            return TRUE;
        } //$this->db->insert_batch($table, $data)
        return FALSE;
    }
    
    /**
    * delete
    * 
    * delete a record from the table specified
    * 
    * @access   private   
    * @param    id      string     the id of the record to be deleted
    * @param    table   string     table which to delete from
    * @param    key     string     the field which the id belongs to
    * @return   Returns true if successful, false if not.
    */
    private function delete($id, $table = 'CULTURE', $key = 'CULT_ID')
    {
        if (!isset($id)) {
            throw new Exception('Class: Culture_model Method: delete - (1) Param $id required.');
        } //isset($id)
        $where = array(
            $key => $id
        );
        return $this->db->delete($table, $where);
    }
    
}