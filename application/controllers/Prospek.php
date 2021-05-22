<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Prospek extends MY_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $data['_title'] = 'Prospek';
        $data['_menu'] = 'marketing';
        $data['_submenu'] = 'prospek';
        $data['_script'] = 'prospek/script';
        $data['_view'] = 'prospek/index';
        $this->load->view('layout/index', $data);
    }

}
