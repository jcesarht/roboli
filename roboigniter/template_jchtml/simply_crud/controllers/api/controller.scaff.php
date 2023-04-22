<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class %Controller% extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function __construct(){
		parent::__construct();
		$this->load->model("%Model%Model");
	}
	
	 public function index()
	{
		$this->load->view('%Model%/show');
	}
	private function create(array $data){
		$response = ['code' => '200','message'=>''];
		$result = $this->%Model%Model->insert($data);
		if ($result['success']){
			$response['code'] = 200;
			$response['message'] = 'Data saved success';
		}
		return $response;
	}
	private function find(array $data){
		$response = ['code' => '200','message'=>''];
		$result = $this->%Model%Model->find($data);
		if ($result['success']){
			$response['code'] = 200;
			$response['data'] = $result['data'];
			$response['message'] = 'Data found success';
		}
		return $response;
	}
	private function update($search,$data){
		$response = ['code' => '200','message'=>''];
		$result = $this->%Model%Model->update($search,$data);
		if ($result['success']){
			$response['code'] = 200;
			$response['message'] = 'Data updated success';
		}
		return $response;
	}
	private function delete($data){
		$response = ['code' => '200','message'=>''];
		$result = $this->%Model%Model->delete($data);
		if ($result['success']){
			$response['code'] = 200;
			$response['message'] = 'Data delete success';
		}
		return $response;
	}
	 public function add(){
		$data = $this->input->post();
		$response = isset($data) ? $this->create($data) : '' ;
		echo json_encode($response);
	 }
	 public function query(){
		$data = $this->input->get();
		$response = $this->find($data);
		echo json_encode($response);
	 }
	 public function edit(){
		if(isset($_GET))
		$data = $this->input->get();
		if(isset($_POST))
		$data = $this->input->post();
		$id_search = ['id'=>$data['id']];
		$response = $this->update($id_search,$data);
		echo json_encode($response);
	 }
	 public function remove(){
		$data = $this->input->get();
		$response = $this->delete($data);
		echo json_encode($response);
	 }

}
