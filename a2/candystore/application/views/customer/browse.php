<div class="ourcenter"><br><?php

  if(isset($browse_data_customer)){
    echo $browse_data_customer;
  } else if (isset($browse_data)){
    echo $browse_data;
  } else {
    echo 'Error loading page information';
  }

?>
</div>
