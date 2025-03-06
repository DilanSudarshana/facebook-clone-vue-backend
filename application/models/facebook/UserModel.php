<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_user()
    {
       $query=$this->db->get('users');
        return $query->result();
    }

    public function insert_user($data){

        return $this->db->insert('users',$data);
    }

    public function check_credentials($email, $password): mixed
    {
        $this->db->where('mobile_or_email', $email);
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            $user = $query->row();
            
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        return null; 
    }


}
