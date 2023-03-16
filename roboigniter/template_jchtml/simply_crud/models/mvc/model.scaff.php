<?php
	//CRUD model para %Model%
	class %Model%Model extends CI_Model
	{
		public function __construct(){
			$this->load->database();
		}
		
		public function insert($columns){
			$error = ['error'=> false,'message' => ''];
			$result = [
				'error' => false,
				'success' => true,
			];
			if(!is_array($columns)){
				$error['error'] = true;
				$error['message'] = 'The params isn´t type array.';
				$result = [
					'error' => $error,
					'success' => false
				];
			}else{
				$insert = $this->db->insert('%tableName%',$columns);
				$result['success'] = $insert;
				if(!$insert){
					$log = $this->db->error();
					$error['error'] = true;
					$error['message'] = 'Code ['.$log['code'].']: '.$log['message'];
					$result['error'] = $error;
				}
			}
			return $result;
		}
		public function find($params = '*'){
			$error = ['error'=> false,'message' => ''];
			$result = [
				'error' => false,
				'success' => true,
			];
			if($params !== '*'){
				if(is_array($params)){
					foreach($params as $key => $value){
						$this->db->where($key,$value);
					}
					$consulta = $this->db->get('%tableName%');
					$log = $this->db->error();
					if($log['code'] != NULL){
						$error['error'] = true;
						$error['message'] = 'Code ['.$log['code'].']: '.$log['message'];
						$result['error'] = $error;
					}else{
						$result = [
							'error' => $error,
							'success' => true,
							'data' => $consulta->result()
						];
					}
				}else{
					$error['error'] = true;
					$error['message'] = 'The params isn´t array type.';
					$result = [
						'error' => $error,
						'success' => false
					];
				}
			}else{
				$consulta = $this->db->get('%tableName%');
				$log = $this->db->error();
				if($log['code'] !== NULL){
					$error['error'] = true;
					$error['message'] = 'Code ['.$log['code'].']: '.$log['message'];
					$result['error'] = $error;
				}else{
					$result = [
						'error' => $error,
						'success' => true,
						'data' => $consulta->result()
					];
				}
			}
			return $result;
		}
		public function update($paramsSearch, $columnsValues){
			$error = ['error'=> false,'message' => ''];
			$result = [
				'error' => false,
				'success' => true,
			];
			if(is_array($paramsSearch) && is_array($columnsValues)){
				foreach($paramsSearch as $key => $value){
					$this->db->where($key,$value);
				}
				$consulta = $this->db->update('%tableName%',$columnsValues);
				$log = $this->db->error();
				if($log['code'] != NULL){
					$error['error'] = true;
					$error['message'] = 'Code ['.$log['code'].']: '.$log['message'];
					$result['error'] = $error;
				}else{
					$result = [
						'error' => $error,
						'success' => true,
					];
				}
			}else{
				$error['error'] = true;
				$error['message'] = 'The params of search or columns - values isn´t type array.';
				$result = [
					'error' => $error,
					'success' => false
				];
			}
			return $result;
		}
		public function delete($params = '*'){
			$error = ['error'=> false,'message' => ''];
			$result = [
				'error' => false,
				'success' => true,
			];
			if($params !== '*'){
				if(is_array($params)){
					foreach($params as $key => $value){
						$this->db->where($key,$value);
					}
					$delete = $this->db->delete('%tableName%');
					$log = $this->db->error();
					if($log['code'] != NULL){
						$error['error'] = true;
						$error['message'] = 'Code ['.$log['code'].']: '.$log['message'];
						$result['error'] = $error;
					}else{
						$result = [
							'error' => $error,
							'success' => true,
						];
					}
				}else{
					$error['error'] = true;
					$error['message'] = 'The params isn´t array type.';
					$result = [
						'error' => $error,
						'success' => false
					];
				}
			}else{
				$delete = $this->db->delete('%tableName%');
				$log = $this->db->error();
				if($log['code'] != NULL){
					$error['error'] = true;
					$error['message'] = 'Code ['.$log['code'].']: '.$log['message'];
					$result['error'] = $error;
				}else{
					$result = [
						'error' => $error,
						'success' => true,
						'data' => $delete->result()
					];
				}
			}
			return $result;
		}
	}
