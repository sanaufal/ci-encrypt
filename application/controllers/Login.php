<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Login_model');
    }

    function index()
    {
        $data['_title'] = 'Login';
        $this->load->view('login',$data);
    }

    function auth()
    {
        $ret = new \stdClass();
        $ret->stat = 0;
        $ret->mesg = '';

        $name = $this->input->post('user_name');
        $pass = md5($this->input->post('user_pass'));
        $user = $this->Login_model->login($name, $pass);
        if ($user && isset($user['user_id'])) {
            $userdata = array(
                'user_id' => $user['user_id'],
                'user_name' => $user['user_name'],
                'user_full_name' => $user['user_full_name'],
                'user_role' => $user['role_name'],
                'user_photo' => isset($user['user_photo']) ? site_url('resources/uploads/photo/') . $user['user_photo'] : site_url('assets/images/dashboard/user.png'),
                'last_login' => time(),
                'last_time' => time()
            );
            $this->session->set_userdata('userdata', $userdata);
            $this->session->set_userdata('loggedin', true);
            $ret->stat = 1;
            $ret->mesg = "Login Sukses";
        } else {
            $ret->stat = 0;
            $ret->mesg = "Login Failed";
        }

        echo json_encode($ret);
    }

    function logout()
    {
        $this->session->unset_userdata('loggedin');
        $this->session->unset_userdata('userdata');
        redirect('login');
    }
}
