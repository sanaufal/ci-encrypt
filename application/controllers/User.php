<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    function index() {
        $data['_role'] = $this->User_model->selectRoles();
        $data['_title'] = 'Users';
        $data['_menu'] = 'user';
        $data['_script'] = 'user/script';
        $data['_view'] = 'user/index';
        $this->load->view('layout/index', $data);
    }

    function manage() {
        $session = $this->session->userdata('userdata');
        $result = new \stdClass();
        $result->stat = 0;
        $result->mesg = '';
        $action = $this->input->post('action');
        if ($action == 'load_users') {
            $columns = array(
                '0' => 'user_full_name',
                '1' => 'user_name',
                '2' => 'user_email',
                '3' => 'role_name',
                '4' => 'user_date',
                '5' => 'user_stat',
                '6' => 'user_id',
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

            $users = $this->User_model->load($search, $limit, $start, $order, $dir);
            $datas = array();
            foreach ($users as $u) {
                $u['user_date'] = date("d-m-Y H:i:s", strtotime($u['user_date']));
                $datas[] = $u;
            }
            $result->data = $datas;
            $totaldata = $this->User_model->UsersCount($search);
            $result->recordsTotal = $totaldata;
            $result->recordsFiltered = $totaldata;
            $result->stat = 1;
            $result->mesg = "Loaded";
        }
        if ($action == 'get_state_and_country') {
            $city_id = $this->input->post('city_id');
            $r = $this->User_model->get_state_and_country($city_id);

            $results = array(
                'city_id' => $r['city_id'],
                'city_name' => $r['city_name'],
                'state_id' => $r['city_state'],
                'state_name' => $r['state_name'],
                'country_id' => $r['state_country'],
                'country_name' => $r['country_name']
            );
            $result->status = 1;
            $result->result = $results;
            $result->message = 'Loaded';
        }
        if ($action == 'activate_user') {
            $id = $this->input->post('id');
            $params = array('user_stat' => $this->input->post('stat'));
            $stat = $this->User_model->status($id, $params);
            if ($stat == true) {
                $result = array('status' => 1);
            } else {
                $result = array('status' => 0);
            }
        }
        if ($action == 'deactivate_user') {
            $id = $this->input->post('id');
            $params = array('user_stat' => $this->input->post('stat'));
            $stat = $this->User_model->status($id, $params);
            if ($stat == true) {
                $result = array('status' => 1);
            } else {
                $result = array('status' => 0);
            }
        }
        if ($action == 'edit_users') {
            $id = $this->input->post('id');
            $data = $this->User_model->edit($id);
            $result = array('status' => 1, 'data' => $data);
        }
        if ($action == 'delete_users') {
            $id = $this->input->post('id');
            $params = array('user_stat' => $this->input->post('stat'));
            $stat = $this->User_model->delete($id, $params);
            if ($stat == true) {
                $result = array('status' => 1);
            } else {
                $result = array('status' => 0);
            }
        }
        if ($action == 'save_user') {
            $params = array(
                'user_name' => $this->input->post('username'),
                'user_full_name' => $this->input->post('fullname'),
                'user_pass' => md5($this->input->post('password')),
                'user_email' => $this->input->post('email'),
                'user_role' => $this->input->post('role'),
                'user_gender' => $this->input->post('gender'),
                'user_addr' => $this->input->post('address'),
                'user_country' => $this->input->post('country'),
                'user_state' => $this->input->post('province'),
                'user_city' => $this->input->post('city'),
                'user_stat' => 1,
//                'created_by' => $session['user_id'],
                'user_date' => date('Ymdhis')
            );
            $id = $this->User_model->save($params);
            if (isset($id)) {
                $path = FCPATH . 'resources/uploads/photo/';
                $config['image_library'] = 'gd2';
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->input->post('photo') != "undefined") {
                    if ($this->upload->do_upload('photo')) {
                        $upload = $this->upload->data();
                        $raw_photo = $upload['raw_name'] . "-" . time() . $upload['file_ext'];
                        $old_name = $upload['full_path'];
                        $new_name = $path . $raw_photo;
                        if (rename($old_name, $new_name)) {
                            //compress
                            $compress['image_library'] = 'gd2';
                            $compress['source_image'] = 'resources/uploads/photo/' . $raw_photo;
                            $compress['create_thumb'] = FALSE;
                            $compress['maintain_ratio'] = TRUE;
                            $compress['width'] = 640;
                            $compress['new_image'] = 'resources/uploads/photo/' . $raw_photo;
                            $this->load->library('image_lib', $compress);
                            $this->image_lib->resize();

                            $data = $this->User_model->get_image($id);
                            if ($data && $data['user_id']) {
                                $params = array(
                                    'user_photo' => $raw_photo
                                );
                                if (!empty($data['user_photo'])) {
                                    if (file_exists($path . $data['user_photo'])) {
                                        unlink($path . $data['user_photo']);
                                    }
                                }
                                $stat = $this->User_model->update($id, $params);
                                if ($stat == true) {
                                    $result = array('status' => 1, 'message' => 'update to database');
                                } else {
                                    $result = array('status' => 0, 'message' => 'Error');
                                }
                            }
                        }
                    } else {
                        
                    }
                } else {
                    $result = array('status' => 1, 'message' => 'insert');
                }
            }
        }
        if ($action == 'update') {
            $id = $this->input->post('id');
            $data1 = array(
                'user_name' => $this->input->post('username'),
                'user_full_name' => $this->input->post('fullname'),
                'user_email' => $this->input->post('email'),
                'user_role' => $this->input->post('role'),
                'user_gender' => $this->input->post('gender'),
                'user_addr' => $this->input->post('address'),
                'user_country' => $this->input->post('country'),
                'user_state' => $this->input->post('province'),
                'user_city' => $this->input->post('city'),
                'user_pass' => md5($this->input->post('password')),
            );
            $data2 = array(
                'user_name' => $this->input->post('username'),
                'user_full_name' => $this->input->post('fullname'),
                'user_email' => $this->input->post('email'),
                'user_role' => $this->input->post('role'),
                'user_gender' => $this->input->post('gender'),
                'user_addr' => $this->input->post('address'),
                'user_country' => $this->input->post('country'),
                'user_state' => $this->input->post('province'),
                'user_city' => $this->input->post('city'),
            );
            $password = $this->input->post('password');
            if ($password == null) {
                $params = $data2;
            } else {
                $params = $data1;
            }
            $data = $this->User_model->update($id, $params);
            if ($data == true) {
                $path = FCPATH . 'resources/uploads/photo/';
                $config['image_library'] = 'gd2';
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->input->post('photo') != "undefined") {
                    if ($this->upload->do_upload('photo')) {
                        $upload = $this->upload->data();
                        $raw_photo = $upload['raw_name'] . "-" . time() . $upload['file_ext'];
                        $old_name = $upload['full_path'];
                        $new_name = $path . $raw_photo;
                        if (rename($old_name, $new_name)) {
                            //compress
                            $compress['image_library'] = 'gd2';
                            $compress['source_image'] = 'resources/uploads/photo/' . $raw_photo;
                            $compress['create_thumb'] = FALSE;
                            $compress['maintain_ratio'] = TRUE;
                            $compress['width'] = 640;
                            $compress['new_image'] = 'resources/uploads/photo/' . $raw_photo;
                            $this->load->library('image_lib', $compress);
                            $this->image_lib->resize();

                            $data = $this->User_model->get_image($id);
                            if ($data && $data['user_id']) {
                                $params = array(
                                    'user_photo' => $raw_photo
                                );
                                if (!empty($data['user_photo'])) {
                                    if (file_exists($path . $data['user_photo'])) {
                                        unlink($path . $data['user_photo']);
                                    }
                                }
                                $stat = $this->User_model->update($id, $params);
                                if ($stat == true) {
                                    $result = array('status' => 1, 'message' => 'update to database');
                                } else {
                                    $result = array('status' => 0, 'message' => 'Error');
                                }
                            }
                        }
                    } else {
                        
                    }
                } else {
                    $result = array('status' => 1, 'message' => 'insert');
                }
            }
        }
        echo json_encode($result);
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
        $drow = $this->User_model->search_city($search, $limit, $start, $id);
        foreach ($drow as $v) {
            $row[] = array(
                'id' => $v->city_id,
                'text' => $v->city_name
            );
        }
        $ret->result = $row;
        $totaldata = $this->User_model->search_city_count($search, $id);
        $ret->counts = $totaldata;
        $ret->stat = 1;
        $ret->mesg = "Loaded";
        echo json_encode($ret);
    }

    function user_role() {
        $action = $this->input->post('action');
        if ($action) {
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';
            if ($action == 'load') {
                $columns = array(
                    '0' => 'role_name',
                    '1' => 'role_user',
                    '2' => 'role_status',
                    '3' => 'role_id',
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

                $datas = $this->User_model->get_all_roles($search, $limit, $start, $order, $dir);
                $ret->data = $datas;
                $totaldata = $this->User_model->get_count_roles($search);
                $ret->recordsTotal = $totaldata;
                $ret->recordsFiltered = $totaldata;
                $ret->stat = 1;
            }
            if ($action == 'activate_role') {
                $id = $this->input->post('id');
                $params = array('role_status' => $this->input->post('stat'));
                $stat = $this->User_model->statRole($id, $params);
                if ($stat == true) {
                    $ret = array('status' => 1);
                } else {
                    $ret = array('status' => 0);
                }
            }
            if ($action == 'deactivate_role') {
                $id = $this->input->post('id');
                $params = array('role_status' => $this->input->post('stat'));
                $stat = $this->User_model->statRole($id, $params);
                if ($stat == true) {
                    $ret = array('status' => 1);
                } else {
                    $ret = array('status' => 0);
                }
            }
            if ($action == 'edit_role') {
                $id = $this->input->post('id');
                $data = $this->User_model->editRoles($id);
                $ret = array('status' => 1, 'data' => $data);
            }
            if ($action == 'delete_role') {
                $id = $this->input->post('id');
                $params = array('role_status' => $this->input->post('stat'));
                $stat = $this->User_model->deleteRole($id, $params);
                if ($stat == true) {
                    $ret = array('status' => 1);
                } else {
                    $ret = array('status' => 0);
                }
            }
            if ($action == 'save_role') {
                $params = array(
                    'role_name' => $this->input->post('rolename'),
                    'role_status' => $this->input->post('rolestatus'),
                    'role_user' => $this->input->post('roleuser'),
                );
                $stat = $this->User_model->saveRole($params);
                if ($stat == true) {
                    $ret = array('status' => 1);
                } else {
                    $ret = array('status' => 0);
                }
            }
            if ($action == 'update_role') {
                $id = $this->input->post('id');
                $params = array(
                    'role_name' => $this->input->post('rolename'),
                    'role_status' => $this->input->post('rolestatus'),
                    'role_user' => $this->input->post('roleuser'),
                );
                $stat = $this->User_model->updateRole($id, $params);
                if ($stat == true) {
                    $ret = array('status' => 1);
                } else {
                    $ret = array('status' => 0);
                }
            }
            echo json_encode($ret);
        } else {
            $data['_title'] = 'Roles';
            $data['_menu'] = 'user role';
            $data['_script'] = 'user/role-script';
            $data['_view'] = 'user/role';
            $this->load->view('layout/index', $data);
        }
    }

}
