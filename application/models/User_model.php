<?php

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function load($search = null, $limit = null, $start = null, $order = null, $dir = null) {
        $this->db->select('user_id,user_full_name,user_name,user_role,user_date,user_email,user_stat,role_name');
        $this->db->where('user_stat<', 2);
        $this->db->join('user_roles', 'role_user=user_role', 'left');
        $this->set_search($search);

        if ($order) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('user_name', 'asc');
        }

        if ($limit) {
            $this->db->limit($limit, $start);
        }

        return $this->db->get('users')->result_array();
    }

    function set_search($search) {
        if ($search) {
            $n = 0;
            $this->db->group_start();
            foreach ($search as $key => $val) {
                if ($n == 0) {
                    $this->db->like($key, $val);
                } else {
                    $this->db->or_like($key, $val);
                }

                $n++;
            }
            $this->db->group_end();
        }
    }

    function UsersCount($search = null) {
        $this->set_search($search);
        $this->db->where('user_stat<', 2);
        $this->db->join('user_roles', 'role_user=user_role', 'left');
        return $this->db->from('users')->count_all_results();
    }

    function get_image($id) {
        $this->db->select('user_photo, user_id');
        $this->db->where('user_id', $id);
        return $this->db->get('users')->row_array();
    }

    function status($id, $params) {
        $this->db->where('user_id', $id);
        return $this->db->update('users', $params);
    }

    function save($params) {
        $this->db->insert('users', $params);
        return $this->db->insert_id();
    }

    function update($id, $params) {
        $this->db->where('user_id', $id);
        return $this->db->update('users', $params);
    }

    function edit($id) {
        $this->db->select('user_id,user_full_name,user_email,user_name,user_role,user_gender,user_photo,user_phone,user_addr,user_country,user_state,user_city,state_name, city_name, country_name,user_stat');
        $this->db->where('user_id', $id);
        $this->db->join('cities', 'city_id=user_city', 'left');
        $this->db->join('states', 'state_id=user_state', 'left');
        $this->db->join('countries', 'country_id=user_country', 'left');
        return $this->db->get('users')->row_array();
    }

    function delete($id, $params) {
        $this->db->where('user_id', $id);
        return $this->db->update('users', $params);
    }

    function search_city($search = null, $limit = null, $start = null, $id) {
        $this->db->select('city_id,city_name, city_state');
        $this->db->from('cities');
        $this->set_search($search);
        if ($limit) {
            $this->db->limit($limit, $start);
        }
        return $this->db->get()->result();
    }

    function search_city_count($search = null, $id) {
        $this->set_search($search);
        return $this->db->from('cities')->count_all_results();
    }

    function get_state_and_country($city_id) {
        $this->db->select('city_id, city_name, city_state, state_name, state_country, country_name');
        $this->db->where('city_id', $city_id);
        $this->db->join('states', 'city_state=state_id', 'left');
        $this->db->join('countries', 'state_country=country_id', 'left');
        return $this->db->get('cities')->row_array();
    }

    function selectRoles() {
        $this->db->select('role_user,role_name');
        $this->db->where('role_status<=', 1);
        return $this->db->get('user_roles')->result();
    }

//    User Roles Model
    function get_all_roles($search = null, $limit = null, $start = null, $order = null, $dir = null) {
        $this->db->select('role_id,role_name,role_status,role_user');
        $this->set_search($search);

        if ($order) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('role_name', "asc");
        }

        if ($limit) {
            $this->db->limit($limit, $start);
        }

        return $this->db->get('user_roles')->result_array();
    }

    function get_count_roles($search = null) {
        $this->set_search($search);
        return $this->db->from('user_roles')->count_all_results();
    }

    function editRoles($id) {
        $this->db->select('role_id,role_name,role_user,role_status');
        $this->db->where('role_id', $id);
        return $this->db->get('user_roles')->row_array();
    }

    function getRoles() {
        $this->db->select('role_id, role_name');
        $this->db->where('role_status', 1);
        return $this->db->get('user_roles')->result_array();
    }

    function statRole($id, $params) {
        $this->db->where('role_id', $id);
        return $this->db->update('user_roles', $params);
    }

    function saveRole($params) {
        $this->db->insert('user_roles', $params);
        return $this->db->insert_id();
    }

    function updateRole($id, $params) {
        $this->db->where('role_id', $id);
        return $this->db->update('user_roles', $params);
    }

    function deleteRole($id, $params) {
        $this->db->where('role_id', $id);
        return $this->db->update('user_roles', $params);
    }

//    Menu Profile
    function getPass($id) {
        $this->db->select('user_pass');
        $this->db->where('user_id', $id);
        return $this->db->get('users')->row_array();
    }

}
