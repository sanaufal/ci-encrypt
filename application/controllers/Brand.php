<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Brand extends MY_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('Brand_model');
    }

    function index() {
        $action = $this->input->post('action');
        if ($action){
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';
            if ($this->input->post('action') == 'load') {
                $columns = array(
                    '0' => 'brand_nama_merk',
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

                $params = array('brand_stat<' => 4);

                $datas = $this->Brand_model->get_all_brand($params, $search, $limit, $start, $order, $dir);
                $ret->data = $datas;
                $totaldata = $this->Brand_model->get_count_brand($params, $search);
                $ret->recordsTotal = $totaldata;
                $ret->recordsFiltered = $totaldata;
                $ret->stat = 1;
            }
            else if ($this->input->post('action') == 'add') {
                $data = array(
                    'brand_nama_merk' => $this->input->post('brand_nama_merk'),
                    'brand_stat' => 1
                );

                $set_data = $this->Brand_model->add_brand($data);
                if ($set_data == true) {
                    $ret = array('stat' => 1, 'data' => $data, 'mesg' => 'Berhasil Menambahkan Data');
                } else {
                    $ret = array('stat' => 0, 'data' => $data, 'mesg' => 'Tidak Berhasil Menambahkan Data');
                }
            }
            else if ($this->input->post('action') == 'edit') {
                $id = $this->input->post('id');
                $data = $this->Brand_model->get_brand($id);
                $result = array('stat' => 1, 'data' => $data);
                $ret->stat = 1;
                $ret->result = $data;
            }
            else if ($this->input->post('action') == 'update') {
                $id = $this->input->post('brand_id');
                $data = array(
                    'brand_nama_merk' => $this->input->post('brand_nama_merk'),
                );
                $set_data = $this->Brand_model->update_brand($id, $data);
                
                if ($set_data == true) {
                    $ret = array('stat' => 1, 'data' => $data, 'mesg' => 'Berhasil Memperbarui Data Siswa Magang');
                } else {
                    $ret = array('stat' => 0, 'data' => $data, 'mesg' => 'Tidak Berhasil Memperbarui Data Siswa Magang');
                }
            }
            else if ($this->input->post('action') == 'delete'){
                $id = $this->input->post('id');
                $params = array('brand_stat' => $this->input->post('stat'));
                $data = $this->Brand_model->delete_brand($id, $params);
                if ($data == true) {
                    $ret = array('stat' => 1, 'mesg' => 'Berhasil Menghapus data!');
                } else {
                    $ret = array('stat' => 0, 'mesg' => 'Gagal Menghapus data!');
                }
            }
            echo json_encode($ret);
        } else {
            $data['_title'] = 'Brand';
            $data['_menu'] = 'asset';
            $data['_submenu'] = 'brand';
            $data['_script'] = 'brand/script';
            $data['_view'] = 'brand/index';
            $this->load->view('layout/index', $data ); 
        }
    }

}
