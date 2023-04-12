<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Readimg extends CI_Controller {

	public function __construct()
    {
		parent::__construct();
		$this->load->library('extract_invoice');
		$this->load->helper('form');
		// $this->load->model('customModels/JsonDat_model','jsondat');
		// $this->load->model('customModels/FactDat_model','factdat');
		
    }

	public function index()
	{
		$this->load->view('header/main');
		$this->load->view('readimgView',array('error' => '' ));
		$this->load->view('footer/main');
	}
	public function layoutView($e)
	{
		$error = array('error' => $e);
		$this->load->view('header/main');
		$this->load->view('readimgView', $error);
		$this->load->view('footer/main');
	}
	public function extract()
	{
		$config['upload_path']          = 'assets/uploads/';
		$config['allowed_types']        = 'jpg|png|pdf';
		$config['overwrite']        = true;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('file')):
			$this->layoutView($this->upload->display_errors());
		else:
			$data = array('upload_data' => $this->upload->data());
			$data =$data['upload_data'] ;

			$result=$this->extract_invoice->imgData($data);

		endif;
	}
}
