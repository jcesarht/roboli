<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
		$this->load->model("userModel");
		$this->load->helper('url');
	}
	
	 public function index()
	{
		$this->load->view('user/show');
	}
	private function create(array $data){
		$response = ['code' => '200','message'=>''];
		$result = $this->userModel->insert($data);
		if ($result['success']){
			$response['code'] = 200;
			$response['message'] = 'Data saved success';
		}
		return $response;
	}
	private function find(array $data){
		$response = ['code' => '200','message'=>''];
		$result = $this->userModel->find($data);
		if ($result['success']){
			$response['code'] = 200;
			$response['data'] = $result['data'];
			$response['message'] = 'Data found success';
		}
		return $response;
	}
	private function update($search,$data){
		$response = ['code' => '200','message'=>''];
		$result = $this->userModel->update($search,$data);
		if ($result['success']){
			$response['code'] = 200;
			$response['message'] = 'Data updated success';
		}
		return $response;
	}
	private function delete($data){
		$response = ['code' => '200','message'=>''];
		$result = $this->userModel->delete($data);
		if ($result['success']){
			$response['code'] = 200;
			$response['message'] = 'Data delete success';
		}
		return $response;
	}
	 public function add(){
		$data = $this->input->post();
		$response = (count($data) !== 0) ? $this->create($data) : '' ;
		$this->load->view('user/add');
	 }
	 public function show(){
		$data = $this->input->get();
		$response = $this->find($data);
		$this->load->view('user/show',$response);
	 }
	 public function edit($needle){
		$search = ['id'=>$needle];
		$data = $this->find($search);
		/*if(isset($_GET))
		$data = $this->input->get();
		if(isset($_POST))
		$data = $this->input->post();
		$id_search = ['id'=>$needle];
		$response = $this->update($id_search,$data);*/
		$this->load->view('user/add',$data);
	 }
	 public function remove(){
		$data = $this->input->get();
		$response = $this->delete($data);
		$this->load->view('user/show');
	 }

}
