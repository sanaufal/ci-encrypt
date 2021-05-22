<?php

class Login_model extends CI_Model
{
    function __construct() {
        parent::__construct();
    }

    function login($name, $pass) {
        $this->db->where("user_name", $name);
        $this->db->where('user_pass', $pass);
        $this->db->join('user_roles', 'role_id=user_role', 'left');
        return $this->db->get("users")->row_array();
    }
}
