<?php
	
	include "../db.php";

	$consumer = strtolower(mysqli_real_escape_string($con_, $_POST['consumer'])); 
	$retailer = strtolower(mysqli_real_escape_string($con_, $_POST['retailer'])); 
	$full_name = strtolower(mysqli_real_escape_string($con_, $_POST['full_name'])); 
	$sex = strtolower(mysqli_real_escape_string($con_, $_POST['sex']));
	$address = strtolower(mysqli_real_escape_string($con_, $_POST['address'])); 
	$phone = strtolower(mysqli_real_escape_string($con_, $_POST['phone']));
	$state = strtolower(mysqli_real_escape_string($con_, $_POST['state']));
	$country = strtolower(mysqli_real_escape_string($con_, $_POST['country']));

	foreach ($_POST as $key => $value) {
		if ($value == null && $key != "consumer" && $key != "retailer") {
			echo "All field is important";
			exit();
		}
	}

	if ($_POST['consumer'] == null && $_POST['retailer'] == null) {
		echo "Account type not selected!";
		exit();
	} 

	if ($this_buy_eligible == 1) {
		$notice_ = "Your account is activated for buying!";
	} else {
		$notice_ = "Account updated!";
	}


	$get_u = $class_->runS("UPDATE `user` SET `full_name` = '$full_name', `phone` = '$phone', `state` = '$state', `country` = '$country', `address` = '$address', `sex` = '$sex', `consumer` = '$consumer', `retailer` = '$retailer', `buy_eligible` = '2' WHERE `u_id` = '$this_u_id'");

	?>
		<script type="text/javascript">
			$("._bbY_d").attr("disabled","disabled");
			$("._no_PP").html("<?php echo $notice_; ?> <img style='height: 10px;' src='./asset/91.gif'> ").css({"background": "#FFF", "color": "#000"});
			setTimeout(function () {
				window.location = "";
			}, 2000, false);
		</script>
	<?php

?>