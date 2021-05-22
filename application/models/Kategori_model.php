<?php

class Kategori_model extends CI_Model{
    function get_all_kategori($params = null, $search = null, $limit = null, $start = null, $order = null, $dir = null)
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
            $this->db->order_by('categories_nama_barang', "desc");
        }

        if ($limit)
        {
            $this->db->limit($limit, $start);
        }
        return $this->db->get('categories')->result_array();
    }

    function get_count_kategori($params = null, $search = null)
    {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();
        return $this->db->from('categories')->count_all_results();
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
    
    function add_kategori($params){
        $this->db->insert('categories',$params);
        return $this->db->insert_id();
    }
    
    function update_kategori($id, $params){
        $this->db->where('categories_id',$id);
        return $this->db->update('categories',$params);
    }
    
    function get_kategori($id){
        $this->db->select('categories_id, categories_code, categories_nama_barang, categories_stat');
        $this->db->where('categories_id', $id);
        $this->set_join();
        return $this->db->get('categories')->row_array();
    }
    
    function delete_kategori($id, $params){
        $this->db->where('categories_id', $id);
        return $this->db->update('categories', $params);
    }
}