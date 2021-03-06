<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {	

	function __construct(){
		parent::__construct();
		$this->load->model('staff_model');
		if($this->session->userdata('logged_in')){
		$userdata=$this->session->userdata('logged_in');
		$user_id=$userdata['user_id'];
		$this->data['hospitals']=$this->staff_model->user_hospital($user_id);
		$this->data['functions']=$this->staff_model->user_function($user_id);
		$this->data['departments']=$this->staff_model->user_department($user_id);
		}
		$this->data['op_forms']=$this->staff_model->get_forms("OP");
		$this->data['ip_forms']=$this->staff_model->get_forms("IP");
	}

	public function view($organization="")
	{
		$this->load->model('reports_model');
		if(!!$organization) //if $organization variable is not empty
		{
			$this->load->helper('form');
			$this->data['organization']=$organization;
			$this->data['report']=$this->reports_model->dashboard($organization);	
			$this->data['title']=$this->data['report'][0];
			$this->load->view('templates/header',$this->data);		
			$this->load->view('pages/dashboard',$this->data);
		}
		else{
			show_404();
		}
		$this->load->view('templates/footer');
	}
	
	public function helpline(){
		$this->load->helper('form');
		$this->data['title']="Helpline Dashboard";
		$this->load->model('helpline_model');
		$this->load->model('staff_model');
		$this->data['caller_type_report']=$this->helpline_model->dashboard('caller_type');	
		$this->data['call_category_report']=$this->helpline_model->dashboard('call_category');	
		$this->data['hospital_report']=$this->helpline_model->dashboard('hospital');	
		$this->data['volunteer_report']=$this->helpline_model->dashboard('volunteer');	
		$this->data['call_type_report']=$this->helpline_model->dashboard('call_type');	
		$this->data['to_number_report']=$this->helpline_model->dashboard('to_number');	
		$this->data['op_ip_report']=$this->helpline_model->dashboard('op_ip');	
		$this->data['duration']=$this->helpline_model->dashboard('duration');			
		$this->data['caller_type']=$this->helpline_model->get_caller_type();
		$this->data['call_category']=$this->helpline_model->get_call_category();
		$this->data['resolution_status']=$this->helpline_model->get_resolution_status();
		$this->data['all_hospitals']=$this->staff_model->get_hospital();
		$this->load->view('templates/header',$this->data);		
		$this->load->view('pages/helpline/helpline_dashboard',$this->data);		
		$this->load->view('templates/footer');
	}
	
	public function bloodbanks(){
		$this->load->helper('form');
		$this->data['title']="Blood Banks Dashboard";
		$this->load->model('bloodbank/reports_model');
		$this->data['available']=$this->reports_model->get_available_blood(1);
		$this->load->view('templates/header',$this->data);		
		$this->load->view('pages/bloodbank/bloodbank_dashboard',$this->data);		
		$this->load->view('templates/footer');	
	}
	public function hospital($organization=""){
		$this->load->model('reports_model');
		$hospitalstarts=$this->reports_model->HospitalTypewise($organization);
		$this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($hospitalstarts));

	}
	public function department($organization=""){
		$this->load->model('reports_model');
		$deptstarts=$this->reports_model->dashboard_department_wise($organization);
		$this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($deptstarts));

	}
	public function district($organization=""){
		$this->load->model('reports_model');
		$diststarts=$this->reports_model->dashboard_district_wise($organization);
		$this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($diststarts));

	}
	
}