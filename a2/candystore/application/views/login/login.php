<h2>Login</h2>

<?php
	if(isset($error)){
		echo $error;
	}

	echo form_open('login/validate');

	echo form_label('Login Username');
	echo form_error('login');
	echo form_input('login',set_value('login'),"required");

	echo form_label('Password');
	echo form_error('password');
	echo form_password('password',set_value('password'),"required");

	echo form_submit('submit', 'Login');
	echo form_close();

	echo '<a href=' . base_url() .'login/create_user>Create User</a>';
	echo '<br>';
	echo '<a href=' . base_url() .'login/browse>Browse Candy</a>';
	
	
      <div class="container-fluid">
        <div class="row vertical-center-row">
            <div class="col-lg-12">
                <div class="row ">
                    <div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-4 col-xs-offset-4">
						<?php echo form_open('login/validate'); ?>
                        <div class="panel panel-primary">
                          <div class="panel-heading">
                            <h3 class="panel-title">Login</h3>
                          </div>
                          <div class="panel-body">
                            <center>INSTRUCTIONS OR GREETING!</center> 
                          </div>
                          <ul class="list-group">
                            <li class="list-group-item"><div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                              <?php echo form_input('login',set_value('login'),"required"); ?>
                              <input type="text" class="form-control" placeholder="Username">
                            </div>
                            </li>
                            <li class="list-group-item"><div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                              <input type="password" class="form-control" placeholder="Password">
                            </div>
                            </li>
                          </ul>
                          <div class="panel-footer">
                            <button class="btn btn-default btn-success">
                                Sign up!
                            </button>
                            <button class="btn btn-default btn-primary pull-right">
                                Login
                            </button>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>  
?>
