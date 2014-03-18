<div class="ourcenter">

	<h2>Edit Product</h2>

<div class="container-fluid">
<div class="row vertical-center-row">
		<div class="col-lg-12">
				<div class="row ">
						<div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-4 col-xs-offset-4">

									<?php
										echo form_open("products/update/$product->id");
									?>
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h3 class="panel-title">Edit Product Information</h3>
									</div>
								<div class="panel-body">
									<center>Update the fields with the new product information, then press Update to continue.</center>
								</div>


			<ul class="list-group">
				<li class="list-group-item">
					<?php echo form_error('name'); ?>
					<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-star"></span></span>
					<?php $name_data = array('class' => 'form-control', 'placeholder' => $product->name, 'value' => $product->name, 'name' => 'name', 'id' => 'name', 'required' => 'true');
					echo form_input($name_data);?>
				</div>
				</li>
				<li class="list-group-item">
					<?php echo form_error('description'); ?>
					<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
					<?php $description_data = array('class' => 'form-control', 'placeholder' => $product->description, 'value' => $product->description, 'name' => 'description', 'id' => 'description', 'type' => 'description', 'required' => 'true');
					echo form_input($description_data);?>
				</div>
				</li>
				<li class="list-group-item">
					<?php echo form_error('price'); ?>
					<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
					<?php $price_data = array('class' => 'form-control', 'placeholder' => $product->price, 'value'=>$product->price, 'name' => 'price', 'id' => 'price', 'type' => 'number', 'required' => 'true', 'pattern' => '^\d+(\.|\,)\d{2}$');
					echo form_input($price_data);?>
				</div>
				</li>
			</ul>
			<div class="panel-footer">

				<button class="btn btn-default btn-primary" name="submit" type="submit" value="login">
						Update
				</button>
			</div>
		</form>

</div>
</div>
</div>
</div>
</div>
