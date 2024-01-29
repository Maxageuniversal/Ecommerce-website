<?php
	
	include "../db.php";

	$p_name = strtolower(mysqli_real_escape_string($con_, $_POST['p_name']));
	$price_range = strtolower(mysqli_real_escape_string($con_, $_POST['price_range']));
	$p_desc = mysqli_real_escape_string($con_, $_POST['p_desc']);
	$p_brand = strtolower(mysqli_real_escape_string($con_, $_POST['p_brand']));
	$discount = strtolower(mysqli_real_escape_string($con_, $_POST['discount']));
	$model_number = strtolower(mysqli_real_escape_string($con_, $_POST['model_number']));

	$category = strtolower(mysqli_real_escape_string($con_, $_POST['category']));
	$sub_category = strtolower(mysqli_real_escape_string($con_, $_POST['sub_category']));
	$sub_sub_category = strtolower(mysqli_real_escape_string($con_, $_POST['sub_sub_category']));

	$p_spec = strtolower(mysqli_real_escape_string($con_, $_POST['p_spec']));

	if (strlen(trim($_POST['category'])) == 0 || strlen(trim($_POST['sub_category'])) == 0 || strlen(trim($_POST['sub_sub_category'])) == 0) {
		echo "Please select category, sub-category and sub sub-category!";
		exit();
	}

	$time_s = time();

	$add_ = $class_->runS(" INSERT INTO `products` (`client_p`, `store_owner`, `name`, `model_number`, `price_range`, `discount`, `description`, `brand`, `category`, `sub_category`, `sub_sub_category`, `rated`, `total_rated`, `time_stamp`, `date_time`, `key_features`, `flash_deal_d`, `flash_deal_tf`, `recommend`, `sponsored`, `p_spec`) VALUES ('1', '$this_u_id', '$p_name', '$model_number', '$price_range', '$discount', '$p_desc', '$p_brand', '$category', '$sub_category', '$sub_sub_category', '0', '0', '$time_s', '$date_', '', '', '-', '-', '-', '$p_spec') ");

	if ($add_) {
		echo "1_" . $con_->insert_id;
	}

?>