
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
			console.log('1');
			this.playerid = player;
			this.row = row;
			this.col = col;

			function getPlayerId() {
				return this.playerid;
			}
		}

		// player 1 makes a move
		$(document).ready(function() {
			console.log('2');
			if(userId!=player1){
				console.log('2a');
				$('.tile').css('background-color', 'red');
			} else {
				console.log('2b');
				$('.tile').each(function(){
					$(this).click(function(){disk_handling(this);});
				});
				console.log('2c');
			}

		});

		function disk_handling(item){
			console.log('3');
			$('.tile').each(function() {
				$(this).off('click');
			})


			var col = $(item).attr('id');

			var row = boardCols[col].length;
			var where = 'dispatcher';
			animate(row, col, item, where);


				console.log('3a');

			var url = '<?php base_url() ?>board/sendMove';
							console.log('3b');

			$.get(url, {row: row, col: col});

			console.log('3c');

			$('.tile').css('background-color', 'red');
		}


	// check for winner
	function winner(chip){
		console.log('4');
		return false;
	}

	function animate(row, col, item, where){
		console.log('5');
		disks++;
		var disk = new Disk(userId, row, col);
		boardCols[col].push(disk);
		if(winner(disk)){
			console.log('Winner winner, chicken dinner');
		}
		console.log('5a');

		if(where=='dispatcher'){
			if(userId == player1){
				console.log('5b');
				var color = 'green';
			} else {
				console.log('5c');
				var color = 'blue';
			}
		} else {
			if (userId == player1){
				console.log('5d');
				var color = 'blue';
			} else {
				console.log('5e');
				var color = 'yellow';
			}
		}

		console.log('5f');

		$('<div></div>', {id:'disk' + disks}).appendTo(item);
		$('#disk'+disks).css({'background-color':color,'border-radius':'60%', 'width':'40px', 'height':'40px', 'position':'absolute'});


		console.log('5g');

		var root_x = $("#buffer").offset().left;
		var position = $("[id='" + row + "']" + "[data-col='" + col + "']").offset();
		var x = position.left;
		var y = position.top;
		var position2 = $(item).offset();
		var y2 = position2.top;

			console.log('5h');
		$('#disks'+disks).animate({left:x-root_x+5, top:y-y2+5}, 2000, 'linear');


		console.log('5i');

	}

	$(function(){
		$('body').everyTime(2000, function() {
			console.log('data1');
			var url = '<?= base_url(); ?>board/updateMatch';
			console.log(url);
			$.getJSON(url, function(data, text, jqZHR){
				console.log('data2');
				console.log(data);
				if(data && !(data.status)){
					console.log('6');
					var row = data.row;
					var col = data.col;
					var col_array = boardCols[col];
					for(var i = 0; i < col_array.length; i++){}
					if(i <= row){
						var item = $('.tile[id="' + col + '"]');
						var where='checker';
						animate(row, col, item, where);
						$('.tile').css('background-color', 'green');
						$('.tile').each(function() {
							$this.click(function(){disk_handling(this);});
						});
<<<<<<< HEAD
					}
					//Get player's updated state here
					var url = "<?= base_url() ?>board/getMsg";
					$.getJSON(url, function (data,text,jqXHR){
						if (data && data.status=='success') {
							var conversation = $('[name=conversation]').val();
							var msg = data.message;
							$('[name=conversation]').val(conversation + "\n" + otherUser + ": " + msg);
						}
					});
			});
=======
					} else {
						console.log('7');
>>>>>>> newsetup

					}
				}
			});
		})
	});


		// $(function(){
		// 	$('body').everyTime(2000,function(){
		// 			if (status == 'waiting') {
		// 				$.getJSON('<?= base_url() ?>arcade/checkInvitation',function(data, text, jqZHR){
		// 						if (data && data.status=='rejected') {
		// 							alert("Sorry, your invitation to play was declined!");
		// 							window.location.href = '<?= base_url() ?>arcade/index';
		// 						}
		// 						if (data && data.status=='accepted') {
		// 							status = 'playing';
		// 							$('#status').html('Playing ' + otherUser);
		// 						}
		//
		// 				});
		// 			}
		// 			var url = "<?= base_url() ?>board/getMsg";
		// 			$.getJSON(url, function (data,text,jqXHR){
		// 				if (data && data.status=='success') {
		// 					var conversation = $('[name=conversation]').val();
		// 					var msg = data.message;
		// 					if (msg.length > 0)
		// 						$('[name=conversation]').val(conversation + "\n" + otherUser + ": " + msg);
		// 				}
		// 			});
		// 	});
		//
		// 	$('form').submit(function(){
		// 			var arguments = $(this).serialize();
		// 			var url = "<?= base_url() ?>board/postMsg";
		// 			$.post(url,arguments, function (data,textStatus,jqXHR){
		// 					var conversation = $('[name=conversation]').val();
		// 					var msg = $('[name=msg]').val();
		// 					$('[name=conversation]').val(conversation + "\n" + user + ": " + msg);
		// 					});
		// 			return false;
		// 			});
		// 	});

	</script>
	<link rel='stylesheet' type='text/css' href='<?= base_url() ?>css/board.css'>
	</head>
