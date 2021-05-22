<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Client_model extends CI_Model {

    function get_all_suppliers($params = null, $search = null, $limit = null, $start = null, $order = null, $dir = null) {
        $this->db->select('*');
        $this->db->where('contact_type', 2);
        $this->db->where('contact_stat<', 4);
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();

        if ($order) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('contact_code', "asc");
        }

        if ($limit) {
            $this->db->limit($limit, $start);
        }

        return $this->db->get('contacts')->result_array();
    }

    function get_count_suppliers($params = null, $search = null) {
        $this->set_params($params);
        $this->db->where('contact_type', 2);
        $this->set_search($search);
        $this->set_join();
        return $this->db->from('contacts')->count_all_results();
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

    function save($params) {
        return $this->db->insert('contacts', $params);
    }

    function edit($id) {
        $this->db->select('contact_id, contact_name, contact_npwp, contact_phone_1,'
                . ' contact_phone_2, contact_pic_name, contact_pic_phone, contact_addr,'
                . ' contact_city, contact_state, contact_country, city_name, state_name, country_name');
        $this->db->where('contact_id', $id);
        $this->db->join('cities', 'city_id=contact_city', 'left');
        $this->db->join('states', 'state_id=contact_state', 'left');
        $this->db->join('countries', 'country_id=contact_country', 'left');
        return $this->db->get('contacts')->row_array();
    }

    function update($id, $params) {
        $this->db->where('contact_id', $id);
        return $this->db->update('contacts', $params);
    }

    function delete($id, $params) {
        $this->db->where('contact_id', $id);
        return $this->db->update('contacts', $params);
    }

}
