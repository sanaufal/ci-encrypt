<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Supplier_model');
        $this->load->model('Generator_model');
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
                $r = $this->Supplier_model->get_state_and_country($city_id);

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
            if ($action == 'load') {
                $columns = array(
                    '0' => 'contact_code',
                    '1' => 'contact_name',
                    '2' => 'contact_pic_name',
                    '3' => 'contact_id'
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
                $datas = $this->Supplier_model->get_all_suppliers($params, $search, $limit, $start, $order, $dir);
                $ret->data = $datas;
                $totaldata = $this->Supplier_model->get_count_suppliers($params, $search);
                $ret->recordsTotal = $totaldata;
                $ret->recordsFiltered = $totaldata;
                $ret->stat = 1;
            }
            if ($action == 'save') {
                $autonumber = $this->autonumber('SP');
                $params = array(
                    'contact_npwp' => $this->input->post('npwp'),
                    'contact_code' => $autonumber,
                    'contact_name' => $this->input->post('name'),
                    'contact_phone_1' => $this->input->post('phone1'),
                    'contact_phone_2' => $this->input->post('phone2'),
                    'contact_pic_name' => $this->input->post('pic_name'),
                    'contact_pic_phone' => $this->input->post('phone_pic'),
                    'contact_addr' => $this->input->post('address'),
                    'contact_city' => $this->input->post('city'),
                    'contact_state' => $this->input->post('state'),
                    'contact_country' => $this->input->post('country'),
                    'contact_type' => 1,
                    'contact_by' => $session['user_id'],
                    'contact_stat' => 1
                );
                $data = $this->Supplier_model->save($params);
                $ret = array('stat' => 1, 'data' => $data);
            }
            if ($action == 'edit') {
                $id = $this->input->post('id');
                $data = $this->Supplier_model->edit($id);
                $ret = array('stat' => 1, 'data' => $data);
            }
            if ($action == 'update') {
                $id = $this->input->post('id');
                $params = array(
                    'contact_npwp' => $this->input->post('npwp'),
                    'contact_name' => $this->input->post('name'),
                    'contact_phone_1' => $this->input->post('phone1'),
                    'contact_phone_2' => $this->input->post('phone2'),
                    'contact_pic_name' => $this->input->post('pic_name'),
                    'contact_pic_phone' => $this->input->post('phone_pic'),
                    'contact_addr' => $this->input->post('address'),
                    'contact_city' => $this->input->post('city'),
                    'contact_state' => $this->input->post('state'),
                    'contact_country' => $this->input->post('country'),
                );
                $data = $this->Supplier_model->update($id, $params);
                $ret = array('stat' => 1, 'data' => $data);
            }
            if ($action == 'delete') {
                $id = $this->input->post('id');
                $params = array('contact_stat' => $this->input->post('stat'));
                $stat = $this->Supplier_model->delete($id, $params);
                if ($stat == true) {
                    $ret = array('stat' => 1);
                } else {
                    $ret = array('stat' => 0);
                }
            }
            echo json_encode($ret);
        } else {
            $data['_title'] = 'Supplier';
            $data['_menu'] = 'supplier';
            $data['_view'] = 'supplier/index';
            $data['_script'] = 'supplier/script';
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
        $drow = $this->Supplier_model->search_city($search, $limit, $start, $id);
        foreach ($drow as $v) {
            $row[] = array(
                'id' => $v->city_id,
                'text' => $v->city_name
            );
        }
        $ret->result = $row;
        $totaldata = $this->Supplier_model->search_city_count($search, $id);
        $ret->counts = $totaldata;
        $ret->stat = 1;
        $ret->mesg = "Loaded";
        echo json_encode($ret);
    }

    function autonumber($inisial) {
        $tipe = '1';
        $last_number = $this->Generator_model->request_number($tipe);
        $auto_number = $inisial . '-' . $last_number;
        return $auto_number;
    }

}
