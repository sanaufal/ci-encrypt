<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Settings_model');
    }

    function menu()
    {
        if ($this->input->post('action')) {
            $ret = new \stdClass();
            $ret->stat = 0;
            $ret->mesg = '';
            if ($this->input->post('action') == 'loadMenu') {
                $raw = $this->Settings_model->getAllMenu();
                $data = [];
                foreach ($raw as $r) {
                    $data[] = array(
                        'submenu' => $this->Settings_model->getAllSubMenu($r->menu_id),
                        'menu_name' => $r->menu_name,
                        'menu_icon' => $r->menu_icon,
                        'menu_url' => $r->menu_url,
                        'menu_id' => $r->menu_id
                    );
                }
                $ret = array('stat' => 1, 'data' => $data, 'mesg' => 'Welcome');
            }
            if ($this->input->post('action') == 'add-menu') {
                $params_check = array(
                    'menu_name' => $this->input->post('name'),
                    'menu_url' => $this->input->post('url'),
                );
                $check = $this->Settings_model->check_data_menu($params_check);
                if ($check == false) {
                    $params = array(
                        'menu_name' => $this->input->post('name'),
                        'menu_url' => $this->input->post('url'),
                        'menu_icon' => $this->input->post('icon'),
                        'menu_parent_id' => 0,
                        'menu_stat' => 1,
                    );
                    $data = $this->Settings_model->saveMenu($params);
                    if ($data > 0) {
                        $data_opt = $this->Settings_model->get_menus_option($data);
                        $ret = array('stat' => 1, 'data' => $data_opt, 'mesg' => 'Berhasil Menyimpan Data');
                    } else {
                        $ret = array('stat' => 0, 'mesg' => 'Gagal Menyimpan Data');
                    }
                } else {
                    $ret = array('stat' => 0, 'mesg' => 'Menu Sudah Ada');
                }
            }
            if ($this->input->post('action') == 'add-sub') {
                $params_check = array(
                    'menu_name' => $this->input->post('name'),
                    'menu_url' => $this->input->post('url'),
                );
                $check = $this->Settings_model->check_data_menu($params_check);
                if ($check == false) {
                    $params = array(
                        'menu_name' => $this->input->post('name'),
                        'menu_parent_id' => $this->input->post('parent_id'),
                        'menu_url' => $this->input->post('url'),
                        'menu_icon' => $this->input->post('icon'),
                        'menu_stat' => 1,
                    );
                    $data = $this->Settings_model->saveMenu($params);
                    if ($data > 0) {
                        $ret = array('stat' => 1, 'mesg' => 'Berhasil Menyimpan Data');
                    } else {
                        $ret = array('stat' => 0, 'mesg' => 'Gagal Menyimpan Data');
                    }
                } else {
                    $ret = array('stat' => 0, 'mesg' => 'Menu Sudah Ada');
                }
            }
            if ($this->input->post('action') == 'update-stat') {
                $id = $this->input->post('id');
                $params = array(
                    'menu_stat' => $this->input->post('stat')
                );
                $data = $this->Settings_model->updateMenu($id, $params);
                $ret->stat = $data == 1 ? 1 : 0;
                $ret->mesg = $ret->stat == 1 ? "Berhasil Update Menu" : "Gagal Update Menu";
            }
            if ($this->input->post('action') == 'update-menu') {
                $id = $this->input->post('id');
                $params = array(
                    'menu_name' => $this->input->post('menu'),
                    'menu_url' => $this->input->post('url'),
                    'menu_icon' => $this->input->post('icon'),
                );
                $data = $this->Settings_model->updateMenu($id, $params);
                $ret->stat = $data == 1 ? 1 : 0;
                $ret->mesg = $ret->stat == 1 ? "Berhasil Update Menu" : "Gagal Update Menu";
            }
            if ($this->input->post('action') == 'update-sub-menu') {
                $id = $this->input->post('id');
                $params = array(
                    'menu_name' => $this->input->post('menu'),
                    'menu_url' => $this->input->post('url'),
                    'menu_icon' => $this->input->post('icon'),
                    'menu_parent_id' => $this->input->post('parent'),
                );
                $data = $this->Settings_model->updateMenu($id, $params);
                $ret->stat = $data == 1 ? 1 : 0;
                $ret->mesg = $ret->stat == 1 ? "Berhasil Update Sub Menu" : "Gagal Update Sub Menu";
            }
            if ($this->input->post('action') == 'get-menu') {
                $id = $this->input->post('id');
                $data = $this->Settings_model->get_menu($id);
                $ret->stat = $data == true ? 1 : 0;
                $ret->data = $ret->stat == 1 ? $data : 0;
                $ret->mesg = $ret->stat == 1 ? "Loaded" : "INVALID";
            }
            echo json_encode($ret);
        } else {
            $data['_option'] = $this->Settings_model->get_menus_parent();
            $data['_title'] = 'Settings';
            $data['_menu'] = 'settings';
            $data['_view'] = 'settings/menu';
            $data['_script'] = 'settings/menu_js';
            $this->load->view('layout/index', $data);
        }
    }

    function profile()
    {
        $data['_title'] = 'Profile';
        $data['_menu'] = 'settings';
        $data['_view'] = 'settings/profile';
        $data['_script'] = 'settings/profile_js';
        $this->load->view('layout/index', $data);
    }
}
