<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Division_model extends CI_Model {

    function get_all_divisions($params = null, $search = null, $limit = null, $start = null, $order = null, $dir = null) {
        $this->db->select('division_name, division_id, division_stat');
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();

        if ($order) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('division_name', "asc");
        }

        if ($limit) {
            $this->db->limit($limit, $start);
        }

        return $this->db->get('divisions')->result_array();
    }

    function get_count_divisions($params = null, $search = null) {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();
        return $this->db->from('divisions')->count_all_results();
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
        
    }

    function edit_divisions($id) {
        $this->db->select('division_id, division_name, division_detail, division_stat');
        $this->db->where('division_id', $id);
        return $this->db->get('divisions')->row_array();
    }

    function getDivisi(){
        $this->db->select('division_id , division_name');
        $this->db->where('division_stat', 1);
        return $this->db->get('divisions')->result_array();
    }
    function save_divisions($params) {
        return $this->db->insert('divisions', $params);
    }

    function update_divisions($id, $params) {
        $this->db->where('division_id', $id);
        return $this->db->update('divisions', $params);
    }

    function delete_divisions($id, $params) {
        $this->db->where('division_id', $id);
        return $this->db->update('divisions', $params);
    }
}
