<?php
defined('BASEPATH') or exit('No direct script access allowed');


require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class UserController extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('facebook/UserModel');
        $this->load->helper('url');
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
            'first_name'=>$this->input->post('first_name'),
            'last_name'=>$this->input->post('last_name'),
            'dob'=>$this->input->post('dob'),
            'gender'=>$this->input->post('gender'),
            'mobile_or_email'=>$this->input->post('mobile_or_email'),
            'password'=>$this->input->post('password'),
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

    public function login_post(){

        $this->load->model('UserModel');

        $email = $this->input->get_post('email');
        $password = $this->input->get_post('password');

        if (!$email || !$password) {
            $this->response([
                'status' => false,
                'message' => 'Input invalid'
            ], REST_Controller::HTTP_OK);
            return;
        }

        $result = $this->UserModel->check_credentials($email, $password);

        if ($result) {
            $this->response([
                'status' => true,
                'message' => 'Login success',
                'user' => [
                    'id' => $result->id,
                    'email' => $result->email,
                    'name' => $result->name
                ]
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Login failed. Invalid credentials.'
            ], REST_Controller::HTTP_OK);
        }
    }
                        
}

