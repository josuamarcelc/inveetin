<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Admin User Model
 * This model is used to fetch, insert, update, and delete records in the database.
 * @author	CodexWorld Dev Team
 * @url		http://www.codexworld.com
 * @license	http://www.codexworld.com/license
 */
class Admin_User extends CI_Model{
	
	function __construct() {
		$this->tblName = 'admin_users';
	}
	
	/*
	 * Returns rows from the database based on the conditions
	 * @params array select, conditions, searchKeyword, id, start, limit and returnType conditions
	 */
	public function getRows($params = array()){
		$this->db->from($this->tblName);
		
		// Fetch data by conditions
        if(array_key_exists("conditions",$params)){
			foreach ($params['conditions'] as $key => $value) {
				$this->db->where($key,$value);
			}
		}
        
        if(array_key_exists("id",$params)){
            $this->db->where('id',$params['id']);
			$query = $this->db->get();
			$result = ($query->num_rows() > 0)?$query->row_array():FALSE;
        }else{
            // Set start and limit
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
				$result = $this->db->count_all_results();
			}elseif(array_key_exists("returnType",$params) && $params['returnType'] == 'single'){
				$query = $this->db->get();
				$result = ($query->num_rows() > 0)?$query->row_array():FALSE;
			}else{
				$query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
		
		// Return fetched data
		return $result;
	}
	
	/*
	 * Insert data into the database
	 * @data array the data for inserting into the table
	 */
	public function insert($data = array()){
		// Add created and modified date if not included
		if(!array_key_exists("created",$data)){
			$data['created'] = date("Y-m-d H:i:s");
		}
		if(!array_key_exists("modified",$data)){
			$data['modified'] = date("Y-m-d H:i:s");
		}
		
		// Insert user data to admin users table
		$insert = $this->db->insert($this->tblName,$data);
		
		// Return the status
		if($insert){
			$id = $this->db->insert_id();
			return $id;
		}else{
			return false;	
		}
	}
	
	/*
	 * Update data into the database
	 * @data array the data for updating into the table
	 * @conditions array where condition on updating data
	 */
	public function update($data = array(), $conditions = array()){
		// Add modified date if not included
		if(!array_key_exists("modified",$data)){
			$data['modified'] = date("Y-m-d H:i:s");
		}
		
		// Update user data to admin users table
		$update = $this->db->update($this->tblName, $data, $conditions);
		return $update?true:false;
		
	}
	
	/*
	 * Delete data from the database
	 * @id identifier to delete data
	 */
	public function delete($id){
		$data['is_deleted'] = 1;
		$delete = $this->db->update($this->tblName,$data,array('id'=>$id));
		return $delete?true:false;
	}
	
	/*
	 * Check admin user data by fields and values
	 */
	public function fieldValueCheck($field_value_array){
		$where = $field_value_array;
		$query = $this->db->get_where($this->tblName,$where); 
		
		if($query->num_rows() > 0){
			$result = $query->row_array();
			return $result['id'];
		}else{
			return FALSE;
		}
	}
	
	/*
	 * Existing admin user check
	 */
	public function loginCheck($condition){
		$query = $this->db->get_where($this->tblName,$condition);
		if($query->num_rows() > 0){
			return $query->row_array();
		}else{
			return FALSE;
		}
	}
}
