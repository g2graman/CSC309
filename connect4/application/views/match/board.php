
<!DOCTYPE html>

<html>
	<head>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="<?= base_url() ?>/js/jquery.timers.js"></script>
	<script>

		var otherUser = "<?= $otherUser->login ?>";
		var user = "<?= $user->login ?>";
		var status = "<?= $status ?>";

		$(function(){
			$('body').everyTime(2000,function(){
					if (status == 'waiting') {
						$.getJSON('<?= base_url() ?>arcade/checkInvitation',function(data, text, jqZHR){
								if (data && data.status=='rejected') {
									alert("Sorry, your invitation to play was declined!");
									window.location.href = '<?= base_url() ?>arcade/index';
								}
								if (data && data.status=='accepted') {
									status = 'playing';
									$('#status').html('Playing ' + otherUser);
								}

						});
					}
					var url = "<?= base_url() ?>board/getMsg";
					$.getJSON(url, function (data,text,jqXHR){
						if (data && data.status=='success') {
							var conversation = $('[name=conversation]').val();
							var msg = data.message;
							$('[name=conversation]').val(conversation + "\n" + otherUser + ": " + msg);
						}
					});
			});

			$('form').submit(function(){
					var arguments = $(this).serialize();
					var url = "<?= base_url() ?>board/postMsg";
					$.post(url,arguments, function (data,textStatus,jqXHR){
							var conversation = $('[name=conversation]').val();
							var msg = $('[name=msg]').val();
							$('[name=conversation]').val(conversation + "\n" + user + ": " + msg);
							});
					return false;
					});
			});

	</script>
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
<tr><td id="00">Row:0 Cell:0</td>
	<td id="01">Row:0 Cell:1</td>
	<td id="02">Row:0 Cell:2</td>
	<td id="03">Row:0 Cell:3</td>
	<td id="04">Row:0 Cell:4</td>
	<td id="05">Row:0 Cell:5</td>
	<td id="06">Row:0 Cell:6</td></tr>
<tr><td id="10">Row:1 Cell:0</td>
	<td id="11">Row:1 Cell:1</td>
	<td id="12">Row:1 Cell:2</td>
	<td id="13">Row:1 Cell:3</td>
	<td id="14">Row:1 Cell:4</td>
	<td id="15">Row:1 Cell:5</td>
	<td id="16">Row:1 Cell:6</td></tr>
<tr><td id="20">Row:2 Cell:0</td>
	<td id="21">Row:2 Cell:1</td>
	<td id="22">Row:2 Cell:2</td>
	<td id="23">Row:2 Cell:3</td>
	<td id="24">Row:2 Cell:4</td>
	<td id="25">Row:2 Cell:5</td>
	<td id="26">Row:2 Cell:6</td></tr>
<tr><td id="30">Row:3 Cell:0</td>
	<td id="31">Row:3 Cell:1</td>
	<td id="32">Row:3 Cell:2</td>
	<td id="33">Row:3 Cell:3</td>
	<td id="34">Row:3 Cell:4</td>
	<td id="35">Row:3 Cell:5</td>
	<td id="36">Row:3 Cell:6</td></tr>
<tr><td id="40">Row:4 Cell:0</td>
	<td id="41">Row:4 Cell:1</td>
	<td id="42">Row:4 Cell:2</td>
	<td id="43">Row:4 Cell:3</td>
	<td id="44">Row:4 Cell:4</td>
	<td id="45">Row:4 Cell:5</td>
	<td id="46">Row:4 Cell:6</td></tr>
<tr><td id="50">Row:5 Cell:0</td>
	<td id="51">Row:5 Cell:1</td>
	<td id="52">Row:5 Cell:2</td>
	<td id="53">Row:5 Cell:3</td>
	<td id="54">Row:5 Cell:4</td>
	<td id="55">Row:5 Cell:5</td>
	<td id="56">Row:5 Cell:6</td></tr>
</table><br><br>

<script> $('table').find('td').click(function(){
								var id = $(this).attr('id');
								var url = "<?= base_url() ?>board/postMsg";
								$.post(url, {'id': id}, function (data,textStatus,jqXHR){}, 'json');
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

<?php

	echo form_textarea('conversation');

	echo form_open();
	echo form_input('msg');
	echo form_submit('Send','Send');
	echo form_close();

?>




</body>

</html>
