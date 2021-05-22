<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Partner_model extends CI_Model {
    
    function get_all_partner($params = null, $search = null, $limit = null, $start = null, $order = null, $dir = null) {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();

        if ($order) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('partner_sekolah', "asc");
        }

        if ($limit) {
            $this->db->limit($limit, $start);
        }
        
        return $this->db->get('partner')->result_array();
    }

    function get_count_partner($params = null, $search = null) {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();
        return $this->db->from('partner')->count_all_results();
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
    function add_partner($params){
        $this->db->insert('partner', $params);
        return $this->db->insert_id();
    }
    
    function get_partner($id){
        $this->db->select('partner_id, partner_sekolah, partner_address, partner_pic, partner_phone, partner_img');
        $this->db->where('partner_id', $id);
        return $this->db->get('partner')->row_array();
    }
    
    function update_partner($id, $params){
        $this->db->where('partner_id', $id);
        return $this->db->update('partner', $params);
    }
}    