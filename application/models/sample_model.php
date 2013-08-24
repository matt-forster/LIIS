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
    
    
    //PUBLIC
    //create
    public function createRow($data)
    {
        $tables = array_keys($data);
        
        createNulls($data);
        
        if (in_array('SOURCE', $tables)) {
            
            $id = $this->create_source($data['SOURCE'], 'SOURCE');
            
            if (in_array('SAMPLE', $tables)) {
                $data['SAMPLE']['SOURCE_ID'] = $id;
            } //in_array('SAMPLE', $tables)
        } //in_array('SOURCE', $tables)
        
        if (in_array('SAMPLE', $tables)) {
            
            $insert = $this->create_sample($data['SAMPLE'], 'SAMPLE');
            
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
                $this->create_dnarna($dnarna, 'DNARNA');
            } //$data['DNARNA'] as $dnarna
        } //in_array('DNARNA', $tables)
    }
    
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
    }
    
    public function create_source($data)
    {
        $data['SOURCE_USER']    = $this->session->userdata('user_id');
        $data['SOURCE_MODDATE'] = date("Y-m-d");
        
        return $this->create($data, 'SOURCE');
    }
    
    public function create_dnarna($data)
    {
        $data['DNARNA_USER']    = $this->session->userdata('user_id');
        $data['DNARNA_MODDATE'] = date("Y-m-d");
        
        return $this->create($data, 'DNARNA');
    }
    
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
    
    public function get_sample($proj, $id)
    {
        
        if (!isset($proj) || !isset($id)) {
            throw new Exception('Class: Sample_model Method: get_sample - (1) project and/or id paramaters required');
        } //!isset($proj) || !isset($id)
        
        try {
            $ids    = $proj . ', ' . $id;
            $result = $this->select($ids);
            return $result[0];
        }
        catch (Exception $e) {
            return 'No properties available. It seems as though this record doesnt exist.';
        }
    }
    
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
        
        $source = $result[0]['SOURCE_ID'];
        if ($source != NULL) {
            try {
                $result = $this->select($source, 'SOURCE', 'SOURCE_ID');
                return $result[0];
            }
            catch (Exception $e) {
                throw $e;
            }
        } //$source != NULL
    }
    
    public function get_dnarna($proj, $id)
    {
        
        if (!isset($proj) || !isset($id)) {
            throw new Exception('Class: Sample_model Method: get_source - (1) project and/or id paramaters required');
        } //!isset($proj) || !isset($id)
        
        try {
            $ids = $proj . ', ' . $id;
            return $this->select($ids, 'DNARNA');
        }
        catch (Exception $e) {
            return 'No DNA / RNA information available.';
        }
    }
    
    public function select_field($field, $table = 'SAMPLE')
    {
        return $this->select(NULL, $table, $field);
    }
    
    public function export($table)
    {
    }
    
    //update
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
            $this->update($id, $fields, 'DNARNA', 'DNARNA_ID');
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    //delete
    public function delete_sample($proj, $id, $table = 'SAMPLE')
    {
        $ids = $proj . ', ' . $id;
        return $this->delete($ids, $table);
    }
    
    public function delete_source($id, $table = 'SOURCE')
    {
        return $this->delete($id, $table, 'SOURCE_ID');
    }
    
    public function delete_dnarna($id, $table = 'DNARNA')
    {
        return $this->delete($id, $table, 'DNARNA_ID');
    }
    
    //PRIVATES
    
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
            throw new Exception('Class: Sample_model Method: select - (1) no results returned');
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
        throw new Exception('Class: Sample_model Method: select - (2) no results returned');
    }
    
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
        throw new Exception('Class: Sample_model Method: selectLike - (2) no results returned');
    }
    
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
        throw new Exception('Class: Sample_model Method: selectRange - (2) no results returned');
    }
    
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
    
    //CONSTRUCTOR
    
    public function __construct()
    {
        
        parent::__construct();
        
        //Load the LIISDATA database for use (see database config 'config/database.php')
        $this->load->database('data');
    }
}
