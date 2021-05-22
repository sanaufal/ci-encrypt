<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Generator_model extends CI_Model {

    function request_number($tipe) {
        $q = $this->db->query("SELECT MAX(RIGHT(contact_code, 4)) AS last_number FROM contacts WHERE contact_type=$tipe");
        $kd = '';
        if($q->num_rows()>0){
            foreach ($q->result() as $k){
                $tmp = ((int)$k->last_number)+1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        
        return $kd;
    }
    
    function request_izin($tipe) {
        $q = $this->db->query("SELECT MAX(RIGHT(izin_code, 4)) AS last_number FROM izins WHERE izin_type=$tipe");
        $kd = '';
        if($q->num_rows()>0){
            foreach ($q->result() as $k){
                $tmp = ((int)$k->last_number)+1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        
        return $kd;
    }

}
