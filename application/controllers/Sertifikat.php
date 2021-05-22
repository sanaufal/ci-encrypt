<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sertifikat extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('Sertifikat_model');
        $this->load->library('session');
        $this->load->model('Magang_model');
        $this->load->model('Core_model');
        $this->load->model('division_model');
        $this->load->model('partner_model');
    }

    
        function encrypt($plaintext) {
            $password = '**Rozioz';
            $method = "sha256RSA";
            $key = hash('sha256', $password, true);
            $iv = openssl_random_pseudo_bytes(16);

            $ciphertext = openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv);
            var_dump($shipertext,$plaintext, $method, $key, OPENSSL_RAW_DATA, $iv);die;
            $hash = hash_hmac('sha256', $ciphertext . $iv, $key, true);

            var_dump(bin2hex($iv . $hash . $ciphertext));
        }

    function decrypt($text) {
        $ivHashCiphertext = hex2bin($text);
        $password = '**Rozioz';
        $method = "AES-256-CBC";
        $iv = substr($ivHashCiphertext, 0, 16);
        $hash = substr($ivHashCiphertext, 16, 32);
        $ciphertext = substr($ivHashCiphertext, 48);
        $key = hash('sha256', $password, true);

        if (!hash_equals(hash_hmac('sha256', $ciphertext . $iv, $key, true), $hash)) {
            return null;
        }

        return openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv);
    }
    
    function print($sertifikat_id) {
        //$id = $this->input->post('id');

        $data['sertifikat'] = $this->Sertifikat_model->get_sertifikat($sertifikat_id);
//        var_dump($data['sertifikat'] = $this->Sertifikat_model->get_sertifikat($sertifikat_id));die;
        $data['_title'] = 'Print Sertifikat';
        $data['_script'] = 'sertifikat/index_js';
//        $data['_view'] = 'sertifikat/print';
        $this->load->view('sertifikat/print', $data);
        
    }

    function index() {
        $action = $this->input->post('action');
        if ($action) {
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';

            if ($this->input->post('action') == 'load') {
                $columns = array(
                    '0' => 'sertifikat_code',
                );
                $limit = $this->input->post('length');
                $start = $this->input->post('start');
                $order = $columns[$this->input->post('order')[0]['column']];
                $dir = $this->input->post('order')[0]['dir'];

                $search = [];
                if ($this->input->post('search')['value']) {
                    $s = $this->input->post('search')['value'];
                    foreach ($columns as $k => $v) {
                        $search[$v] = $s;
                    }
                }

                $params = array();
                $datas = $this->Sertifikat_model->get_all_sertifikat($params, $search, $limit, $start, $order, $dir);
                $ret->data = $datas;
                $totaldata = $this->Sertifikat_model->get_count_sertifikat($params, $search);
                $ret->recordsTotal = $totaldata;
                $ret->recordsFiltered = $totaldata;
                $ret->stat = 1;
            }
            if ($this->input->post('action') == 'add') {
                $get_number = $this->Core_model->req_number(1);
                $data = array(
                    'sertifikat_code' => $get_number,
                    'sertifikat_magang_id' => $this->input->post('sertifikat_magang_id'),
                );
                $data['sertifikat_qr'] = "";
                //if ($this->input->post('action') && $this->input->post('action') == "generate_qrcode") {
                $ect = $get_number . ' Dokumen Ini Asli';
                $this->load->library('ciqrcode');
                $qr_image = date('d-m-Y') . ' ' . rand() . '.png';
                $params['data'] = $ect;
                $params['level'] = 'H';
                $params['size'] = 8;
                $params['savename'] = FCPATH . "assets/media/image/qrimg/" . $qr_image;

                if ($this->ciqrcode->generate($params)) {
                    $data['sertifikat_qr'] = $qr_image;
                    $data['sertifikat_encrypt'] = $ect;
                }
                
                $set_data = $this->Sertifikat_model->add_sertifikat($data);
                
                if ($set_data == true) {
                    $ret = array('stat' => 1, 'data' => $data, 'mesg' => 'Data Berhasil Ditambahkan');
                } else {
                    $ret = array('stat' => 1, 'data' => $data, 'mesg' => 'Data Tidak Berhasil Ditambahkan');
                }
            }
            if ($this->input->post('action') == 'edit') {
                $id = $this->input->post('id');
                $data = $this->Magang_model->get_magang($id);
                $result = array('stat' => 1, 'data' => $data);
                $ret->stat = 1;
                $ret->result = $data;
            }
            echo json_encode($ret);
        } else{
            $params = array('magang_stat' => 0) ;
            $data['magang'] = $this->Magang_model->get_all_magang($params);
            $data['_title'] = 'Program';
            $data['_menu'] = 'programmagang';
            $data['_submenu'] = 'sertifikat';
            $data['_script'] = 'sertifikat/index_js';
            $data['_view'] = 'sertifikat/index';
            $this->load->view('layout/index', $data);
        }
    }

}
