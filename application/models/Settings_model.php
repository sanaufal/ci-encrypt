<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function check_data_menu($params) {
        $this->db->where($params);
        $query = $this->db->get('menus')->num_rows();
        if ($query > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getAllMenu() {
        $this->db->where('menu_parent_id', 0);
        $this->db->where('menu_stat<', 4);
        return $this->db->get('menus')->result();
    }

    function getAllSubMenu($id) {
        $this->db->where('menu_parent_id', $id);
        $this->db->where('menu_stat<', 4);
        return $this->db->get('menus')->result_array();
    }

    function get_menus_parent() {
        $this->db->select('menu_id, menu_name');
        $this->db->where('menu_parent_id', 0);
        return $this->db->get('menus')->result();
    }

    function get_menu($id) {
        $this->db->select('menu_id, menu_parent_id, menu_name, menu_url, menu_icon');
        $this->db->where('menu_id', $id);
        return $this->db->get('menus')->row_array();
    }

    function get_menus_option($id) {
        $this->db->select('menu_id, menu_name, menu_url, menu_icon');
        $this->db->where('menu_parent_id', 0);
        $this->db->where('menu_id', $id);
        return $this->db->get('menus')->row_array();
    }

    function saveMenu($params) {
        $this->db->insert('menus', $params);
        return $this->db->insert_id();
    }

    function updateMenu($id, $params) {
        $this->db->where('menu_id', $id);
        return $this->db->update('menus', $params);
    }

}
