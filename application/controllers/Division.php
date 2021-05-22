<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Division extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Division_model');
    }

    function index() {
        $action = $this->input->post('action');
        if ($action) {
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';
            if ($action == 'load') {
                $columns = array(
                    '0' => 'division_name',
                    '1' => 'division_id',
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
                    'division_stat<' => 4
                );
                $datas = $this->Division_model->get_all_divisions($params, $search, $limit, $start, $order, $dir);
                $ret->data = $datas;
                $totaldata = $this->Division_model->get_count_divisions($params, $search);
                $ret->recordsTotal = $totaldata;
                $ret->recordsFiltered = $totaldata;
                $ret->stat = 1;
            }
            if ($action == 'edit') {
                $id = $this->input->post('id');
                $data = $this->Division_model->edit_divisions($id);
                $ret = array('stat' => 1, 'data' => $data);
            }
            if ($action == 'update') {
                $id = $this->input->post('id');
                $params = array(
                    'division_name' => $this->input->post('name'),
                    'division_detail' => $this->input->post('desc'),
                    'division_stat' => $this->input->post('status'),
                );
                $data = $this->Division_model->update_divisions($id, $params);
                $ret = array('stat' => 1, 'data' => $data);
            }
            if ($action == 'save') {
                $params = array(
                    'division_name' => $this->input->post('name'),
                    'division_detail' => $this->input->post('desc'),
                    'division_stat' => $this->input->post('status'),
                );
                $data = $this->Division_model->save_divisions($params);
                $ret = array('stat' => 1, 'data' => $data);
            }
            if ($action == 'delete') {
                $id = $this->input->post('id');
                $params = array('division_stat' => $this->input->post('stat'));
                $stat = $this->Division_model->delete_divisions($id, $params); 
                if ($stat == true) {
                    $ret = array('stat' => 1);
                } else {
                    $ret = array('stat' => 0);
                }
            }
            echo json_encode($ret);
        } else {
            $data['_title'] = 'Division';
            $data['_menu'] = 'division';
            $data['_script'] = 'division/script';
            $data['_view'] = 'division/index';
            $this->load->view('layout/index', $data);
        }
    }

}
