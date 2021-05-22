<?php
 
class Sertifikat_model extends CI_Model{
    
    function get_sertifikat($field_id) {
        $this->db->where('sertifikat_id',$field_id);
        $this->set_join();
        return $this->db->get_where('sertifikat')->row_array();
    }

    function get_all_sertifikat($params = null, $search = null, $limit = null, $start = null, $order = null, $dir = null) {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();

        if ($order) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('sertifikat_code', "desc");
        }

        if ($limit) {
            $this->db->limit($limit, $start);
        }
        
        return $this->db->get('sertifikat')->result_array();
    }

    function get_count_sertifikat($params = null, $search = null) {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();
        return $this->db->from('sertifikat')->count_all_results();
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
        $this->db->join('magang', 'magang_id=sertifikat_magang_id', 'left');
        $this->db->join('divisions', 'division_id=magang_divisi', 'left');
        $this->db->join('partner', 'partner_id=magang_sekolah', 'left');    
    }
    
    function add_sertifikat($params) {
        $this->db->insert('sertifikat', $params);
        return $this->db->insert_id();
    }

    function delete_sertifikat($id, $params) {
        $this->db->where('sertifikat_id', $id);
        return $this->db->update('sertifikat', $params);
    }

    function update_sertifikat($id, $params) {
        $this->db->where('sertifikat_id', $id);
        return $this->db->update('sertifikat', $params);
    }
    
}


