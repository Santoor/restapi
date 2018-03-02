<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model {

    public function __construct() {
        parent::__construct();
		
		//load database library
        $this->load->database();
    }

    /*
     * Fetch user data
     */
    function getRows($id = ""){
        if(!empty($id)){
            $query = $this->db->get_where('users', array('id' => $id));
            return $query->row_array();
        }else{
            $query = $this->db->get('users');
            return $query->result_array();
        }
    }
    
    
    
    
    function getMcq($id = "",$array=array()){
        if(!empty($id)){
            $query = $this->db->get_where('mcq', array('id' => $id));
            return $query->row_array();
        }else{

            
            $this->db->select('*');
            $this->db->from('mcq');
            if(count($array)>0){
                
              
                //log_message('error', print_r($array,1));
                $this->db->where_not_in('id', $array);
                
                //$this->db->where_not_in('id', $quesString);
            }
            $this->db->order_by('rand()');
            $this->db->limit(1);
            
            
            $result = $this->db->get();
            //log_message('error', $this->db->last_query());
            if ($result->num_rows() > 0) {
    		return $result->row_array();
            } else {
    		return array();
            }
        }
    }
    
    
    
    function getMcqUserDetails($id = ""){
        if(!empty($id)){
            $query = $this->db->get_where('user_score', array('uid' => $id));
            return $query->result_array();
        }else{
            $this->db->select('sum(us.points) as "Points",sum(us.time_taken) AS "Total Time",u.name');
            $this->db->from('user_score us');
            $this->db->join('users u', 'us.uid = u.id', 'left');
            $this->db->group_by('us.uid'); 
            $query = $this->db->get();
            return $query->result_array();
        }
    }
    
    /*
     * Insert user data
     */
    public function insert($data = array()) {
		
        $insert = $this->db->insert('users', $data);
        if($insert){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    
     public function insertUserAnsData($data = array()) {
		
        $insert = $this->db->insert('user_score', $data);
        if($insert){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    
    /*
     * Update user data
     */
    public function update($data, $id) {
        if(!empty($data) && !empty($id)){
			if(!array_key_exists('modified', $data)){
				$data['modified'] = date("Y-m-d H:i:s");
			}
            $update = $this->db->update('users', $data, array('id'=>$id));
            return $update?true:false;
        }else{
            return false;
        }
    }
    
    /*
     * Delete user data
     */
    public function delete($id){
        $delete = $this->db->delete('users',array('id'=>$id));
        return $delete?true:false;
    }

}
?>