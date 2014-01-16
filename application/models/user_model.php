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
 * User Model
 *
 * Loads the USERS database and provides logic for manipulating the USER table.
 *
 * @category    LIIS-Model
 * @author      Matt Forster / @frostyforster
 * @link        http://github.com/forstermatth/liis
 */

class User_model extends CI_Model
{
    
    protected $userdb;
    
    function __construct()
    {
        parent::__construct();
        
        $this->userdb = $this->load->database('user', TRUE);
    }
    
    public function listUsers()
    {
        $this->userdb->select('USER_ID, USER_FNAME, USER_LNAME');
        $this->userdb->from('USERS');
        $records = $this->userdb->get();
        return $records->result_array();
    }
    
    public function selectuser($id, $key = 'USER_ID')
    {
        try {
            return $this->select($id, 'USERS', $key);
        }
        catch (Exception $e) {
            return FALSE;
        }
        
    }
    
    public function createUser($data)
    {
        $name               = explode(' ', $data['NAME']);
        $data['USER_FNAME'] = $name[0];
        if (isset($name[1])) {
            $data['USER_LNAME'] = $name[1];
        } //isset($name[1])
        unset($data['NAME']);
        return $this->create($data);
    }
    
    public function updateUser($id, $data)
    {
        $name               = explode(' ', $data['NAME']);
        $data['USER_FNAME'] = $name[0];
        if (isset($name[1])) {
            $data['USER_LNAME'] = $name[1];
        } //isset($name[1])
        unset($data['NAME']);
        return $this->update($id, $data);
    }
    
    public function deleteUser($id)
    {
        return $this->delete($id);
    }
    
    //Private
    private function create($data, $table = 'USERS')
    {
        if (!is_array($data)) {
            throw new Exception('Class: User_model Method: Create - (1) Param $data required to be array.');
        } //is_array($data)
        
        if ($this->userdb->insert($table, $data)) {
            if ($this->userdb->insert_id())
                return $this->userdb->insert_id();
            return TRUE;
        } //$this->userdb->insert($table, $data)
        return FALSE;
    }
    
    private function select($id = NULL, $table = 'USERS', $key = 'USER_ID', $custom = NULL)
    {
        
        //returns full table with unresolved keys
        if ($id === NULL) {
            if ($custom != NULL) {
                $this->db->where($custom);
            } //$custom != NULL
            $query = $this->userdb->get($table);
            
            if ($query->num_rows() > 0) {
                return $query->result_array();
            } //$query->num_rows() > 0
            throw new Exception('Class: User_model Method: select - (1) no results returned');
        } //$id === NULL
        
        //returns table row(s) that matches id passed
        if ($custom != NULL) {
            $this->userdb->where($custom);
        } //$custom != NULL
        $query = $this->userdb->get_where($table, array(
            $key => $id
        ));
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } //$query->num_rows() > 0
        throw new Exception('Class: User_model Method: select - (2) no results returned');
    }
    
    private function update($id, $data, $table = 'USERS', $key = 'USER_ID', $custom = NULL)
    {
        if (!isset($id) || !isset($data)) {
            throw new Exception('Class: User_model Method: update - (1) Params $id/$data required.');
        } //isset($id) || !isset($data)
        if (!is_array($data)) {
            throw new Exception('Class: User_model Method: update - (1) Param $data required to be array.');
        } //is_array($data)
        
        $this->userdb->where($key, $id);
        if ($custom) {
            $this->userdb->where($custom);
        } //$custom
        if ($this->userdb->update($table, $data)) {
            return TRUE;
        } //$this->userdb->update($table, $data)
        return FALSE;
    }
    
    private function delete($id, $table = 'USERS', $key = 'USER_ID')
    {
        if (!isset($id)) {
            throw new Exception('Class: User_model Method: update - (1) Param $id required.');
        } //isset($id)
        $where = array(
            $key => $id
        );
        return $this->userdb->delete($table, $where);
    }
}