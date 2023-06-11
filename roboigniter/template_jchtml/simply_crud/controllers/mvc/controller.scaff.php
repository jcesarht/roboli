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
		$this->load->helper('url');
	}
	
	 public function index()
	{
		$response = $this->find([]);
		$this->load->view('%Model%/show',$response);
	}
	private function create(array $data){
		$response = ['code' => '200','message'=>''];
		$result = $this->%Model%Model->insert($data);
		if ($result != false){
			$response['code'] = 200;
			$response['message'] = 'Data saved success';
		}
		return $response;
	}
	private function find(array $data){
		$response = ['code' => '200','message'=>''];
		$result = $this->%Model%Model->find($data);
		if ($result != false){
			$response['code'] = 200;
			$response['data'] = $result;
			$response['message'] = 'Data found success';
		}
		return $response;
	}
	private function update($search,$data){
		$response = ['code' => '200','message'=>''];
		$result = $this->%Model%Model->update($search,$data);
		if ($result != false){
			$response['code'] = 200;
			$response['message'] = 'Data updated success';
		}
		return $response;
	}
	private function delete($data){
		$response = ['code' => '200','message'=>''];
		$result = $this->%Model%Model->delete($data);
		if ($result != false){
			$response['code'] = 200;
			$response['message'] = 'Data delete success';
		}
		return $response;
	}
	 public function add(){
		$data = $this->input->post();
		$response = (count($data) !== 0) ? $this->create($data) : '' ;
		$this->load->view('%Model%/add');
	 }
	 public function show(){
		$data = $this->input->get();
		$response = $this->find($data);
		$this->load->view('%Model%/show',$response);
	 }
	 public function edit($needle=''){
		if($needle === '')
		{
			$input = $this->input->post();
			if(count($input) != 0)
			{
				$search = ['%primaryKey%'=>$input['%primaryKey%']];
				$data = $this->update($search,$input);
				$this->load->view('%Model%/update');
			}else{
				$this->index();
			}
			
		}else
		{
			$search = ['%primaryKey%'=>$needle];
			$data = $this->find($search);
			$this->load->view('%Model%/update',$data);
		}
	 }
	 public function remove($needle=''){
		$url_base = base_url().'index.php/';
		if($needle === ''){
			$input = $this->input->post();
			if(count($input) != 0)
			{
				$search = ['%primaryKey%'=>$input['%primaryKey%']];
				$data = $this->update($search,$input);
				redirect($url_base.'/%Model%/show');
			}else{
				$this->index();
			}
		}else{
			$search = ['%primaryKey%'=>$needle];
			$this->delete($search);
			redirect($url_base.'%Model%/show');
		}
	 }

}
