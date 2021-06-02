<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Verifikasi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $data['_title'] = 'Verifikasi';
        $data['_menu'] = 'verif';
        $data['_view'] = 'verif';
        $this->load->view('verif',$data);
    }
}