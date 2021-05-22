<?php

class Brand_model extends CI_Model{
    function get_all_brand($params = null, $search = null, $limit = null, $start = null, $order = null, $dir = null)
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
            $this->db->order_by('brand_nama_merk', "desc");
        }

        if ($limit)
        {
            $this->db->limit($limit, $start);
        }
        return $this->db->get('brands')->result_array();
    }

    function get_count_brand($params = null, $search = null)
    {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();
        return $this->db->from('brands')->count_all_results();
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
       
    }
    
    function add_brand($params){
        $this->db->insert('brands',$params);
        return $this->db->insert_id();
    }
    
    function update_brand($id, $params){
        $this->db->where('bran_id',$id);
        return $this->db->update('brands',$params);
    }
    
    function get_brand($id){
        $this->db->select('brands_id, brand_nama_merk, brand_stat');
        $this->db->where('brand_id', $id);
        $this->set_join();
        return $this->db->get('brands')->row_array();
    }
    
    function delete_brand($id, $params){
        $this->db->where('brand_id', $id);
        return $this->db->update('brands', $params);
    }
}