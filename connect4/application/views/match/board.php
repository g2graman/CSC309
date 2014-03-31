
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
							if (msg.length > 0)
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


	<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
</style>
<?php echo form_open(); ?>
	<table class="tg">
	  <tr>
	    <th class="tg-031e">
					<?php /*if(isset($thispos) && $thispos = player1){
								echo '<img src="plyar1">';
							 else if(player2){

							} else {
								echo '<input type="radio" name="select" value="p00">Select';
							}
					} */ ?>
			</th>
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












<?php

	echo form_textarea('conversation');


	echo form_input('msg');
	echo form_submit('Send','Send');
	echo form_close();

?>




</body>

</html>
