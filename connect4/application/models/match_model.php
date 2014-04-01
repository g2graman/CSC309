<?php
class Match_model extends CI_Model {

	function getExclusive($id)
	{
		$sql = "select * from `match` where id=? for update";
		$query = $this->db->query($sql,array($id));
		if ($query && $query->num_rows() > 0)
			return $query->row(0,'Match');
		else
			return null;
	}

	function get($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('match');
		if ($query && $query->num_rows() > 0)
			return $query->row(0,'Match');
		else
			return null;
	}


	function insert($match) {
		return $this->db->insert('match',$match);
	}


	function updateMsgU1($id,$msg) {
		$this->db->where('id',$id);
		return $this->db->update('match',array('u1_msg'=>$msg));
	}

	function updateMsgU2($id,$msg) {
		$this->db->where('id',$id);
		return $this->db->update('match',array('u2_msg'=>$msg));
	}

	function updateStatus($id, $status) {
		$this->db->where('id',$id);
		return $this->db->update('match',array('match_status_id'=>$status));
	}

	function updateBoard($rowNum, $colNum) {
		if (isset($_SESSION['boardState']) && isset($_SESSION['user'])){
			$_SESSION['boardState'][$rowNum][$colNum] = $_SESSION['user'];
			$encodedBoard = json_encode($_SESSION['boardState']);
			$this->db->update('match', array('board_state'=> $encodedBoard));
		}
	}

	function getBoard() {
		//print_r($_SESSION);
		if(isset($_SESSION['user'])){
				$matchId = $_SESSION['user']->match_id;;
				$query = $this->db->get_where('match', array('id' => $matchId));
				$result = $query->result();
				if ($query && $query->num_rows() > 0) {
					foreach($result as $admin) {
						return json_decode($admin->board_state);
					}
				} else {
					return false;
				}
		} else {
			return false;
		}
	}

	function validateMove($id) {

			$rowNum = substr($id, 0, 1);
			$colNum = substr($id, -1);

			error_log( $colNum . ' test ' . $rowNum );

			error_log('match id: ' . $user->match_id);

			$boardState = $this->getBoard();
			// error_log('boardState1: ' . $boardState['state']);
			error_log('boardState2: ' . $boardState->state[$rowNum][$colNum]);
	}
}
?>
