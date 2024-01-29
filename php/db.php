<?php

	error_reporting(0);
	 $con_ = mysqli_connect("localhost", "root", "", "yossell");
// $con_ = mysqli_connect("localhost", "alltrade_yossell", "Maxwell@365", "alltrade_yossellname");

	 
	$date_ = date("d-M-Y H:i:s a");
	$date_a = strtotime(date("d-M-Y"));
	$date_y = strtotime(date("d-M-Y", strtotime("-1 day")));
	$date_7 = strtotime(date("d-M-Y", strtotime("-7 days")));
	$date_30 = strtotime(date("d-M-Y", strtotime("-30 days")));
	$date_90 = strtotime(date("d-M-Y", strtotime("-90 days")));

	$expire_d = time()+(60*60*24*5);
	$time_stamp = time()+(60*60*24*5);

    $_ary_img_act = array("png", "peg", "jpeg", "jpg", "gif", "mp4");
	$cur_currency = "₦";
	include "class.php"; $class_ = new xClass();
	$on_ = 0;

	// ------------------ S_FD
	date_default_timezone_set("GMT+01:00 West Africa Standard Time");

	$fd_d = date("Ymd");
	$tf = $class_->getFDTF();
	$tf_c_DWN = $class_->tf_c_DWN($tf);
	// ------------------------------------- FD

$rt_policy = "7 day Return & Refund If Eligible";
 //$del_time = "Within 24 Hours - 18 Business Days";
	$warranty = "Depending On Item the warranty Period Maybe Different";
	$shipping_method = array("visa" => "visa.png", "mcard" => "mcard.png", "wiretransfer" => "wiretransfer.png",  );
	$payment_gateway =  array("cards" => "cards.png");
	$moneyback =  array("moneyback" => "moneyback.jpg");
	$facebook =  array("facebook" => "facebook.png");
	$instagram =  array("instagram" => "instagram.png");
	$whatsapp =  array("whatsapp" => "whatsapp.png");
	$call =  array("call" => "call.png");
	$orders =  array("orders" => "orders.png");
	$help =  array("help" => "help.png");
	$feedback =  array("feedback" => "feedback.png");
	$callus =  array("callus" => "callus.png");
	

	$this_get_cp = $class_->runS("SELECT * FROM `stick_data` WHERE `title` = 'COUPON' ");
	$this_cp_row = mysqli_fetch_assoc($this_get_cp);
	$all_coupon = $this_cp_row['data'];
	$all_coupon_trace = $this_cp_row['coupon_trace'];

	$this_get_abt = $class_->runS("SELECT * FROM `stick_data` WHERE `title` = 'ABOUT' ");
	$this_abt_row = mysqli_fetch_assoc($this_get_abt);
	$all_about = $this_abt_row['data'];

	$this_get_prv = $class_->runS("SELECT * FROM `stick_data` WHERE `title` = 'PRIVACY' ");
	$this_prv_row = mysqli_fetch_assoc($this_get_prv);
	$all_privacy = $this_prv_row['data'];

	$this_get_shp_f = $class_->runS("SELECT * FROM `stick_data` WHERE `title` = 'SHIPPING' ");
	$this_shp_f_row = mysqli_fetch_assoc($this_get_shp_f);
	$all_ship_f = $this_shp_f_row['data'];

	$sup_store_owner = "WU6QP111532100796";

	$get_s_u = $class_->runS(" SELECT phone FROM `user` WHERE `u_id` = '$sup_store_owner' ");
	$row_su = mysqli_fetch_assoc($get_s_u);
	$this_s_u_phone = $row_su['phone'];

	if (isset($_COOKIE['_tporta'])) {

		$this_user = $_COOKIE['_tporta'];

		$get_u = $class_->runS("SELECT * FROM `user` WHERE `email` = '$this_user' ");
		$check_g_u = $class_->row($get_u);

		if ($check_g_u > 0) {

			$on_ = 1;

			$row = mysqli_fetch_assoc($get_u);

			$thisId = $row['id'];
			$this_u_id = $row['u_id'];
			$this_email = $row['email'];
			$this_full_name = $row['full_name'];

			$this_image = $row['image'];
			$this_cart_id = $row['cart_id'];

			$reserved_admin = array("WU6QP111532100796");

			$get_cart = $class_->runS(" SELECT * FROM `cart` WHERE `user` = '$this_u_id' ");
			$total_cart = mysqli_num_rows($get_cart)+0;

			$this_sex = $row['sex'];
			$this_state = $row['state'];
			$this_country = $row['country'];
			$this_consumer = $row['consumer'];
			$this_retailer = $row['retailer'];
			$this_address = $row['address'];
			$this_phone = $row['phone'];
			$this_buy_eligible = $row['buy_eligible'];
			
			$this_seller_manufacturer = $row['seller_manufacturer'];
			$this_seller_retailer = $row['seller_retailer'];
			$this_business_name = $row['business_name'];
			$this_company_certificate = $row['company_certificate'];
			$this_b_date = $row['b_date'];
			$this_b_phone = $row['b_phone'];
			$this_sell_eligible = $row['sell_eligible'];

			$this_a_o_spec = $row['a_o_spec'];
			$this_s_cat = $row['s_cat'];
			$this_b_loc = $row['b_loc'];
			$this_b_phone = $row['b_phone'];

			$this_service_description = $row['service_description'];
			$this_service_eligible = $row['service_eligible'];

			$this_date_joined = $row['date_joined'];
			$this_my_coupon = $row['my_coupon']+0;
			$this_used_coupon = $row['used_coupon'];

			$admin_ = 0;
			if (in_array($this_u_id, $reserved_admin)) {
				$admin_ = 1;
				$this_sell_eligible = 2;
			}

			$this_email_list = $row['email_list'];

			$this_get_Nty = $class_->runS("SELECT id FROM `notification` WHERE `receiver` = '$this_u_id' AND `status` = '0' ");
			$notify__ = mysqli_num_rows($this_get_Nty) + 0;

			$get_db_news = $class_->runS(" SELECT * FROM `flash_news` WHERE `news_type` = 'DB' ");
			$get_db_news_f = mysqli_fetch_assoc($get_db_news);
			$this_news_header = $get_db_news_f['news_header'];
			$this_date_time = $get_db_news_f['date_time'];

		} else {
			$on_ = 0;
		}

	}

?>