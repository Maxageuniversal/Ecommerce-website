<?php

	include "../db.php";

	$delImg = $_POST['delImg'];
	$delImg_Src = $_POST['delImg_Src'];

	$del_img = $class_->runS(" DELETE FROM `sub_products` WHERE `id` = '$delImg' ");

	if ($del_img) {
		unlink("../../" . $delImg_Src);
		echo "Image Removed";
		?>
			<script type="text/javascript">
				$("#eImg<?php echo $delImg; ?>").remove();
			</script>
		<?php
	}