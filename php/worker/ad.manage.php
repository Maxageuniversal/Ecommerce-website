<?php
	
	include "../db.php";

	$trace_ = $_GET['trace_'];

	if ($trace_ == "sF") {
		
		$sh_fee = mysqli_real_escape_string($con_, $_POST['sh_fee']);

		if ($_POST['sh_fee'] < 0 || !is_numeric($_POST['sh_fee'])) {
			echo "Invalid shipping-fee value!";
			exit();
		}

		$class_->runS(" DELETE FROM `stick_data` WHERE `title` = 'SHIPPING' ");
		$ins_cp = $class_->runS(" INSERT INTO `stick_data` (`title`, `data`, `coupon_trace`) VALUES ('SHIPPING', '$sh_fee', '') ");

		if ($ins_cp) {
			echo "Shipping-fee created";
			?>
				<script type="text/javascript">
					$("._this_cp").css({"border-color": "#0ae14f"});
				</script>
			<?php
		}
	
	} else if ($trace_ == "aB") {
		
		$about = mysqli_real_escape_string($con_, $_POST['about']);

		if (empty($_POST['about'])) {
			echo "Empty field not allowed";
			exit();
		}

		$class_->runS(" DELETE FROM `stick_data` WHERE `title` = 'ABOUT' ");
		$ins_cp = $class_->runS(" INSERT INTO `stick_data` (`title`, `data`, `coupon_trace`) VALUES ('ABOUT', '$about', '') ");

		if ($ins_cp) {
			echo "About-us page updated";
			?>
				<script type="text/javascript">
					$("._this_cp").css({"border-color": "#0ae14f"});
				</script>
			<?php
		}
	
	} else if ($trace_ == "rT") {
		
		$rt_privacy = mysqli_real_escape_string($con_, $_POST['rt_privacy']);

		if (empty($_POST['rt_privacy'])) {
			echo "Empty field not allowed";
			exit();
		}

		$class_->runS(" DELETE FROM `stick_data` WHERE `title` = 'PRIVACY' ");
		$ins_cp = $class_->runS(" INSERT INTO `stick_data` (`title`, `data`, `coupon_trace`) VALUES ('PRIVACY', '$rt_privacy', '') ");

		if ($ins_cp) {
			echo "Return privacy page updated";
			?>
				<script type="text/javascript">
					$("._this_cp").css({"border-color": "#0ae14f"});
				</script>
			<?php
		}
	
	} else if ($trace_ == "sC") {
		
		$coupon = mysqli_real_escape_string($con_, $_POST['coupon']);
		$coupon_code = mysqli_real_escape_string($con_, $_POST['coupon_code']);

		if ($_POST['coupon'] < 0 || !is_numeric($_POST['coupon'])) {
			echo "Invalid coupon value!";
			exit();
		}

		$class_->runS(" DELETE FROM `stick_data` WHERE `title` = 'COUPON' ");
		$ins_cp = $class_->runS(" INSERT INTO `stick_data` (`title`, `data`, `coupon_trace`) VALUES ('COUPON', '$coupon', '$coupon_code') ");

		if ($ins_cp) {
			echo "Coupon activated!";
			?>
				<script type="text/javascript">
					$("._this_cp").css({"border-color": "#0ae14f"});
				</script>
			<?php
		}
	
	} else if ($trace_ == "fN") {

		$news_header = trim(strtolower($_POST['news_header']));

		$chk_cat = $class_->runS(" SELECT news_header FROM `flash_news` WHERE `news_header` = '$news_header' ");
		if (mysqli_num_rows($chk_cat) > 0) {
			echo "Flash-news already exist!";
			exit();
		} else {
			$class_->runS(" INSERT INTO `flash_news` (`news_header`, `date_time`) VALUES ('$news_header', '$date_') ");
			echo "Flash-news " . $news_header . " created!";
		}

	} else if ($trace_ == "dN") {

		$db_news = trim($_POST['db_news']);

		$check_fn = $class_->runS(" SELECT id FROM `flash_news` WHERE `news_type` = 'DB' ");
		if (mysqli_num_rows($check_fn) > 0) {
			$class_->runS(" UPDATE `flash_news` SET `news_header` = '$db_news' WHERE `news_type` = 'DB' ");
			echo "Dashboard news updated!";
			exit();
		} else {
			$class_->runS(" INSERT INTO `flash_news` (`news_header`, `date_time`, `news_type`) VALUES ('$db_news', '$date_', 'DB') ");
			echo "Dashboard news created!";
		}

	} else if ($trace_ == "mC") {

		$category = trim(strtolower($_POST['category']));

		$chk_cat = $class_->runS(" SELECT category FROM `category` WHERE `category` = '$category' ");
		if (mysqli_num_rows($chk_cat) > 0) {
			echo "Category already exist!";
			exit();
		} else {
			$class_->runS(" INSERT INTO `category` (`category`) VALUES ('$category') ");
			echo "Category " . $category . " created!";
		}

	} else if ($trace_ == "mSC") {

		$category = trim(strtolower($_POST['category']));
		$sub_category = trim(strtolower($_POST['sub_category']));

		if ($category == null || $sub_category == null) {
			echo "All field is required!";
			exit();
		}

		$chk_cat = $class_->runS(" SELECT category, sub_category FROM `sub_category` WHERE  `category` = '$category' AND `sub_category` = '$sub_category' ");
		if (mysqli_num_rows($chk_cat) > 0) {
			echo "Sub-Category already exist under '" . $category . "'!";
			exit();
		} else {
			$class_->runS(" INSERT INTO `sub_category` (`category`, `sub_category`) VALUES ('$category', '$sub_category') ");
			echo "Sub-Category " . $sub_category . " created under '" . $category . "'!";
		}

	} else if ($trace_ == "mSSC") {

		$category = trim(strtolower($_POST['category']));
		$sub_category = trim(strtolower($_POST['sub_category']));
		$sub_sub_category = trim(strtolower($_POST['sub_sub_category']));

		if ($category == null || $sub_category == null || $sub_sub_category == null) {
			echo "All field is required!";
			exit();
		}

		$chk_cat = $class_->runS(" SELECT category, sub_category, sub_sub_category FROM `sub_sub_category` WHERE  `category` = '$category' AND `sub_category` = '$sub_category' AND `sub_sub_category` = '$sub_sub_category' ");
		if (mysqli_num_rows($chk_cat) > 0) {
			echo "Sub Sub-Category already exist under '" . $sub_category . "'!";
			exit();
		} else {
			$class_->runS(" INSERT INTO `sub_sub_category` (`category`, `sub_category`, `sub_sub_category`) VALUES ('$category', '$sub_category', '$sub_sub_category') ");
			echo "Sub Sub-Category " . $sub_sub_category . " created under '" . $sub_category . "'!";
		}

	} else if ($trace_ == "mB") {

		$category = trim(strtolower($_POST['category']));
		$brand_name = trim(strtolower($_POST['brand_name']));

		// -----------------------------------------------------------------------

		$img_1 = $_FILES['img_1']['name'];
		$img_1_tmp = $_FILES['img_1']['tmp_name'];
		$img_1_ext = substr($img_1, -3);

		if ($brand_name == null) {
			echo "All field is required!";
			exit();
		}

		$img_1_size = $_FILES['img_1']['size'];
		if (($img_1_size/1024) > 1000 || $img_1_size == 0) {
			echo "Invalid image, 1000kb max image size!";
			exit();
		}

		if ($img_1_ext == null) {
			echo "Please select at leaset one image!";
			exit();
		} else if (!in_array($img_1_ext, $_ary_img_act)) {
			echo "Only JPG and PNG file accepted!";
			exit();
		}

		$img_1 = md5($brand_name)."br_img.".$img_1_ext;

		// -----------------------------------------------------------------------

		$chk_cat = $class_->runS(" SELECT brand_name FROM `brand` WHERE  `brand_name` = '$brand_name' ");
		if (mysqli_num_rows($chk_cat) > 0) {

			echo "Brand already exist under!";
			exit();

		} else {

			move_uploaded_file($img_1_tmp, "../../images/_brand/".$img_1);

			$class_->runS(" INSERT INTO `brand` (`image`, `brand_name`, `category`) VALUES ('$img_1', '$brand_name', '$category') ");
			echo "Brand " . $brand_name . " created under " . $category;

		}

	} else if ($trace_ == "mBi") {

		$type = mysqli_real_escape_string($con_, trim(strtolower($_POST['type'])));
		$category = mysqli_real_escape_string($con_, trim(strtolower($_POST['category'])));
		$board_link = mysqli_real_escape_string($con_, trim(strtolower($_POST['board_link'])));
		$position = mysqli_real_escape_string($con_, trim(strtolower($_POST['position'])));

		// -----------------------------------------------------------------------

		$img_1 = $_FILES['img_1']['name'];
		$img_1_tmp = $_FILES['img_1']['tmp_name'];
		$img_1_ext = substr($img_1, -3);

		if ($category == null || $board_link == null || $type == null || $board_link == $position) {
			echo "All field is required!";
			exit();
		}

		$img_1_size = $_FILES['img_1']['size'];
		if (($img_1_size/1024) > 1000 || $img_1_size == 0) {
			echo "Invalid image, 1000kb max image size!";
			exit();
		}

		if ($img_1_ext == null) {
			echo "Please select at leaset one image!";
			exit();
		} else if (!in_array($img_1_ext, $_ary_img_act)) {
			echo "Only JPG and PNG file accepted!";
			exit();
		}

		$img_1 = md5($position)."br_img.".$img_1_ext;

		// -----------------------------------------------------------------------

		$chk_bb = $class_->runS(" DELETE FROM `billboard` WHERE  `position` = '$position' ");
		
		move_uploaded_file($img_1_tmp, "../../images/_board/".$img_1);

		$class_->runS(" INSERT INTO `billboard` (`type`, `position`, `image`, `link`, `category`) VALUES ('$type', '$position', '$img_1', '$board_link', '$category') ");
		echo "Billboard " . $position . " created!";

	}

?>