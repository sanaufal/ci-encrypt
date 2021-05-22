<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');
    }

    function index() {
        $data['_title'] = 'Dashboard';
        $data['_menu'] = 'dashboard';
        $data['_script'] = 'dashboard/script';
        $data['_view'] = 'dashboard/index';
        $this->load->view('layout/index', $data );
    }

}
