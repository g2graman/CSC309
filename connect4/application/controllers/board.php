<?php

class Board extends CI_Controller {

    function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();
	    	session_start();
        $this->load->model('match_model');
    }

    public function _remap($method, $params = array()) {
	    	// enforce access control to protected functions

    		if (!isset($_SESSION['user']))
   			redirect('account/loginForm', 'refresh'); //Then we redirect to the index page again

	    	return call_user_func_array(array($this, $method), $params);
    }


    function index() {
		    $user = $_SESSION['user'];

	    	$this->load->model('user_model');
	    	$this->load->model('invite_model');
	    	$this->load->model('match_model');

	    	$user = $this->user_model->get($user->login);

	    	$invite = $this->invite_model->get($user->invite_id);

	    	if ($user->user_status_id == User::WAITING) {
	    		$invite = $this->invite_model->get($user->invite_id);
	    		$otherUser = $this->user_model->getFromId($invite->user2_id);
	    	}
	    	else if ($user->user_status_id == User::PLAYING) {
	    		$match = $this->match_model->get($user->match_id);
	    		if ($match->user1_id == $user->id)
	    			$otherUser = $this->user_model->getFromId($match->user2_id);
	    		else
	    			$otherUser = $this->user_model->getFromId($match->user1_id);
	    	}

	    	$data['user']=$user;
	    	$data['otherUser']=$otherUser;

	    	switch($user->user_status_id) {
	    		case User::PLAYING:
	    			$data['status'] = 'playing';
	    			break;
	    		case User::WAITING:
	    			$data['status'] = 'waiting';
	    			break;
	    	}

		    $this->load->view('match/board',$data);
    }

 	function postMsg() {
      // echo "SOMETHING HAPPENED?";
     $position = $this->input->post('position');
     $userID = $this->input->post('userID');
     error_log('path: ' . $_SESSION['user']->id . ' 6');

    //  if($this->match_model->validateMove($position, $userID)) {
     //
    //  }

      error_log('thisisidddddd: ' . $position);

      error_log('userID' . $userID);

      $rowNum = substr($position, 1, 1);
      $colNum = substr($position, -1);

      error_log( $colNum . ' -> col, row -> ' . $rowNum );

      error_log('match id: ' . $_SESSION['user']->match_id);

      $this->load->model('match_model');

      $boardState = $this->match_model->getBoard();
      // error_log('boardState1: ' . $boardState['state']);
      error_log('boardState2: ' . $boardState->state[$rowNum][$colNum]);

      // update value of the board
      // if($_SESSION['player1'] == $userID){
      //   $boardState->state[$rowNum][$colNum] = 1;
      // } else if($_SESSION['player2'] == $userID){
      //   $boardState->state[$rowNum][$colNum] = 2;
      // } else {
      //   error_log('error');
      // }

      $boardState->state[$rowNum][$colNum] = $userID;

      error_log('new board row/col: ' . $boardState->state[$rowNum][$colNum]);

   }
 // 		if ($this->form_validation->run() == TRUE) {
 // 			$this->load->model('user_model');
 // 			$this->load->model('match_model');
   //
 // 			$user = $_SESSION['user'];
   //
 // 			$user = $this->user_model->getExclusive($user->login);
 // 			if ($user->user_status_id != User::PLAYING) {
	// 			$errormsg="Not in PLAYING state";
 // 				goto error;
 // 			}
   //
 // 			$match = $this->match_model->get($user->match_id);
 // 			$msg = $this->input->post('msg');
   //
  //      $msg = $msg;
   //
 // 			if ($match->user1_id == $user->id)  {
 // 				$msg = $match->u1_msg == ''? $msg :  $match->u1_msg . "\n" . $msg;
 // 				$this->match_model->updateMsgU1($match->id, $msg);
 // 			}
 // 			else {
 // 				$msg = $match->u2_msg == ''? $msg :  $match->u2_msg . "\n" . $msg;
 // 				$this->match_model->updateMsgU2($match->id, $msg);
 // 			}
   //
 // 			echo json_encode(array('status'=>'success'));
   //
 // 			return;
 // 		}
   //
 // 		$errormsg="Missing argument";
   //
	// 	error:
	// 		echo json_encode(array('status'=>'failure','message'=>$errormsg));
 // 	}

	function getMsg() {
 		$this->load->model('user_model');
 		$this->load->model('match_model');

 		$user = $_SESSION['user'];
     error_log('path: ' . $_SESSION['user']->id . ' 7');

 		$user = $this->user_model->get($user->login);
 		if ($user->user_status_id != User::PLAYING) {
 			$errormsg="Not in PLAYING state";
 			goto error;
 		}
 		// start transactional mode
 		$this->db->trans_begin();

 		$match = $this->match_model->getExclusive($user->match_id);

 		if ($match->user1_id == $user->id) {
			$msg = $match->u2_msg;
 			$this->match_model->updateMsgU2($match->id,"");
 		}
 		else {
 			$msg = $match->u1_msg;
 			$this->match_model->updateMsgU1($match->id,"");
 		}

 		if ($this->db->trans_status() === FALSE) {
 			$errormsg = "Transaction error";
 			goto transactionerror;
 		}

 		// if all went well commit changes
 		$this->db->trans_commit();

 		echo json_encode(array('status'=>'success','message'=>$msg));
		 return;

		transactionerror:
		$this->db->trans_rollback();

		error:
		echo json_encode(array('status'=>'failure','message'=>$errormsg));
 	}

 }
