<?php

	include "../db.php";
	
	$_bK = $_POST['_bK'];
	$getW_P = $class_->runS("SELECT bookslovers FROM `products` WHERE `id` = '$_bK' ");
	$getW_P_FEt = mysqli_fetch_assoc($getW_P);

	$bookslovers = $getW_P_FEt['bookslovers'];

	if ($bookslovers == "bk") {
		$up_d = $class_->runS(" UPDATE `products` SET `bookslovers` = '-', `petsworld` = '-' WHERE `id` = '$_bK' ");
		if ($up_d) {
			?>
				<script type="text/javascript">
					$("._fd<?php echo $_bK; ?>").hide(300);
					$("._rC<?php echo $_bK; ?>").css({"background-color": "white", "color": "#000"});
					$("._bK<?php echo $_bK; ?>").css({"background-color": "white", "color": "#000"});
				</script>
			<?php
		}
	} else {
		$up_d = $class_->runS(" UPDATE `products` SET `bookslovers` = 'bk', `petsworld` = '-' WHERE `id` = '$_bK' ");
		if ($up_d) {
			?>
				<script type="text/javascript">
					$("._fd<?php echo $_bK; ?>").hide(300);
					$("._rC<?php echo $_bK; ?>").css({"background-color": "white", "color": "#000"});
					$("._bK<?php echo $_bK; ?>").css({"background-color": "#00AFEF", "color": "#FFF"});
				</script>
			<?php
		}
	}

?>