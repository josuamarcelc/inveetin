<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Settings Model
 * This model is used to fetch, insert, and update records in the database.
 * @author	CodexWorld Dev Team
 * @url		http://www.codexworld.com
 * @license	http://www.codexworld.com/license
 */
class Settings extends CI_Model{
    function __construct() {
        $this->tblName = 'site_settings';
    }
    
	/*
	 * Returns row from the database based
	 * @params not available
	 */
    function getRow(){
        $this->db->from($this->tblName);
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		$query = $this->db->get();
		$result = ($query->num_rows() > 0)?$query->row_array():FALSE;

        // Return fetched data
        return $result;
    }
    
	/*
	 * Insert/Update data into the database
	 * @data array the data for updating into the table
	 * @conditions not available
	 */
    public function update($data) {
		
		// Check prev row
		$prevRowCount = $this->db->count_all_results($this->tblName);
		
		if($prevRowCount > 0){
            // Add modified date if not included
			if(!array_key_exists("modified", $data)){
				$data['modified'] = date("Y-m-d H:i:s");
			}
            
            // Update settings data in the table
			$update = $this->db->update($this->tblName, $data);
            return $update?true:false;
        }else{
            // Add created and modified date if not included
			if(!array_key_exists("created", $data)){
				$data['created'] = date("Y-m-d H:i:s");
			}
			if(!array_key_exists("modified", $data)){
				$data['modified'] = date("Y-m-d H:i:s");
			}
			
			// Insert cms data to cms pages table
			$insert = $this->db->insert($this->tblName, $data);
			
			return $insert?$this->db->insert_id():false;
		}
    }
}
