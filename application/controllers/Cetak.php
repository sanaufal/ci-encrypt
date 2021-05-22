<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak extends CI_Controller {
    function __construct()
    {
        parent::__construct();
    }

    function izin() {
        $data['_title'] = 'Izin';
        $data['_view'] = 'cetak/izin';
        $this->load->view('cetak/izin', $data );
    }

}
