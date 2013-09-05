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
 * Sample Model
 *
 * Loads the LIISDATA database and provides logic for manipulating the SAMPLE 
 * and related tables
 *
 * @category    LIIS-Model
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */

class Sample_model extends CI_Model
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
    * Valid tables are: SAMPLE, SOURCE, DNARNA 
    * See database schema for valid fields.
    * 
    * @access   public   
    * @param    data    array   The array that holds the record data.
    * @return   1 if succesful, negative number if not. -1 source fail, -2 sample fail, -3 dnarna fail.
    */
    public function createRow($data)
    {
        $tables = array_keys($data);
        
        createNulls($data);
        
        if (in_array('SOURCE', $tables)) {
            
            if(!$id = $this->create_source($data['SOURCE'], 'SOURCE')){
                return -1;
            }
            
            if (in_array('SAMPLE', $tables)) {
                $data['SAMPLE']['SOURCE_ID'] = $id;
            } //in_array('SAMPLE', $tables)
        } //in_array('SOURCE', $tables)
        
        if (in_array('SAMPLE', $tables)) {
            
            if($insert = $this->create_sample($data['SAMPLE'], 'SAMPLE')){
                return -2;
            }
            
            if (in_array('DNARNA', $tables) && $insert) {
                foreach ($data['DNARNA'] as &$dnarna) {
                    $dnarna['SAMP_EXP_ID'] = $data['SAMPLE']['SAMP_EXP_ID'];
                    $dnarna['SAMP_ID']     = $data['SAMPLE']['SAMP_ID'];
                } //$data['DNARNA'] as &$dnarna
                unset($dnarna);
            } //in_array('DNARNA', $tables) && $insert
        } //in_array('SAMPLE', $tables)
        
        if (in_array('DNARNA', $tables)) {
            foreach ($data['DNARNA'] as $dnarna) {
                if($this->create_dnarna($dnarna, 'DNARNA')){
                    return -3;
                }
            } //$data['DNARNA'] as $dnarna
        } //in_array('DNARNA', $tables)

        return 1;
    }
    
    /**
    * create_sample
    *
    * Create a record in the sample table. Requires an associative array arranged as: array(field => value, field => value, ...)
    * See database schema for valid field names and types
    * 
    * @access   public   
    * @param    data    array   an associative array holding the field names and values of the data to insert.
    * @return   Returns the record ID (array) if successful, false if not.
    */
    public function create_sample($data)
    {
        $data['SAMP_USER']    = $this->session->userdata('user_id');
        $data['SAMP_MODDATE'] = date("Y-m-d");
        
        if ($this->create($data, 'SAMPLE')) {
            return array(
                'SAMP_EXP_ID' => $data['SAMP_EXP_ID'],
                'SAMP_ID' => $data['SAMP_ID']
            );
        } //$this->create($data, 'SAMPLE')
        else{
            return FALSE;
        }
    }
    
    /**
    * create_source
    *
    * Create a record in the source table. Requires an associative array arranged as: array(field => value, field => value, ...)
    * See database schema for valid field names and types
    * 
    * @access   public   
    * @param    data    array   an associative array holding the field names and values of the data to insert.
    * @return   Returns the record ID if successful, false if not.
    */
    public function create_source($data)
    {
        $data['SOURCE_USER']    = $this->session->userdata('user_id');
        $data['SOURCE_MODDATE'] = date("Y-m-d");
        
        return $this->create($data, 'SOURCE');
    }
    
    /**
    * create_dnarna
    *
    * Create a record in the dnarna table. Requires an associative array arranged as: array(field => value, field => value, ...)
    * See database schema for valid field names and types
    * 
    * @access   public   
    * @param    data    array   an associative array holding the field names and values of the data to insert.
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
    * Create multiple sample records. Requires a multidimensional associative array arranged as: array( array(field => value, field => value, ...), array(...), ...)
    * See database schema for valid field names and types
    * 
    * @access   public   
    * @param    data    array   an associative array holding the field name and values of the data to insert.
    * @param    table   string  the primary table to import into
    * @return   Returns true if successful, false if not.
    */
    public function import($array, $table = 'SAMPLE')
    {
        foreach ($array as &$sample) {
            $sample['SAMP_USER']    = $this->session->userdata('user_id');
            $sample['SAMP_MODDATE'] = date("Y-m-d");
        } //$array as &$sample
        
        try {
            $this->create_batch($array, $table);
        }
        catch (Exception $e) {
            throw $e;
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
    public function search($keywords, $fields, $table = 'SAMPLE', $key = 'SAMP_EXP_ID, SAMP_ID', $type = 'like', $custom = NULL)
    {
        
        if (!is_array($fields)) {
            $fields = explode(', ', $fields);
        } //!is_array($fields)
        
        if (!is_array($keywords)) {
            $keywords = explode(', ', $keywords);
        } //!is_array($keywords)
        
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
                        return $this->selectRange($conditions, 'SAMP_DATE', $table, $key, $custom);
                    }
                    catch (Exception $e) {
                        return FALSE;
                    }
                    
                } //sizeof($keywords) == 2
                else {
                    throw new Exception('Class: Sample_model Method: search Case: "range" - (1) to many keywords passed');
                }
                
                break;
            
            default:
                throw new Exception('Class: Sample_model Method: search - (2) Invalid Type');
                break;
        } //$type
    }
    
    /**
    * selectOne
    *
    * Selects and returns one fully resolved sample record (includes all lookup tables and other related records)
    * 
    * @access   public
    * @param    proj    string            the project ID of the sample to select   
    * @param    id      int (string)      the ID of the sample to select
    * @return   Returns an array of results. (elements will be false if record does not exist)
    */
    public function selectOne($proj, $id)
    {
        
        $record = array();
        
        try {
            $record['SAMPLE'] = $this->get_sample($proj, $id);
        }
        catch (Exception $e) {
            throw $e;
        }
        
        try {
            $record['SOURCE'] = $this->get_source($proj, $id);
        }
        catch (Exception $e) {
            throw $e;
        }
        
        try {
            $record['DNARNA'] = $this->get_dnarna($proj, $id);
        }
        catch (Exception $e) {
            throw $e;
        }
        
        return $record;
    }
    
    /**
    * get_sample
    *
    * Selects and returns the a sample record without any resolved foreign keys
    * 
    * @access   public   
    * @param    proj    string           the project ID of the sample to select
    * @param    id      int (string)     the ID of the sample to select
    * @return   Returns an array of results if successful, a message string if not.
    */
    public function get_sample($proj, $id)
    {
        
        if (!isset($proj) || !isset($id)) {
            throw new Exception('Class: Sample_model Method: get_sample - (1) project and/or id paramaters required');
        } //!isset($proj) || !isset($id)
        
        try {
            $ids    = $proj . ', ' . $id;
            $result = $this->select($ids);
        }
        catch (Exception $e) {
            return 'No properties available. It seems as though this record doesnt exist.';
        }

        if($result[0]){
            return $result[0];
        }else{
            return 'No properties available. It seems as though this record doesnt exist.';
        }
    }
    
    /**
    * get_source
    *
    * Selects and returns the taxonomy record associated with the sample id passed 
    * 
    * @access   public   
    * @param    proj    string           the project ID of the **sample** record you want to resolve the source from.
    * @param    id      int (string)     the ID of the **sample** record you want to resolve the source from.
    * @return   Returns an array of results if successful, false if not.
    */
    public function get_source($proj, $id)
    {
        
        if (!isset($proj) || !isset($id)) {
            throw new Exception('Class: Sample_model Method: get_source - (1) project and/or id paramaters required');
        } //!isset($proj) || !isset($id)
        
        try {
            $ids    = $proj . ', ' . $id;
            $result = $this->select($ids);
        }
        catch (Exception $e) {
            return 'No Source Available';
        }
        
        if($result){
            $source = $result[0]['SOURCE_ID'];
        }else{
            return 'No Source Available';
        }
        
        if ($source != NULL) {
            try {
                $result = $this->select($source, 'SOURCE', 'SOURCE_ID');
                if($result){
                    return $result[0];
                }else{
                    return 'No Source Available';
                }
            }
            catch (Exception $e) {
                throw $e;
            }
        } //$source != NULL
    }
    
    /**
    * get_dnarna
    *
    * Selects and returns an array of all the dna/rna associated with the sample id passed
    * 
    * @access   public   
    * @param    proj    string          the project ID of the **sample** record you want to resolve the source from
    * @param    id      int (string)    the ID of the **sample** record you want to resolve the dnarna from
    * @return   Returns an array of results if successful, a message string if not.
    */
    public function get_dnarna($proj, $id)
    {
        
        if (!isset($proj) || !isset($id)) {
            throw new Exception('Class: Sample_model Method: get_source - (1) project and/or id paramaters required');
        } //!isset($proj) || !isset($id)
        
        try {
            $ids = $proj . ', ' . $id;
            $result = $this->select($ids, 'DNARNA');
        }
        catch (Exception $e) {
            return 'No DNA / RNA information available.';
        }

        if($result){
            return $result;
        }else{
            return 'No DNA / RNA information available.';
        }
    }
    
    /**
    * select_field
    *
    * Selects and returns an array of values belonging to one column of a table
    * 
    * @access   public   
    * @param    field   string          the colomn you wish to select
    * @param    table   string          the table you wish to select from
    * @return   Returns an array of results if successful, false if not.
    */
    public function select_field($field, $table = 'SAMPLE')
    {
        return $this->select(NULL, $table, $field);
    }
        
    //update

    /**
    * editRow
    *
    * Updates the row id specified with the data that is passed. The data should be an associative array
    * arranged like: array(table => array(field => name, field => name, ...), table => array(...), ...)
    * valid tables are: SAMPLE, SOURCE, DNARNA
    * See database schema for valid field names and types.
    * 
    * @access   public   
    * @param    proj    string          the project id of the **sample** record you wish to edit
    * @param    id      int (string)    the id of the **sample** record you wish to edit
    * @param    data    array           an array holding the data you want to update the record with
    * @return   an array of booleans, where true entries are successful updates and false entries are not.
    */
    public function editRow($proj, $id, $data)
    {
        if (!isset($id) || !isset($proj)) {
            throw new Exception('Class: Culture_model Method: editRow - (1) Param $id/$proj required.');
        } //!isset($id) || !isset($proj)
        if (!isset($data) || !is_array($data)) {
            throw new Exception('Class: Culture_model Method: editRow - (1) Param $data (Array) required.');
        } //!isset($data) || !is_array($data)
        
        $record = array();
        $tables = array_keys($data);
        
        try {
            if (in_array('SOURCE', $tables)) {
                $record['SOURCE'] = $this->update_source($proj, $id, $data['SOURCE']);
            } //in_array('SOURCE', $tables)
        }
        catch (Exception $e) {
            throw $e;
        }
        
        try {
            if (in_array('SAMPLE', $tables)) {
                $record['SAMPLE'] = $this->update_sample($proj, $id, $data['SAMPLE']);
            } //in_array('SAMPLE', $tables)
        }
        catch (Exception $e) {
            throw $e;
        }
        
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
    * update_sample
    *
    * Updates a sample record with the fields given
    * Fields to update should be specified in the fields array: array( field => value, field => value, ...)
    * 
    * @access   public   
    * @param    proj    string          the project id of the sample you wish to update
    * @param    id      int (string)    the id of the sample you want to update.
    * @param    fields  array           associative array holding the field => value pairs to update the record with
    * @return   Returns true if successful, false if not.
    */
    public function update_sample($proj, $id, $fields)
    {
        
        if (!isset($proj) || !isset($id)) {
            throw new Exception('Class: Culture_model Method: update_sample - (1) Param $proj/$id required.');
        } //!isset($proj) || !isset($id)
        if (!isset($fields) || !is_array($fields)) {
            throw new Exception('Class: Culture_model Method: update_sample - (1) Param $fields (Array) required.');
        } //!isset($fields) || !is_array($fields)
        
        $ids = $proj . ', ' . $id;
        
        try {
            $fields['SAMP_USER']    = $this->session->userdata('user_id');
            $fields['SAMP_MODDATE'] = date("Y-m-d");
            return $this->update($ids, $fields, 'SAMPLE', 'SAMP_EXP_ID, SAMP_ID');
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    /**
    * update_source
    *
    * Updates a source record with the fields given
    * Fields to update should be specified in the fields array: array( field => value, field => value, ...)
    * 
    * @access   public   
    * @param    proj    string          the project id of the **sample** you wish to update the source for
    * @param    id      int (string)    the id of the **sample** you wish to update the source for
    * @param    fields  array           associative array holding the field => value pairs to update the record with
    * @return   Returns true if successful, false if not.
    */
    public function update_source($proj, $id, $fields)
    {
        
        if (!isset($proj) || !isset($id)) {
            throw new Exception('Class: Culture_model Method: update_source - (1) Param $id required.');
        } //!isset($proj) || !isset($id)
        if (!isset($fields) || !is_array($fields)) {
            throw new Exception('Class: Culture_model Method: update_source - (1) Param $fields (Array) required.');
        } //!isset($fields) || !is_array($fields)
        
        try {
            $ids    = $proj . ', ' . $id;
            $sample = $this->select($ids);
        }
        catch (Exception $e) {
            throw $e;
        }
        $sourceid = $sample[0]['SOURCE_ID'];
        
        try {
            $fields['SOURCE_USER']    = $this->session->userdata('user_id');
            $fields['SOURCE_MODDATE'] = date("Y-m-d");
            return $this->update($sourceid, $fields, 'SOURCE', 'SOURCE_ID');
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
    * @param    id      int (string)    the id of the dnarna record you want to update
    * @param    fields  array           associative array holding the field => value pairs to update the record with
    * @return   Returns true if successful, false if not.
    */
    public function update_dnarna($id, $fields)
    {
        
        if (!isset($id)) {
            throw new Exception('Class: Culture_model Method: update_culture - (1) Param $id required.');
        } //!isset($id)
        if (!isset($fields) || !is_array($fields)) {
            throw new Exception('Class: Culture_model Method: update_culture - (1) Param $fields (Array) required.');
        } //!isset($fields) || !is_array($fields)
        
        try {
            $fields['DNARNA_USER']    = $this->session->userdata('user_id');
            $fields['DNARNA_MODDATE'] = date("Y-m-d");
            return $this->update($id, $fields, 'DNARNA', 'DNARNA_ID');
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    //delete

    /**
    * delete_sample
    *
    * Deletes a sample record and the records associated with it (cascading delete in mysql)
    * 
    * @access   public   
    * @param    proj    string          the project id of the sample you wish to delete
    * @param    id      int (string)    the id of the sample you wish to delete
    * @return   Returns true if successful, false if not.
    */
    public function delete_sample($proj, $id, $table = 'SAMPLE')
    {
        $ids = $proj . ', ' . $id;
        return $this->delete($ids, $table);
    }
    
    /**
    * delete_source
    *
    * Deletes a source record
    * 
    * @access   public   
    * @param    id      int (string)    the id of the source you wish to delete
    * @return   Returns true if successful, false if not.
    */
    public function delete_source($id, $table = 'SOURCE')
    {
        return $this->delete($id, $table, 'SOURCE_ID');
    }
    
    /**
    * delete_dnarna
    *
    * Deletes a dnarna record
    * 
    * @access   public   
    * @param    id      int (string)    the id of the dnarna you wish to delete
    * @return   Returns true if successful, false if not.
    */
    public function delete_dnarna($id, $table = 'DNARNA')
    {
        return $this->delete($id, $table, 'DNARNA_ID');
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
    private function select($id = NULL, $table = 'SAMPLE', $key = 'SAMP_EXP_ID, SAMP_ID', $custom = NULL)
    {
        
        //returns query 
        if ($id === NULL) {
            if ($custom != NULL) {
                $this->db->where($custom);
            } //$custom != NULL
            
            $this->db->select($key)->distinct();
            $query = $this->db->get($table);
            
            if ($query->num_rows() > 0) {
                return $query->result_array();
            } //$query->num_rows() > 0
            return FALSE;
        } //$id === NULL
        
        //composite key matching
        $keys  = explode(', ', $key);
        $ids   = explode(', ', $id);
        $where = array();
        for ($x = 0; $x < sizeof($keys); $x++) {
            $where[$keys[$x]] = $ids[$x];
        } //$x = 0; $x < sizeof($keys); $x++
        
        if ($custom != NULL) {
            $this->db->where($custom);
        } //$custom != NULL
        $query = $this->db->get_where($table, $where);
        
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
    private function selectLike($conditions, $table = 'SAMPLE', $key = 'SAMP_EXP_ID, SAMP_ID', $custom = NULL, $type = 'or')
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
                if ($statement['word'] == NULL) {
                    if ($i == 0) {
                        $wheregroup .= $statement['field'] . ' IS NULL';
                    } //$i == 0
                    else {
                        $wheregroup .= ' OR ' . $statement['field'] . ' IS NULL';
                    }
                } //$statement['word'] == NULL
                else {
                    if ($i == 0) {
                        $wheregroup .= $statement['field'] . ' LIKE \'' . $statement['word'] . '\'';
                    } //$i == 0
                    else {
                        $wheregroup .= ' OR ' . $statement['field'] . ' LIKE \'' . $statement['word'] . '\'';
                    }
                }
            } //$type == 'or'
            elseif ($type == 'and') {
                if ($statement['word'] == NULL) {
                    if ($i == 0) {
                        $wheregroup .= $statement['field'] . ' IS NULL';
                    } //$i == 0
                    else {
                        $wheregroup .= ' AND ' . $statement['field'] . ' IS NULL';
                    }
                } //$statement['word'] == NULL
                else {
                    if ($i == 0) {
                        $wheregroup .= $statement['field'] . ' LIKE \'' . $statement['word'] . '\'';
                    } //$i == 0
                    else {
                        $wheregroup .= ' AND ' . $statement['field'] . ' LIKE \'' . $statement['word'] . '\'';
                    }
                }
            } //$type == 'and'
            else {
                throw new Exception('Class: Sample_model Method: selectLike - (1) invalid $type');
            }
            $i++;
        } //$statements as $statement
        $wheregroup .= ')';
        $this->db->where($wheregroup, '', FALSE);
        
        if ($table == 'SAMPLE')
            $this->db->order_by('SAMP_EXP_ID', 'asc');
        if ($table == 'SAMPLE')
            $this->db->order_by('SAMP_ID', 'asc');
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
    private function selectRange($range, $field = 'SAMP_DATE', $table = 'SAMPLE', $key = 'SAMP_EXP_ID, SAMP_ID', $custom = NULL)
    {
        
        //$range = array('before' => 'value', 'after' => 'value')
        //where $field > before and where $field < after
        
        if (sizeof($range) != 2) {
            throw new Exception('Class: Sample_model Method: selectRange - (1) $range param is required to be an array of two elements: "before" and "after"');
        } //sizeof($range) != 2
        elseif (!isset($range['before']) || !isset($range['after'])) {
            throw new Exception('Class: Sample_model Method: selectRange - (2) $range param is required to be an array of two elements: "before" and "after"');
        } //!isset($range['before']) || !isset($range['after'])
        
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
    private function update($id, $data, $table = 'SAMPLE', $key = 'SAMP_EXP_ID, SAMP_ID', $custom = NULL)
    {
        if (!isset($id)) {
            throw new Exception('Class: Sample_model Method: update - (1) Param $id required.');
        } //!isset($id)
        
        $keys  = explode(', ', $key);
        $ids   = explode(', ', $id);
        $where = array();
        for ($x = 0; $x < sizeof($keys); $x++) {
            $where[$keys[$x]] = $ids[$x];
        } //$x = 0; $x < sizeof($keys); $x++
        
        $this->db->where($where);
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
    private function create($data, $table = 'SAMPLE')
    {
        if (!is_array($data)) {
            throw new Exception('Class: Sample_model Method: Create - (1) Param $data required to be array.');
        } //!is_array($data)
        
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
    * @return   Returns true if successful, false if not.
    */
    private function create_batch($data, $table = 'SAMPLE')
    {
        if (!is_array($data)) {
            throw new Exception('Class: Sample_model Method: create_batch - (1) Param $data required to be array.');
        } //!is_array($data)
        
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
    * @param    id      string     comma delimited string of the record id to be deleted
    * @param    table   string     table which to delete from
    * @param    key     string     comma delimited list of the fields which the id belongs to
    * @return   Returns true successful, false if not.
    */
    private function delete($id, $table = 'SAMPLE', $key = 'SAMP_EXP_ID, SAMP_ID')
    {
        if (!isset($id)) {
            throw new Exception('Class: Sample_model Method: delete - (1) Param $id required.');
        } //!isset($id)
        
        $keys  = explode(', ', $key);
        $ids   = explode(', ', $id);
        $where = array();
        for ($x = 0; $x < sizeof($keys); $x++) {
            $where[$keys[$x]] = $ids[$x];
        } //$x = 0; $x < sizeof($keys); $x++
        
        return $this->db->delete($table, $where);
    }
    
}
