<div class="ourcenter"><br><br>
	<div class="container-fluid">
	<div class="row vertical-center-row">
			<div class="col-lg-12">
					<div class="row ">
							<div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-4 col-xs-offset-4">
									<form method="post" accept-charset="utf-8" action="<?php echo base_url() . 'login/validate'; ?>" />
									<div class="panel panel-primary">
										<div class="panel-heading">
											<h3 class="panel-title">Login</h3>
										</div>
										<div class="panel-body">
											<center>Please Login To Continue!</center>
										</div>

<?php
	echo form_open('login/validate');
?>

                          <ul class="list-group">
                            <li class="list-group-item">
															<?php echo form_error('login'); ?>
															<div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
															<?php $login_data = array('class' => 'form-control', 'placeholder' => 'Username', 'name' => 'login', 'id' => 'login');
															echo form_input($login_data);?>
                            </div>
                            </li>
                            <li class="list-group-item">
															<?php echo form_error('password'); ?>
															<div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
															<?php $pass_data = array('class' => 'form-control', 'placeholder' => 'Password', 'name' => 'password', 'id' => 'password', 'type' => 'password');
															echo form_input($pass_data);?>
                            </div>
                            </li>
                          </ul>
                          <div class="panel-footer">
                            <a href="<?php echo base_url() . 'login/create_user';?>"  class="btn btn-default btn-success">
                                Sign up!
                            </a>
														<button class="btn btn-default btn-primary pull-right" name="submit" type="submit" value="login">
																Login
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
