<div class="ourcenter">

<h2>Submit order</h2>

<?php
  if(isset($show_output)){
    echo $show_output;
  }

  if($this->session->userdata['total_quantity'] <= 0 && !isset($this->session->userdata['redirect_value'])){
    echo "Warning: You have no items in your cart<br>";
  }

    if(isset($this->session->userdata['redirect_value'])){
      echo $this->session->userdata['redirect_value'].'<br>';
      $this->session->unset_userdata('redirect_value');
    }

  echo form_open('checkout/verify_user_info');
?>

<?php
?>

<div class="container-fluid">
<div class="row vertical-center-row">
<div class="col-lg-12">
<div class="row ">
<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-6 col-xs-offset-3">


  <ul class="list-group">
    <li class="list-group-item">
      <?php echo form_error('cnum'); ?>
      <div class="input-group">
      <span class="input-group-addon">Credit Card Number</span>
      <?php $cnum_data = array('class' => 'form-control', 'pattern' => '[0-9]{16}','placeholder' => 'XXXXXXXXXXXXXXXX', 'name' => 'cnum', 'id' => 'cnum');
      echo form_input($cnum_data);?>
    </div>
    </li>
    <li class="list-group-item">
      <?php echo form_error('expmonth'); ?>
      <div class="input-group">
      <span class="input-group-addon">Expiration Month</span>
      <?php $month_data = array('class' => 'form-control', 'pattern' => '[0-9]{2}', 'placeholder' => 'MM', 'name' => 'expmonth', 'id' => 'expmonth', 'type' => 'number');
      echo form_input($month_data);?>
    </div>
    </li>
    <li class="list-group-item">
      <?php echo form_error('expyear'); ?>
      <div class="input-group">
      <span class="input-group-addon">Expiration Year</span>
      <?php $year_data = array('class' => 'form-control', 'pattern' => '[0-9]{2}', 'placeholder' => 'YY', 'name' => 'expyear', 'id' => 'expyear', 'type' => 'number');
      echo form_input($year_data);?>
    </div>
    </li>
  </ul>
  <button class="btn btn-default btn-primary pull-right" name="submit" type="submit" value="submit">
      Submit order
  </button>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
