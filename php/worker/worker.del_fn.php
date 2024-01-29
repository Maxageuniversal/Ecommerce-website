<?php

	include "../db.php";

	$_delfn = $_POST['_delfn'];
	$thread_1 = $class_->runS(" DELETE FROM `flash_news` WHERE `news_header` = '$_delfn' ");

	$getThis_fn = $class_->getP($_delfn);
	$row_tP = mysqli_fetch_assoc($getThis_P);
	}

	if ($thread_0) {
		
		echo "flash_news Removed";
		?>
			<script type="text/javascript">
				$("#_fM<?php echo $_delfn; ?>").slideUp(300, function () {
					$(this).remove();
				});
			</script>
		<?php

	}