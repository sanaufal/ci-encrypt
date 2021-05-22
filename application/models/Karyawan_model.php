<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_karyawan($id) {
        $this->db->select('karyawan_id,karyawan_code,karyawan_name,karyawan_nik,karyawan_phone,karyawan_division,karyawan_role,karyawan_address,karyawan_city,karyawan_state,karyawan_country,city_name,state_name,country_name');
        $this->db->where('karyawan_id', $id);
        $this->db->join('cities', 'city_id=karyawan_city', 'left');
        $this->db->join('states', 'state_id=karyawan_state', 'left');
        $this->db->join('countries', 'country_id=karyawan_country', 'left');
        return $this->db->get_where('karyawan')->row_array();
    }

    function get_all_karyawans($params = null, $search = null, $limit = null, $start = null, $order = null, $dir = null) {
        $this->db->select('karyawan_id,karyawan_code,karyawan_name,karyawan_division,division_name,role_name');
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();

        if ($order) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('karyawan_name', "asc");
        }

        if ($limit) {
            $this->db->limit($limit, $start);
        }

        return $this->db->get('karyawan')->result_array();
    }

    function get_count_karyawans($params = null, $search = null) {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();
        return $this->db->from('karyawan')->count_all_results();
    }

    function set_params($params) {
        if ($params) {
            foreach ($params as $k => $v) {
                $this->db->where($k, $v);
            }
        }
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

    function set_join() {
        $this->db->join('divisions', 'division_id=karyawan_division', 'left');
        $this->db->join('user_roles', 'role_id=karyawan_role', 'left');
    }

    function code($tipe) {
        $q = $this->db->query("SELECT MAX(RIGHT(karyawan_code, 4)) AS last_number FROM karyawan");
        $kd = '';
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->last_number) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }

        return $kd;
    }

    function save($params) {
        return $this->db->insert('karyawan', $params);
    }

    function update($id, $params) {
        $this->db->where('karyawan_id', $id);
        return $this->db->update('karyawan', $params);
    }

}
