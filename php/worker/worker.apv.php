<?php
	
	include "../db.php";

	$_app_inf = mysqli_real_escape_string($con_, $_POST['_app_inf']);
	$up_apv = $class_->runS(" UPDATE `user` SET `sell_eligible` = '2' WHERE `id` = '$_app_inf' ");

	if ($up_apv) {
		?> <div class="_notice_pix_g">Congrats! Account approved for Business.</div> <?php
	}