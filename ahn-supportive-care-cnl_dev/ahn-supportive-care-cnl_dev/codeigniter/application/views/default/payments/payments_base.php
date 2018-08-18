<?php

$course_price = $course['course_price'];
$course_name = $course['course_name'];

?>

<h3>Enter Payment Information Below to Access the <?php echo $course['course_name'] ?> Course</h3>

<?php if($this->session->flashdata('payments_error')): ?>
	<p class="bg-danger" style="padding:10px;">
		<strong>Error:</strong> <?php echo $this->session->flashdata('payments_error'); ?>
	</p>
<?php endif; ?>

<?php if(ENVIRONMENT !== 'production'): ?>
	<p class="bg-info" style="padding:10px;">
		<strong>In Sandbox Mode:</strong> View the <a href="https://developers.braintreepayments.com/reference/general/testing/ruby#credit-card-numbers" target="_blank">Braintree Documentation</a> for test Credit Card and CVV\CID numbers.
	</p>
<?php endif; ?>


<form id="checkout" method="post" action="payments/checkout">
  <div id="payment-form"></div>
  <input type="submit" class="btn btn-info" value="Pay $<?php echo $course_price; ?>">
</form>

<script src="https://js.braintreegateway.com/js/braintree-2.20.0.min.js"></script>

<script>
	var client_token = "<?php echo $client_token; ?>";

  braintree.setup(
    // Replace this with a client token from your server
    client_token,
    "dropin", {
      container: "payment-form"
    });
</script>