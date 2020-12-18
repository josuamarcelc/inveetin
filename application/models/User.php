<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * User Model
 * This model is used to fetch, insert, update, and delete records in the database.
 * @author	CodexWorld Dev Team
 * @url		http://www.codexworld.com
 * @license	http://www.codexworld.com/license
 */
class User extends CI_Model{
    function __construct() {
        $this->tblName = 'users';
    }
    
	/*
	 * Returns rows from the database based on the conditions
	 * @params array select, conditions, searchKeyword, id, start, limit and returnType conditions
	 */
    function getRows($params = array()){
        $this->db->select("u.*, CONCAT(u.first_name,' ',u.last_name) as full_name");
        $this->db->from($this->tblName.' as u');
        
        // Fetch data by conditions
        if(array_key_exists("conditions",$params)){
			foreach ($params['conditions'] as $key => $value) {
				if(strpos($key,'.') !== false){
					$this->db->where($key,$value);
				}else{
					$this->db->where('u.'.$key,$value);
				}
			}
		}
		
		// Search by keywords
		if(!empty($params['searchKeyword'])){
			$params['searchKeyword'] = addslashes($params['searchKeyword']);
			$this->db->where("(u.first_name LIKE '%".$params['searchKeyword']."%' OR u.last_name LIKE '%".$params['searchKeyword']."%' OR u.email LIKE '%".$params['searchKeyword']."%' OR u.phone LIKE '%".$params['searchKeyword']."%')");
		}
        
        if(array_key_exists("id",$params)){
            $this->db->where('u.id',$params['id']);
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
				$this->db->limit(1);
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
    public function insert($data = array()) {
        // Add created and modified date if not included
        if(!array_key_exists("created", $data)){
            $data['created'] = date("Y-m-d H:i:s");
        }
        if(!array_key_exists("modified", $data)){
            $data['modified'] = date("Y-m-d H:i:s");
        }
        
        // Insert user data in the table
        $insert = $this->db->insert($this->tblName, $data);

        // Return the status
        if($insert){
            return $this->db->insert_id();;
        }else{
            return false;
        }
    }
	
	/*
	 * Update data into the database
	 * @data array the data for updating into the table
	 * @conditions array where condition on updating data
	 */
    public function update($data, $conditions) {
		if(!empty($data) && is_array($data) && !empty($conditions)){
            // Add modified date if not included
			if(!array_key_exists("modified", $data)){
				$data['modified'] = date("Y-m-d H:i:s");
			}
            
            // Update user data in the table
			$update = $this->db->update($this->tblName, $data, $conditions);
            return $update?true:false;
        }else{
            return false;
		}
    }
	
	/*
	 * Delete data from the database
	 * @id identifier to delete data
	 */
	public function delete($id){
		$delete = $this->db->delete($this->tblName, array('id' => $id));
		return $delete?true:false;
	}
}
