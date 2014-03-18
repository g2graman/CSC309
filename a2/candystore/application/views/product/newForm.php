<div class="ourcenter">

	<h2>New Product</h2>

<?php
/*	echo "<p>" . anchor('products/index','Back') . "</p>";

	echo form_open_multipart('products/create');

	echo form_label('Name');
	echo form_error('name');
	echo form_input('name',set_value('name'),"required");

	echo form_label('Description');
	echo form_error('description');
	echo form_input('description',set_value('description'),"required");

	echo form_label('Price');
	echo form_error('price');
	echo form_input('price',set_value('price'),"required");

	echo form_label('Photo');

	if(isset($fileerror))
		echo $fileerror;

	echo '<input type="file" name="userfile" size="20" />';


	echo form_submit('submit', 'Create');
	echo form_close();

	echo '<a href="' . base_url() . 'login/index">Return Home</a>';
	*/
?>


<div class="container-fluid">
<div class="row vertical-center-row">
		<div class="col-lg-12">
				<div class="row ">
						<div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-4 col-xs-offset-4">
							<?php
								echo form_open_multipart('products/create');
							?>
							<div class="panel panel-primary">
									<div class="panel-heading">
										<h3 class="panel-title">Add New Product</h3>
									</div>
									<div class="panel-body">
										<center>Fill out the following information to add a new product.</center>
									</div>

												<ul class="list-group">
													<li class="list-group-item">
														<?php echo form_error('name'); ?>
														<div class="input-group">
														<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
														<?php $name_data = array('class' => 'form-control', 'placeholder' => 'Product Name', 'name' => 'name', 'id' => 'name');
														echo form_input($name_data);?>
													</div>
													</li>
													<li class="list-group-item">
														<?php echo form_error('description'); ?>
														<div class="input-group">
														<span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
														<?php $description_data = array('class' => 'form-control', 'placeholder' => 'Description', 'name' => 'description', 'id' => 'description');
														echo form_input($description_data);?>
													</div>
													</li>
													<li class="list-group-item">
														<?php echo form_error('price'); ?>
														<div class="input-group">
														<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
														<?php $price_data = array('class' => 'form-control', 'placeholder' => 'Price', 'name' => 'price', 'id' => 'price', 'pattern' => '^\d+(\.|\,)\d{2}$');
														echo form_input($price_data);?>
													</div>
													</li>
													<li class="list-group-item">
														<?php echo form_error('file_name'); ?>
														<?php $userfile_data = array('style' => 'btn btn-default btn-primary pull-right', 'placeholder' => 'Upload File', 'name' => 'userfile', 'id' => 'userfile');
														echo form_upload($userfile_data);?>
													</li>
												</ul>
												<div class="panel-footer">
													<button class="btn btn-default btn-primary" name="submit" type="submit" value="login">
															Add New Product
													</button>
												</div>
											</form>
											</div>
									</div>
							</div>
					</div>
			</div>
		</div>

</div>
