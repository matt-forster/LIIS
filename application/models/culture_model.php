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
    
    
    //PUBLIC
    //create
    public function createRow($data)
    {
        $tables = array_keys($data);
        
        createNulls($data);
        
        if (in_array('TAXONOMY', $tables)) {
            
            $id = $this->create_tax($data['TAXONOMY'], 'TAXONOMY');
            
            if (in_array('CULTURE', $tables)) {
                $data['CULTURE']['TAX_ID'] = $id;
            } //in_array('CULTURE', $tables)
        } //in_array('TAXONOMY', $tables)
        
        if (in_array('CULTURE', $tables)) {
            
            $insert = $this->create_culture($data['CULTURE']);
            
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
                $this->create_dnarna($dnarna);
            } //$data['DNARNA'] as $dnarna
        } //in_array('DNARNA', $tables)
        if (in_array('VIAL', $tables)) {
            foreach ($data['VIAL'] as $vial) {
                $this->create_vial($vial);
            } //$data['VIAL'] as $vial
        } //in_array('VIAL', $tables)
    }
    
    public function create_culture($data)
    {
        $data['CULT_USER']    = $this->session->userdata('user_id');
        $data['CULT_MODDATE'] = date("Y-m-d");
        
        return $this->create($data, 'CULTURE');
    }
    
    public function create_tax($data)
    {
        $data['TAX_USER']    = $this->session->userdata('user_id');
        $data['TAX_MODDATE'] = date("Y-m-d");
        
        return $this->create($data, 'TAXONOMY');
    }
    
    public function create_vial($data)
    {
        $data['VIAL_USER']    = $this->session->userdata('user_id');
        $data['VIAL_MODDATE'] = date("Y-m-d");
        
        $this->create($data, 'VIAL');
    }
    
    public function create_dnarna($data)
    {
        $data['DNARNA_USER']    = $this->session->userdata('user_id');
        $data['DNARNA_MODDATE'] = date("Y-m-d");
        
        $this->create($data, 'DNARNA');
    }
    
    public function import($array, $table = 'CULTURE')
    {
        foreach ($array as &$culture) {
            $culture['CULT_USER']    = $this->session->userdata('user_id');
            $culture['CULT_MODDATE'] = date("Y-m-d");
        } //$array as &$culture
        
        try {
            $this->create_batch($array, $table);
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    //read
    public function search($keywords, $fields, $table = 'CULTURE', $key = 'CULT_ID', $type = 'like', $custom = NULL)
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
    
    public function get_culture($id)
    {
        
        if (!isset($id)) {
            throw new Exception('Class: Culture_model Method: get_culture - (1) id paramater required');
        } //!isset($id)
        
        try {
            $results = $this->select($id, 'CULTURE');
            return $results[0]; //should only be one element of the query array returned.
        }
        catch (Exception $e) {
            return 'No Culture available. It seems as though this culture does not exist. ';
        }
    }
    
    public function get_tax($id)
    {
        
        if (!isset($id)) {
            throw new Exception('Class: Culture_model Method: get_tax - (1) id paramater required');
        } //!isset($id)
        
        //First, get taxonomy ID from the Culture table.
        try {
            $culture = $this->select($id);
        }
        catch (Exception $e) {
            return 'No Culture available.';
        }
        
        $taxid = $culture[0]['TAX_ID']; //element 0 should be the only one. Reduce the dimension of the array.
        
        //Second, grab the taxonomy row and return.
        try {
            $results = $this->select($taxid, 'TAXONOMY', 'TAX_ID');
            return $results[0]; //reduce the dimension of the array returned.
        }
        catch (Exception $e) {
            return ' No Taxonomy available.';
        }
    }
    
    public function get_vials($id)
    {
        
        if (!isset($id)) {
            throw new Exception('Class: Culture_model Method: get_vials - (1) id paramater required');
        } //!isset($id)
        
        try {
            $vials = $this->select($id, 'VIAL');
        }
        catch (Exception $e) {
            return ' No Vials available.';
        }
        
        return $vials; //multiple results can be expected
    }
    
    public function get_dnarna($id)
    {
        
        if (!isset($id)) {
            throw new Exception('Class: Culture_model Method: get_dnarna - (1) id paramater required');
        } //!isset($id)
        
        try {
            return $this->select($id, 'DNARNA'); //multiple results can be expected
        }
        catch (Exception $e) {
            return ' No DNA or RNA available.';
        }
    }
    
    public function export()
    {
        
    }
    
    //update
    public function editRow($id, $data)
    {
        if (!isset($id)) {
            throw new Exception('Class: Culture_model Method: editRow - (1) Param $id required.');
        } //!isset($id)
        if (!isset($data) || !is_array($data)) {
            throw new Exception('Class: Culture_model Method: editRow - (1) Param $data (Array) required.');
        } //!isset($data) || !is_array($data)
        
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
    
    public function update_culture($id, $fields)
    {
        
        if (!isset($id)) {
            throw new Exception('Class: Culture_model Method: update_culture - (1) Param $id required.');
        } //!isset($id)
        if (!isset($fields) || !is_array($fields)) {
            throw new Exception('Class: Culture_model Method: update_culture - (1) Param $fields (Array) required.');
        } //!isset($fields) || !is_array($fields)
        
        try {
            $fields['CULT_USER']    = $this->session->userdata('user_id');
            $fields['CULT_MODDATE'] = date("Y-m-d");
            return $this->update($id, $fields, 'CULTURE', 'CULT_ID');
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    public function update_tax($id, $fields)
    {
        
        if (!isset($id)) {
            throw new Exception('Class: Culture_model Method: update_culture - (1) Param $id required.');
        } //!isset($id)
        if (!isset($fields) || !is_array($fields)) {
            throw new Exception('Class: Culture_model Method: update_culture - (1) Param $fields (Array) required.');
        } //!isset($fields) || !is_array($fields)
        
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
    
    public function update_vial($id, $fields)
    {
        
        if (!isset($id)) {
            throw new Exception('Class: Culture_model Method: update_culture - (1) Param $id required.');
        } //!isset($id)
        if (!isset($fields) || !is_array($fields)) {
            throw new Exception('Class: Culture_model Method: update_culture - (1) Param $fields (Array) required.');
        } //!isset($fields) || !is_array($fields)
        
        try {
            $fields['VIAL_USER']    = $this->session->userdata('user_id');
            $fields['VIAL_MODDATE'] = date("Y-m-d");
            return $this->update($id, $fields, 'VIAL', 'VIAL_ID');
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
    public function delete_culture($id, $table = 'CULTURE')
    {
        return $this->delete($id);
    }
    
    public function delete_tax($id, $table = 'TAXONOMY')
    {
        return $this->delete($id, $table, 'TAX_ID');
    }
    
    public function delete_dnarna($id, $table = 'DNARNA')
    {
        return $this->delete($id, $table, 'DNARNA_ID');
    }
    
    public function delete_vial($id, $table = 'VIAL')
    {
        return $this->delete($id, $table, 'VIAL_ID');
    }
    
    //PRIVATES
    
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
            throw new Exception('Class: Culture_model Method: select - (1) no results returned');
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
        throw new Exception('Class: Culture_model Method: select - (2) no results returned');
    }
    
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
        throw new Exception('Class: Culture_model Method: selectLike - (2) no results returned');
    }
    
    private function selectRange($range, $field = 'CULT_DATE', $table = 'CULTURE', $key = 'CULT_ID', $custom = NULL)
    {
        
        //$range = array('before' => 'value', 'after' => 'value')
        //where $field > before and where $field < after
        
        if (sizeof($range) != 2) {
            throw new Exception('Class: Culture_model Method: selectRange - (1) $range param is required to be an array of two elements: "before" and "after"');
        } //sizeof($range) != 2
        elseif (!isset($range['before']) || !isset($range['after'])) {
            throw new Exception('Class: Culture_model Method: selectRange - (2) $range param is required to be an array of two elements: "before" and "after"');
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
        throw new Exception('Class: Culture_model Method: selectRange - (2) no results returned');
    }
    
    private function update($id, $data, $table = 'CULTURE', $key = 'CULT_ID', $custom = NULL)
    {
        if (!is_array($data)) {
            throw new Exception('Class: Culture_model Method: update - (1) Param $data required to be array.');
        } //!is_array($data)
        
        $this->db->where($key, $id);
        if ($custom) {
            $this->db->where($custom);
        } //$custom
        if ($this->db->update($table, $data)) {
            return TRUE;
        } //$this->db->update($table, $data)
        return FALSE;
    }
    
    private function create($data, $table = 'CULTURE')
    {
        if (!is_array($data)) {
            throw new Exception('Class: Culture_model Method: Create - (1) Param $data required to be array.');
        } //!is_array($data)
        
        if ($this->db->insert($table, $data)) {
            if ($this->db->insert_id())
                return $this->db->insert_id();
            return TRUE;
        } //$this->db->insert($table, $data)
        return FALSE;
    }
    
    private function create_batch($data, $table = 'CULTURE')
    {
        if (!is_array($data)) {
            throw new Exception('Class: Culture_model Method: create_batch - (1) Param $data required to be array.');
        } //!is_array($data)
        
        if ($this->db->insert_batch($table, $data)) {
            return TRUE;
        } //$this->db->insert_batch($table, $data)
        return FALSE;
    }
    
    private function delete($id, $table = 'CULTURE', $key = 'CULT_ID')
    {
        if (!isset($id)) {
            throw new Exception('Class: Culture_model Method: delete - (1) Param $id required.');
        } //!isset($id)
        $where = array(
            $key => $id
        );
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