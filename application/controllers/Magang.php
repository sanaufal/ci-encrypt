<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Magang extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('Magang_model');
        $this->load->library('session');
        $this->load->model('Division_model');
        $this->load->model('Partner_model');
    }

    function index() {
        $action = $this->input->post('action');
        if ($action) {
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';
            if ($this->input->post('action') == 'load') {
                $columns = array(
                    '0' => 'magang_nim',
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

                $params = array('magang_stat<' => 4);

                $datas = $this->Magang_model->get_all_magang($params, $search, $limit, $start, $order, $dir);
                $ret->data = $datas;
                $totaldata = $this->Magang_model->get_count_magang($params, $search);
                $ret->recordsTotal = $totaldata;
                $ret->recordsFiltered = $totaldata;
                $ret->stat = 1;
            }
            if ($this->input->post('action') == 'add') {
                $data = array(
                    'magang_user' => $this->input->post('magang_user'),
                    'magang_nim' => $this->input->post('magang_nim'),
                    'magang_phone' => $this->input->post('magang_phone'),
                    'magang_address' => $this->input->post('magang_address'),
                    'magang_divisi' => $this->input->post('magang_divisi'),
                    'magang_sekolah' => $this->input->post('magang_sekolah'),
                    'magang_tglm' => date('Y-m-d', strtotime($this->input->post('magang_tglm'))),
                    'magang_tglk' => date('Y-m-d', strtotime($this->input->post('magang_tglk'))),
                    'magang_stat' => 1
                );

                $set_data = $this->Magang_model->add_magang($data);
                if ($set_data == true) {
                    $ret = array('stat' => 1, 'data' => $data, 'mesg' => 'Berhasil Menambahkan Data');
                } else {
                    $ret = array('stat' => 0, 'data' => $data, 'mesg' => 'Tidak Berhasil Menambahkan Data');
                }
            }
            if ($this->input->post('action') == 'edit') {
                $id = $this->input->post('id');
                $data = $this->Magang_model->get_magang($id);
                $result = array('stat' => 1, 'data' => $data);
                $ret->stat = 1;
                $ret->result = $data;
            }
            if ($this->input->post('action') == 'update') {
                $id = $this->input->post('magang_id');
                $data = array(
                    'magang_user' => $this->input->post('magang_user'),
                    'magang_nim' => $this->input->post('magang_nim'),
                    'magang_phone' => $this->input->post('magang_phone'),
                    'magang_address' => $this->input->post('magang_address'),
                    'magang_divisi' => $this->input->post('magang_divisi'),
                    'magang_sekolah' => $this->input->post('magang_sekolah'),
                    'magang_tglm' => $this->input->post('magang_tglm'),
                    'magang_tglk' => $this->input->post('magang_tglk'),
                );
                $set_data = $this->Magang_model->update_magang($id, $data);
                
                if ($set_data == true) {
                    $ret = array('stat' => 1, 'data' => $data, 'mesg' => 'Berhasil Memperbarui Data Siswa Magang');
                } else {
                    $ret = array('stat' => 0, 'data' => $data, 'mesg' => 'Tidak Berhasil Memperbarui Data Siswa Magang');
                }
            }
            if ($this->input->post('action')=='aktif') {
                $id = $this->input->post('id');
                $data = array (
                    'magang_stat' => 1
                );
                $set_data = $this->Magang_model->update_magang($id, $data);
                if($set_data==true) {
                    $ret->stat=1;
                    $ret->message='berhasil diaktifkan';
                } else {
                    $ret->message='gagal diaktifkan';
                }
            } 
            if ($this->input->post('action')=='nonaktif') {
                $id = $this->input->post('id');
                $data = array (
                    'magang_stat' => 0
                );
                $set_data = $this->Magang_model->update_magang($id, $data);
                if($set_data==true) {
                    $ret->stat=1;
                    $ret->message='berhasil dinonaktifkan';
                } else {
                    $ret->message='gagal dinonaktifkan';
                }
            }
            echo json_encode($ret);
        } else {
            $data['divisions'] = $this->Division_model->getDivisi();
            $data['magang'] = $this->Magang_model->get_all_magang();
            $data['partner'] = $this->Partner_model->get_all_partner();
            $data['date_now'] = date('d-m-Y');
            $data['_title'] = 'Program';
            $data['_menu'] = 'programmagang';
            $data['_submenu'] = 'magang';
            $data['_script'] = 'magang/index_js';
            $data['_view'] = 'magang/index';
            $this->load->view('layout/index', $data);
        }
    }

}
