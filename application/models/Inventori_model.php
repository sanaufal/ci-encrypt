<?php

class Inventori_model extends CI_Model{
    function get_all_inventori($params = null, $search = null, $limit = null, $start = null, $order = null, $dir = null)
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
            $this->db->order_by('inventori_karyawan', "desc");
        }

        if ($limit)
        {
            $this->db->limit($limit, $start);
        }
        return $this->db->get('inventorys')->result_array();
    }

    function get_count_inventori($params = null, $search = null)
    {
        $this->set_params($params);
        $this->set_search($search);
        $this->set_join();
        return $this->db->from('inventorys')->count_all_results();
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
        $this->db->join('brands', 'brand_id=inventori_nama_merk', 'left');
        $this->db->join('categories', 'categories_id=inventori_nama_barang', 'left');
        $this->db->join('karyawan', 'karyawan_id=inventori_karyawan', 'left');
    }
    
    function add_inventori($params){
        $this->db->insert('inventorys',$params);
        return $this->db->insert_id();
    }
    
    function update_inventori($id, $params){
        $this->db->where('inventori_id',$id);
        return $this->db->update('inventorys',$params);
    }
    
    function get_inventori($id){
        $this->db->select('inventori_id, inventori_code, inventori_karyawan, inventori_nama_barang, inventori_nama_merk, inventori_keterangan, inventori_jumlah, inventori_stat, categories_nama_barang, brand_nama_merk, karyawan_name');
        $this->db->where('inventori_id', $id);
        $this->set_join();
        return $this->db->get('inventorys')->row_array();
    }
    
    function delete_inventori($id, $params){
        $this->db->where('inventori_id', $id);
        return $this->db->update('inventorys', $params);
    }
}