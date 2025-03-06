<?php
defined('BASEPATH') or exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class ApiController extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('api/UserModel');
    }

    public function index_get(){
        $user=new UserModel;
        $result=$user->get_user();
        $this->response($result,200);
    }

    public function createUser_post(){

        $user=new UserModel;

        $json_data = json_decode($this->input->raw_input_stream, true);

        $data=[
            'name'=>$this->input->post('name'),
            'email'=>$this->input->post('email')
        ];

        $result=$user->insert_user($data);

        if( $result>0){
            $this->response([
                'status'=>true,
                'message'=>'User created'
            ],REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status'=>false,
                'message'=>'Failed user created'
            ],REST_Controller::HTTP_OK);
        }
        
    }

    public function findUser_get($id){
        $user=new UserModel;
        $result=$user->editUser($id);
        $this->response($result,200);
    }

    public function updateUser_put($id) {
        
        $user=new UserModel;
        $json_data = json_decode($this->input->raw_input_stream, true);

        $data = [
            'name' => $this->put('name'),
            'email' => $this->put('email')
        ];
    
        $updated_result = $user->update_user($id, $data);
    
        if ($updated_result) {
            $this->response([
                'status' => true,
                'message' => 'User updated.'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Failed to update.'
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    

    public function deleteUser_delete($id){

        $user=new UserModel;
        $result=$user->delete_user($id);
        $this->response($result,200);
    }
}
