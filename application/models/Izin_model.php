<?php

class Izin_model extends CI_Model {

    function get_all_izins($params = null, $search = null, $limit = null, $start = null, $order = null, $dir = null) {
        $this->db->select('izin_id,us.user_full_name as izin_user, us1.user_full_name as izin_by, izin_code, izin_date, izin_type, izin_date_start, izin_date_end, izin_stat');
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();

        if ($order) {
            $this->db->order_by($order, $dir);
        } else {
            $this->db->order_by('izin_user', "desc");
        }

        if ($limit) {
            $this->db->limit($limit, $start);
        }
        return $this->db->get('izins')->result_array();
    }

    function get_count_izins($params = null, $search = null) {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();
        return $this->db->from('izins')->count_all_results();
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
        $this->db->join('users as us', 'us.user_id=izin_user', 'left');
        $this->db->join('users as us1', 'us1.user_id=izin_by', 'left');
        $this->db->join('divisions as d', 'd.division_id=us.user_role', 'left');
    }

    function add_izins($params) {
        $this->db->insert('izins', $params);
        return $this->db->insert_id();
    }

    function update_izins($id, $params) {
        $this->db->where('izin_id', $id);
        return $this->db->update('izins', $params);
    }

    function get_izins($id) {
        $this->db->select('izin_id, division_name, izin_date_masuk, us.user_full_name as user, us1.user_full_name as acc, izin_process_note, izin_by, izin_user, izin_code, izin_date, izin_type, izin_date_start, izin_date_end, izin_note, izin_image, izin_stat');
        $this->db->where('izin_id', $id);
        $this->set_join();
        return $this->db->get('izins')->row_array();
    }

    function delete_izins($id, $params) {
        $this->db->where('izin_id', $id);
        return $this->db->update('izins', $params);
    }

    function code($tipe) {
        $q = $this->db->query("SELECT MAX(RIGHT(izin_code, 4)) AS last_number FROM izins");
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

}
