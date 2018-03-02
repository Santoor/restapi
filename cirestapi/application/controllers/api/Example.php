<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


require APPPATH . '/libraries/REST_Controller.php';

class Example extends REST_Controller {

    public function __construct() { 
        parent::__construct();
		
		//load user model
        $this->load->model('user');
    }
	
	public function user_get($id = 0) {
		//returns all rows if the id parameter doesn't exist,
		//otherwise single row will be returned
		$users = $this->user->getRows($id);
		
		//check if the user data exists
		if(!empty($users)){
			//set the response and exit
			//OK (200) being the HTTP response code
			$this->response($users, REST_Controller::HTTP_OK);
		}else{
			//set the response and exit
			//NOT_FOUND (404) being the HTTP response code
			$this->response([
				'status' => FALSE,
				'message' => 'No user were found.'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}
        
        
        
        public function mcq_get($id = 0,$uid=0) {
		//returns all rows if the id parameter doesn't exist,
		//otherwise single row will be returned
                //log_message('error', 'Start');
                //log_message('error',$uid );
                
                if($uid!="0"){
                    $existingQuesData=$this->user->getMcqUserDetails($uid);
                    $existingQuesArray=array();
                    foreach($existingQuesData as $key=>$data){
                        $existingQuesArray[$key]=$data['qid'];
                    }
                    //log_message('error',print_r($existingQuesArray,1) );
                    $mcq = $this->user->getMcq($id,$existingQuesArray);
                }else{
                    $mcq = $this->user->getMcq($id,$array=array());
                }
            
		
		
		//check if the user data exists
		if(!empty($mcq)){
			
                        //echo "<pre>";print_r($users);
			$this->response($mcq, REST_Controller::HTTP_OK);
		}else{
			//set the response and exit
			//NOT_FOUND (404) being the HTTP response code
			$this->response([
				'status' => FALSE,
				'message' => 'No Questions were found.'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}
        
        
        public function userdetails_get($id = 0) {
		
            
		$mcqUserDetail = $this->user->getMcqUserDetails($id);
		
		
		if(count($mcqUserDetail)>0){
			
                        //echo "<pre>";print_r($users);
			$this->response($mcqUserDetail, REST_Controller::HTTP_OK);
		}else{
			//set the response and exit
			//NOT_FOUND (404) being the HTTP response code
			$this->response([
				'status' => FALSE,
				'message' => 'User did not answered any questions'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}
        
	
	public function user_post() {
		$userData = array();
		$userData['name'] = $this->post('name');
		
		$userData['email'] = $this->post('email');
		
		if(!empty($userData['name'])  && !empty($userData['email'])){
			//insert user data
			$insert = $this->user->insert($userData);
			
			//check if the user data inserted
			if($insert){
				//set the response and exit
				$this->response([
                                        'data'=>$insert,
					'status' => TRUE,
					'message' => 'User has been added successfully.'
				], REST_Controller::HTTP_OK);
			}else{
				//set the response and exit
				$this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
			}
        }else{
			//set the response and exit
			//BAD_REQUEST (400) being the HTTP response code
            $this->response("Provide complete user information to create.", REST_Controller::HTTP_BAD_REQUEST);
		}
	}
        
        
        
        public function mcq_post() {
		$userMcqData = array();
                
                //log_message('error', print_r($this->post(),1));
		$userMcqData['uid'] = $this->post('uid');
		$userMcqData['qid'] = $this->post('qid');
                $userMcqData['ans'] = $this->post('ans');
		$userMcqData['points'] = $this->post('points');
                $userMcqData['time_taken'] = $this->post('time_taken');
		
		if(!empty($userMcqData['uid']) && !empty($userMcqData['ans'])){
			//insert user data
			$insert = $this->user->insertUserAnsData($userMcqData);
			
			//check if the user data inserted
			if($insert){
				//set the response and exit
				$this->response([
                                        'data'=>$insert,
					'status' => TRUE,
					'message' => 'Answer has been sent successfully.'
				], REST_Controller::HTTP_OK);
			}else{
				//set the response and exit
				$this->response("Some problems occurred, please try again.", REST_Controller::HTTP_BAD_REQUEST);
			}
        }else{
			
                $this->response("Provide Select answer.", REST_Controller::HTTP_BAD_REQUEST);
		}
	}
        
         
}

?>
