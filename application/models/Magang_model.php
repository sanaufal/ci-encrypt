<?php

class Magang_model extends CI_Model{
    function get_all_magang($params = null, $search = null, $limit = null, $start = null, $order = null, $dir = null)
    {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();

        if ($order)
        {
            $this->db->order_by($order, $dir);
        }
        else
        {
            $this->db->order_by('magang_user', "desc");
        }

        if ($limit)
        {
            $this->db->limit($limit, $start);
        }
        return $this->db->get('magang')->result_array();
    }

    function get_count_magang($params = null, $search = null)
    {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();
        return $this->db->from('magang')->count_all_results();
    }

    function set_params($params)
    {
        if ($params)
        {
            foreach ($params as $k => $v)
            {
                $this->db->where($k, $v);
            }
        }
    }

    function set_search($search)
    {
        if ($search)
        {
            $n = 0;
            $this->db->group_start();
            foreach ($search as $key => $val)
            {
                if ($n == 0)
                {
                    $this->db->like($key, $val);
                }
                else
                {
                    $this->db->or_like($key, $val);
                }

                $n++;
            }
            $this->db->group_end();
        }
    }

    function set_join()
    {
        $this->db->join('divisions', 'division_id=magang_divisi', 'left');
        $this->db->join('partner', 'partner_id=magang_sekolah', 'left');
    }
    
    function add_magang($params){
        $this->db->insert('magang',$params);
        return $this->db->insert_id();
    }
    
    function update_magang($id, $params){
        $this->db->where('magang_id',$id);
        return $this->db->update('magang',$params);
    }
    
    function get_magang($id){
        $this->db->select('magang_id, magang_nim, magang_user, magang_phone, magang_address, magang_divisi, magang_sekolah, magang_tglm, magang_tglk, magang_stat, partner_sekolah, division_name');
        $this->db->where('magang_id', $id);
        $this->set_join();
        return $this->db->get('magang')->row_array();
    }
    
    
}