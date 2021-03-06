<?php
class Login extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('muser/user_model', 'model');
        $this->load->library('session');
    }
    public function islogin()
    {
        if( $user_name = $this->session->userdata('user_name'))
        {
            $data['json'] = array(
                'code'=>0,
                'msg'=>'',
                'data'=>''
            );
            $this->load->view('json_view', $data);
            return;
        }
        $data['json'] = array(
            'code'=>1,
            'msg'=>'You havent login, please login.',
            'data'=>''
        );
        $this->load->view('json_view', $data);
    }
    public function dashboard()
    {
        $user_name = $this->session->userdata('user_name');
        if( $user_name == "" )
        {
            $data['json'] = array(
                'code'=>1,
                'msg'=>'You havent login, please login.',
                'data'=>''
            );
            $this->load->view('json_view', $data);
            return;
        }
        $data['json'] = array(
            'code'=>0,
            'msg'=>'',
            'data'=>''
        );
        $this->load->view('json_view', $data);
    }
    public function checkin()
    {
        $name = $this->input->post('name');
        $pwd = $this->input->post('pwd');

        $data['json'] = $this->model->login($name, $pwd);
        if( empty($data['json']) )
        {
            show_404();
            return;
        }
        $this->session->set_userdata('user_name', $name);
        $this->load->view('json_view', $data);
    }
    public function checkout()
    {
        $this->session->set_userdata('user_name', "");
        $this->session->sess_destroy();
        $this->load->view('json_view'); 
    }
}
