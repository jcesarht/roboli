<?php
	//CRUD model para %Model%
	class %Model%Model extends CI_Model
	{
		public function __construct(){
			$this->load->database();
		}
		
		public function insert($columns){
			$response = false;
			try{
				if(is_array($columns)){
					$insert = $this->db->insert('%tableName%',$columns);
					if($insert == true){
						$response = true;
					}
				}
			}catch(Exception $e){
			}
			return $response;
		}
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

		public function update($paramsSearch, $columnsValues){
			try{
				$response = false;
				if(!is_array($paramsSearch)){
					throw new Exception("");
				}
				if(!is_array($columnsValues)){
					throw new Exception("");
				}
				foreach($paramsSearch as $key => $value){
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
