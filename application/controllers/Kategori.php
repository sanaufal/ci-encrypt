<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends MY_Controller {

    function __construct() {
        parent::__construct();
        
        $this->load->model('Kategori_model');
    }

    function index() {
        $action = $this->input->post('action');
        if ($action){
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';
            if ($this->input->post('action') == 'load') {
                $columns = array(
                    '0' => 'categories_nama_barang',
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

                $params = array('categories_stat<' => 4);

                $datas = $this->Kategori_model->get_all_kategori($params, $search, $limit, $start, $order, $dir);
                $ret->data = $datas;
                $totaldata = $this->Kategori_model->get_count_kategori($params, $search);
                $ret->recordsTotal = $totaldata;
                $ret->recordsFiltered = $totaldata;
                $ret->stat = 1;
            }
            else if ($this->input->post('action') == 'add') {
                $data = array(
                    'categories_nama_barang' => $this->input->post('categories_nama_barang'),
                    'categories_stat' => 1
                );

                $set_data = $this->Kategori_model->add_kategori($data);
                if ($set_data == true) {
                    $ret = array('stat' => 1, 'data' => $data, 'mesg' => 'Berhasil Menambahkan Data');
                } else {
                    $ret = array('stat' => 0, 'data' => $data, 'mesg' => 'Tidak Berhasil Menambahkan Data');
                }
            }
            else if ($this->input->post('action') == 'edit') {
                $id = $this->input->post('id');
                $data = $this->Kategori_model->get_kategori($id);
                $result = array('stat' => 1, 'data' => $data);
                $ret->stat = 1;
                $ret->result = $data;
            }
            else if ($this->input->post('action') == 'update') {
                $id = $this->input->post('categories_id');
                $data = array(
                    'categories_nama_barang' => $this->input->post('categories_nama_barang'),
                );
                $set_data = $this->Kategori_model->update_kategori($id, $data);
                
                if ($set_data == true) {
                    $ret = array('stat' => 1, 'data' => $data, 'mesg' => 'Berhasil Memperbarui Data Siswa Magang');
                } else {
                    $ret = array('stat' => 0, 'data' => $data, 'mesg' => 'Tidak Berhasil Memperbarui Data Siswa Magang');
                }
            }
            else if ($this->input->post('action') == 'delete'){
                $id = $this->input->post('id');
                $params = array('categories_stat' => $this->input->post('stat'));
                $data = $this->Kategori_model->delete_kategori($id, $params);
                if ($data == true) {
                    $ret = array('stat' => 1, 'mesg' => 'Berhasil Menghapus data!');
                } else {
                    $ret = array('stat' => 0, 'mesg' => 'Gagal Menghapus data!');
                }
            }
            echo json_encode($ret);
        } 
        else{
            $data['_title'] = 'Kategori';
            $data['_menu'] = 'asset';
            $data['_submenu'] = 'kategori';
            $data['_script'] = 'kategori/script';
            $data['_view'] = 'kategori/index';
            $this->load->view('layout/index', $data);
        }
       
    }

}