<body>
	<h1>Game Area</h1>
	<style type="text/css">
.tftable {font-size:12px;color:#333333;width:100%;border-width: 1px;border-color: #729ea5;border-collapse: collapse;}
.tftable th {font-size:12px;background-color:#acc8cc;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;text-align:left;}
.tftable tr {background-color:#d4e3e5;}
.tftable td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;}
.tftable tr:hover {background-color:#ffffff;}
</style>

<table class="tftable" border="1" name="board">
<tr><td id="00">0</td>
	<td id="01">0</td>
	<td id="02">0</td>
	<td id="03">0</td>
	<td id="04">0</td>
	<td id="05">0</td>
	<td id="06">0</td></tr>
<tr><td id="10">0</td>
	<td id="11">0</td>
	<td id="12">0</td>
	<td id="13">0</td>
	<td id="14">0</td>
	<td id="15">0</td>
	<td id="16">0</td></tr>
<tr><td id="20">0</td>
	<td id="21">0</td>
	<td id="22">0</td>
	<td id="23">0</td>
	<td id="24">0</td>
	<td id="25">0</td>
	<td id="26">0</td></tr>
<tr><td id="30">0</td>
	<td id="31">0</td>
	<td id="32">0</td>
	<td id="33">0</td>
	<td id="34">0</td>
	<td id="35">0</td>
	<td id="36">0</td></tr>
<tr><td id="40">0</td>
	<td id="41">0</td>
	<td id="42">0</td>
	<td id="43">0</td>
	<td id="44">0</td>
	<td id="45">0</td>
	<td id="46">0</td></tr>
<tr><td id="50">0</td>
	<td id="51">0</td>
	<td id="52">0</td>
	<td id="53">0</td>
	<td id="54">0</td>
	<td id="55">0</td>
	<td id="56">0</td></tr>
</table><br><br>

<script> function validateMove(id) {
							var row = id.toString().charAt(0); //Useless
							var col = id.toString().charAt(1);

							var last = 5;
							var position = '';
							while(last >= 0){
								position = '#' + last.toString() + col.toString();
								console.log(position);
								if($(position).text() == 0) {
									console.log('Found valid position in the column at' + position);
									return position
								}
								last -= 1;
							}
							return false;
						}


						$('table').find('td').click(function(){
								var id = $(this).attr('id');
								var userID = "<?= $user->id; ?>";
								var position = validateMove(id);
								if (position != false) {
									$(position).text(userID);
								} else {
									alert('INVALID MOVE!');
								}
								var url = "<?= base_url() ?>board/postMsg";
								$.post(url, {'position': position, 'userID': userID}, function (data,textStatus,jqXHR){}, 'json');
						return false;});
</script>

<?php print_r($_SESSION); ?>


<!-- <?php
	// print_r($_SESSION);
		// $script = '';
		// $script .= "<script> $('table').find('td').click(function(){";
		// // $script .= "var id = $(this).attr('id');";
		// $script .= "var id = new Array();";
		// $script .= "id[0] = $(this).attr('id');";
		// //$script .= "alert(id);";
		// $script .= 'var url ="' . base_url() . 'board/postMsg";';
		// $script .= "$.post(url, id);";
		//
		//
		// // $script .= "var id = $(this).attr('id');";
	  // // $script .= "var arguments = " . $this->match_model->getBoard() . ";";
		// // $script .= 'var url ="' . base_url() . '"board/postMsg;';
		// // $script .= 'alert("shits going down");';
		// // //echo "$.post(url,arguments, function (data,textStatus,jqXHR){";
		// // //echo "		$('[id=45]').val('1');";
		// // //echo "	}, 'json');";
		// $script .= "return false;});";
		// $script .= "</script>";
		// echo $script;
		// print_r($this->match_model->getBoard());
?> -->
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

<<<<<<< HEAD
<?php

	echo form_textarea('conversation');

	echo form_open();
	echo form_input('msg');
	echo form_submit('Send','Send');
	echo form_close();

?>
=======
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



<!-- <?php //echo form_open(); ?> -->
<!-- 	<table class="tg">
	  <tr>
	    <th class="tg-031e"> -->
					<?php /*if(isset($thispos) && $thispos = player1){
								echo '<img src="plyar1">';
							 else if(player2){

							} else {
								echo '<input type="radio" name="select" value="p00">Select';
							}
					} */ ?>
<!-- 			</th>
	    <th class="tg-031e">
				<input type="radio" name="select" value="p01">Select
			</th>
	    <th class="tg-031e">
				<input type="radio" name="select" value="p02">Select
			</th></th>
	    <th class="tg-031e">
				<input type="radio" name="select" value="p03">Select
			</th></th>
	    <th class="tg-031e">
				<input type="radio" name="select" value="p04">Select
			</th></th>
	    <th class="tg-031e">
				<input type="radio" name="select" value="p05">Select
			</th></th>
	    <th class="tg-031e">
				<input type="radio" name="select" value="p06">Select
			</th></th>
	  </tr>
	  <tr>
				<th class="tg-031e">
						<input type="radio" name="select" value="p10">Select
				</th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p11">Select
				</th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p12">Select
				</th></th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p13">Select
				</th></th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p14">Select
				</th></th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p15">Select
				</th></th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p16">Select
				</th></th>
			</tr>
	  <tr>
				<th class="tg-031e">
						<input type="radio" name="select" value="p20">Select
				</th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p21">Select
				</th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p22">Select
				</th></th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p23">Select
				</th></th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p24">Select
				</th></th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p25">Select
				</th></th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p26">Select
				</th></th>
			</tr>
	  <tr>
			<th class="tg-031e">
					<input type="radio" name="select" value="p30">Select
			</th>
			<th class="tg-031e">
				<input type="radio" name="select" value="p31">Select
			</th>
			<th class="tg-031e">
				<input type="radio" name="select" value="p32">Select
			</th></th>
			<th class="tg-031e">
				<input type="radio" name="select" value="p33">Select
			</th></th>
			<th class="tg-031e">
				<input type="radio" name="select" value="p34">Select
			</th></th>
			<th class="tg-031e">
				<input type="radio" name="select" value="p35">Select
			</th></th>
			<th class="tg-031e">
				<input type="radio" name="select" value="p36">Select
			</th></th>
		</tr>
		<tr>
				<th class="tg-031e">
						<input type="radio" name="select" value="p40">Select
				</th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p41">Select
				</th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p42">Select
				</th></th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p43">Select
				</th></th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p44">Select
				</th></th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p45">Select
				</th></th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p46">Select
				</th></th>
			</tr>
		<tr>
				<th class="tg-031e">
						<input type="radio" name="select" value="p50">Select
				</th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p51">Select
				</th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p52">Select
				</th></th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p53">Select
				</th></th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p54">Select
				</th></th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p55">Select
				</th></th>
				<th class="tg-031e">
					<input type="radio" name="select" value="p56">Select
				</th></th>
			</tr>
	</table>

 -->










<!-- <?php
	//
	// echo form_textarea('conversation');
	//
	//
	// echo form_input('msg');
	// echo form_submit('Send','Send');
	// echo form_close();

?> -->
>>>>>>> newsetup




</body>

</html>
