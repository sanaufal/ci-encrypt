<?php

class Core_model extends CI_model{
    function __construct() {
        parent::__construct();
        
        
    }
    
    function req_number($type){
        if ($type == 1){
            $init = 'DM';
            $col = "sertifikat_code";
            $tabel = "sertifikat";
        }
        $query = $this->db->query("SELECT MAX(RIGHT($col, 4)) as last_numb FROM $tabel");
        $code = '';
        if ($query->num_rows() > 0){
            foreach($query->result()as $k){
                $temp = ((int)$k->last_numb)+1;
                $code = sprintf("%04s", $temp );
            }
        }else{
            $code = "0001";
        }
        date_default_timezone_set('Asia/Jakarta');
        $date_rilis = date('Y');
//        var_dump($date_rilis);die;
        return $init.'/'.$date_rilis.'/'.$code;
    }
    
    function code($type) {
        if($type == 1){
            $init = 'INV';
            $col = "inventori_code";
            $tabel = "inventorys";
        }
        $q = $this->db->query("SELECT MAX(RIGHT(inventori_code, 4)) AS last_number FROM inventorys");
        $kd = '';
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->last_number) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }

        return $init.'/'.$kd;
    }
}

