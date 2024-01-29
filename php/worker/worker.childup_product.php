<?php

	include "../db.php";
	
	$_cU = $_POST['_cU'];
	$getW_P = $class_->runS("SELECT childup FROM `products` WHERE `id` = '$_cU' ");
	$getW_P_FEt = mysqli_fetch_assoc($getW_P);

	$childup = $getW_P_FEt['childup'];

	if ($childup == "cu") {
		$up_d = $class_->runS(" UPDATE `products` SET `childup` = '-', `womup` = '-' WHERE `id` = '$_cU' ");
		if ($up_d) {
			?>
				<script type="text/javascript">
					$("._fd<?php echo $_cU; ?>").hide(300);
					$("._rC<?php echo $_cU; ?>").css({"background-color": "white", "color": "#000"});
					$("._cU<?php echo $_cU; ?>").css({"background-color": "white", "color": "#000"});
				</script>
			<?php
		}
	} else {
		$up_d = $class_->runS(" UPDATE `products` SET `childup` = 'cu', `womup` = '-' WHERE `id` = '$_cU' ");
		if ($up_d) {
			?>
				<script type="text/javascript">
					$("._fd<?php echo $_cU; ?>").hide(300);
					$("._rC<?php echo $_cU; ?>").css({"background-color": "white", "color": "#000"});
					$("._cU<?php echo $_cU; ?>").css({"background-color": "#00AFEF", "color": "#FFF"});
				</script>
			<?php
		}
	}

?>