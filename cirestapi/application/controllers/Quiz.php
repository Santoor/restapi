<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller {

    private $username = "admin";
    private $password = "1234";
    private $apikey = "santoor@123";

    function __construct() {
        parent::__construct();
        $this->load->model('user');
        
    }

    public function index() {
        $this->session->sess_destroy();
        $this->load->view('quiz/index');
    }

    public function useradd() {

        $formData = $this->input->post();
        //print_r($formData);

        $this->form_validation->set_rules('name', 'Name', array('required', 'min_length[3]'));
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('quiz/index');
        } else {
            $url = base_url() . '/api/example/user/';

            $userData = array(
                'name' => $formData['name'],
                'email' => $formData['email']
            );


            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . $this->apikey));
            curl_setopt($ch, CURLOPT_USERPWD, "$this->username:$this->password");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $userData);

            $result = curl_exec($ch);
            curl_close($ch);

            $resultarray = json_decode($result, true);
            //print_r($resultarray);
            if (array_key_exists('data', $resultarray)) {
                $id = $resultarray['data'];

                $userDetail = $this->user->getRows($id);
                //echo "<pre>";
                //print_r($userDetail);

                $this->session->set_userdata('user_id', $id);
                $this->session->set_userdata('user_name', $userDetail['name']);


                redirect('quiz/ques');
            } else {
                redirect('quiz/index');
            }
        }
    }

    public function ques() {
        //echo "<pre>";print_r( $_SESSION);
            $userId=$this->session->userdata('user_id');
            $url = base_url() . '/api/example/userdetails/'.$userId;
            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . $this->apikey));
            curl_setopt($ch, CURLOPT_USERPWD, "$this->username:$this->password");

            $result = curl_exec($ch);
            curl_close($ch);

            $mcqUserData = json_decode($result, true);
            //print_r($mcqUserData);
            
            
            if (array_key_exists('status', $mcqUserData)) {
                // no records found in mcq user table
                $url = base_url() . '/api/example/mcq/';
                $ch = curl_init($url);

                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . $this->apikey));
                curl_setopt($ch, CURLOPT_USERPWD, "$this->username:$this->password");

                $result = curl_exec($ch);
                curl_close($ch);
                
                
                 
             }else{
                 //echo "<pre>";print_r($mcqUserData);
//                $existuqesarray=array(); 
//                foreach($mcqUserData as $key=>$data){
//                    $existuqesarray[$key]=$data['qid'];
//                     
//                }
                //print_r($existuqesarray); die;
                 
                $url = base_url() . '/api/example/mcq/0/'.$userId;
                $ch = curl_init($url);

                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . $this->apikey));
                curl_setopt($ch, CURLOPT_USERPWD, "$this->username:$this->password");

                $result = curl_exec($ch);
                curl_close($ch);
                
                //echo $result;die;
                
            }
            $mcqData = json_decode($result, true);
            if (array_key_exists('id', $mcqData)) {
                $viewdata['ques'] = $mcqData;
                $viewdata['uid']=$this->session->userdata('user_id');
                $viewdata['uname']=$this->session->userdata('user_name');
                $_SESSION['quiz_start'] = time();

                $this->load->view('quiz/ques', $viewdata);
            }else{
                echo $result;
                redirect('quiz/finish');

            }
            
     }
    
    
    public function submit() {
        $_SESSION['quiz_end']=time();
        $time_taken= $_SESSION['quiz_end']-$_SESSION['quiz_start'];
        $formData = $this->input->post();
       // print_r($formData);die;

        //$this->form_validation->set_rules('uid', 'Name', array('required'));
        $this->form_validation->set_rules('answer', 'Answer', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('quiz/index');
        } else {
            
            $url = base_url() . '/api/example/mcq/'.$formData['ques'];
            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . $this->apikey));
            curl_setopt($ch, CURLOPT_USERPWD, "$this->username:$this->password");

            $result = curl_exec($ch);
            curl_close($ch);

            $mcqData = json_decode($result, true);
            //print_r($mcqData);die;
            if (array_key_exists('id', $mcqData)) {
//                $viewdata['ques'] = $mcqData;
//                $viewdata['uid']=$this->session->userdata('user_id');
//                $_SESSION['quiz_start'] = time();
//
//                $this->load->view('quiz/ques', $viewdata);
//            }else{
//                echo $result;
//                
//                 
            if($mcqData['ans']==$formData['answer']){
                $point="1";
                
            }else{
                 $point="0";
            }
            
            $_SESSION['quiz_end'] = time();
            
           
            
            $url = base_url() . '/api/example/mcq/';

            $userData = array(
                'uid' => $formData['uid'],
                'qid' => $formData['ques'],
                'ans' => $formData['answer'],
                'points'=>$point,
                'time_taken'=>$time_taken
            );


            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . $this->apikey));
            curl_setopt($ch, CURLOPT_USERPWD, "$this->username:$this->password");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $userData);

            $result = curl_exec($ch);
            curl_close($ch);

            $resultarray = json_decode($result, true);
            //echo "<pre>";print_r($resultarray);
            //
            redirect('quiz/ques');
//
            }else{
                
                echo "problem";
            }
    
           
//            if (array_key_exists('data', $resultarray)) {
//                $id = $resultarray['data'];
//
//                $userDetail = $this->user->getRows($id);
//                //echo "<pre>";
//                //print_r($userDetail);
//
//                $this->session->set_userdata('user_id', $id);
//                $this->session->set_userdata('user_name', $userDetail['name']);
//
//
//                redirect('quiz/ques');
//            } else {
//                
//            }
        }
    }
    
    
    public function finish() {
        $userId=$this->session->userdata('user_id');
        if($userId){
            
        }else{
            
            redirect('quiz/index');
        }
        $url = base_url() . '/api/example/userdetails/'.$userId;
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY:" . $this->apikey));
        curl_setopt($ch, CURLOPT_USERPWD, "$this->username:$this->password");
        
        $result = curl_exec($ch);
        curl_close($ch);
        $mcqUserData = json_decode($result, true);
        
        //echo "<pre>";print_r($mcqUserData);
        
        if (array_key_exists('status', $mcqUserData)) {
            redirect('quiz/ques');
        }else{
            $data['quizresult']=$mcqUserData;
            $data['name']=$this->session->userdata('user_name');
            $this->load->view('quiz/finish',$data);
        }
        //$this->load->view('quiz/finish');
    }
    
    public function getalldata(){
        
        $url = base_url() . '/api/example/userdetails/';
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY:" . $this->apikey));
        curl_setopt($ch, CURLOPT_USERPWD, "$this->username:$this->password");
        
        $result = curl_exec($ch);
        curl_close($ch);
        $mcqUserData = json_decode($result, true);
        
       // echo "<pre>";print_r($mcqUserData);
        
        if (array_key_exists('status', $mcqUserData)) {
            redirect('quiz/ques');
        }else{
            $data['alldata']=$mcqUserData;
            $this->load->view('quiz/list',$data);
        }
    }
    
    
    

}
