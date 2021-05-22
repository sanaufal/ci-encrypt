<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inventori extends MY_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('Inventori_model');
        $this->load->library('session');
        $this->load->model('Core_model');
        $this->load->model('Karyawan_model');
        $this->load->model('Brand_model');
        $this->load->model('Kategori_model');
        
    }

    function index() {
        $action = $this->input->post('action');
        if ($action){
           $ret = new \stdClass();
           $ret->stat = 0;
           $ret->mesg = '';
           if ($this->input->post('action') == 'load'){
               $columns = array(
                    '0' => 'inventori_karyawan',
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

                $params = array('inventori_stat<' => 4);
                
                $datas = $this->Inventori_model->get_all_inventori($params, $search, $limit, $start, $order, $dir);
                $ret->data = $datas;
                $totaldata = $this->Inventori_model->get_count_inventori($params, $search);
                $ret->recordsTotal = $totaldata;
                $ret->recordsFiltered = $totaldata;
                $ret->stat = 1;
            }
            else if ($this->input->post('action') == 'add') {
                $get_number = $this->Core_model->code(1);
                $data = array(
                    'inventori_code' => $get_number,
                    'inventori_karyawan' => $this->input->post('inventori_karyawan'),
                    'inventori_nama_barang' => $this->input->post('inventori_nama_barang'),
                    'inventori_nama_merk' => $this->input->post('inventori_nama_merk'),
                    'inventori_keterangan' => $this->input->post('inventori_keterangan'),
                    'inventori_jumlah' => $this->input->post('inventori_jumlah'),
                    'inventori_stat' => 1
                );

                $set_data = $this->Inventori_model->add_inventori($data);
                if ($set_data == true) {
                    $ret = array('stat' => 1, 'data' => $data, 'mesg' => 'Berhasil Menambahkan Data');
                } else {
                    $ret = array('stat' => 0, 'data' => $data, 'mesg' => 'Tidak Berhasil Menambahkan Data');
                }
            }
            else if ($this->input->post('action') == 'edit') {
                $id = $this->input->post('id');
                $data = $this->Inventori_model->get_inventori($id);
                $result = array('stat' => 1, 'data' => $data);
                $ret->stat = 1;
                $ret->result = $data;
            }
            else if ($this->input->post('action') == 'update') {
                $id = $this->input->post('kategori_id');
                $data = array(
                    'inventori_karyawan' => $this->input->post('inventori_karyawan'),
                    'inventori_nama_barang' => $this->input->post('inventori_nama_barang'),
                    'inventori_nama_merk' => $this->input->post('inventori_nama_merk'),
                    'inventori_keterangan' => $this->input->post('inventori_keterangan'),
                    'inventori_jumlah' => $this->input->post('inventori_jumlah'),
                );
                $set_data = $this->Inventori_model->update_inventori($id, $data);
                
                if ($set_data == true) {
                    $ret = array('stat' => 1, 'data' => $data, 'mesg' => 'Berhasil Memperbarui Data Siswa Magang');
                } else {
                    $ret = array('stat' => 0, 'data' => $data, 'mesg' => 'Tidak Berhasil Memperbarui Data Siswa Magang');
                }
            }
            else if ($this->input->post('action') == 'delete'){
                $id = $this->input->post('id');
                $params = array('inventori_stat' => $this->input->post('stat'));
                $data = $this->Inventori_model->delete_inventori($id, $params);
                if ($data == true) {
                    $ret = array('stat' => 1, 'mesg' => 'Berhasil Menghapus data!');
                } else {
                    $ret = array('stat' => 0, 'mesg' => 'Gagal Menghapus data!');
                }
            }
            echo json_encode($ret);
        }else{
            $data['categories'] = $this->Kategori_model->get_all_kategori();
            $data['brands'] = $this->Brand_model->get_all_brand();
            $data['karyawan'] = $this->Karyawan_model->get_all_karyawans();
            $data['_title'] = 'Inventori';
            $data['_menu'] = 'asset';
            $data['_submenu'] = 'inventori';
            $data['_script'] = 'inventori/script';
            $data['_view'] = 'inventori/index';
            $this->load->view('layout/index', $data );
        }
        
    }

}
