<?php

	// IN CASE OF EMERGENCY BREAK GLASS
	// ini_set('display_errors', 1); error_reporting(E_ALL);

	require_once ('db.php'); 
	$db = new db();

?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Amazon AWS IoT Button Demo</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<script>
			function check(){
				$.ajax({
					type: 'POST',
					url: 'checker.php',
					dataType: 'json',
					data: {
						counter:$('#message-list').data('counter')
					}
				}).done(function( response ) {
					/* update counter */
					$('#message-list').data('counter',response.current);
					/* check for update */
					if(response.update==true){
						$('#message-list').html(response.click);
					}
				});
			}
			// Check for new update every X milliseconds; (e.g., 3000 = 3 seconds)
			// Set a longer interval to reduce the impact on website stats 
			setInterval(check,3000);
		</script>

	</head>
	<body>

		<h2>Amazon AWS IoT Button </h2>
			<section style="text-align: center; width: 215px">
					<div id="message-list" data-counter="<?php echo (int)$db->check_changes();?>">
						<?php  echo $db->get_clicks();
						?>
					</div>
			</section>


<?php // DESCRIPTIVE TEXT BEGIN ?>
		<hr />
		<p>If everything is working, the text above the line will change when you click your AWS IoT button. <br/>
		Since the page uses jQuery, you do not need to refresh the page to see the change.</p>

		<h2>Overview</h2>
		<h3>At Remote Location...</h3>
			<ul>
				<li>IoT Button (click)</li>
				<li>WiFi + Security Keys</li>
				<li>Internet</li>
				<li>AWS Lambda Function</li>
				<li>POST to PHP/MySQL located at this website</li>
			</ul>
		<h3>Meanwhile, on this website...</h3>
			<ul>
				<li>PHP</li>
				<li>MySQL</li>
				<li>HTML</li>
				<li>JQuery (provides live updates)</li>
			</ul>
		<h3>Download the Code</h3>
		<p><a href="https://github.com/zdrive/aws-iot-button-php">https://github.com/zdrive/aws-iot-button-php</a></p>

<?php // DESCRIPTIVE TEXT END ?>


		<!-- Scripts -->
			<script src="jquery.min.js"></script>

	</body>
</html>
