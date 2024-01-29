<?php
	
	include "../db.php";

	$_del_inf = mysqli_real_escape_string($con_, $_POST['_del_inf']);
	$up_apv = $class_->runS(" UPDATE `user` SET `sell_eligible` = '4' WHERE `id` = '$_del_inf' ");

	if ($up_apv) {
		?> <div class="_notice_pix">Account approval declined.</div> <?php
	}