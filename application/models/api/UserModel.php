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
       $query=$this->db->get('user');
        return $query->result();
    }

    public function insert_user($data){

        return $this->db->insert('user',$data);
    }

    public function editUser($id){

        $this->db->where('id',$id);
        $query=$this->db->get('user');
        return $query->row();
    }

    public function update_user($id,$data){

        return $this->db->where('id', $id)->update('user', $data);
    }

    public function delete_user($id){
        
        return $this->db->where('id', $id)->delete('user');
    }
}
