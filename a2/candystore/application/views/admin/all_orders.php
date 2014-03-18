<div class="ourcenter">
<h1>Order History</h1>
<p>Displayed below is the order history. This consists of every finalized order
  that has been conducted through our system.</p>

<?php
    if(isset($order_history)){
      echo $order_history;
    } else {
      echo 'Error loading Order History';
    }
?>

</div>
