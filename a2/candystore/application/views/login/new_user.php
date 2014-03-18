<div class="ourcenter"><br>
  <div class="container-fluid">
  <div class="row vertical-center-row">
      <div class="col-lg-12">
          <div class="row ">
              <div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-4 col-xs-offset-4">
                  <form method="post" accept-charset="utf-8" action="<?php echo base_url() . 'login/new_user'; ?>" />
                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      <h3 class="panel-title">Create an Account</h3>
                    </div>
                    <div class="panel-body">
                      <center>We're excited you want to shop with us! Create an account and enjoy the benefits!</center>
                      <center><?php if(isset($error){echo $error; } ?></center>
                    </div>

                    <?php
                      echo form_open('login/validate');
                    ?>

                          <ul class="list-group">
                            <li class="list-group-item">
                              <?php echo form_error('first'); ?>
                              <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                              <?php $login_data = array('class' => 'form-control', 'placeholder' => 'First Name', 'name' => 'first', 'id' => 'first');
                              echo form_input($login_data);?>
                            </div>
                            </li>
                            <li class="list-group-item">
                              <?php echo form_error('last'); ?>
                              <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                              <?php $login_data = array('class' => 'form-control', 'placeholder' => 'Last Name', 'name' => 'last', 'id' => 'last');
                              echo form_input($login_data);?>
                            </div>
                            </li>
                            <li class="list-group-item">
                              <?php echo form_error('login'); ?>
                              <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                              <?php $login_data = array('class' => 'form-control', 'placeholder' => 'Username', 'name' => 'login', 'id' => 'login');
                              echo form_input($login_data);?>
                            </div>
                            </li>
                            <li class="list-group-item">
                              <?php echo form_error('email'); ?>
                              <div class="input-group">
                              <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                              <?php $login_data = array('class' => 'form-control', 'placeholder' => 'Email', 'name' => 'email', 'id' => 'email', 'type'=>'email');
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
                            <a href="<?php echo base_url() . 'login/index';?>"  class="btn btn-default btn-success">
                                Back
                            </a>
                            <button class="btn btn-default btn-primary pull-right" name="submit" type="submit" value="login">
                                Create Account
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
