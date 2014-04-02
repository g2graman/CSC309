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

	function updateBoard($board, $newUser) {
		$encodedBoard = json_encode(array('state'=> $boardArray, 'current_user' => $newUser));
		$this->db->update('match', array('board_state'=> $encodedBoard));
	}

	function getBoard() {
		//print_r($_SESSION);
		error_log('inside getBoard');
		error_log('user id: ' . $_SESSION['user']->id);
		error_log('match id: ' . $_SESSION['user']->match_id);
		if(isset($_SESSION['user'])){
				error_log('gb1');
				$matchId = $_SESSION['user']->match_id;;
				$query = $this->db->get_where('match', array('id' => $matchId));
				$result = $query->result();
				if ($query && $query->num_rows() > 0) {
					error_log('gb2');
					foreach($result as $board) {
						error_log('gb3');
						error_log('user1 id: ' . $board->user1_id);
						error_log('user2 id: ' . $board->user2_id);
						error_log('board state: ' . $board->board_state->state[0][0]);
						return json_decode($board->board_state);
					}
				} else {
					error_log('gb4');
					return false;
				}
		} else {
			error_log('gb5');
			return false;
		}
	}

	function validateMove($id, $userID) {

			error_log('userID' . $userID);

			$rowNum = substr($id, 1, 1);
			$colNum = substr($id, -1);

			error_log('thisisidddddd: ' . $id);

			error_log( $colNum . ' test ' . $rowNum );

			error_log('match id: ' . $_SESSION['user']->match_id);

			$boardState = $this->getBoard();
			// error_log('boardState1: ' . $boardState['state']);
			error_log('boardState2: ' . $boardState->state[$rowNum][$colNum]);

			// calculate which position to put it in (if it's valid)
			// $newRowNum = $this->validColumn($boardState->state, $colNum);

			// error_log('newrow: ' . $newRowNum);

			// update board
			// error_log('player1 id: ' . $_SESSION['player1']);
			// error_log('player2 id: ' . $_SESSION['player2']);

			// if($user->id == $_SESSION['player1']){
			// 	$boardState->state[$newRowNum][$colNum] = 1;
			// } else if($user->id == $_SESSION['player2']){
			// 	$boardState->state[$newRowNum][$colNum] = 2;
			// } else {
			// 	$boardState->state[$newRowNum][$colNum] = 0;
			// }

			$boardState->state[$rowNum][$colNum] = $userID;

			error_log('new board row/col: ' . $boardState->state[$rowNum][$colNum]);

			// $winner = $this->hasWinner($board, $newRowNum, $colNum);

			// if($winner){
			// 	// winner stuff
			// 	error_log('winner');
			// } else {
			// 	$this->updateBoard($boardState->state);
			// }

	}

	// returns rowNum if true empty, else returns false
	function validColumn($board, $colNum){
		error_log('vc, board: ' . $board . ' colnum: ' . $colNum);
		$i = 5;
		while($i != 0){
			error_log('validcolumn i: ' . $i . ' board: ' . $board[$i][$colNum]);
			if($board[$i][$colNum] === 0){
				return $i;
			}
			$i = $i - 1;
		}

		return false;
	}

	function hasWinner($board, $row, $col){
		error_log('inside has winner');

		// game logic
	}

}
?>
