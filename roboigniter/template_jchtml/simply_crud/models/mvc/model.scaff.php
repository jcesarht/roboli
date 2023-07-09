<?php
	//CRUD model para %Model%
	class %Model%Model extends CI_Model
	{
		public function __construct(){
			$this->load->database();
		}
		
		/**
		 * Insert the values in the table
		 * @param {array} get the field and values
		 * @return {boolean} response true if the process in success
		 */

		public function insert($columns){
			$response = false;
			try{
				if(is_array($columns)){
					foreach($columns as $column => $value){
						$columns[$column] = $this->db->escape($value);
					}
					$insert = $this->db->insert('%tableName%',$columns);
					if($insert == true){
						$response = true;
					}
				}
			}catch(Exception $e){
			}
			return $response;
		}

		/**
		 *  Find in the records in the table  
		 * @param {array} get the field and values for filtering
		 * @return {boolean} response true if the process in success
		 */

		public function find($params = '*'){
			$response = false;
			try{
				if(is_array($params)){
					foreach($params as $key => $value){
						$this->db->where($key,$value);
					}
					$consulta = $this->db->get('%tableName%');
					if($consulta->num_rows() > 0){
						$response = $consulta->result_array();
					}
				}else{
					$consulta = $this->db->get('%tableName%');	
					if($consulta->num_rows() > 0){
						$response = $consulta->result_array();
					}
				}
			}catch(Exception $e){
			}
			return $response;
		}

		/**
		 *  Update the values in the table
		 * @param {array} get the field and values
		 * @return {boolean} response true if the process in success
		 */

		public function update($paramsSearch, $columnsValues){
			try{
				$response = false;
				if(!is_array($paramsSearch)){
					throw new Exception("");
				}
				if(!is_array($columnsValues)){
					throw new Exception("");
				}

				foreach($columnsValues as $column => $value){
					$columnsValues[$column] = $this->db->escape($value);
				}

				foreach($paramsSearch as $key => $value){
					$key = $this->db->escape($key);
					$value = $this->db->escape($value);
					$this->db->where($key,$value);
				}
				$consulta = $this->db->update('%tableName%',$columnsValues);
				if($consulta == false){
					throw new Exception("");
				}
				$response = true;
			}catch(Exception $e){
			}
			return $response;
		}

		/**
		 *  delete the records in the table
		 * @param {array} get the field and values for filter
		 * @return {boolean} response true if the process in success
		 */

		public function delete($params = '*'){
			$response = false;
			if($params !== '*'){
				if(!is_array($params)){
					throw new Exception("");
				}
				foreach($params as $key => $value){
					$this->db->where($key,$value);
				}
				$delete = $this->db->delete('%tableName%');
				$log = $this->db->error();
				if($log['code'] != NULL){
					throw new Exception("");
				}
			}
			return $response;
		}
	}
