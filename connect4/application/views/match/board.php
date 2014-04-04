
<!DOCTYPE html>

<html>
	<head>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="<?= base_url() ?>/js/jquery.timers.js"></script>
	<script>

		var otherUser = "<?= $otherUser->login ?>";
		var user = "<?= $user->login ?>";
		var status = "<?= $status ?>";
		var player1 = "<?= $player1 ?>";
		var player2 = "<?= $player2 ?>";
		var userId = "<?= $user->id ?>";
		var otherUserId = "<?= $otherUser->id ?>";
		var disks = 0;
		var boardCols = [[], [], [], [], [], [], []];

		function Disk(player, row, col){
			console.log('2');
			this.playerid = player;
			this.row = row;
			this.col = col;

			this.id = function getPlayerId() {
				return this.playerid;
			}
		}

		// player 1 makes a move
		$(document).ready(function() {
			console.log('3');
			if(userId!=player1){
				$('.tile').css('background-color', 'red');
			} else {
				// if(check_valid_move(this)){
					$('.tile').each(function(){
						$(this).click(function(){disk_handling(this);});
					});
				// } else {
					// alert("Error: That is not a valid move");
				// }
			}

		});

		function check_valid_move(item){
			console.log('4');
			var col = $(item).attr('id');
			var row = boardCols[col].length;

			if(row >= 7){
				return false;
			} else {
				return true;
			}

		}

		function disk_handling(item){
			console.log('5');
			// determine col and row
			var col = $(item).attr('id');
			var row = boardCols[col].length;

			// check if there is space to add another disk on the column
			if(row >= 6){
				alert("Error: This is not a valid move");
				return false;
			}

			// switch the colors of the arrow buttons
			$('.tile').each(function() {
				$(this).off('click');
			})

			// where we came from
			var from = 'diskhandler';
			add_disk(row, col, item, from);

			$("[id='" + row + "']" + "[data-col='" + col + "']").css({'background-color':'red'});

			var url = '<?php base_url();?>sendMove';

			$.get(url, {row: row, col: col});

			$('.tile').css('background-color', 'red');

		}

	// function winner_helper(rowOrig, colOrig, playerId){
	// 	console.log('rowOrig: ' + rowOrig);
	// 	console.log('colOrig: ' + colOrig);
	// 	console.log('playerId: ' + playerId);

	// 			boardCols[colOrig].each(function(){
	// 					console.log(this.getPlayerId().toString())});
	// 	console.log('boardCols[colOrig]: ' + boardCols[colOrig]);
	// 	// console.log('boardCols[colOrig][rowOrig]: ' + boardCols[colOrig][rowOrig]);
	// 	console.log('boardCols[colorOrig][rowOrig].playerId ' +boardCols[colorOrig][rowOrig].playerId);

	// 	return false;
	// }

		// function checkForWin(disk){
		// 	playerId = disk.id();
		// 	return winInDirection(parseInt(disk.row), parseInt(disk.col), 0, 1, playerId) || // check to the right
		// 	winInDirection(parseInt(disk.row), parseInt(disk.col), 0, -1, playerId) || // check to the left
		// 	winInDirection(parseInt(disk.row), parseInt(disk.col), -1, 0, playerId) || // check down
		// 	winInDirection(parseInt(disk.row), parseInt(disk.col), 1, 1, playerId) || // check up and right
		// 	winInDirection(parseInt(disk.row), parseInt(disk.col), 1, -1, playerId) || // check up and left
		// 	winInDirection(parseInt(disk.row), parseInt(disk.col), -1, -1, playerId) || // check down and left
		// 	winInDirection(parseInt(disk.row), parseInt(disk.col), -1, 1, playerId); // check down and right

		// }

		// /*
		// * Given the current position of the chip, and the directions to change in (dRow, dCol) and the player,
		// * cheacks if the player has connected 4 in the given direction
		// */
		// function winInDirection(currRow, currColumn, dRow, dCol, player){
		// 	streak = 1;

		// 	while (currColumn + dCol >= 0 && currColumn + dCol < boardCols.length
		// 	&& currRow + dRow >= 0 && currRow + dRow <= 7
		// 	&& boardCols[currColumn + dCol].length > (currRow + dRow)
		// 	&& boardCols[currColumn + dCol][currRow + dRow].id() == player){
		// 		console.log('while: ' + boardCols[currColumn + dCol][currRow + dRow].id())
		// 		streak++;
		// 		currRow = currRow + dRow;
		// 		currColumn = currColumn + dCol;
		// 	}
		// 	return streak >= 4;

		// }

		function winner_helper(rowOrig, colOrig, playerId){
		console.log('1');
		console.log('playerid: ' + playerId);
		var x_streak = 1;
		for(var i = 1; i < 4; i++){
			if(x_streak == 4 || (colOrig + i <= 6 && boardCols[colOrig + i].length > rowOrig && boardCols[colOrig + i][rowOrig].id() == playerId)) {
				console.log('disk.id(): ' + disk.id());
				x_streak += 1
				console.log('x_streak: 2a ' + x_streak);
			} else {
				console.log('x_streak: 2c ' + x_streak);
				break;
			}
		}

		for(var i = 1; i < 4; i++){
			if(x_streak == 4 || (colOrig - i >= 0 && boardCols[colOrig - i].length > rowOrig && boardCols[colOrig - i][rowOrig].id() == playerId)) {
				x_streak += 1
				console.log('x_streak: 2b ' + x_streak);
			} else {
				console.log('x_streak: 2d ' + x_streak);
				break;
			}
		}

		if (x_streak >= 4) {
			return true;
		}

		var y_streak = 1;
		for(var i = 1; i < 4; i++){
			if(y_streak == 4 || (rowOrig - i >= 0 && boardCols[colOrig].length > rowOrig  && boardCols[colOrig][rowOrig - i].id() == playerId)) {
				y_streak += 1
				console.log('y_streak: 2e ' + y_streak);
			} else {
				break;
			}
		}

		if (y_streak >= 4) {
			return true;
		}

		var ld_streak = 1;
		for(var i = 1; i < 4; i++){
			if(ld_streak == 4 || (colOrig - i >= 0 && rowOrig - i >= 0 && boardCols[colOrig - i].length > rowOrig  && boardCols[colOrig - i][rowOrig - i].id() == playerId)) {
				ld_streak += 1
				console.log('ld_streak: 2f ' + ld_streak);
			} else {
				break;
			}
		}

		for(var i = 1; i < 4; i++){
			if(ld_streak == 4 || (colOrig + i <= 6 && rowOrig + i <= 6 && boardCols[colOrig + i].length > rowOrig  && boardCols[colOrig + i][rowOrig + i].id() == playerId)) {
				ld_streak += 1
				console.log('ld_streak: 2g ' + ld_streak);
			} else {
				break;
			}
		}

		if (ld_streak >= 4) {
			return true;
		}

		var ul_streak = 1;
		for(var i = 1; i < 4; i++){
			if(ul_streak == 4 || (colOrig - i >= 0 && rowOrig + i <= 6 && boardCols[colOrig - i].length > rowOrig  && boardCols[colOrig - i][rowOrig + i].id() == playerId)) {
				ul_streak += 1
				console.log('ul_streak: 2h ' + ul_streak);
			} else {
				break;
			}
		}

		for(var i = 1; i < 4; i++){
			if(ul_streak == 4 || (colOrig + i <= 6 && rowOrig - i >= 0 && boardCols[colOrig + i].length > rowOrig  && boardCols[colOrig + i][rowOrig - i].id() == playerId)) {
				ul_streak += 1
				console.log('ul_streak: 2i ' + ul_streak);
			} else {
				break;
			}
		}

		if (ul_streak >= 4) {
			console.log('6');
			return true;
		}

		return false;
	}


	// check for winner
	function isWinnerOrTie(disk){
			console.log('7');
		// left, right, diagonal left down, diagonal right down, regular down.
		// call winner_helper on each direction to see if there was a win
		// if(winner_helper(parseInt(disk.row), parseInt(disk.col), parseInt(disk.id()))){
		// 	console.log('entering winner_helper');
		// 	end_of_game('win', parseInt(disk.id()));
		// }
		// check if it is a tie
		if(disks >= 42){
			end_of_game('tie', parseInt(disk.id()));
		} else {
			return false;
		}
	}



	function end_of_game(reason, player){
			console.log('8');
		if(reason==='tie'){
			alert("The game ended in a tie");
		} else if(reason==='win'){
			alert("The game ended. " + player + " won the game");
		}

		// handle how to end the game here
		// ie update the status and the database, then return to the mainPage/arcade

	}

	function add_disk(row, col, item, from){
			console.log('9');
		disks++;
		var disk = new Disk(userId, row, col);
		boardCols[col].push(disk);

		if(from=='diskhandler'){
			if(userId == player1){
				var color = 'green';
				var imgUrl = "url(<?= base_url() ?>images/doge.png)";
			} else {
				var color = 'blue';
				var imgUrl = "url(<?= base_url() ?>images/cat.png)";
			}
		} else {
			if (userId == player1){
				var color = 'blue';
				var imgUrl = "url(<?= base_url() ?>images/cat.png)";
			} else {
				var color = 'green';
				var imgUrl = "url(<?= base_url() ?>images/doge.png)";
			}
		}

		$("[id='" + row + "']" + "[data-col='" + col + "']").css({'background-color':color, 'background-image':imgUrl});

		isWinnerOrTie(disk);

	}

	$(function(){
		$('body').everyTime(2000, function() {
			console.log('10');
			var url = "<?= base_url() . 'board/updateMatch'; ?>";
			$.getJSON(url, function(data, text, jqZHR){
				if(data && !(data.status) && data.row && data.col){
					var row = data.row;
					var col = data.col;
					var col_array = boardCols[col];
						if(col_array.length <= row){
							var item = $('.tile[id="' + col + '"]');
							var from='everytime';
							add_disk(row, col, item, from);
							$('.tile').css('background-color', 'green');
							$('.tile').each(function() {
								$(this).click(function(){disk_handling(this);});
							});
						}
				}
			});
		})
	});


	</script>
	<link rel='stylesheet' type='text/css' href='<?= base_url() ?>css/our.css'>
	</head>
<body>
	<h1>Game Area</h1>

	<div>
	Hello <?= $user->fullName() ?>  <?= anchor('account/logout','(Logout)') ?>
	</div>

	<div id='status'>
	<?php
		if ($status == "playing")
			echo "Playing " . $otherUser->login;
		else
			echo "Wating on " . $otherUser->login;
	?>
	</div>

	<div class="ourcenter">
		<div id='gameboard'>
			<h1>Franshni Presents Connect 4!</h1>
			<div id='buffer'>
				<?php
					for($i=0; $i<7; $i++){
						if($i == 0){
							echo '<div class="tile" id=' . $i . '><img id="img" src=' . base_url() . 'images/arrow.png></div>';
						} else {
							echo '<div class="tile" id=' . $i . '><img id="img" src=' . base_url() . 'images/arrow.png></div>';
						}
					}
					echo '<div class="clear"></div>';
				?>
			</div>
			<?php
				for($i = 5; $i >= 0; $i--){
					for($j = 0; $j<7; $j++){
						echo '<div class="disk" data-col=' . $j . ' id='. $i . '></div>';
					}
					echo '<div class="clear"></div>';
				}
			?>
		</div>
	</div>

</body>

</html>
