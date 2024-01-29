<?php

	include "../db.php";
	$ct_count = $_POST['ct_count'];

?>

<option value="">-- Select State --</option>

<?php $get_cat = $class_->runS(" SELECT state FROM `user` WHERE `country` = '$ct_count' AND `sell_eligible` = 2 ");

	while ($row__ = mysqli_fetch_assoc($get_cat)) {
		$id = $row__['id'];
		$category = $row__['state']; ?>
			<option value="<?php echo strtolower($category); ?>"><?php echo $class_->Capita($category); ?></option>
		<?php
	}
?>