<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Division_model');
        $this->load->model('User_model');
        $this->load->model('Client_model');
        $this->load->model('Karyawan_model');
    }

    function index() {
        $session = $this->session->userdata('userdata');
        $action = $this->input->post('action');
        if ($action) {
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';
            if ($action == 'get_state_and_country') {
                $city_id = $this->input->post('city_id');
                $r = $this->Client_model->get_state_and_country($city_id);
                $results = array(
                    'city_id' => $r['city_id'],
                    'city_name' => $r['city_name'],
                    'state_id' => $r['city_state'],
                    'state_name' => $r['state_name'],
                    'country_id' => $r['state_country'],
                    'country_name' => $r['country_name']
                );
                $ret->status = 1;
                $ret->result = $results;
                $ret->mesg = 'Loaded';
            }
            if ($action == 'save') {
                $autonumber = $this->autonumber('KRYWN');
                $params = array(
                    'karyawan_nik' => $this->input->post('nik'),
                    'karyawan_code' => $autonumber,
                    'karyawan_name' => $this->input->post('name'),
                    'karyawan_division' => $this->input->post('divisi'),
                    'karyawan_phone' => $this->input->post('phone'),
                    'karyawan_role' => $this->input->post('role'),
                    'karyawan_address' => $this->input->post('address'),
                    'karyawan_city' => $this->input->post('city'),
                    'karyawan_state' => $this->input->post('state'),
                    'karyawan_country' => $this->input->post('country'),
                    'karyawan_stat' => 1,
                );
                $data = $this->Karyawan_model->save($params);
                if ($data == true) {
                    $ret = array('stat' => 1, 'data' => $data, 'mesg' => 'Berhasil Menambahkan Data Karyawan');
                } else {
                    $ret = array('stat' => 0, 'data' => $data, 'mesg' => 'Gagal Menambahkan Data Karyawan');
                }
            }
            if ($action == 'update') {
                $id = $this->input->post('id');
                $params = array(
                    'karyawan_nik' => $this->input->post('nik'),
                    'karyawan_name' => $this->input->post('name'),
                    'karyawan_division' => $this->input->post('divisi'),
                    'karyawan_phone' => $this->input->post('phone'),
                    'karyawan_role' => $this->input->post('role'),
                    'karyawan_address' => $this->input->post('address'),
                    'karyawan_city' => $this->input->post('city'),
                    'karyawan_state' => $this->input->post('state'),
                    'karyawan_country' => $this->input->post('country'),
                );
                $data = $this->Karyawan_model->update($id, $params);
                if ($data == true) {
                    $ret = array('stat' => 1, 'data' => $data, 'mesg' => 'Berhasil Memperbarui Data Karyawan');
                } else {
                    $ret = array('stat' => 0, 'data' => $data, 'mesg' => 'Gagal Memperbarui Data Karyawan');
                }
            }
            if ($action == 'load') {
                $columns = array(
                    '0' => 'karyawan_code',
                    '1' => 'karyawan_name',
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

                $params = array(
                    'karyawan_stat<' => 4
                );
                $datas = $this->Karyawan_model->get_all_karyawans($params, $search, $limit, $start, $order, $dir);
                $ret->data = $datas;
                $totaldata = $this->Karyawan_model->get_count_karyawans($params, $search);
                $ret->recordsTotal = $totaldata;
                $ret->recordsFiltered = $totaldata;
                $ret->stat = 1;
            }
            if ($action == 'edit') {
                $id = $this->input->post('id');
                $data = $this->Karyawan_model->get_karyawan($id);
                $ret = array('stat' => 1, 'data' => $data);
            }
            if ($action == 'delete') {
                $id = $this->input->post('id');
                $params = array('karyawan_stat' => $this->input->post('stat'));
                $data = $this->Karyawan_model->update($id, $params);
                if ($data == true) {
                    $ret = array('stat' => 1, 'mesg' => 'Berhasil Menghapus data!');
                } else {
                    $ret = array('stat' => 0, 'mesg' => 'Gagal Menghapus data!');
                }
            }
            echo json_encode($ret);
        } else {
            $data['role'] = $this->User_model->getRoles();
            $data['divisi'] = $this->Division_model->getDivisi();
            $data['_title'] = 'Karyawan';
            $data['_menu'] = 'karyawan';
            $data['_view'] = 'karyawan/index';
            $data['_script'] = 'karyawan/script';
            $this->load->view('layout/index', $data);
        }
    }

    function getCity() {
        $ret = new \stdClass();
        $ret->stat = 0;
        $ret->mesg = 'INVALID';
        $search = array();
        if ($this->input->post('keyword')) {
            $search['city_name'] = $this->input->post('keyword');
        }
        $limit = $this->input->post('pageSize');
        $start = $this->input->post('page');
        $id = $this->input->post('id');
        $drow = $this->Client_model->search_city($search, $limit, $start, $id);
        foreach ($drow as $v) {
            $row[] = array(
                'id' => $v->city_id,
                'text' => $v->city_name
            );
        }
        $ret->result = $row;
        $totaldata = $this->Client_model->search_city_count($search, $id);
        $ret->counts = $totaldata;
        $ret->stat = 1;
        $ret->mesg = "Loaded";
        echo json_encode($ret);
    }

    function autonumber($inisial) {
        $tipe = '1';
        $last_number = $this->Karyawan_model->code($tipe);
        $auto_number = $inisial . '-' . $last_number;
        return $auto_number;
    }

}
