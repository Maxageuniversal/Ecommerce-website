<?php
	
	include "php/db.php";

	if (isset($_GET['cart']) && $on_ == 0) {
		header("Location: ./?login");
	}

	if (isset($_GET['de_l_c'])) {
		$de_l_c = $_GET['de_l_c'];
		$class_->runS(" DELETE FROM `cart` WHERE `cart_thumb_id` = '$de_l_c' ");
		header("Location: ./?cart");
	}

	if (isset($_GET['cart']) && isset($_GET['dinv'])) {
		$new_c_id = $this_u_id.time();
		$class_->runS(" UPDATE `user` SET `cart_id` = '$new_c_id' WHERE `u_id` = '$this_u_id' ");
		$class_->runS(" DELETE FROM `invoice` WHERE `invoice_id` = '$this_cart_id' ");
		header("Location: ./?cart");
	}

	$desh_code = $class_->en(str_shuffle($this_cart_id)."xuIvX".$class_->en($class_->en($this_cart_id))."xuIvX".str_shuffle($this_cart_id));

	if (isset($_GET['_bnc'])) {

		$pay_desh_code = $class_->en($_bn_quanty."-".$_bn_thumb."-".$_bn_var."-".$_bn_price);

		$pay_desh_code = $_GET['_bnc'];

		$bn_data_ = explode("-", $_GET['_bnc']);

		$_bn_quanty = $_GET['qt'];
		$_bn_color = $_GET['th_col'];
		$_bn_thumb = $_GET['th_i'];
		$_bn_p_id = $_GET['product_v'];
		$_bn_var = $bn_data_[0];
		$_bn_price = $bn_data_[1]*$_bn_quanty;

		$this_buy_cart_id = $this_u_id.time();

		$this_bn_gP = $class_->getP($_bn_p_id);
		$this_bn_gPF = mysqli_fetch_assoc($this_bn_gP);
		$bn_store_owner = $this_bn_gPF['store_owner'];

		$class_->runS(" INSERT INTO `invoice` (`user`, `invoice_id`, `address`, `phone`, `email`, `date_time`, `coupon`, `shipping_fee`, `status`) VALUES ('$this_u_id', '$this_buy_cart_id', '$this_address', '$this_phone', '$this_email', '$date_', '', '$all_ship_f', 'PAID') ");

		$class_->runS(" UPDATE `sub_products` SET `purchased` = purchased+1 WHERE `id` = '$_bn_thumb' ");
		$class_->runS(" INSERT INTO `orders` (`seller_id`, `user`, `date_time`, `quantity`, `price`, `color`, `size`, `capacity`, `product_id`, `thumb_p_id`, `invoice_id`, `tracking_status`, `tracking_label`, `status`, `date_stamp`, `f_status`, `p_status`, `tr_time`, `tr_loc`, `tr_day`, `paid_status`) VALUES ('$bn_store_owner', '$this_u_id', '$date_', '$_bn_quanty', '$_bn_price', '$_bn_color', '$_bn_var', '$_bn_var', '$_bn_p_id', '$_bn_thumb', '$this_buy_cart_id', '', '', '0', '$date_a', 'UNCLAIMED', 'UNPAID', '-', '-', '-', 'PAID') ");

		header("Location: ./?product_v=".$_bn_p_id);

	}

	if (isset($_GET['_q'])) {
		$_q = $_GET['_q'];
		$d1 = $class_->den($_q);
		$d2 = $class_->den($class_->den(explode("xuIvX", $d1)[1]));
		$new_c_id = $this_u_id.time();
		$class_->runS(" DELETE FROM `cart` WHERE `user` = '$this_u_id' ");
		$class_->runS(" UPDATE `invoice` SET `status` = 'PAID' WHERE `invoice_id` = '$this_cart_id' ");

		$ord_npy = $class_->runS(" SELECT * FROM `orders` WHERE `paid_status` = 'UNPAID' AND `invoice_id` = '$this_cart_id' ");
		$coupon_collected = array();

		while ($row_ord_npy = mysqli_fetch_assoc($ord_npy)) {

			$id_ord = $row_ord_npy['id'];
			$seller_id_ = $row_ord_npy['seller_id'];
			$ord_npy_thumb_id = $row_ord_npy['thumb_p_id'];

			// Purchased
			$class_->runS(" UPDATE `sub_products` SET `purchased` = purchased+1 , `reached_checkout` = reached_checkout-1, `added_to_cart` = added_to_cart-1 WHERE `id` = '$ord_npy_thumb_id' ");
			
			$class_->runS(" UPDATE `orders` SET `paid_status` = 'PAID' WHERE `id` = '$id_ord' ");

			if (!in_array($seller_id_, $coupon_collected)) {
				$class_->runS(" INSERT INTO `coupon` (`coupon`, `store_owner`, `date_time`, `user`) VALUES ('$ord_this_store_coupon', '$seller_id_', '$date_', '$this_u_id') ");
				$coupon_collected[] = $seller_id_;
				$class_->pushN("Yossell", $this_u_id, "You have received coupon of " . $ord_this_store_coupon . " for your next purchase");

			}
			
		}

		$class_->runS(" UPDATE `user` SET `cart_id` = '$new_c_id' WHERE `u_id` = '$this_u_id' ");
		header("Location: ./");
	}

	if (isset($_POST['_c_inv'])) {

		$ch_inv_ = $class_->runS(" SELECT * FROM `invoice` WHERE `invoice_id` = '$this_cart_id' AND `status` = 'UNPAID' ");
		if (mysqli_num_rows($ch_inv_) == 0) {
			
			$address = $_POST['address'];
			$phone = $_POST['phone'];
			$email = $_POST['email'];
		
		$class_->runS(" INSERT INTO `invoice` (`user`, `invoice_id`, `address`, `phone`, `email`, `date_time`) VALUES ('$this_u_id', '$this_cart_id', '$address', '$phone', '$email', '$date_') ");

		}

		header("Location: ./?cart");

	}

	// icon();

	function icon()
	{
		$letters = "`1234567890-=~!@#$%^&*()_+';|}{\?><,./][';/./.,<>?`~abcdefghijklmnopqurstuvwxyzABCDEFGHIJKLMNOPQURSTUVWXYZ";
		for ($i=0; $i < strlen($letters); $i++) { 
			echo $letters[$i] ." - <p class='pa'>" . $letters[$i] . "</p> <br>"; 
		}
	}

	if ((isset($_GET['register']) || isset($_GET['login'])) && $on_ == 1) {
		header("Location: ./");
	}

	if (isset($_GET['logout']) && $on_ == 1) {
		setcookie("_tporta", $_COOKIE['_tporta'], strtotime("-1 day"), "/");
		header("Location: ./");
	}

	if (isset($_GET['clear_cart']) && $on_ == 1) {
		$class_->runS(" DELETE FROM `cart` WHERE `user` = '$this_u_id' ");
		header("Location: ./?cart");
	}

	if (isset($_POST['_lgV_'])) {

		$password = $_POST['password'];
		$e_mail =$_POST['e_mail'];

		if (strlen(trim($_POST['password'])) == 0 || strlen(trim($_POST['e_mail'])) == 0) {
			$_resp_ = "Login failed";
		}

		$get_u = $class_->runS("SELECT * FROM `user` WHERE `email` = '$e_mail' AND `password` = '$password' ");
		$check_g_u = $class_->row($get_u);

		if ($check_g_u == 1) {
			setcookie("_tporta", $_POST['e_mail'], strtotime("+1 month"), "/");
			header("Location: ./");
		} else {
			$_resp_ = "Login not correct!";
		}

	}

	if (isset($_POST['_rTV_'])) {

		$e_mail = mysqli_real_escape_string($con_, strtolower(trim($_POST['e_mail'])));
		$get_u = $class_->runS(" SELECT * FROM `user` WHERE `email` = '$e_mail' ");
		$check_g_u = $class_->row($get_u);

		if ($check_g_u == 1 && !empty($e_mail)) {

			$get_u_ft = mysqli_fetch_assoc($get_u);

			$rt_this_u_id = $get_u_ft['u_id'];
			$rt_this_email = $get_u_ft['email'];
			$rt_this_full_name = $get_u_ft['full_name'];
			$rt_this_password = $get_u_ft['password'];

			$message ='<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>Yossell -Global trade platform</title></head><body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;"><div style="padding:10px; background:#333; font-size:24px; color:#CCC;"><a href="http://www.Yossell.com"><img src="http://www.Yossell.com/asset/yossell.png" width="36" height="30" alt="Yossell" style="border:none; float:left;"></a>Yossell User Account Private Information</div><div style="padding:24px; font-size:17px;">Hello '.$rt_this_full_name.', <br />Here are Your Yossell Account Information: <br /> Email: '. $rt_this_email . "<br>Password: " . $rt_this_password;', Click the link below to activate your buying or selling account when ready:<br /><br /><a href="http://www.Yossell.com">To Log you back in now</a><br /><br />Ensure to keep your account information private</b></div></body></html>';
			$class_->sendMail($rt_this_email, "ACCOUNT INFORMATION", $message, "<no-reply@yossell.com>");

			$_resp_ = "Check your email for Account Private Information!";

		} else {
			$_resp_ = "User not found!";
		}

	}

	if (isset($_POST['_rGst_'])) {

		$display_n = mysqli_real_escape_string($con_, strtolower(trim($_POST['display_n'])));
		$full_name = mysqli_real_escape_string($con_, strtolower(trim($_POST['full_name'])));
		$e_mail = mysqli_real_escape_string($con_, strtolower(trim($_POST['e_mail'])));
		$password = mysqli_real_escape_string($con_, strtolower(trim($_POST['password'])));
		$re_type_password = mysqli_real_escape_string($con_, strtolower(trim($_POST['re_type_password'])));

		$get_u_d_name = $class_->runS(" SELECT display_name FROM `user` WHERE `display_name` = '$display_n' ");
		$check_g_u_d_name = $class_->row($get_u_d_name);

		$get_u = $class_->runS(" SELECT email FROM `user` WHERE `email` = '$e_mail' ");
		$check_g_u = $class_->row($get_u);

		if (strlen(trim($_POST['display_n'])) == 0 || strlen(trim($_POST['full_name'])) == 0 || strlen(trim($_POST['e_mail'])) == 0 || strlen(trim($_POST['password'])) == 0 || strlen(trim($_POST['re_type_password'])) == 0) {
			$_resp_ = "All field is required!";
		} else if ($password !== $re_type_password) {
			$_resp_ = "Password do not match!";
		} else if (strlen(trim($password)) < 6) {
			$_resp_ = "Minimum of six(6) characters for password!";
		} else if (strlen(trim($full_name)) < 3) {
			$_resp_ = "Fullname too short!";
		} else if ($check_g_u_d_name > 0) {
			$_resp_ = "Phone number already exist!";
		} else if ($check_g_u > 0) {
			$_resp_ = "Email already exist!";
		} else {			

			$cart_idnw = uniqid();
			$u_id = strtoupper(str_replace(" ", null, $class_->en($display_n).time()));

			$db_ = $class_->runS(" INSERT INTO `user` (`u_id`, `display_name`, `brand_name`, `email`, `password`, `full_name`, `image`, `phone`, `state`, `country`, `address`, `sex`, `account_type`, `retailer`, `consumer`, `buy_eligible`, `seller_manufacturer`, `seller_retailer`, `business_name`, `company_certificate`, `b_phone`, `b_date`, `b_loc`, `s_cat`, `sell_eligible`, `a_o_spec`, `service_description`, `service_eligible`, `date_joined`, `cart_id`, `email_list`) VALUES ('$u_id', '$display_n', '-', '$e_mail', '$password', '$full_name', '---', '-', '-', '-', '-', '-', '-', '-', '-', '1', '-', '-', '-', '-', '-', '-', '-', '', '1', '-', NULL, '1', '$date_', '$cart_idnw', '0') ");

			if (!$db_) {
				$_resp_ = "Registration failed!";
			} else {
				$class_->pushN("yossell", $u_id, "Congrats!!! you now own a yossell account. Click your profile icon to Sign-Up as a buyer or a seller .");
				$_resp_ = "Registration successful!";

				setcookie("_tporta", $_POST['e_mail'], strtotime("+1 month"), "/");
				if (isset($_GET['triv'])) {
					header("Location: ./?product_v=" . $_GET['triv']);
				} else {
					header("Location: ./");
				}
				
			}
						
		}

	}

?>

<!--First top header starts here-->

	<!DOCTYPE html>
	<html>
	<head>
	 
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
	
	<link rel="icon"" href="./asset/yossell.png"> 
	<title>Yossell Global Trade Platform - Online Shoppng For consumer Products, |  Fashion | Technology | Smart Home Equipments| Kitchen | Clothing | Life </title>
	<!-- Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="#ff6600" />
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="#ff6600">
<!-- iOS Safari -->
	<meta name="apple-mobile-web-app-status-bar-style" content="#ff6600">
	<!-- iOS Safari -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
	<meta property="og:locale" content="en_US" />
	
	<meta property="og:type" content="website">
	<meta property="og:image:width" content="1200"> 
	<meta property="og:image:height" content="630">

    <meta property="og:url" content="www.yossell.com" />
	<meta property="og:title" content="https://www.yossell.com/ - Global Trade Platform" />
	<meta property="og:description" content=" Fashion | Technology | Smart Home | Kitchen | Clothing | Life | Consumers Product | " />
	<script type="text/javascript" src="./js/js.lib.js"></script>
	<script type="text/javascript" src="./js/10.js"></script>
	<script type="text/javascript" src="./js/cvas.js"></script>
	<link rel="stylesheet" type="text/css" href="./style/10.css">
	
	<link rel="stylesheet" type="text/css" href="./style/swiper.min.css">

	<script type="text/javascript" src="./js/swiper.min.js"></script> 

	<link rel="stylesheet" type="text/css" href="style/animate.css">
	<script type="text/javascript" src="wow.min.js"></script>  
	<script type="text/javascript" src="wow.js"></script> 
	
     <script src="https://js.paystack.co/v1/inline.js">

	<script type="text/javascript" src="http://cdn.howcode.org/content/static/javascript/jquery.min.js"></script>
		<script src="http://cdn.howcode.org/content/static/javascript/jquery.cookie.js"></script>	

	<!--
	</script>	<style type="text/css">
		.goog-te-banner-frame.skiptranslate{display:none!important;}
		body{top:0px!important;}
		</style>
		 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="/resources/demos/style.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
  


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">
</head>
<body>


    <script type="application/javascript" src="https://sdki.truepush.com/sdk/v2.0.2/app.js" async></script>
    <script>
    var truepush = window.truepush || [];
            
    truepush.push(function(){
        truepush.Init({
            id: "5e908a23b0bbcdde44f15b71"
        },function(error){
          if(error) console.error(error);
        })
    })
    </script>

    <script>
    truepush.push({
      operation: "add-tags",
      data: [{ tagName: "YOUR_TAG_NAME", tagType: "TAG_DATATYPE", tagValue: "YOUR_TAG_VALUE" }],
      callback: function(error,response){
                  console.log(error,response);
                }
    })
</script>

	<script>
    truepush.push({
      operation: "remove-tags",
      data: [{ tagName: "YOUR_TAG_NAME", tagValue: "YOUR_TAG_VALUE_TO_BE_REMOVED" }],
      callback: function(error,response){
                  console.log(error,response);
                }
    })   
</script>

	<script> 
    truepush.push({
      operation: "get-tags",
      callback: function(error,response){
        console.log(error,response);
      }
    })
</script>
	<!-- Start Splash -->
	<?php if ($_COOKIE['_splash'] !== date("dmy")) {

		setcookie("_splash", date("dmy"), strtotime("+3 days"), "/");

	?>
		
	<script type="text/javascript">
		$(document).ready(function () {
			Splash();
		})
	</script>

	<div class="_spl_">
		<div class="_spl_ctr">
			<center>

				<!-- data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiIgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiBmaWxsPSIjMjIyMjIyIj4KICA8cGF0aCBvcGFjaXR5PSIuMjUiIGQ9Ik0xNiAwIEExNiAxNiAwIDAgMCAxNiAzMiBBMTYgMTYgMCAwIDAgMTYgMCBNMTYgNCBBMTIgMTIgMCAwIDEgMTYgMjggQTEyIDEyIDAgMCAxIDE2IDQiLz4KICA8cGF0aCBkPSJNMTYgMCBBMTYgMTYgMCAwIDEgMzIgMTYgTDI4IDE2IEExMiAxMiAwIDAgMCAxNiA0eiI+CiAgICA8YW5pbWF0ZVRyYW5zZm9ybSBhdHRyaWJ1dGVOYW1lPSJ0cmFuc2Zvcm0iIHR5cGU9InJvdGF0ZSIgZnJvbT0iMCAxNiAxNiIgdG89IjM2MCAxNiAxNiIgZHVyPSIwLjhzIiByZXBlYXRDb3VudD0iaW5kZWZpbml0ZSIgLz4KICA8L3BhdGg+Cjwvc3ZnPgo= 

				<img class="_spl_load" src="data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB2aWV3Qm94PSIwIDAgNDUgNDUiIHhtbDpzcGFjZT0icHJlc2VydmUiDQoJPg0KCTxzdHlsZT4NCiAgICA8IVtDREFUQVsNCgkgICAgY2lyY2xlIHsNCgkJCXN0cm9rZS1kYXNoYXJyYXk6IDEsIDIwMDsNCgkJCXN0cm9rZS1kYXNob2Zmc2V0OiAwOw0KCQkJYW5pbWF0aW9uOiBkYXNoLWNvbG9yIDEuNXMgZWFzZS1pbi1vdXQgaW5maW5pdGU7DQoJCQlzdHJva2UtbGluZWNhcDogcm91bmQ7DQoJICAgIH0NCgkJQGtleWZyYW1lcyBkYXNoLWNvbG9yIHsNCgkJCTAlIHsNCgkJCQlzdHJva2U6ICMwMDgzMjk7DQoJCQkJc3Ryb2tlLWRhc2hhcnJheTogMSwgMjAwOw0KCQkJCXN0cm9rZS1kYXNob2Zmc2V0OiAwOw0KCQkJfQ0KCQkJNDAlIHsNCgkJCQlzdHJva2U6ICNhNGRkODM7DQoJCQkJc3Ryb2tlLWRhc2hhcnJheTogODksIDIwMDsNCgkJCQlzdHJva2UtZGFzaG9mZnNldDogLTM1cHg7DQoJCQl9DQoJCQk2MCUsDQoJCQkxMDAlIHsNCgkJCQlzdHJva2U6ICMzN2EwMDA7DQoJCQkJc3Ryb2tlLWRhc2hhcnJheTogODksIDIwMDsNCgkJCQlzdHJva2UtZGFzaG9mZnNldDogLTEyNHB4Ow0KCQkJfQ0KCQl9DQogICAgXV0+DQogIDwvc3R5bGU+DQogIAk8Y2lyY2xlIGN4PSIyMiIgY3k9IjIyIiByPSIyMCIgZmlsbD0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiICAvPg0KPC9zdmc+DQo=">
				<img class="_spl_logo" src="./asset/yossell.png">-->
			</center>
		</div>
	</div>

	<?php }; ?>
	<!-- End Splash -->

	<!-- Start Dashboard -->

	
	<?php if (isset($_GET['dashboard']) && $on_ == 1 && $this_buy_eligible == 2) { ?>

		<div class="_ovvvv_"></div>

		<div class="nerochike">
			
			<div class="Atiluta">

				<?php if ($this_sell_eligible == 3) { ?>
					<p class="v__hd">Pending</p>	
				<?php } else if ($this_sell_eligible == 4) { ?>
					<p class="v__hd">Declined</p>
				<?php } else if ($this_sell_eligible == 2) {

					$this_Convrs = $class_->runS(" SELECT added_to_cart, reached_checkout, purchased FROM `sub_products` WHERE `store_owner` = '$this_u_id' ");

					$this_total_added_to_cart = 0;
					$this_total_reached_checkout = 0;
					$this_total_purchased = 0;
					
					while ($thisConvFetch = mysqli_fetch_assoc($this_Convrs)) {
						
						$this_total_added_to_cart += $thisConvFetch['added_to_cart'];
						$this_total_reached_checkout += $thisConvFetch['reached_checkout'];
						$this_total_purchased += $thisConvFetch['purchased'];

					} ?>

					<p class="v__hd">Verified</p>
				<?php } else { ?>
					<p class="v__hd">Not Applied</p>
				<?php }; ?>

				<a class="_side_l__" href="./"> <span class="pa _side_l__oa ">o</span>Visit Site Home</a>
				<a class="_side_l__" href=""> <span class="pa _side_l__oa dbh_">d</span>Overview Panel</a>
				<!--<a class="_side_l__ dbh_nty _call_module" href="#NOTIFICATION" id="_notification"> <span class="pa _side_l__oa dbh_">i</span>Notification <div class="c_num"><?php echo $notify__; ?></div></a>-->
				<a class="_side_l__ dbh_pro _call_module" href="#PROFILE_" id="_profile"> <span class="pa _side_l__oa">L</span>Account Setting</a>

				<?php if ($this_sell_eligible == 2) { ?>
					<a class="_side_l__ dbh_s _call_module" href="#SELL_" id="_sell"> <span class="pa _side_l__oa">+</span>Create Product Now</a>
					<a class="_side_l__ dbh_ms _call_module" href="#MY-SHOP" id="_ms"> <span class="pa _side_l__oa">;</span>View All Products</a>
					<!-- <a class="_side_l__" href="./?review"> <span class="pa _side_l__oa">_</span>Reviews</a> -->
				<?php };?>

				<?php if ($this_buy_eligible == 2) { ?>
					<a class="_side_l__ dbh_od _call_module" id="_orders"> <span class="pa _side_l__oa">a</span>Customers Orders</a>
					<!-- <a class="_side_l__" href=""> <span class="pa _side_l__oa">x</span>My Wallet</a>
					<a class="_side_l__ dbh_wl _call_module" href="#WISHLIST_" id="_wl"> <span class="pa _side_l__oa">!</span>My Favorite</a>
					<a class="_side_l__" href="./?cart"> <span class="pa _side_l__oa fas fa-shopping-cart">a</span>Cart</a>
				<?php } else { ?>
					<a class="_side_l__ dbh_b _call_module" href="#BUY_" id="_buy"> <span class="pa _side_l__oa">5</span>Buy</a>
				<?php };?>

				<?php if ($this_buy_eligible == 2 || $this_sell_eligible == 2) { ?>
					<a class="_side_l__ dbh_tc _call_module" href="#TICKET" id="ts"> <span class="pa _side_l__oa">=</span>Messages</a> -->
				<?php }; ?>

				 <a class="_side_l__ dbh_se _call_module" href="#SERVICE_" id="_service"> <span class="pa _side_l__oa">c</span>Service</a> 
				
				<!-- <a class="_side_l__" href=""> <span class="pa _side_l__oa">K</span>Help</a> -->
				<?php
					if (in_array(strtoupper($this_u_id), $reserved_admin)) {
						?>
							<a class="_side_l__ dbh_sad _call_module" href="#S" id="sad"> <span class="pa _side_l__oa">7</span> Admin Control Panel</a>

							<a class="_side_l__" href="https://app.sendlane.com/start"> <span class="pa _side_l__oa">~</span>Go-To-Mailer</a>

							<a class="_side_l__" href="https://app.truepush.com/apps/5e9dbdfd32878c96c797a6e5/dashboard"> <span class="pa _side_l__oa">~</span>Send Push Notification</a>

							
						<?php
					}
				?>
				
				<a class="_side_l__" href="./?logout"> <span class="pa _side_l__oa">~</span>Sign Out</a>
				<!-- <a class="_side_l__" href=""> <span class="pa _side_l__oa">u</span>Yossell App</a> -->
				
			</div>


			<div class="kosifavko">

				<div class="_m_sec pa _t_dmenu">d</div>
				<div class="act_db_img"><img class="str_img__" src="./images/_p_img/<?php echo $this_image; ?>"></div>
				<div class="_txsh" style="font-weight: 700;"> <?php echo $class_->Capita($this_full_name); ?></div>

					<?php if ($this_sell_eligible == 1) { ?>
						<!--<div class="button__01 dbh_s _call_module" id="_sell" style="background: orange;"> Trade Now </div>
					<?php }; ?>

					<?php if ($this_buy_eligible == 1) { ?>

						<!-- <img class="_welc_icon" src="./asset/welc_.png">
						<p class="_hd">Welcome to Tradeporta</p>
						<p class="_hd_s">You are yet to complete your profile.</p> -->

						
						<div class="button__01 dbh_b _call_module" id="_buy">Buy Now</div>

					<?php }; ?>

				<!-- <div class="button__01 dbh_tc _call_module" id="ts" href="./?store_home=<?php echo $store_owner; ?>&st_hm=<?php echo uniqid(); ?>">Request Product</div> -->

			</div>

			<style>
				.Atiluta{
				width: 20%;
			    overflow: hidden;
			    height: 100%;
			    max-height: 100%;
			    display: inline-block;
			    overflow-y: scroll;
			    float: left;
			    background-color: #999;
				}
				.nerochike{
				width: 90%;
			    overflow: hidden;
			    height: 90%;
			    margin: 2.5% 5%;
			    top: 0;
			    left: 0;
			    border-radius: 5px;
			    box-shadow: 5px 8px 0px rgba(0,0,0,0.04);
			    position: fixed;
				}
				.kosifavko{
				width: 100%;
			    display: block;
			    overflow: hidden;
			    position: absolute;
			    top: 0;
			    left: 0;
			    padding: 10px;
			    z-index: 100;
			    background-color: #f5f8fa;
			    box-shadow: 0px 0px 20px rgba(0,0,0,0.2);
			    height: 70px;
				}
				.efezino{
				margin-top: 70px;
			    width: 80%;
			    background-color: rgba(230, 236, 240, 0.15);
			    height: 100%;
			    float: right;
			    overflow: hidden;
			    overflow-y: scroll;
			    position: relative;
			    padding-bottom: 70px;
				}
				.ceecemay{
				width: 100%;
			    display: block;
			    overflow: hidden;
			    padding: 20px;
			    background-color: #f5f8fa;
			    position: relative;
				}
				@media (max-width: 800px){
				.Atiluta {
				width: 80%;
				position: fixed;
				z-index: 10;
				display: none;
				}
				.nerochike{
				margin-left: 0;
			    width: 100%;
			    height: 100%;
			    margin-top: 0px;
			    /* margin-bottom: 0px; */
			    float: unset;
			    padding-bottom: 0;
				}
				.efezino{
				width: 100%;
			    display: block;
			    overflow: hidden;
			    padding: 20px;
			    background-color: #f5f8fa;
			    position: relative;
			    overflow-y: scroll;
			    padding-bottom: 70px;
				}
				.ceecemay{
				width: 126%;
			    display: block;
			    margin-top: -46px;
			    margin-left: -40px;
			    overflow: hidden;
			    padding: 20px;
			    background-color: #f5f8fa;
			    position: relative;
				}
				._db_news_hd__ {
			    width: 100%;
			    display: block;
			    background-color: #050505;
			    font-weight: 450;
			    font-size: 12pt;
			    overflow: hidden;
			    padding: 30px;
			    color: yellow;
			    border-radius: 10px;
			    margin-bottom: 10px;
				}
				._inP__b {
			  	background: #FFF;
			    width: 50%;
			    display: inline-block;
			    float: left;
			    border-right: 1px solid #EEE;
				}
				._seg_m {
			    margin: 1%;
			    width: 98%;
			    background: #FFF;
			    overflow: hidden;
			    border-radius: 0px;
			    margin-bottom: 25px;
			    border: 1px solid #EEE;
				}
				._column_aba {
	    		width: 96%;
	    		margin: 10px 2.5%;
    			}
			</style>

			<div class="efezino">

				<div class="ceecemay">

					<?php if (mysqli_num_rows($get_db_news) > 0) { ?>
						<div class="_db_news_hd__">
							<span class="pa">&</span><?php echo $this_news_header; ?>
						</div>
					<?php }; ?>

					<div class="rd_edge">

						<?php if ($this_sell_eligible == 2) {

							$thisOdTD = $class_->runS(" SELECT SUM(price*quantity) AS 'add' FROM `orders` WHERE `seller_id` = '$this_u_id' AND `date_stamp` = '$date_a' AND `paid_status` = 'PAID' ");
							$sum_price_TD = mysqli_fetch_assoc($thisOdTD);
							$sum_price_TD = $sum_price_TD['add'];

							$thiscount_TD = $class_->runS(" SELECT id FROM `orders` WHERE `seller_id` = '$this_u_id' AND `date_stamp` = '$date_a' AND `paid_status` = 'PAID' ");
							$count_TD = mysqli_num_rows($thiscount_TD)+0;

							$thisOdYD = $class_->runS(" SELECT SUM(price*quantity) AS 'add' FROM `orders` WHERE `seller_id` = '$this_u_id' AND `date_stamp` = '$date_y' AND `paid_status` = 'PAID' ");
							$sum_price_YD = mysqli_fetch_assoc($thisOdYD);
							$sum_price_YD = $sum_price_YD['add'];

							$thiscount_YD = $class_->runS(" SELECT id FROM `orders` WHERE `seller_id` = '$this_u_id' AND `date_stamp` = '$date_y' AND `paid_status` = 'PAID' ");
							$count_YD = mysqli_num_rows($thiscount_YD)+0;

							$thisOdL7 = $class_->runS(" SELECT SUM(price*quantity) AS 'add' FROM `orders` WHERE `seller_id` = '$this_u_id' AND `date_stamp` != '$date_a' AND `date_stamp` >= '$date_7' AND `paid_status` = 'PAID' ");
							$sum_price_L7 = mysqli_fetch_assoc($thisOdL7);
							$sum_price_L7 = $sum_price_L7['add'];

							$thiscount_L7 = $class_->runS(" SELECT id FROM `orders` WHERE `seller_id` = '$this_u_id' AND `date_stamp` != '$date_a' AND `date_stamp` >= '$date_7' AND `paid_status` = 'PAID' ");
							$count_L7 = mysqli_num_rows($thiscount_L7)+0;

							$thisOdL30 = $class_->runS(" SELECT SUM(price*quantity) AS 'add' FROM `orders` WHERE `seller_id` = '$this_u_id' AND `date_stamp` != '$date_a' AND `date_stamp` <= '$date_30' AND `paid_status` = 'PAID' ");
							$sum_price_L30 = mysqli_fetch_assoc($thisOdL30);
							$sum_price_L30 = $sum_price_L30['add'];

							$thiscount_L30 = $class_->runS(" SELECT id FROM `orders` WHERE `seller_id` = '$this_u_id' AND `date_stamp` != '$date_a' AND `date_stamp` <= '$date_30' AND `paid_status` = 'PAID' ");
							$count_L30 = mysqli_num_rows($thiscount_L30)+0;

							$thisOdL90 = $class_->runS(" SELECT SUM(price*quantity) AS 'add' FROM `orders` WHERE `seller_id` = '$this_u_id' AND `date_stamp` != '$date_a' AND `date_stamp` <= '$date_90' AND `paid_status` = 'PAID' ");
							$sum_price_L90 = mysqli_fetch_assoc($thisOdL90);
							$sum_price_L90 = $sum_price_L90['add'];

							$thiscount_L90 = $class_->runS(" SELECT id FROM `orders` WHERE `seller_id` = '$this_u_id' AND `date_stamp` != '$date_a' AND `date_stamp` <= '$date_90' AND `paid_status` = 'PAID' ");
							$count_L90 = mysqli_num_rows($thiscount_L90)+0;

							?>

							<div class="_flow_widTH">

								<div class="_inP__b">
									<div class="_in_db_Rt _col_t11">TODAY</div>
									<div class="_in_db_Num"><?php echo $class_->_currency($cur_currency, $sum_price_TD); ?></div>
									<div class="_in_db_Rt _btop_"><?php echo $count_TD; ?> Order</div>
								</div>

								<div class="_inP__b">
									<div class="_in_db_Rt _col_t11">YESTERDAY</div>
									<div class="_in_db_Num"><?php echo $class_->_currency($cur_currency, $sum_price_YD); ?></div>
									<div class="_in_db_Rt _btop_"><?php echo $count_YD; ?> Order</div>
								</div>

								<div class="_inP__b">
									<div class="_in_db_Rt _col_t11">LAST 7 DAYS</div>
									<div class="_in_db_Num"><?php echo $class_->_currency($cur_currency, $sum_price_L7); ?></div>
									<div class="_in_db_Rt _btop_"><?php echo $count_L7; ?> Order</div>
								</div>

								<div class="_inP__b">
									<div class="_in_db_Rt _col_t11">LAST 30 DAYS</div>
									<div class="_in_db_Num"><?php echo $class_->_currency($cur_currency, $sum_price_L30); ?></div>
									<div class="_in_db_Rt _btop_"><?php echo $count_L30; ?> Order</div>
								</div>

								<div class="_inP__b">
									<div class="_in_db_Rt _col_t11">LIFE TIME +</div>
									<div class="_in_db_Num"><?php echo $class_->_currency($cur_currency, $sum_price_L90); ?></div>
									<div class="_in_db_Rt _btop_"><?php echo $count_L90; ?> Order</div>
								</div>

							</div>

							<div class="_flow_widTH _Area__09">

								<div class="_column_aba">

									<div class="_seg_m box">
										<div class="_s_head">
											<div class="_s_h_ic pa m_none">x</div>
											<div class="_s_h_t">Top Orders</div>
											<div class="_s_h_ic br_"><?php echo $count_TD+$count_YD+$count_L7+$count_L30+$count_L90; ?></div>
										</div>
										<div class="_s_cont_">

											<?php

												$get_my_pop_sales = $class_->runS( " SELECT `product_id`, `thumb_p_id`, COUNT(*) AS total FROM `orders` WHERE `seller_id` = '$this_u_id' GROUP BY `product_id`, `thumb_p_id` ORDER BY COUNT(*) ASC ");

												if (mysqli_num_rows($get_my_pop_sales) > 0) {
													
													while ($get_my_pop_sales_r = mysqli_fetch_assoc($get_my_pop_sales)) {
													
														$product_id = $get_my_pop_sales_r['product_id'];
														$top_product_ = $get_my_pop_sales_r['thumb_p_id'];
														$top_product_C = $get_my_pop_sales_r['total']; // Amount_

														$getTP = $class_->getP($product_id);

														// Getting Sub Product From Orders
														$getSP = $class_->getSP($top_product_);
														$getSPF = mysqli_fetch_assoc($getSP);
														$image = $getSPF['image'];
														$added_to_cart = strtolower($getSPF['added_to_cart']);
														$reached_checkout = strtolower($getSPF['reached_checkout']);
														$reached_checkout_p = strtolower($getSPF['purchased']);

														if (mysqli_num_rows($getTP) > 0) {
															$getTopP = mysqli_fetch_assoc($getTP);
															$name = strtolower($getTopP['name']);

															?>

																<div class="_seg_m_div_0">
																	<img class="_in_div_img" src="./images/_product/<?php echo $image; ?>">
																	<div class="_o_r_in_div">
																		<a class="_pop_tag_ bor" href="./?product_v=<?php echo $product_id; ?>"><?php echo $class_->Capita($name); ?></a>
																		<div class="_rr_o_seg">
																			<span class="_in_s_r_sold">Added to Cart: <?php echo $added_to_cart; ?></span>
																			<span class="_in_s_r_sold">Reached Checkout: <?php echo $reached_checkout; ?></span>
																			<span class="_in_s_r_sold">Purchased: <?php echo $reached_checkout_p; ?></span>
																		</div>
																	</div>
																</div>

															<?php
														}

													}

												} else {
													?>
														<center><p style="padding: 20px; color: #DADADA;">No orders.</p></center>
													<?php
												}

											?>
											
										</div>
									</div>

									<div class="_seg_m box">
										<div class="_s_head">
											<div class="_s_h_ic pa m_none">m</div>
											<div class="_s_h_t">Conversions</div>
										</div>
										<div class="_s_cont_">

											<div class="_seg_m_div box">
												<div class="_cv_img fas fa-shopping-cart"></div>
												<div class="cv_dtl">
													<div class="_span___ _span___1"><?php echo number_format($this_total_added_to_cart); ?></div>
													<span class="_span___">Added to cart</span>	
												</div>
											</div>

											<div class="_seg_m_div box">
												<div class="_cv_img far fa-credit-card"></div>
												<div class="cv_dtl">
													<div class="_span___ _span___1"><?php echo number_format($this_total_reached_checkout); ?></div>
													<span class="_span___">Reached Checkout</span>	
												</div>
											</div>

											<div class="_seg_m_div box">
												<div class="_cv_img far fa-money-bill-alt"></div>
												<div class="cv_dtl">
													<div class="_span___ _span___1"><?php echo number_format($this_total_purchased); ?></div>
													<span class="_span___">Successful Purchase</span>	
												</div>
											</div>

										</div>
									</div>

								</div>

								<div class="_column_aba">
									
									<div class="_seg_m box">
										<div class="_s_head">
											<div class="_s_h_ic pa m_none">K</div>
											<div class="_s_h_t">Important Notice</div>
										</div>
										<div class="_s_cont_">

											<?php
												$get_news = $class_->runS(" SELECT * FROM `flash_news` WHERE `news_type` != 'DB' ORDER BY id ASC LIMIT 7 ");
												while ($row_news = mysqli_fetch_assoc($get_news)) {
													$news_header = $row_news['news_header'];
													?>
													<div class="_imp_notice__">&raquo <?php echo $news_header; ?></div>
													<?php
												}
											?>
											
										</div>
									</div>

									<div class="_seg_m box">

										<div class="_s_head">
											<div class="_s_h_ic pa m_none">[</div>
											<div class="_s_h_t">Latest Product Review</div>
										</div>

										<div class="_s_cont_">

											<?php $get_ARvv_ = $class_->runS("SELECT * FROM `review` WHERE `seller` = '$this_u_id' ORDER BY `id` DESC LIMIT 3 ");
											if (mysqli_num_rows($get_ARvv_)) {

												while ($rowRv_ = mysqli_fetch_assoc($get_ARvv_)) {
													
													$star = $rowRv_['star'];
													$user = $rowRv_['user'];
													$product = $rowRv_['product'];
													$date_time = $rowRv_['date_time'];
													$review = $rowRv_['review']; ?>

														<div class="_rv_FlwW">

															<a target="_blank" class="_s_RowW" style="font-weight: 500;" href="./?product_v=<?php echo $product; ?>"><?php echo $class_->Capita($class_->getUD($user, "nm")); ?> | <?php echo $date_time; ?></a>
															<div class="_s_RowW" style="font-weight: 600; color: orange;">Country: <?php echo $class_->Capita($class_->getUD($user, "ct")); ?></div>

															<div class="_s_LlR">
																<div class="_s_RowW"><?php echo $review; ?></div>
															</div>

															<div class="_start_box">
																<img class="_star_in_Box_" src="./asset/star.png">
																<img class="_star_in_Box_" src="./asset/star.png">
																<img class="_star_in_Box_" src="./asset/star.png">
																<img class="_star_in_Box_" src="./asset/star.png">
																<img class="_star_in_Box_" src="./asset/star.png">
																<div class="star_covr" style="width: <?php echo 100-($star*20); ?>%"></div>
															</div>

														</div>

												<?php }; } else { ?>

													<center><p style="padding: 20px; color: #DADADA;">No product reviews.</p></center>

												<?php } ?>
											
										</div>

									</div>

								</div>

								<!-- <img src="./asset/91.gif"> -->
							</div>

						<?php }; ?>

					</div>

				</div>
			</div>
			<!-- End Dashboard -->
		</div>
<!-- Start Billboard-->




	<?php } else {

		$g_ldb = $class_->runS(" SELECT * FROM `billboard` ");
		while ($row_ldb = mysqli_fetch_assoc($g_ldb)) {
			$position = $row_ldb['position'];
			$image = $row_ldb['image'];
			$link = $row_ldb['link'];
			$category = $row_ldb['category'];

			if ($position == "mobile page-top") {

				if (file_exists("images/_board/" . $image)) {

					?>
						<a class="_flow_not dim_p_m" href="<?php echo $link; ?>" target="_blank">
							<img class="_ldbb_img" src="<?php echo './images/_board/'. $image; ?>">
						</a>
					<?php

				}

			} else if ($position == "page-top") {

				if (file_exists("images/_board/" . $image)) {

					?>
						<a class="_flow_not dim_p" href="<?php echo $link; ?>" target="_blank">
							<img style="width: 100%;" src="<?php echo './images/_board/'. $image; ?>">
						</a>
					<?php 

				}

			}

		}

		?>
		<!--start Header HERE
			<div class="mobileHide">-->
		
   				 	
				

<!--

					<?php if ($on_ == 1) { ?>
							<center>
							<?php if ($this_sell_eligible == 2) { ?>
								<a class="obamacall" href="./?dashboard"><span class="pa obamacall dbh_"></span>Admin Control Panel</a>
							<?php } else if ($this_sell_eligible == 3) { ?>
								<div class="_notice_pix_g">Your account is awaiting approval for selling.<br>You will be contacted shortly.</div>
							<?php } else { ?>
								<div class="obamacall _sell_inf" style=" cursor: pointer;"><span class="pa obamacall dbh_"></span>Become a Seller</div>
							<?php }; ?>

							<a class="obamacall _profile_inf"  href="#PROFILE"><span class="pa obamacall dbh_"></span>My Profile</a>

							<?php if ($this_buy_eligible != 2) { ?>			
								<div class="obamacall _buy_inf" ><span class="pa obamacall dbh_"></span>Complete Profile</div>

							<?php }; ?>

							
						
						<?php }; ?>
			</div>
			</div>
		</div>	

					mamaomo-->
<style type="text/css">
	._side_l__oa2 {
    text-transform: unset;
    font-size: 16pt;
</style>
					
					<div class="mobileHide">
					<div class=" kogbodi">

						<a class="obamacallmish _sell_inf" style=" cursor: pointer;"><span class="pa _side_l__oa2">f</span>Trade With Yossell</a>
				</div>
				</div>

				<div class="mobileHide">
						<a href="./"> <img class="akinlogo" src="./asset/yossell.png">
</a>
				
					<form class="_very_search">
						<input class="_inP_" type="text" name="s" placeholder="What Kind Of Products Are You Looking For......">
						<input type="submit" class="bebeto dokokoko" name="_serach_" value="SEARCH">
					</form>
					<center>

					<a class="cartown"  href="./?cart"> <span style=" font-size: 14pt; cursor: pointer; color: #050505;" class="fas fa-shopping-cart">Cart</span> <div class="c_numb c_num_"><?php echo $total_cart; ?> </div></a>

					<a class="cartownZ _wish_inf"> <span style=" font-size: 16pt; cursor: pointer; color: #050505;" class="fab fa-gratipay">My Favorites</span></a>

					<!--<div class="cartownZ _ticket_inf" href="./?dashboard"><span class="pa _side_l__oawet">/</span>My Messages</div>-->



					
					<style>
					.cartown {
					    display: inline-block;
					    padding: 0px 4px;
					    line-height: 40px;
					    margin-top: 46px;
					    color: #050505;
					    transition: background 0.5s;
					    margin-left: -16px;
					    margin-right: -65px;
					}
					.cartownZ {
						display: inline-block;
					    padding: 0px 4px;
					    line-height: 40px;
					    margin-top: 46px;
					    color: #050505;
					    font-weight: 400;
					    transition: background 0.5s;
					    margin-left: -24px;
					    font-size: 13pt;
					    margin-right: 23px;
					}
					.c_numb {
					    width: 20px;
					    text-align: center;
					    background: #000000;
					    display: inline-block;
					    float: right;
					    font-weight: bold;
					    color: #FFF;
					    margin-left: -42px;
					    margin-right: 117px;
					    height: 20px;
					    font-size: 8pt;
					    border-radius: 100px;
					    margin-top: -7px;
					    line-height: 20px;
					</style>
							<!--
<div class="mobileHide">
		<div class=" pastorokon">
					<center>

						<?php if ($on_ == 1) { ?>
							<center>
							<?php if ($this_sell_eligible == 2) { ?>
								<a class="obamacall" style=" font-size: 17pt; font-weight: 400; cursor: pointer;" href="./?dashboard"><span class="pa oyahky dbh_">7</span>Dashboard</a>
							<?php } else if ($this_sell_eligible == 3) { ?>
								<div class="_notice_pix_g">Your account is awaiting approval for selling.<br>You will be contacted shortly.</div>
							<?php } else { ?>
								<div class="obamacallmish _sell_inf" style=" cursor: pointer;"><span class="pa oyahky dbh_">f</span>Become a Seller</div>
							<?php }; ?>

							<a class="obamacallmish _profile_inf" style=" font-size: 17pt; cursor: pointer; font-weight: 400;" href="#PROFILE"><span class="pa oyahky dbh_">L</span>My Profile</a>

							<?php if ($this_buy_eligible != 2) { ?>			
								<div class="obamacallmish _buy_inf" style=" font-size: 17pt; cursor: pointer; font-weight: 400;"><span class="pa oyahky dbh_">.</span>Complete Profile</div>
							<?php } else { ?>
								<div class="obamacallmish _ticket_inf" style=" font-size: 17pt;cursor: pointer; font-weight: 400;" href="./?dashboard"><span class="pa oyahky">w</span> Open Dispute</div>
								<div class="obamacall _order_inf" style=" font-size: 17pt;cursor: pointer; font-weight: 400;" href="./?dashboard"><span class="pa oyahky">a</span> Track My Order</div>
							<?php }; ?>

							<a class="obamacall" style=" font-size: 17pt; font-weight: 400; cursor: pointer;" href="./?logout"><span class="pa oyahky dbh_">9</span>Log Out</a>

						
						<?php }; ?>
					</div>

				</div>
				
			</div>
			
		</div>
	</div>
</div>
</div>-->
					<!--mobile view Starts HERE sss___-->
</center>
</div>
		
				<div class="mobileShow">
						<div class="ritta ">
						<!--<div class="_m_sec pa _s_mb dbh_pro _call_module" href="#PROFILE_" id="_profile">L</div>-->

        	<a href="#PROFILE_" id="_profile" class=" _s_mb  dbh_pro _call_module">
             <div class="_m_sec pa _s_mb sss___ wow zoomIn">L</div><div class=" _p__plop wow zoomIn"></div></a>

         	 <a href="./?cart" class=" _s_mb  ">
             <div class="_m_sec pa _s_mb sss___ wow zoomIn">f</div><div class="c_num c_num_ _p__plop wow zoomIn"><?php echo $total_cart; ?></div></a>

             <a href="#NOTIFICATION" id="_notification" class=" _s_mb  dbh_nty _call_module">
             <div class="_m_sec pa _s_mb sss___ wow zoomIn">b</div><div class="c_num c_num_ _p__plop dbh_"><?php echo $notify__; ?></div></a>
           
          <!-- <a class="_m_sec pa _s_mb sss___ wow zoomIn dbh_nty _call_module" href="#NOTIFICATION" id="_notification"><div class="c_numm"></div> <span class="pa  dbh_">b</span></a>-->
   
             
          <div class="_m_sec pa _t_menu" style="color: black; font-size: 20pt;">d</div>
							
							<a href="./" class="_l_sec__ wow zoomIn"> <img class="_hp_logoo " src="./asset/yossell.png"></a></div></div>

<div class="mobileShow">
							  <div class="_s_sec">
			          <form class=" subtile">
			            <input class="_inP_ wow zoomIn" type="text" name="s" placeholder="Search for products, brands and categories ...">
			            <input type="submit" class="_inP_ _inP__btn" name="_serach_" value="SEARCH">
			          </form>
			        </div>
			      </div>
				</div>
							<!--	<?php if ($on_ == 1) { ?>
<div class="_m_sec _s_mb _ticket_inf" href="#TICKET" id="ts"><span class="pa " style="color: #000; text-transform: unset;font-size: 12.0pt; margin-left: 17px;">=</span> </div>

<?php
								}
							?>
							hellomike-->
						
						
						<!--<a class="_m_sec _s_mb"  href="./?social"> <span class="pa _side_l__oa1 dbh_" style="color: #FFF; font-size: 20pt">></span></a>-->
				

			<div class="_flow_not _pop_head_tv">

						<marquee class="_news_p_flash" scrollamount="4"><a class=" " style="color: #fff;     font-weight: 500; font-size: 13pt;"> Payment Made Easy, You can take a photo of the items you intend to purchase, Make a payment to the following account detail: Blue Connect Nig Company, 1007054997, KeyStone Bank. Then send the screenshot of the transaction & the photos of the items you intent to purchase to our customer care whatsapp account by clicking the following link <a href="http://wa.me/2348031370588" >+2348031370588 here</a>.<a class=" " style="color: #fff;     font-weight: 500; font-size: 13pt;"> It's that easy</a>
							<?php
								$get_news = $class_->runS(" SELECT * FROM `flash_news` WHERE `news_type` != 'DB' ORDER BY id DESC LIMIT 7 ");
								while ($row_news = mysqli_fetch_assoc($get_news)) {
									$news_header = $row_news['news_header'];
									?>
									<div class="_marq_news"><?php echo $news_header; ?></div>
									<?php
								}
							?>
						</marquee>

					</div>
							<!--mobile view ENDS HERE-->	


	<?php if (!isset($_GET['forgot']) && !isset($_GET['_serach_']) && !isset($_GET['fd_rg']) && !isset($_GET['contact_us']) && !isset($_GET['privacy']) && !isset($_GET['terms_policy']) && !isset($_GET['terms_sale']) && !isset($_GET['social']) && !isset($_GET['about_us']) && !isset($_GET['return_refund']) && !isset($_GET['realestate_centre']) && !isset($_GET['categories_navigation']) && !isset($_GET['publishing_centre']) && !isset($_GET['logistics_centre']) && !isset($_GET['graphics_centre']) && !isset($_GET['wholesale_centre']) && !isset($_GET['c_inv']) && !isset($_GET['store_home']) && !isset($_GET['u_bx']) && !isset($_GET['cart']) && !isset($_GET['product_v']) && !isset($_GET['login']) && !isset($_GET['register']) && !isset($_GET['flash_deals']) && !isset($_GET['c_invoice']) && !isset($_GET['cat_']) && !isset($_GET['s_cat_']) && !isset($_GET['ss_cat_']) && !isset($_GET['fil'])) { ?>

						

			
				<!-- Bill board starts here
					<div class="_xd_01 _xd_"> -->
							<div class="mobileHide">
						<div class="_tv_othrded2">



				<a class="dashus" style=" font-size: 8pt; font-weight: 320px; color: #333; background-color: #fbfbfb; margin-bottom: -29px; cursor: pointer;" href="https://inkluxefx.com/yossell/?cat_=LTLSzbRVkSl"><i class='fa fa-television' style='font-size:25px; color: #ff6600;'></i> Electronics</a>

				<a class="dashus" style=" font-size: 8pt; font-weight: 320px; color: #333; background-color: #fbfbfb; margin-bottom: -29px; cursor: pointer;" href="https://inkluxefx.com/yossell/?cat_=sjjsbLT"><i class='fas fa-tshirt' style='font-size:25px; color: #ff6600;'></i> Apparel</a>

				<a class="dashus" style=" font-size: 8pt; font-weight: 320px; color: #333; background-color: #fbfbfb; margin-bottom: -29px; cursor: pointer;" href="https://inkluxefx.com/yossell/?cat_=E2bVkz2bL"><i class='fas fa-couch' style='font-size:25px; color: #ff6600;'></i> Furniture</a>

				<a class="dashus" style=" font-size: 8pt; font-weight: 320px; color: #333; background-color: #fbfbfb; margin-bottom: -29px; cursor: pointer;" href="https://inkluxefx.com/yossell/?cat_=ljRbzl-%-LVzLbzskVQLVz"><i class='fas fa-dumbbell' style='font-size:25px; color: #ff6600;'></i> Sports & Entertianment</a>
		
			

							
			<a class="dashus" style=" font-size: 8pt; font-weight: 320px; color: #333; background-color: #fbfbfb; margin-bottom: -29px; cursor: pointer;"  href="
								https://www.inkluxefx.com/yossell/?cat_=GLs2zI-%-jLblRVsT-SsbL"><i class="fas fa-user-shield" style='font-size:25px; color: #ff6600;'></i> Beauty & Personal Care</a>
		
			
			<div class="dashus " style=" font-size: 8pt; font-weight: 320px; color: #333; background-color: #fbfbfb; margin-bottom: -29px; cursor: pointer;" href="https://www.inkluxefx.com/yossell/?cat_=ALrLTbI,-zkQLjkLSL-%-LIL-rLsbl"><i class="fas fa-gem" style='font-size:25px; color: #ff6600; margin-left: 3px;'></i> Jewelry, Timepiece & Eyewear</div>
		

		<a class="dashus " style=" font-size: 8pt; font-weight: 320px; color: #333; background-color: #fbfbfb; margin-bottom: -29px; cursor: pointer;"  href="https://www.inkluxefx.com/yossell/?cat_=zRRTl-%-Msb9rsbL"><i class="fas fa-tools" style='font-size:25px; color: #ff6600; margin-left: 3px;'></i>Tools & Hardwear</a>

				
			<div class="dashus " style=" font-size: 8pt; font-weight: 320px; color: #333; background-color: #fbfbfb; margin-bottom: -29px; cursor: pointer;" href="https://www.inkluxefx.com/yossell/?cat_=QsSMkVLbI">
					</a><i class="fas fa-subway" style='font-size:25px; color: #ff6600; margin-left: 3px;'></i>Machinery</div>
	
			<div class="dashus " style=" font-size: 8pt; font-weight: 320px; color: #333; background-color: #fbfbfb; margin-bottom: -29px; cursor: pointer;"  href="https://www.inkluxefx.com/yossell/?cat_=EsGbkSszkRV-lLbqkSLl"><i class='fas fa-coins'style='font-size:25px; color: #ff6600; margin-left: 3px;'></i> Fabrication Services</div>

			<div class="dashus " style=" font-size: 8pt; font-weight: 320px; color: #333; background-color: #fbfbfb; margin-bottom: -29px; cursor: pointer;"  href="https://www.inkluxefx.com/yossell/?cat_=s2zRQRGkTL-jsbzl-%-sSSLllRbkLl"><i class="fas fa-car-battery" style='font-size:25px; color: #ff6600; margin-left: 3px;'></i> Automobile Parts & accessories</div>
			
			<a class="dashus" style=" font-size: 8pt; font-weight: 320px; color: #333; background-color: #fbfbfb; margin-bottom: -29px; cursor: pointer;" href="./?categories_navigation"><i class='fas fa-cookie' style='font-size:25px; color: #ff6600;'></i> other categories</a>
				</div>
			</div>

						<?php

					$getFlDeal = $class_->runS("SELECT * FROM `billboard` WHERE `type` = 'slide' ORDER BY position ASC ");
					{ ?>

						



						<div class="mspeaker">
							<div class="dspeaker">
								
								<?php
									$count___ = 0;
									while ($roww = mysqli_fetch_assoc($getFlDeal)) {

										$count___1 = $count___++;
										if ($count___1 == 0) { $l_image = $roww['image']; }

										?>
											<a href="./?cat_=<?php echo $class_->urlF($category, 1); ?>"><img class="maria" src="./images/_board/<?php echo $roww['image']; ?>" /></a>
										<?php
									}
								?>
								<a target="_blank" href="<?php echo $roww['link']; ?>"><img class="maria" src="./images/_board/<?php echo $l_image; ?>" /></a>

							</div> 
						</div>
					
						<div class="mobileHide">
						<div class="_tv_othrded112">

							

							
						<?php if ($on_ == 1) { ?>
							<a href=" ./?dashboard" class="dashus dbh_" style=" font-size: 13pt; font-weight: 320px; color: #333; background-color: #fbfbfb; border-bottom: 1px solid #333; cursor: pointer;"><span class="pa ">d</span>Dashboard </a>

							<a class="dashus  _profile_inf" style=" font-size: 13pt; font-weight: 320px; color: #333; background-color: #fbfbfb; border-bottom: 1px solid #333; " href="#PROFILE"><span class="pa ">L</span><?php echo $class_->Capita($this_full_name); ?></a>
							
							
							<!--<a class="dashus"  href="./?cart"> <span style=" font-size: 14pt; cursor: pointer; color: #f19001" class="fas fa-shopping-cart">Cart</span> <div class="c_num c_num_"><?php echo $total_cart; ?> </div></a>-->


							<div class="dashus _order_inf" style=" font-size: 13pt; font-weight: 320px; color: #333; background-color: #fbfbfb; border-bottom: 1px solid #333; cursor: pointer;" href="./?dashboard"><span class="pa ">E</span> Track My Order</div>

							<div class="dashus _wish_inf" style=" font-size: 13pt; font-weight: 320px; color: #333; background-color: #fbfbfb; border-bottom: 1px solid #333; cursor: pointer;"  href="./?dashboard"><span class="pa">V</span>My Wish List</div>



							<a class="dashus" style=" font-size: 13pt; font-weight: 320px; color: #333; background-color: #fbfbfb; border-bottom: 1px solid #333;" href="./?logout"><span class="pa dbh_">~</span>Log Out</a>

							<div class="dashus _ticket_inf" style=" font-size: 13pt; font-weight: 320px; color: #333; background-color: #fbfbfb; border-bottom: 1px solid #333; cursor: pointer;"  href="./?dashboard"><span class="pa">V</span>My Message</div>
							

						<?php } else { ?>

						
							<a class="dashus" style=" font-size: 13pt; font-weight: 320; color: #333; background-color: #fbfbfb; border-bottom: 1px solid #333;" href="./?register"> <span class=" pa">0</span> Sign Up</a>
							<a class="dashus" style=" font-size: 13pt; font-weight: 320; color: #333; background-color: #fbfbfb; border-bottom: 1px solid #333;" href="./?login"> <span class=" pa">9</span> Login</a>
	<?php }; ?>

						</div>
					</div>
				</div>
			</div>
					
<style type="text/css">
	.far{
		color: #fff;
		font-size: 28pt;
	}
	.fas{
		color: #fff;
		font-size: 28pt;
	}
	@media (max-width: 800px){
			.far{
		color: #fff;
		font-size: 12pt;
	    font-size: 13pt;
	    /* width: 24%; */
	    /* float: left; */
	    /* font-size: 16px; */
	    margin-left: 24px;
	    margin-top: 25px;
	    margin-bottom: 29px;
	    /* background-color: #333; */
	    display: inline-block;
	    /* border-radius: 23px; */
	    /* box-shadow: 0px 10px 19px #ff6600; */
	}
	.fas{
		color: #fff;
		font-size: 12pt;
	    /* width: 24%; */
	    /* float: left; */
	    /* font-size: 16px; */
	    margin-left: 24px;
	    margin-top: 25px;
	    margin-bottom: 29px;
	    /* background-color: #333; */
	    display: inline-block;
	    /* border-radius: 23px; */
	    /* box-shadow: 0px 10px 19px #ff6600; */
	}
	} @media (max-width: 812px){
		.fas {
    color: #fff;
    font-size: 12pt;
    /* width: 24%; */
    /* float: left; */
    /* font-size: 16px; */
    margin-left: 24px;
    margin-top: 25px;
    margin-bottom: 29px;
    /* background-color: #333; */
    display: inline-block;
    /* border-radius: 23px; */
    /* box-shadow: 0px 10px 19px #ff6600; */

</style>
						<div class="mobileHide">
					<div class="_tv_othrded">
							<a href="./?u_bx=1" class="_tv_othrded_btred"><span class="fas fa-sitemap"></span>   Quality Suppliers</a>
							<a href="./?u_bx=2" class="_tv_othrded_btred wow " > <span class="  fas fa-tags"></span>   Manufacturers</a>

							<a href="./?fd_rg" class="_tv_othrded_btred _call_module" id="ts""><span class="  far fa-compass"></span>  Find Traders By Region</a>
							<a href="mailto:support@inkluxefx.com"yossell/ class="_tv_othrded_btred call_module" id="ts"><span class="fas fa-binoculars"></span>  Specific Request Submit</a>
						</div>
					</div>


					<div class="mobileShow">
					<div class="_tv_othrded">
							<a href="./?u_bx=1" class="_tv_othrded_btred211 wow delay2s fadeInDown"><span class="fas fa-sitemap">  Suppliers</a></span>
							<a href="./?u_bx=2" class="_tv_othrded_btred211 wow delay6s fadeInDown " > <span class="  fas fa-tags">   Manufacturers</a></span>

							<a href="./?fd_rg" class="_tv_othrded_btred211 wow delay7s fadeInDown _call_module" id="ts""><span class="  far fa-compass"> My Region</a></span>
							<a href="mailto:support@yossell.com" class="_tv_othrded_btred211 wow delay9s fadeInDown call_module" id="ts"><span class="fas fa-binoculars"> Request</a></span> 
						</div>
					</div>





					<!--<div class="mobileHide compound">
					<div class="_tv_othrded2">
							<a class="_top_text_01" style="background: #ff6600;" href="./?u_bx=1"><span class="pa _side_l__oa dbh_">d</span>Quality Suppliers</a>
							<a href="./?u_bx=2" class="_top_text_02 ">Manufacturers</a>
							<a href="./?fd_rg" class="_top_text_02 _call_module" id="ts">Find Traders By Region</a>
							<a href="#rq_" class="_top_text_02 _call_module" id="ts">Specific Request Submit</a>
						</div>
							</div>
							leftyossell banner starts hereleft banner ends her-->



					
	<?php }; ?>














						<!--// The Category Pictures like jumai

							<style type="text/css">
								
								#wrap {
									width: 100%;
								}
								.left {
									width: 20%;
									height: 90px;
									float: left;
									border-radius: 19px;
								}
								.right {
									width: 20%;
									height: 90px;
									float: right;
									border-radius: 19px;
								}
								.explore {
									width: 20%;
									height: 90px;
									float: left;
									border-radius: 19px;
								}
								.discovery {
									width: 20%;
									height: 90px;
									float: left;
									border-radius: 19px;
								}
								.doit {
									width: 20%;
									height: 90px;
									float: left;
									border-radius: 9px;


								}
							</style>
						<div class="mobileShow">				
						<div id="wrap">
							<div><a class="explore" href="https://www.fortismall.com/?cat_=QLVl-STRzMkVd"><img class="_this_p_img_q" style=" padding-top: 5px; padding-right: 18px; width: 90%; height: 55%;  margin-left: 12px;" src="./images/_product1/men.jpg"><h7 class="_p_v_seg_l " style="color: #000; font-size:7pt; margin-left: 6px;">Men Clothing</h7></a></div>

							<div><a class="left" href="
								https://www.fortismall.com/?cat_=rRQLV-STRzMkVd"><img class="_this_p_img_q" style=" padding-top: 5px; padding-right: 18px; width: 90%;  height: 55%; margin-left: 12px;" src="./images/_product1/woman.jpg"><h7 class="_p_v_seg_l " style="color: #000; font-size:7pt; margin-left: -2px;">Women Clothing</h7></a></div>


							<div><a class="left" href="https://www.fortismall.com/?cat_=rRQLV-Gsdl-%-lMRLl"><img class="_this_p_img_q" style=" padding-top: 5px; padding-right: 18px; width: 90%;  height: 55%; margin-left: 12px;" src="./images/_product1/wbag.jpg"><h7 class="_p_v_seg_l " style="color: #000; font-size:7pt; margin-left: 6px;">Bags Shoes</h7></a></div>
								

							<div><a class="explore" href="https://www.fortismall.com/?cat_=GsGI-jbR92Szl"><img class="_this_p_img_q" style="  padding-top: 5px; padding-right: 18px; width: 90%; height: 55%; margin-left: 12px;" src="./images/_product1/baby.jpg"><h7 class="_p_v_seg_l " style="color: #000; font-size:7pt; margin-left: 6px;">Baby Products</h7></a></a></div>
							
							<div><a class="discovery" href="https://www.fortismall.com/?cat_=jMRVLl-%-zsGTLzl"><img class="_this_p_img_q" style=" padding-top: 5px; padding-right: 18px; width: 90%;  height: 55%; margin-left: 12px;" src="./images/_product1/phone.png"><h7 class="_p_v_seg_l " style="color: #000; font-size:7pt; margin-left: 6px;">Phones & Tabs</h7></a></div>

							<div><a class="left" href="https://www.fortismall.com/?cat_=MRQL-%-dsb9LV,-sjjTksVSLl"><img class="_this_p_img_q" style=" padding-top: 5px; padding-right: 18px; width: 90%;  height: 55%; margin-left: 12px;"  src="./images/_product1/homefu.jpg"><h7 class="_p_v_seg_l " style="color: #000; font-size:7pt; margin-left: 6px;">Home Garden</h7></a></div> 

							
							<!--<div><a class="left" href="https://www.oyibomarket.com/?cat_=l2VdTsllLl"><img class="_this_p_img_q" style=" padding-top: 5px; padding-right: 5px; width: 100%; height: 85%; margin-left: 5px" src="./images/_product1/sunglasses.jpg"><h7 class="sm">Sunglasses</h7></a></div>



							 LINE 2 CATEGORY

										<div><a class="left" href="https://www.oyibomarket.com/?cat_=2VklLH"><img class="_this_p_img_q" style=" padding-top: 5px; padding-right: 5px; width: 100%; height: 85%; margin-left: 5px" src="./images/_product1/unisex.jpg"><h7 class="sm">Unisex Products</h7></a></div>
																			
							<div><a class="explore" href="https://www.fortismall.com/?cat_=QLVl-Gsdl-%-lMRLl"><img class="_this_p_img_q" style=" padding-top: 5px; padding-right: 18px; width: 90%;   height: 55%; margin-left: 12px;" src="./images/_product1/mbag.jpg"><h7 class="_p_v_seg_l " style="color: #000; font-size:7pt; margin-left: 4px;">Male Bag Shoes</h7></a></div>
							
							<div><a class="discovery" href="https://www.fortismall.com/?cat_=SRQj2zLb-REEkSL-%-lLS2bkzI"><img class="_this_p_img_q" style=" padding-top: 5px; padding-right: 18px; width: 90%;  height: 55%; margin-left: 12px;" src="./images/_product1/cso.jpg"><h7 class="_p_v_seg_l " style="color: #000; font-size:7pt; margin-left: 15px;">Computer Security</h7></a></div>

										<div><a class="left" href="https://www.fortismall.com/?cat_=MLsTzM,-GLs2zI-%-Mskb"><img class="_this_p_img_q" style=" padding-top: 5px; padding-right: 18px; width: 90%;  height: 55%; margin-left: 12px" src="./images/_product1/hair.jpg"><h7 class="_p_v_seg_l " style="color: #000; font-size:7pt;">Hair & Beauty</h7></a></div>

							<div><a class="discovery" href="https://www.fortismall.com/?cat_=ALrLTbI-%-rszSMLl"><img class="_this_p_img_q" style=" padding-top: 5px; padding-right: 18px; width: 90%;  height: 55%; margin-left: 15px" src="./images/_product1/jwe.jpg"><h7 class="_p_v_seg_l " style="color: #000; font-size:7pt; margin-left: 18px;">Jewelry</h7></a></div>
						</div>
					</div>
				</div>
			</div>
-->
			<style type="text/css">
				.tymix{
					color: #000;
				}
			</style>




	<?php

	$getFlDeal = $class_->runS("SELECT * FROM `products` WHERE `client_p` = '2' AND `flash_deal_d` = '$fd_d' AND `flash_deal_tf` = '$tf' ORDER BY RAND()LIMIT 8 ");
	if (mysqli_num_rows($getFlDeal) > 0) { ?>

		<div class="_flow_t_board_" style="background: #<?php echo rand(111111,999999); ?>;">
							
			<div class="_flow_t_board_in" style="background: #<?php echo rand(111111,999999); ?>;">

				<script type="text/javascript">
					window.onload = function () {
						var _fl_timMP = document.querySelector("._fl_timMP");
						td("<?php echo $tf_c_DWN ?>", _fl_timMP, "Flash Sales: ");
					}
				</script>

				<div class="_fl_timMP">Flash Sales</div>

				<div class="__in_F__">
					
					<center>
						
						<?php
							while ($row_FD = mysqli_fetch_assoc($getFlDeal)) {
								$p_id = $row_FD['id'];
								$image = $class_->getImageP($p_id);
								$price_range = $row_FD['price_range'];
								$name = $row_FD['name'];
								$discount_ = $row_FD['discount']; ?>

									<a href="./?product_v=<?php echo $p_id; ?>" class="__model__M _flas_DM">

										<div class="_this_p_img_rst _fl_imGG"><img class="fld_img" src="./images/_product/<?php echo $image; ?>"></div>

										<div class="_fl_secX">
											<div class="_fl_P _x25" style="  text-transform: capitalize; "><?php if (strlen($name) > 40) {
								echo substr($name, 0,15)."...";
							} else {
								echo $name;
							}; ?></div>
											<div class="_fl_P _x25" style=" font-weight: 700; "><?php echo $class_->PriceR($price_range); ?></div>
										</div>

										<!-- <div class="_fl_O"> <div class="_fl_In"></div> </div> -->

									</a>

								<?php
							}
						?>

					</center>

				</div>

				<div class="_flow_not">
					<a class="_mor_fld" href="./?flash_deals=1&up=<?php echo $tf; ?>">View All</a>
				</div>

			</div>
			
		</div>

	<?php } ?>

	<?php } ?>

	<div class="_o_body">

		<?php if (isset($_GET['flash_deals'])) {

			$array_ = array(null, "00:00", "06:00", "12:00", "18:00");
			$up = $_GET['up'];

			for ($i=$tf; $i <= 4; $i++) { ?>

				<a href="./?flash_deals=1&up=<?php echo $i; ?>" class="_fl_d_date <?php if ($i == $tf) { echo "d_fl_"; }; ?>">
					<div class="_fd_m_HD _sub_fHD"><?php echo $array_[$i]; ?></div><br>
					<div class="_fd_m_HD _sub_fHD">
						
						<?php
							if ($i < $tf) {
								echo "PAST";
							} else if ($i == $tf) {
								echo "ON";
							} else {
								echo "UPCOMING";
							}
						?>

					</div>
				</a>

			<?php }

		if ($up < $tf || $up > 4) {
			$getFlDeal = $class_->runS("SELECT * FROM `products` WHERE `client_p` = '2' AND `flash_deal_d` = '$fd_d' AND `flash_deal_tf` = '$tf' ");
		} else {
			$getFlDeal = $class_->runS("SELECT * FROM `products` WHERE `client_p` = '2' AND `flash_deal_d` = '$fd_d' AND `flash_deal_tf` = '$up' ");
		}

		if (mysqli_num_rows($getFlDeal) > 0) { ?>

			<script type="text/javascript">
				window.onload = function () {
					var _fl_timMP = document.querySelector("._fl_timMP");
					td("<?php echo $tf_c_DWN ?>", _fl_timMP, "Flash Sales: ");
				}
			</script>
			
			<div class="_fl_timMP text_w" style="color: red;">Flash Sales</div>

			<div class="__in_F__">
				
				<center>
					
					<?php
						while ($row_FD = mysqli_fetch_assoc($getFlDeal)) {
							$p_id = $row_FD['id'];
							$image = $class_->getImageP($p_id);
							$price_range = $row_FD['price_range'];
							$discount_ = $row_FD['discount'];

							?>

								<a href="./?product_v=<?php echo $p_id; ?>" class="__model__M _flas_DM">

									<div class="_this_p_img_rst _fl_imGG"><img class="fld_img" src="./images/_product/<?php echo $image; ?>"></div>

									<div class="_fl_secX">
										<div class="_fl_P _x25"><?php echo $class_->PriceR($price_range); ?></div>
										<div class="_fl_P _strike"><?php echo $class_->discountR($price_range, $discount_); ?></div>
									</div>

									<!-- <div class="_fl_O"> <div class="_fl_In"></div> </div> -->

								</a>

							<?php
						}
					?>

				</center>

			</div>

		<?php } else { ?>

			<div class="__in_F__">
				<div class="_exp_Div">
						<div><a class="explore"><img class="_this_p_img_q" style=" padding-top: 5px; padding-right: 5px; width: 65%; height: 55%;  margin-left: 12px" src="./images/_product1/noprobss.png"><h4 class="tymix" style="color: #000;"></h4></a></div>

						
						</div>
				</div>
			</div>

		<?php } ?>

		<?php } elseif (isset($_GET['fd_rg'])) {

			?>
				<div class="__in_F__">

					<form class="_s_rgg__">
						<select class="_inpp____ __country____">
							<option value="">-- Select State --</option>

							<?php $get_cat = $class_->runS(" SELECT DISTINCT country FROM `user` WHERE `sell_eligible` = 2 ");

								while ($row__ = mysqli_fetch_assoc($get_cat)) {
									$id = $row__['id'];
									$category = $row__['country']; ?>
										<option value="<?php echo strtolower($category); ?>"><?php echo $class_->Capita($category); ?></option>
									<?php
								}
							?>							

						</select>
						<select class="_inpp____ _st_ate">
							<option value="">-- Select State --</option>
						</select>
					</form>

					<div class="_s_rgg__ rsp___"></div>

				</div>
			<?php

			$class_->_bs(2);

		} elseif (isset($_GET['u_bx'])) {
			
			$u_bx = $_GET['u_bx'];

			if ($u_bx == 1) {
				?>

				<div class="_lone_pg_hd">Quality Suppliers</div>
				<br><br>
				<?php

				$get_u_statu = $class_->runS("SELECT * FROM `user` WHERE `seller_retailer` = '1' ORDER BY id DESC ");
			} else {
				?>

				<div class="_lone_pg_hd">Manufacturers</div>
				<br><br>
				<?php
				$get_u_statu = $class_->runS("SELECT * FROM `user` WHERE `seller_manufacturer` = '1' ORDER BY id DESC ");
			}

			$check_g_m_list = $class_->row($get_u_statu);

			if ($check_g_m_list > 0) {

				while ($row = mysqli_fetch_assoc($get_u_statu)) {
					$_u_id = $row['u_id'];
					$_full_name = $row['full_name'];
					$_data_this_image = $row['image'];
					$_business_name = $row['business_name']; ?>

						<a class="_aut_hh" href="./?store_home=<?php echo $_u_id; ?>&st_hm=<?php echo uniqid(); ?>">
							<img class="tab_image__" src="./images/_p_img/<?php echo $_data_this_image; ?>">
							<div class="_u_bx_tab__name"><?php echo $class_->Capita($_business_name); ?></div>	
						</a>


							<?php
				}

			}

		} else if (isset($_GET['cart']) || isset($_GET['c_inv'])) { ?>

			<div class="_l75 _cart_M">

				<?php

				if ($total_cart > 0) {

					$invoice_id = $this_cart_id;
					$error = 0;

					if (isset($_GET['c_inv'])) {

						$chek_ord = $class_->runS(" SELECT * FROM `orders` WHERE `invoice_id` = '$this_cart_id' AND `paid_status` = 'UNPAID' ");
						$order_exist = mysqli_num_rows($chek_ord);

						$class_->runS(" DELETE FROM `orders` WHERE `invoice_id` = '$this_cart_id' AND `paid_status` = 'UNPAID' ");

					}

					while ($row_cart = mysqli_fetch_assoc($get_cart)) {
						
						$cart_thumb_id_ = $row_cart['cart_thumb_id'];
						$price_tag = explode("-", $row_cart['price_tag']);

						$c_q = $price_tag[2];
						$c_price = $price_tag[1];
						$c_var = $price_tag[0];
						
						// Getting sub product details
						$getCartP_Sub_Product = $class_->getSP($cart_thumb_id_);
						$get_sub_product_fetch = mysqli_fetch_assoc($getCartP_Sub_Product);
						$id_gi = $get_sub_product_fetch['product_id'];
						$id_image = $get_sub_product_fetch['image'];
						$color_gi = $get_sub_product_fetch['color'];

						$getCartP = $class_->getP($id_gi);

						if (mysqli_num_rows($getCartP) > 0) {

							$getW_P_FEt = mysqli_fetch_assoc($getCartP);

							$id = $getW_P_FEt['id'];
							$name = $getW_P_FEt['name'];
							$store_owner = $getW_P_FEt['store_owner'];
							$date_time = $getW_P_FEt['date_time'];

							$t_stamp = $getW_P_FEt['time_stamp'];

							$cart_tt += $c_price*$c_q;
							$prodo_discount_ = $getW_P_FEt['discount'];
							$prodo_discount += $getW_P_FEt['discount'];
							$cart_td += ($prodo_discount/100)*$c_price;

							if (isset($_GET['c_inv'])) {

								// Reached CheckOut
								if ($order_exist == 0) {
									$class_->runS(" UPDATE `sub_products` SET `reached_checkout` = reached_checkout+1 WHERE `id` = '$cart_thumb_id_' ");
								}

								$class_->runS(" INSERT INTO `orders` (`seller_id`, `user`, `date_time`, `quantity`, `price`, `color`, `size`, `capacity`, `product_id`, `thumb_p_id`, `invoice_id`, `tracking_status`, `tracking_label`, `status`, `date_stamp`, `f_status`, `p_status`, `tr_time`, `tr_loc`, `tr_day`, `paid_status`) VALUES ('$store_owner', '$this_u_id', '$date_time', '$c_q', '$c_price', '$color_gi', '$c_var', '$c_var', '$id', '$cart_thumb_id_', '$invoice_id', '', '', '0', '$date_a', 'UNCLAIMED', 'UNPAID', '-', '-', '-', 'UNPAID') ");
							}

							?>

							<div class="_l75 _cart_M">
							<div class="_flat_Mall_" id="_fM<?php echo $id; ?>" crt="<?php echo $value_1; ?>">

								<?php
									if ((time()-$t_stamp) < (60*60*24)) {
										?> <div class="__model__M_New">NEW</div> <?php
									}
								?>

								<div class="_img_fl_rst2"><img class="w_img" src="./images/_product/<?php echo $id_image; ?>"></div>
								
								<div class="_div_shr _div_shr_01">
									<div class="_pN<?php echo $id; ?>"><?php echo strtoupper($name); ?></div>
									<div class="_this_p_dtl _this_p_dtl_nP">
										<div class="_p_price_Ip_FL _pP<?php echo $id; ?>"><?php echo $class_->_currency($cur_currency, $c_price*$c_q); ?></div>
										
										<div class="_dis_count_ _w_d"><?php echo $date_time; ?></div>
									</div>
								</div>

								<div class="_div_shr _div_shr_02">
									<a class="pa _mP_Act m_none" target="_blank" href="./?product_v=<?php echo $id; ?>" id="<?php echo $id; ?>">&</a>
											<a class="pa _mP_Act" href="./?de_l_c=<?php echo $cart_thumb_id_; ?>">$</a>
								</div>

								<div class="_c_button_">
									<span class="_in_s_r_sold irx"> <span class="fwi">Color:</span> <?php echo $color_gi; ?></span>
									<span class="_in_s_r_sold irx"> <span class="fwi">Quantity:</span> <?php echo $c_q; ?></span>
									<span class="_in_s_r_sold irx"> <span class="fwi">Variation:</span> <?php echo $c_var; ?></span>
									<span class="_in_s_r_sold irx"> <span class="fwi">Price:</span> <?php echo $class_->_currency($cur_currency, $c_price); ?></span>
								</div>

									<?php if (!isset($_GET['c_inv'])) { ?>
										
									<?php } ?>

								</div>

							</div>

							<?php

						}

					}

				} else {

					$emp_cart = 0;

					?>
						<div class="_exp_Div">
							Your shopping cart is empty <span class='pa' style='float: unset;'>$</span>
						</div>
					


					<?php

				}; ?>

			</div>

			<div class="_l7434 _cart_M">

				<?php if ($total_cart > 0) { ?>
					<a class="_inp__ fleft _in_s_r_sold _b_green1 _mkpp__" href="./?clear_cart">Clear Cart</a>
				<?php }; ?>

				<div class="_in_Frm_xLF _col_c_sum">Cart Summary</div>

				

				

				<?php if ($total_cart > 0) { ?>

					

					<div class="in_flow_sum">
					<h2 class="_label___">Product Worth</h2>
					<div class="_info__ _c_p_w">&raquo <?php echo $class_->_currency($cur_currency, $cart_tt+$cart_td); ?></div>
				</div>

				<div class="in_flow_sum">
					<h2 class="_label___">Discount Percentage</h2>
					<div class="_info__ _c_t_dis">&raquo <?php echo $prodo_discount; ?>%</div>
				</div>

				<div class="in_flow_sum">
					<a class="_label___ ">Discount Price</a>
					<div class="_info__ _c_t_dis">&raquo <?php echo $class_->_currency($cur_currency, $cart_tt); ?></div>
				</div>

				<div class="in_flow_sum">
						<a class="_label___">Shipping Fee</a>
						<div class="_info__ _c_t_dis">&raquo <?php echo $class_->_currency($cur_currency, $all_ship_f); ?></div>
					</div>

				<div class="in_flow_sum">
					<a class="_label___ ">Cart Sub Total</a>
					<div class="_info__ _c_t_dis">&raquo <?php echo $class_->_currency($cur_currency, $cart_tt+$all_ship_f); ?></div>
				</div>

				<div class="in_flow_sum" style="background: #050505; border: none; margin-bottom: 10px; width: 100%; margin-left: 0px; margin-top: 10px; padding: 20px;">
					<h2 class="_label___" style="color: #FFF;">Grand Total</h2>
					<div class="_info__ _c_g_t" style="color: #FFF;">&raquo  <?php echo $class_->_currency($cur_currency, $cart_tt-$this_my_coupon+$all_ship_f);?></div> <!--($cart_tt-$this_my_coupon)+$all_ship_f);-->
				</div>
				
					<?php if ($this_my_coupon > 0) { ?>
						<div class="in_flow_sum">
							<a class="_label___">Voucher</a>
							<div class="_info__ _c_t_dis">&raquo <?php echo $class_->_currency($cur_currency, $this_my_coupon); ?></div>
						</div>


					<?php } else { ?>
						<div class="in_flow_sum">
						
							<form action="" method="POST" class="_val_coup">
								<a class="_label___" style="margin-top: 0px;">Have Voucher To Verify?</a>
								<input class="_inp__ _this_cp" type="text" name="_coupoun_code" placeholder="Enter Voucher code ">
								<input class="_inp__ button__ _bbY_d _b_green" type="submit" value="APPLY VOUCHER">
							</form>

						</div>
					<?php } ?>

				<?php } else {
					$all_ship_f = 0;
				}; ?>									
							

				

				<?php

					if ($emp_cart !== 0) {

						$ch_inv = $class_->runS(" SELECT * FROM `invoice` WHERE `invoice_id` = '$this_cart_id' AND `status` = 'UNPAID' ");

						$ch_inv_ = mysqli_num_rows($ch_inv);

						if ($ch_inv_ == 1) {

							$row_inv = mysqli_fetch_assoc($ch_inv); ?>

							<div class="_in_Frm_xLF _col_c_sum">Verified Shipping Info</div>

							<div class="in_flow_sum">
								<a class="">Address</a>
								<div class="_info__ _c_p_w">&raquo <?php echo $class_->Capita($row_inv['address']); ?></div>
							</div>

							<div class="in_flow_sum">
								<a class=" ">Phone</a>
								<div class="_info__ _c_p_w">&raquo <?php echo $class_->Capita($row_inv['phone']); ?></div>
							</div>

							<div class="in_flow_sum">
								<a class=" ">Email</a>
								<div class="_info__ _c_p_w">&raquo <?php echo $class_->Capita($row_inv['email']); ?></div>
							</div>

							<?php if (isset($_GET['c_inv'])) { ?>
								<a class="_in_s_r_sold bred" href="./?cart&dinv">CANCEL ORDER</a>

								<form >
								  <button type="button" class="_inp__ _chek_b button__ _bbY_d _b_green" onclick="payWithPaystack('<?php echo $this_email; ?>', '<?php echo (($cart_tt-$this_my_coupon)+$all_ship_f)*100; ?>', '<?php echo $invoice_id.'_'.time(); ?>', '<?php echo $this_u_id; ?>', '<?php echo $this_phone; ?>', 1)"> Pay via <img class="_chek_bcoin" src="./asset/cardpay.png"> </button>								   
								</form>


<form action="https://www.coinpayments.net/index.php" target="_blank" method="post">
	<input type="hidden" name="cmd" value="_pay">
	<input type="hidden" name="reset" value="1">
	<input type="hidden" name="merchant" value="723d864a29860b0f2ecc2b21e2f2568e">
	<input type="hidden" name="item_name" value="<?php echo strtoupper($name); ?>">
	<input type="hidden" name="item_number" value="1">
	<input type="hidden" name="invoice" value="<?php echo $cart_thumb_id_; ?>">
	<input type="hidden" name="currency" value="NGN">
	<input type="hidden" name="amountf" value="<?php echo (($cart_tt-$this_my_coupon)+$all_ship_f); ?>">
	<input type="hidden" name="quantity" value="1">
	<input type="hidden" name="allow_quantity" value="0">
	<input type="hidden" name="want_shipping" value="<?php echo $all_ship_f; ?>">
	<input type="hidden" name="success_url" value="https://yossell.com<?php if (type_ == 1) { echo "/?_q=" . $desh_code; } else if (type_ == 1) { echo "/?_bnc=" . $pay_desh_code . "&product_v=" . $_GET['product_v']; } ?>">
	<input type="hidden" name="cancel_url" value="https://yossell.com/c">
	<input type="hidden" name="ipn_url" value="https://yossell.com/ipn">
	<input type="hidden" name="allow_extra" value="1">
	<div class="_val_coup">
	<button class="_inp__ _chek_b button__ _bbY_d _b_green"> Pay Via <img class="_chek_bcoin" src="./asset/bitcoin.png"></button></div>
</form>

							<?php } else { ?>
								<a class="_in_s_r_sold bred" href="./?cart&dinv">Edit shipping details</a>
								<a href="./?c_inv=<?php echo md5($cart_val); ?>" class="_chek_b"> CHECKOUT <?php echo $class_->_currency($cur_currency, ($cart_tt-$this_my_coupon)+$all_ship_f); ?></a>
							<?php }

							if ($error == 0 && isset($_GET['c_inv'])) { ?>

								<script>

									function payWithPaystack(email, amt, inv_id, u_idd, this_phone, type_){
									  var handler = PaystackPop.setup({
									    key: 'pk_live_678b05726033f11b42fcba701eb235714c0af5fc',
									    email: email,
									    amount: amt,
									    ref: ''+inv_id,
									    metadata: {
									       custom_fields: [
									          {
									              display_name: "" + u_idd,
									              variable_name: "" + inv_id,
									              value: "" + this_phone
									          }
									       ]
									    },
									    callback: function(response){

									        var r_ref = response.reference;

												  if (r_ref == inv_id) {
												  	// alert("Your Payment Was Successful");
												  	if (type_ == 1) {
												  		window.location = "./?_q=<?php echo $desh_code; ?>";
												  	} else if (type_ == 1) {
												  		window.location = "./?_bnc=<?php echo $pay_desh_code; ?>&product_v=<?php echo $_GET['product_v']; ?>";
												  	}
												  	
												  } else {
												  	alert("Sorry Payment Was Not Successful");
												  }

									    },
									    onClose: function(){
									        // alert('window closed');
									    }
									  });
									  handler.openIframe();
									}
								</script>

								<?php
							}

						} else { ?>

							<form class="_" action="" method="POST">

								<div class="_in_Frm_xLF _col_c_sum" style="font-size: 20pt;">Shipping Information</div>

								<div class="_inf_col_">
									
									<label class="_label__">Shipping address</label>
									<input class="_inp__" type="text" name="address" placeholder="e.g. Plot 32 Maryan Lane" value="<?php echo $class_->Capita($this_address); ?>">

									<label class="_label__">Phone number</label>
									<input class="_inp__" type="text" name="phone" placeholder="e.g. +234816....." value="<?php echo $class_->Capita($this_phone); ?>">

									<label class="_label__">Email</label>
									<input class="_inp__" type="email" name="email" placeholder="e.g. example@mail.com" value="<?php echo $class_->Capita($this_email); ?>">

									<input class="_inp__ button__ fleft" type="submit" name="_c_inv" value="Confirm This Details">

								</div>

							</form>

						<?php } ?>

					<?php } ?>
				
			</div>

		<?php } else if (isset($_GET['register'])) {

			?>
				
				<form method="POST" class="_lGFrm__ _off_Frm">

					<h1 class="_in_Frm_xLF _l_Hd mbot">Join Us Free</h1>

						<label class="_label__">Phone Number</label>
					<input class="_inp__" type="text" name="display_n" placeholder="e.g. +23496543--" value="<?php echo $_POST['display_n']; ?>">

					<label class="_label__">FULL NAME</label>
					<input class="_inp__" type="text" name="full_name" placeholder="e.g. Marvel Duke" value="<?php echo $_POST['full_name']; ?>">

					<label class="_label__">EMAIL</label>
					<input class="_inp__" type="text" name="e_mail" placeholder="example@mail.com" value="<?php echo $_POST['e_mail']; ?>">


					<label class="_label__">PASSWORD</label>
					<input class="_inp__" type="password" name="password" placeholder="password">

					<label class="_label__">CONFIRM PASSWORD</label>
					<input class="_inp__" type="password" name="re_type_password" placeholder="re-type password">

					<?php
						if (isset($_POST['_rGst_'])) {
							echo "<div class='_notice_pix _mtop_10'>".$_resp_."</div>";
						}
					?>

					<input class="_inp__ button__" type="submit" value="COMPLETE" name="_rGst_">

					<center>
						<br>
						<p style="font-size: 12px;">As You Sign-Up, You Agree To Our <a style="color: #64649a; font-weight: 500;" href="./?terms_policy">Terms, Conditions And Privacy Policy, Including Our Cookie Use.</a></p>
						<br>
						<p>I Already Have An Account. <a class="_t_link___" href="./?login">Sign In</a> </p>
						<br>
					</center>

				</form>
			<?php

		} else if (isset($_GET['login'])) { ?>

			<form method="POST" class="_lGFrm__ _off_Frm">

				<h1 class="_in_Frm_xLF _l_Hd mbot">SIGN-IN</h1>

				<label class="_label__">Email</label>
				<input class="_inp__" type="text" name="e_mail" placeholder="example@mail.com" value="<?php echo $_POST['e_mail']; ?>">

				<label class="_label__">Password</label>
				<input class="_inp__" type="password" name="password" placeholder="password" value="<?php echo $_POST['e_mail']; ?>">

				<?php
					if (isset($_POST['_lgV_'])) {
						echo "<div class='_notice_pix _mtop_10'>".$_resp_."</div>";
					}
				?>

				<input class="_inp__ button__" type="submit" value="SIGN-IN" name="_lgV_">

				<center>
					<br>
					<p>Don't have an account? <a class="_t_link___" href="./?register">Join Us</a></p>
					<p>Forgot password? <a class="_t_link___" href="./?forgot">Mail Me</a></p>
					<br>
				</center>
				
			</form>
		
		<?php } else if (isset($_GET['forgot'])) { ?>

			<form method="POST" class="_lGFrm__ _off_Frm">

				<h1 class="_in_Frm_xLF _l_Hd mbot">Retrieve Password</h1>

				<label class="_label__">Email</label>
				<input class="_inp__" type="text" name="e_mail" placeholder="example@mail.com" value="<?php echo $_POST['e_mail']; ?>">

				<?php
					if (isset($_POST['_rTV_'])) {
						echo "<div class='_notice_pix _mtop_10'>".$_resp_."</div>";
					}
				?>

				<input class="_inp__ button__" type="submit" value="RETRIEVE" name="_rTV_">

				<center>
					<br>
					<p>Don't have an account? <a class="_t_link___" href="./?register">Join Us</a></p>
					<br>
					<p>Already have an account. <a class="_t_link___" href="./?login">Login</a> </p>
					<br>
				</center>
				
			</form>
		
		<?php } else if (isset($_GET['cat_']) || isset($_GET['s_cat_']) || isset($_GET['ss_cat_']) || isset($_GET['fil'])) {

			$_category = $class_->urlF($_GET['cat_'], 2);
			$s_category = $class_->urlF($_GET['s_cat_'], 2);
			$ss_category = $class_->urlF($_GET['ss_cat_'], 2);

			// Check module called			
			if (isset($_GET['cat_']) && isset($_GET['s_cat_']) && isset($_GET['ss_cat_'])) {

				$modeX3 = $modeX2 = $modeX1 = 1;
				$dom_hlf_link = "./?cat_=" . $_GET['cat_'] . "&s_cat_=" . $_GET['s_cat_'] . "&&ss_cat_=" . $_GET['ss_cat_'];

				if ($_GET['fil'] == "hl") {
					$getRPFlw = $class_->runS(" SELECT * FROM `products` WHERE `client_p` = '2' AND `category` = '$_category' AND `sub_category` = '$s_category' AND `sub_sub_category` = '$ss_category' ORDER BY price DESC ");
				} else if ($_GET['fil'] == "lh") {
					$getRPFlw = $class_->runS(" SELECT * FROM `products` WHERE `client_p` = '2' AND `category` = '$_category' AND `sub_category` = '$s_category' AND `sub_sub_category` = '$ss_category' ORDER BY price ASC ");
				} else {
					$getRPFlw = $class_->runS(" SELECT * FROM `products` WHERE `client_p` = '2' AND `category` = '$_category' AND `sub_category` = '$s_category' AND `sub_sub_category` = '$ss_category' ORDER BY id DESC");
				}
				
				$get_PBrand = $class_->runS(" SELECT DISTINCT brand FROM `products` WHERE `client_p` = '2' AND `category` = '$_category' AND `sub_category` = '$s_category' AND `sub_sub_category` = '$ss_category' ");

			} else if (isset($_GET['cat_']) && isset($_GET['s_cat_'])) {

				$modeX2 = $modeX1 = 1;
				$dom_hlf_link = "./?cat_=" . $_GET['cat_'] . "&s_cat_=" . $_GET['s_cat_'];

				if ($_GET['fil'] == "hl") {
					$getRPFlw = $class_->runS(" SELECT * FROM `products` WHERE `client_p` = '2' AND `category` = '$_category' AND `sub_category` = '$s_category' ORDER BY price DESC ");
				} else if ($_GET['fil'] == "lh") {
					$getRPFlw = $class_->runS(" SELECT * FROM `products` WHERE `client_p` = '2' AND `category` = '$_category' AND `sub_category` = '$s_category' ORDER BY price ASC ");
				} else {
					$getRPFlw = $class_->runS(" SELECT * FROM `products` WHERE `client_p` = '2' AND `category` = '$_category' AND `sub_category` = '$s_category' ORDER BY id DESC");
				}
				
				$get_PBrand = $class_->runS(" SELECT DISTINCT brand FROM `products` WHERE `client_p` = '2' AND `category` = '$_category' AND `sub_category` = '$s_category' ");

			} else {

				if (isset($_GET['fil'])) {

					// $dom_hlf_link = "./?cat_=" . $_GET['cat_'];
					$fil = $_GET['fil'];

					if ($fil == "sp") {

						$getRPFlw = $class_->runS(" SELECT * FROM `products` WHERE `client_p` = '2' AND `sponsored` = 'sp' AND `flash_deal_d` != '$fd_d' ORDER BY RAND() ");

					} else if ($fil == "rc") {
						
						$getRPFlw = $class_->runS(" SELECT * FROM `products` WHERE `client_p` = '2' AND`recommend` = 'rc' AND `flash_deal_d` != '$fd_d' ORDER BY RAND() ");

					} else if ($fil == "nb") {
						
						$getRPFlw = $class_->runS("SELECT * FROM `products` WHERE `client_p` = '2' AND `sponsored` != 'sp' AND `recommend` != 'rc' AND `flash_deal_d` != '$fd_d' ORDER BY RAND() ");

					}
					
				} else {

					$modeX1 = 1;
					$dom_hlf_link = "./?cat_=" . $_GET['cat_'];

					if ($_GET['fil'] == "hl") {
						$getRPFlw = $class_->runS(" SELECT * FROM `products` WHERE `client_p` = '2' AND `category` = '$_category' ORDER BY price DESC ");
					} else if ($_GET['fil'] == "lh") {
						$getRPFlw = $class_->runS(" SELECT * FROM `products` WHERE `client_p` = '2' AND `category` = '$_category' ORDER BY price ASC ");
					} else {
						$getRPFlw = $class_->runS(" SELECT * FROM `products` WHERE `client_p` = '2' AND `category` = '$_category' ORDER BY id ASC");
					}
					
					$get_PBrand = $class_->runS(" SELECT DISTINCT brand FROM `products` WHERE `client_p` = '2' AND `category` = '$_category' ");

				}

			}

			if (mysqli_num_rows($getRPFlw) > 0 || $_GET['fil'] == "bs") { ?>

				<div class=" fl_ll _lmax75 _cart_M">

					<div class="_nnav_ppV">

							<?php
						if (mysqli_num_rows($get_PBrand) > 0) {
							?>
								<div class="_nnav_ppV">
									<div class="_in_s_r_sold _grey_">Favorite BRANDS</div>
									<div class="_nnav_ppV_rM">
										<?php
											while ($rowBrand = mysqli_fetch_assoc($get_PBrand)) {
												
												$brand_ = $rowBrand['brand'];

												// ---------- START BRAND DETAIL
												$get_PBrandDetail = $class_->runS(" SELECT image FROM `brand` WHERE `brand_name` = '$brand_' `products` = '$products' ");
												$rowBrandDetail = mysqli_fetch_assoc($get_PBrandDetail);
												$brand_img = $rowBrandDetail['image'];
												// ------------------------------- END BRAND DETAIL

												?>
													<a title="<?php echo $class_->Capita($brand_); ?>" href="./?cat_=<?php echo $class_->urlF($category, 1); ?>&br=<?php echo $class_->urlF($brand_, 1); ?>" class="_brnpV"><img class="_nnav_ppV_Br" src="./images/_brand/<?php echo $brand_img; ?>"></a>
												<?php
											}
										?>
									</div>
								</div>



						<a class="_in_s_r_sold _grey_" href="./">Home</a>
						
						<?php

							if ($modeX1 == 1) {
								?> <a class="_in_s_r_sold _grey_" href="./?cat_=<?php echo $_GET['cat_']; ?>"><?php echo $_category; ?></a> <?php
							}

							if ($modeX2 == 1) {
								?> <a class="_in_s_r_sold _grey_" href="./?cat_=<?php echo $_GET['cat_']; ?>&s_cat_=<?php echo $_GET['s_cat_']; ?>"><?php echo $s_category; ?></a> <?php
							}

							if ($modeX3 == 1) {
								?> <a class="_in_s_r_sold _grey_" href="./?cat_=<?php echo $_GET['cat_']; ?>&s_cat_=<?php echo $_GET['s_cat_']; ?>&&ss_cat_=<?php echo $_GET['ss_cat_']; ?>"><?php echo $ss_category; ?></a> <?php
							}

						?>
					</div>

				
							<?php
						}
					?>

					<center>
						<?php
						if ($_GET['fil'] == "bs") {

							$class_->_bs("MV");

						} else {
							$class_->callTemp($getRPFlw);
						}

						?>
					</center>

				</div>

			<?php };

		} else if (isset($_GET['st_hm'])) {

			$den_sth = $_GET['store_home'];
			$get_PBrand = $class_->runS(" SELECT DISTINCT brand FROM `products` WHERE `client_p` = '2' AND `store_owner` = '$den_sth' ");

			$get_Pow = $class_->runS("SELECT * FROM `user` WHERE `u_id` = '$den_sth' ");

			$row = mysqli_fetch_assoc($get_Pow);
			$my_st_P_u_id = $row['u_id'];
			$my_st_P_bName = $row['business_name'];
			$my_st_P_bImage = $row['image'];
			$my_st_P_u_id = $row['u_id'];
			$my_st_P_sell_eligible = $row['sell_eligible'];
			$my_st_P_sell_date_joined = $row['date_joined'];

			$gett_DName = $class_->runS("SELECT DISTINCT category FROM `products` WHERE `client_p` = '2' AND `store_owner` = '$den_sth' ");

			if (isset($_GET['flhmp'])) {
				$st_cat = $class_->urlF($_GET['st_cat'], 2);
				$gett_SponP = $class_->runS("SELECT * FROM `products` WHERE `client_p` = '2' AND `store_owner` = '$den_sth' AND `category` = '$st_cat' ORDER BY id DESC ");
			} else if (isset($_GET['br'])) {
				$st_br = $class_->urlF($_GET['br'], 2);
				$gett_SponP = $class_->runS("SELECT * FROM `products` WHERE `client_p` = '2' AND `store_owner` = '$den_sth' AND `brand` = '$st_br' ORDER BY id DESC ");
			} else {
				$gett_SponP = $class_->runS("SELECT * FROM `products` WHERE `client_p` = '2' AND `store_owner` = '$den_sth' ORDER BY id DESC ");
			}
			
			$total_p = mysqli_num_rows($gett_SponP);
			?>

				
					<div class="_str_hmp__">

					<!--<h1 class="_p_st_hD">Products of <?php echo $my_st_P_bName; ?></h1> -->

					<div class="_r25">
						<div class="str_img__rst"><img class="str_img__" src="./images/_p_img/<?php echo $my_st_P_bImage; ?>"></div>
					</div>
					
					<div class="_l75">
						<div class="_str_hmp_na"><?php echo $my_st_P_bName; ?> STORE HOME<?php if ($this_sell_eligible == 2) { ?>
						<p class="pa"  style="color: #0ae14f; float: right;">U</p><?php }; ?></div>

						<div class="div_bl_cap" style="font-size: 10pt; " ><b>Total Products: </b><?php echo $total_p; ?> found</div>
						<div class="div_bl_cap" style="font-size: 10pt; " ><b>Joined yossell: </b><?php echo $my_st_P_sell_date_joined; ?></div>
					</div>
				</div>

					<div class="mobileShow">
									<div class="dropdown">
  <button onclick="myFunction()" class="dropbtn" style="  border-bottom: 1px solid #ff6600; overflow: hidden; width: 320px; padding: 15px; font-weight: 700; color: #FFF; display: block; background: #050505; box-shadow: 0px 10px 19px #ff6600; border-radius: 95px; border-radius: 95px 0px;">Shop By Category</button>
  <div id="myDropdown" class="dropdown-content">

  	<a href="./?store_home=<?php echo $_GET['store_home']; ?>&st_hm=<?php echo uniqid(); ?>" class="__lfil__">View All Products</a>

  		<?php while ($row_cat___ = mysqli_fetch_assoc($gett_DName)) { ?>
									
									<a href="./?store_home=<?php echo $_GET['store_home']; ?>&st_hm=<?php echo uniqid(); ?>&flhmp=c&st_cat=<?php echo $class_->urlF($row_cat___['category'], 1); ?>" class="__lfil__"><?php echo $class_->Capita($row_cat___['category']); ?></a></nav>


									
								<?php }; ?>

</div>
</div>



								<script >
									/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
								</script>
					
				

				</div>

				<div class="_l75">
					
					<?php if (mysqli_num_rows($gett_SponP) > 0) { ?>

						<?php
							if (mysqli_num_rows($get_PBrand) > 0) {
								?>
									<div class="_nnav_ppV">
										
										<div class="_nnav_ppV_rM">
											<?php
												while ($rowBrand = mysqli_fetch_assoc($get_PBrand)) {
													
													$brand_ = $rowBrand['brand'];

													// ---------- START BRAND DETAIL
													$get_PBrandDetail = $class_->runS(" SELECT image FROM `brand` WHERE `brand_name` = '$brand_' ");
													$rowBrandDetail = mysqli_fetch_assoc($get_PBrandDetail);
													$brand_img = $rowBrandDetail['image'];
													// ------------------------------- END BRAND DETAIL

													?>
														<a title="<?php echo $class_->Capita($brand_); ?>" href="./?store_home=<?php echo $_GET['store_home']; ?>&st_hm=<?php echo uniqid(); ?>&br=<?php echo $class_->urlF($brand_, 1); ?>" class="_brnpV"><img class="_nnav_ppV_Br" src="./images/_brand/<?php echo $brand_img; ?>"></a>
													<?php
												}
											?>
										</div>
									</div>
								<?php
							}
						?>

						<div class="_flow_inPP">

							<center>
								<?php $class_->callTemp($gett_SponP); ?>
							</center>

						</div>

					<?php }; ?>

				</div>


</div>

		<?php 

		} else if (isset($_GET['_serach_']) && isset($_GET['s'])) {

			$qry = $_GET['s'];

			$gett_SponP = $class_->runS("SELECT * FROM `products` WHERE `client_p` = '2' AND `name` LIKE '%$qry%' OR `description` LIKE '%$qry%' ORDER BY id DESC ");



			if (mysqli_num_rows($gett_SponP) > 0) { ?>
				
				<div class="_flow_inPP">

					<center> <h1 class="_pVHd">Search Result</h1> </center>

					<center>
						<?php $class_->callTemp($gett_SponP); ?>
					</center>

				</div>

			<?php } else { ?>

				<div class="_exp_Div">
					No result found
				</div>
			</div>
			
			

				<?php }




		} else if (isset($_GET['contact_us'])) { ?>

			<div class="_cont_u_pg">
				<div class="_lone_pg_hd">Contact Us</div>
				<br><br>

				<div class="left_50">

					<p class="_fd_090__">
						How can we help?
						<span style=" font-size: 12px; display: block; width: 100%; font-weight: 600;">Here are the most frequently asked questions.</span>
					</p>

					<p class="_c_pp___" style="color: #ff005e;">I don't know why no free Shipping!	</p>
					<p class="_c_pp___" style="color: #ff005e;">Please i am looking For!	</p>
					<p class="_c_pp___" style="color: #ff005e;">Whats The Duration Of Delivery To the USA? </p>
					<p class="_c_pp___" style="color: #ff005e;">How Can I Become An Affiliate?	</p>
					<p class="_c_pp___" style="color: #ff005e;">Why No Pay On Delivery?	</p>

					<div class="_call_module _ct_btn___ box" id="ts" href="./?store_home=<?php echo $store_owner; ?>&st_hm=<?php echo uniqid(); ?>">Create A Ticket</div>

				</div>
				
				<div class="right_50">

					<p class="_fd_090__">
					<!--		<h2>Visit our Experience Center</h2><br>
					GRA Amagba, Benin City (Opposite I.O Farms) <br><br>-->
					<h4 >Customer Care Centre</h4> 
					For complaints speak to one of our customer service agents. <br>
					+234814 178 6417 or +2347054 396 211 <br><br>
					Office Hours: Mon-Fri, 8am-8pm; Sat, 9am-5pm; Public Holidays, 9am-5pm.<br><br>
					<h4 style="color: #FFF">Email</h4> 
					help@fortismall.com <br><br>


					<center>
				<?php
					foreach ($payment_gateway as $key => $value) { ?>
						<a  href="./?privacy"><img title="<?php echo $class_->Capita($key); ?>" class="_ft_ic__" src="./asset/pay_icon/<?php echo $value; ?>">
					<?php }
				?>

				<?php
					foreach ($orders as $key => $value) { ?>
						<a  href="./?terms_policy"><img title="<?php echo $class_->Capita($key); ?>" class="_ft_ic__"  src="./asset/pay_icon/<?php echo $value; ?>">
					<?php }
				?>

								<?php
					foreach ($help as $key => $value) { ?>
						<a  href="./?about_us"><img title="<?php echo $class_->Capita($key); ?>" class="_ft_ic__" src="./asset/pay_icon/<?php echo $value; ?>">
					<?php }
				?>

								<?php
					foreach ($feedback as $key => $value) { ?>
						<a href="./?contact_us"><img title="<?php echo $class_->Capita($key); ?>" class="_ft_ic__" src="./asset/pay_icon/<?php echo $value; ?>">
					<?php }
				?>
		 	</center>


				</div>

			</div>
</p>

<?php } else if (isset($_GET['privacy'])) { ?>
			<div class="_cont_u_pg">
				<div class="_lone_pg_hd">Privacy Policy</div>
				<p class="_fd_090__">
				</p>
				Your privacy is important to fortismall and always has been. So we've developed a Privacy Policy that covers how we collect, use, disclose, transfer, and store your information. Please take a moment to familiarize yourself with our privacy practices and let us know if you have any questions.
By visiting fortismall, you are accepting the practices described in this Privacy Notice.<br><br><br>


<p class="_fd_090__">

		<span style="font-size: 12px; display: block; width: 100%; font-weight: 600;">Here are the most frequently asked questions.</span>
					</p>

					<div class="_cont_u_pg">

    <p class="_c_pp___" style="background-color: #ddd">How Personal Information about Customers is used?</p>
    <p class="_c_pp___" style="background-color: #ddd">What Personal Information about Customers does fortismall Gather?
    <p class="_c_pp___" style="background-color: #ddd">What about Cookies?</p>
   <p class="_c_pp___" style="background-color: #ddd">What is the accuracy of the Personal data provided to fortismall?</p>
   <p class="_c_pp___" style="background-color: #ddd">How Secure is Information about Me?</p>
   <p class="_c_pp___"style="background-color: #ddd">Examples of Information Collected</p>
    <p class="_c_pp___"style="background-color: #ddd">What are your rights?</p>


	<div class="_cont_u_pg">

<h2> How Personal Information about Customers is used?</h2><br>

User data may be shared with fortismall providers to improve order processing and customer service. It may also be used both for marketing research purposes and customer relation management, it being specified that some of those providers are not located in the European Union.
</div><br><br>
<h2> What is done with your personal information?</h2><br>
User data collected help us to personalize our website according to each userís wishes and preferences. Offering you the most spontaneous and friendly surfing experience is our priority. Data collected are for statistical purposes only and help us to:

     <p class="_c_pp___" style="background-color: #ddd" >Process orders</p>
     <p class="_c_pp___" style="background-color: #ddd">Deliver products and services</p>
     <p class="_c_pp___" style="background-color: #ddd">Process payments and communicate with you about your orders, products, services and promotional offers</p>
    <p class="_c_pp___" style="background-color: #ddd"> Keep and update our database and your accounts with us</p>
     <p class="_c_pp___" style="background-color: #ddd">Propose a unique and targeted navigation experience</p>
     <p class="_c_pp___" style="background-color: #ddd">Prevent and detect fraud and abuse on our website</p>
    </p>

<div class="left_50" style="background-color: #ddd"><h1> By completing an order or signing up, you agree to receive </h2><br>

<p class="_c_pp___" style="background-color: #ddd" >(a) emails associated with finalizing your order, which may contain relevant offers from third parties, </p> 

<p class="_c_pp___" style="background-color: #ddd" >(b) emails asking you to review fortismall and your purchase</p>

<p class="_c_pp___" style="background-color: #ddd" >(c) promotional emails, SMS and push notifications from fortismall. You may unsubscribe from promotional emails via a link provided in each email. If you would like us to remove your personal information from our database, unsubscribe from emails and/or SMS, please email Customer Service email address by country</p>
</div>

<div class="_cont_u_pg">
<h2> What about Cookies?</h2><br>

Cookies are unique identifiers that we transfer to your device to enable our systems to recognize your device and to provide features to make your navigation experience unique and targeted.

The acceptance of cookies is not a requirement for visiting the Site. However we would like to point out that the use of the 'basket' functionality on the Site and ordering is only possible with the activation of cookies. <p>Cookies are tiny text files which identify your computer to our server as a unique user when you visit certain pages on the Site and they are stored by your Internet browser on your computer's hard drive.</p> Cookies can be used to recognize your Internet Protocol address, saving you time while you are on, or want to enter, the Site. We only use cookies for your convenience in using the Site (for example to remember who you are when you want to amend your shopping cart without having to re-enter your email address) and not for obtaining or using any other information about you (for example targeted advertising). <p>Your browser can be set to not accept cookies, but this would restrict your use of the Site. Please accept our assurance that our use of cookies does not contain any personal or private details and are free from viruses.</p>

fortismall uses Google Analytic for marketing and personal data optimization purposes. fortismall also uses Google Digital Marketing to propose targeted offers.<br><br><br>
<h2>To find out more:</h2>
<br><br><br>
   About Google Analytics: Google Search
   About Google Digital Marketing: Google Search

<br><br><br><h2>What is the accuracy of the Personal Data provided to fortismall?</h2> <br>

You declare and guarantee that You are the owner or have the necessary rights on the content that You transmit to Us; that at the date of its transmission 
<p class="_c_pp___" style="background-color: #ddd" >(i) the content is exact and true,</p>
	<p class="_c_pp___" style="background-color: #ddd" >(ii) the use of the content does not contravene any of our policies and will not be damaging to any third party 
		(i.e. that the content is not defamatory).</p>
	</div>

<div class="_cont_u_pg">
<h2>How Secure is Information about Me?</h2><br>

<p class="_c_pp___" style="background-color: #ddd" >It is important for you to protect against unauthorized access to your password and to your computer. Be sure to sign off when finished using a shared computer.</p>
<p class="_c_pp___" style="background-color: #ddd" >We work to protect the security of your information during transmission by using Secure Sockets Layer (SSL) software, which encrypts information you input.</p>
<p class="_c_pp___" style="background-color: #ddd" >We reveal only the last four digits of your credit card numbers when confirming an order. Of course, we transmit the entire credit card number to the appropriate credit card company during order processing.</p>
</div>

<div class="_cont_u_pg">
<h2> Information We Collect:</h2><br>

  <h4>Information you give us:</h4> <br><p>You provide most such information when you search, buy, post, participate in a contest or questionnaire, or communicate with customer service. For example, you provide information when you search for a product; place an order through fortismall or one of our third-party sellers; provide information in Your Account (and you might have more than one if you have used more than one e-mail address when shopping with us) or Your Profile; communicate with us by phone, e-mail, or otherwise; complete a questionnaire or a contest entry form. As a result of those actions, you might supply us with such information as your name, address, and phone numbers; credit card information; people to whom purchases have been shipped, including addresses and phone number; e-mail addresses of your friends and other people; content of reviews and e-mails to us; personal description and photograph in Your Profile ; and financial information, including Social Security and driver's license numbers.</p></div></p><br><br>

   <div class="_cont_u_pg"><h4>Automatic information:</h4> <br><p>Examples of the information we collect and analyze include the Internet protocol (IP) address used to connect your computer to the Internet; login; e-mail address; password; computer and connection information such as browser type, version, and time zone setting, browser plug-in types and versions, operating system, and platform; purchase history, which we sometimes aggregate with similar information from other customers to create features like Top Sellers ; the full Uniform Resource Locator (URL) clickstream to, though, and from our Web site, including date and time; cookie number; products you viewed or searched for; and the phone number you used to call our 800 number. We may also use browser data such as cookies, Flash cookies (also known as Flash Local Shared Objects), or similar data on certain parts of our Web site for fraud prevention and other purposes. During some visits we may use software tools such as JavaScript to measure and collect session information, including page response times, download errors, length of visits to certain pages, page interaction information (such as scrolling, clicks, and mouse-overs), and methods used to browse away from the page. We may also collect technical information to help us identify your device for fraud prevention and diagnostic purposes.</p></div></p><br><br>
<div class="_cont_u_pg">
   <h4> Mobile:</h4><br><p> Most mobile devices provide users with the ability to disable location services. Most likely, these controls are located in the device's settings menu. If you have questions about how to disable your device's location services, we recommend you contact your mobile service carrier or your device manufacturer.</p></div></p><br><br>

   <div class="_cont_u_pg"><h4>Information from other sources:</h4> <p><br><br>Examples of information we receive from other sources include updated delivery and address information from our carriers or other third parties, which we use to correct our records and deliver your next purchase or communication more easily; account information, purchase or redemption information, and page-view information from some merchants with which we operate co-branded businesses or for which we provide technical, fulfillment, advertising, or other services; search term and search result information from some searches conducted through the Web search features.</p></div></p><br><br>

<div class="_cont_u_pg"><h2> What are your rights?</h2>
<p><br><br>
If you are concerned about your data you have the right to request access to the personal data which we may hold or process about you. You have the right to require us to correct any inaccuracies in your data free of charge. At any stage you also have the right to ask us to stop using your personal data for direct marketing purposes.</p></e<s></div>
	


					
				</div>

			</div>		

<br><br><br><br>
		<?php } else if (isset($_GET['terms_policy'])) { ?>
			<div class="_cont_u_pg">
				<div class="_lone_pg_hd">Terms & Conditions- Yossell</div>
				<p class="_fd_090__">
						<h2>Introduction</h2><br><br>
						<span style="font-size: 12px; display: block; width: 100%; font-weight: 600;">Last updated: (24/05/2018) </span>
					</p><br>Please read these Terms and Conditions carefully before using the https://www.fortismall.com website and the Yossell mobile application Trade Service operated by Yossell. <br><br>


					 Your access to and use of the Service is conditioned on your acceptance of and compliance with these Terms.  These Terms apply to all visitors, users and others who access or use the Service. <br><br>

By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part of the terms then you may not access the Service. <br><br>

<div class="right_50">
					<h3>Use of the Site</h3> <br>
					You confirm that you are at least 18 years of age or are accessing the Site under the supervision of a parent or legal guardian.
Both parties agree that this website may only be used in accordance with these Terms and Conditions of Use. If you do not agree with the Terms and Conditions of Use or do not wish to be bound by them, you agree to refrain from using this website.<br><br>
We grant you a non-transferable, revocable and non-exclusive license to use this Site, in accordance with the Terms and Conditions of Use, for such things as: shopping for personal items sold on the site, gathering prior information regarding our products and services and making purchases. Commercial use or use on behalf of any third party is prohibited, except as explicitly permitted by us in advance.<br><br>	These Terms and Conditions of Use specifically prohibit actions such as: accessing our servers or internal computer systems, interfering in any way with the functionality of this website, gathering or altering any underlying software code, infringing any intellectual property rights. This list is non-exhaustive and similar actions are also strictly prohibited.<br><br>
Any breach of these Terms and Conditions of Use shall result in the immediate revocation of the license granted in this paragraph without prior notice to you. <br><br> Should we determine at our sole discretion that you are in breach of any of these conditions, we reserve the right to deny you access to this website and its contents and do so without prejudice to any available remedies at law or otherwise.<br><br>
Certain services and related features that may be made available on the Site may require registration or subscription. <br><br>Should you choose to register or subscribe for any such services or related features, you agree to provide accurate and current information about yourself, and to promptly update such information if there are any changes. <br><br>Every user of the Site is solely responsible for keeping passwords and other account identifiers safe and secure.<br><br>
The account owner is entirely responsible for all activities that occur under such password or account. Furthermore, you must notify us of any unauthorized use of your password or account. The Site shall not be responsible or liable, directly or indirectly, in any way for any loss or damage of any kind incurred as a result of, or in connection with, your failure to comply with this section. <br><br>
During the registration process you agree to receive promotional emails from the Site. <br><br> You can subsequently opt out of receiving such promotional e-mails by clicking on the link at the bottom of any promotional email. <br><br>
	


			<br><br>
					<h2>Information Available on Website</h2> <br>
					You accept that the information contained in this website is provided ìas is, where isî, is intended for information purposes only and that it is subject to change without notice.<br><br> Although we take reasonable steps to ensure the accuracy of information and we believe the information to be reliable when posted, it should not be relied upon and it does not in any way constitute either a representation or a warranty or a guarantee.<br><br>
Product representations expressed on this Site are those of the vendor and are not made by us. Submissions or opinions expressed on this Site are those of the individual posting such content and may not reflect our opinions.<br><br>
We make no representations as to the merchantability of any products listed on our website, and we hereby disclaim all warranties, whether express or implied, as to the merchantability and/or fitness of the products listed on our website for any particular purpose. <br><br> We shall not be held responsible or made liable for any damages or injury which may arise as a result of any error, omission, interruption, deletion, delay in operation or transmission, computer virus, communication failure and defect in the information, content, materials, software or other services included on or otherwise made available through our Website. We understand that certain state laws do not allow limitations on implied warranties or limitation of certain damages, these disclaimers may therefore not apply where these laws are applicable. <br>
				</div>
			</div>

			<div class="right_50">
	
				<h2>Accessibility of Website</h2> <br>
					Our aim is to ensure accessibility to the website at all times, however we make no representation of that nature and reserves the right to terminate the website at any time and without notice.<br><br> You accept that service interruption may occur in order to allow for website improvements, scheduled maintenance or may also be due to outside factors beyond our control.
 
				</div>
			</div>
					<div class="right_50">
					<h2>Links and Thirds Party Websites</h2> <br>
					We may include links to third party websites at any time. However, the existence of a link to another website should not be consider as an affiliation or a partnership with a third party or viewed as an endorsement of a particular website unless explicitly stated otherwise.
In the event the user follows a link to another website, he or she does so at his or her own risk. We accept no responsibility for any content, including, but not limited to, information, products and services, available on third party websites.
Creating a link to this website is strictly forbidden without our prior written consent. Furthermore, we reserve the right to revoke our consent without notice or justification.
				</div>
			</div> <br>

						<div class="right_50">
						<h2>Intellectual Property</h2> <br>
					Both parties agree that all intellectual property rights and database rights, whether registered or unregistered, in the Site, information content on the Site and all the website design, including, but not limited to, text, graphics, software, photos, video, music, sound, and their selection and arrangement, and all software compilations, underlying source code and software shall remain at all times vested in us or our licensors. Use of such material will only be permitted as expressly authorized by us or our licensors.
Any unauthorised use of the material and content of this website is strictly prohibited and you agree not to, or facilitate any third party to, copy, reproduce, transmit, publish, display, distribute, commercially exploit or create derivative works of such material and content.
 				</div>
			</div> <br>

						<div class="right_50">
					
					<h2>Data Protection</h2> <br>
					Any personal information collected in relation to the use of this website will be held and used in accordant with our <a href="?privacy" style="color: blue;">Privacy Policy</a>, which is available on our Site.

				</div>
			</div> <br>
				<div class="right_50">
					
	<h2>Indemnity</h2> <br>
					You agree to indemnify and hold us, our affiliates, officers, directors, agents and/or employees, as the case may be, free from any claim or demand, including reasonable legal fees, related to your breach of these Terms of Use and User Agreement
 <br>
				</div>
			</div>

			<div class="right_50">
				
				<h2>Applicable Law and Jurisdiction</h2> <br>
					These Terms and Conditions of Use shall be interpreted and governed by the laws in force in the Federal Republic of Nigeria. Subject to the Arbitration section below, each party hereby agrees to submit to the jurisdiction of the courts of Nigeria and to waive any objections based upon venue.
 <br>	

 	</div>
			</div>
					<div class="right_50">
					
				<h2>Arbitration</h2> <br>
					Any controversy, claim or dispute arising out of or relating to these Terms and Conditions of Use will be referred to and finally settled by private and confidential binding arbitration before a single arbitrator held in Nigeria in English and governed by Nigeria law pursuant to the Arbitration and Conciliation Act Cap A18 Laws of the Federation of Nigeria 2004, as amended, replaced or re-enacted from time to time.
The arbitrator shall be a person who is legally trained and who has experience in the information technology field in Nigeria and is independent of either party. Notwithstanding the foregoing, the Site reserves the right to pursue the protection of intellectual property rights and confidential information through injunctive or other equitable relief through the courts.
					</div>
			</div>
				<div class="right_50">
					
		<h1>Termination</h1><br>
		In addition to any other legal or equitable remedies, we may, without prior notice to you, immediately terminate the Terms and Conditions of Use or revoke any or all of your rights granted under the Terms and Conditions of Use.<br>
Upon any termination of this Agreement, you shall immediately cease all access to and use of the Site and we shall, in addition to any other legal or equitable remedies, immediately revoke all password(s) and account identification issued to you and deny your access to and use of this Site in whole or in part.<br> Any termination of this agreement shall not affect the respective rights and obligations (including without limitation, payment obligations) of the parties arising before the date of termination. <br> You furthermore agree that the Site shall not be liable to you or to any other person as a result of any such suspension or termination.<br>
If you are dissatisfied with the Site or with any terms, conditions, rules, policies, guidelines, or practices of Jetmega Global Services Nigeria Enterprises in operating the Site, your sole and exclusive remedy is to discontinue using the Site.
</div>
			</div>
					<div class="right_50">
					
			<h1>Severability</h1><br>
If any portion of these terms or conditions is held by any court or tribunal to be invalid or unenforceable, either in whole or in part, then that part shall be severed from these Terms and Conditions of Use and shall not affect the validity or enforceability of any other section listed in this document.
				</div>
			</div>
<div class="right_50">
					
<h1>Miscellanuous Provisions</h1><br>
You agree that all agreements, notices, disclosures and other communications that we provide to you electronically satisfy any legal requirement that such communications be in writing.
Assigning or sub-contracting any of your rights or obligations under these Terms and Conditions of Use to any third party is prohibited unless agreed upon in writing by the seller.
We reserve the right to transfer, assign or sub-contract the benefit of the whole or part of any rights or obligations under these Terms and Conditions of Use to any third party. See Our <a href="?terms_sale" style="color: blue;">TERMS & CONDITIONS OF SALE</a>
				</div>
			</div>

				
		<?php } else if (isset($_GET['terms_sale'])) { ?>
			<div class="_cont_u_pg">
                <div class="_lone_pg_hd">Terms and Conditions of Sale</div>
                <p class="_fd_090__">

                        <h1>General</h1><br>
                            You confirm that you are at least 18 years of age or are accessing the Site under the supervision of a parent or legal guardian. You agree that if you are unsure of the meaning of any part of the Terms and Conditions of Sale, you will not hesitate to contact us for clarification prior to making a purchase.
				These Terms and Conditions of Sale fully govern the sale of goods and services purchased on this Site. No extrinsic evidence, whether oral or written, will be incorporated.
				<br><br>
				<h1>Formation of Contract</h1><br>
				Both parties agree that browsing the website and gathering information regarding the services provided by the seller does not constitute an offer to sell, but merely an invitation to treat. The parties accept that an offer is only made once you have selected the item you intend to purchase, chosen your preferred payment method, proceeded to the checkout and completed the checkout process.
				Both parties agree that the acceptance of the offer is not made when the seller contacts you by phone or by email to confirm that the order has been placed online. Your offer is only accepted when we dispatch the product to you and inform you either by email or by phone of the dispatch of your ordered product. Before your order is confirmed, you may be asked to provide additional verifications or information, including but not limited to phone number and address, before we accept the order.
				Please note that there are cases when an order cannot be processed for various reasons. The Site reserves the right to refuse or cancel any order for any reason at any given time. <br> <br>

				<h1>Acceptance of Electronic Documents</h1>
				You agree that all agreements, notices, disclosures and other communications that we provide to you electronically satisfy any legal requirement that such communications be in writing. <br> <br>


				                            <h1>
				                                Payment and Pricing
				                            </h1>
				                                We are determined to provide the most accurate pricing information on the Site to our users; however, errors may still occur, such as cases when the price of an item is not displayed correctly on the website. As such, we reserve the right to refuse or cancel any order. In the event that an item is mispriced, we may, at our own discretion, either contact you for instructions or cancel your order and notify you of such cancellation.
				We shall have the right to refuse or cancel any such orders whether or not the order has been confirmed and your credit/debit card charged. In the event that we are unable to provide the services, we will inform you of this as soon as possible. A full refund will be given where you have already paid for the products.
				Feel free to check our payments methods <br> <br>

				<h1>Use of Coupon Codes</h1>

				                        Our Site accepts the use of Coupon codes for orders placed online. The marketing Coupon codes which are accepted on our Site entitle you at the time of ordering a product to a saving on the order being placed on our Site. Coupon may also be issued to customers in exchange for advance payments made to us via transfer to our bank accounts for products intended to be purchased on the Site.
				Our Coupon codes may not be exchanged for cash. With the exception of Coupon issued in accordance with our refunds policy and Coupon issued in exchange for advance payments, we reserve the right to cancel or withdraw our Coupon codes at any time.
				 <br> <br>

				 <h1>Liability of Parties on the Yossell Marketplace</h1>

				                        We also operate a marketplace which is open for third-parties to sell their products on our website. None of the products listed on the Yossell Marketplace are owned or sold by us, neither are we involved in the actual sale transaction between the buyers and sellers on the Yossell Marketplace.
				The buyer and seller agree that we would be held free from any liability in contract, pre-contract or other representations in tort, for all transactions conducted on the Yossell Marketplace.
				 <br> <br>


				 <h1>Delivery</h1>

				                        This Site is only for delivery of products to customers Within Nigeria & Worldwide. We make every effort to deliver goods within the estimated timescales set out on our Site; however delays are occasionally inevitable due to unforeseen factors. We shall be under no liability for any delay or failure to deliver the products within the estimated timescales where they did not occur due to our fault or negligence.
				You agree not to hold the seller liable for any delay or failure to deliver products or otherwise perform any obligation as specified in these Terms and Conditions of Sale if the same is wholly or partly caused whether directly or indirectly by circumstances beyond our reasonable control.
				 <br> <br>




				        


				                         <h1>Indemnity</h1><br>
				You agree to indemnify us, our affiliates, officers, directors, agents and/or employees, as the case may be, free from any claim or demand, including reasonable legal fees, related to your breach of these Terms and Conditions of Sale.
				 <br> <br> <br>

				 <h1>Applicable Law and Jurisdiction</h1><br>
				These Terms and Conditions of Sale shall be interpreted and governed by the laws in force in the Federal Republic of Nigeria. Subject to the Arbitration section below, each party hereby agrees to submit to the jurisdiction of the courts of Nigeria and to waive any objections based upon venue. <br> <br> <br>

				<h1>Arbitration</h1><br>
				Any controversy, claim or dispute arising out of or relating to these Terms and Conditions of Sale will be referred to and finally settled by private and confidential binding arbitration before a single arbitrator held in Nigeria in English and governed by Nigeria law pursuant to the Arbitration and Conciliation Act Cap A18 Laws of the Federation of Nigeria 2004, as amended, replaced or re-enacted from time to time.
				The arbitrator shall be a person who is legally trained and who has experience in the information technology field in Nigeria and is independent of either party. Notwithstanding the foregoing, the Site reserves the right to pursue the protection of intellectual property rights and confidential information through injunctive or other equitable relief through the courts.
				 <br> <br> <br>

				 <h1>Severability</h1><br>
				If any portion of these Terms or Conditions of Sale is held by any court or tribunal to be invalid or unenforceable, either in whole or in part, then that part shall be severed from these Terms and Conditions of Sale and shall not affect the validity or enforceability of any other section listed in this document. <br> <br> <br>

				<h1>Miscellaneous Provisions</h1><br>
				You agree that all agreements, notices, disclosures and other communications that we provide to you electronically satisfy any legal requirement that such communications be in writing.
				Assigning or sub-contracting any of your rights or obligations under these Terms and Conditions of Sale to any third party is prohibited unless agreed upon in writing by the seller.
				We reserve the right to transfer, assign or sub-contract the benefit of the whole or part of any rights or obligations under these Terms and Conditions of Sale to any third party. <br> <br> <br>

				<h1>Notice of Copyright Infringement</h1><br>
				If you have any complaints with respect to the infringement of your copyright, kindly write to the following address: help@fortismall.com
				Who? Where?
				Where you believe that your intellectual property has been infringed upon on our website, please notify us by email it to (insert physical address and email address for copyright complaints). We expeditiously respond to all concerns regarding copyright infringements.
				We request that you provide the following information along with your complaint:
				A physical or electronic signature of the person authorized to act on behalf of the owner of the copyrighted work for the purposes of the complaint.
				A proper description of the copyrighted work claimed to have been infringed.
				A description of the location of the infringing material on our Website.
				The address, telephone number or e-mail address of the complaining party.
				A statement made by the complaining party that he has a good-faith belief that use of the material in the manner complained of is not authorized by the copyright owner, its agent or by law.
				A statement deposed to under oath, that the information in the notice of copyright infringement is  accurate, and that the complaining party is authorized to act on behalf of the copyright owner. Please note that this procedure is exclusively for notifying Yossell that your copyrighted material has been infringed. See our <a href="./?return_refund" style="color: blue">Return & Refund Guarantee</a>
				</p>
				<br>


		<?php } else if (isset($_GET['about_us'])) { ?>
									
			<div class="_cont_u_pg">
				<div class="_lone_pg_hd">About Us - Our Story</div>
				<p class="_fd_090__">
						
						


					

					<style type="text/css">
						._this_p_img_qtt234{
								width: 396px;
								height: 490px;
							 padding-top: 2px; 
							 padding-right: 12px; 
							 margin-left: 2px;

						}
						.zorr{
							    width: 768px;
   								 padding-right: 0px;

						}

						@media (max-width: 800px){
							._this_p_img_qtt234{
								width: 339px;
								height: 369px;
							 padding-top: 2px; 
							 padding-right: 12px; 
							 margin-left: 1px;
							  padding-bottom: 2px;
						}
						.zorr{
							    width: 768px;
    							padding-right: 0px;
							}
					</style>


					<div class="right_50"><p ><span style="text-transform: capitalize;font-size: 15pt; color: #a54686; display: block; width: 100%; font-weight: 600;"><centre>We are here for the long run  </centre></span></p><br><br>Because we've weathered the storm, and challenged the status quo, Yossell has now become a bundle of innovations. We make sure to dish the best service at any given time; with a tailored aim to bring a whole new style in online shopping experience, always hungry to bring you more solutions. 

						
 <br><br><p >
 Yossell is continually evolving in the modern business times, geared to team up with highly certified manufacturers for the purpose of facilitating direct consumers relationship with manufacturers via our online trading platform.. Yossell is fast growing into a vibrant global online portal and fast becoming the well refined online shopping portal in the world. Currently Yossell executes operations via the online portal, professionally built for B2C (Business to Customers) and B2B (Business to Business). Yossell is a certified registered company with Registration Number 2912608 in nature of Digital marketing. <br> <br>

 </p>

					<br><br><br>
					
					

 <h4 >- OUR MISSION, VISION & VALUES</h4><br>
We aspire to be the trading platform with a difference by meeting the daily needs of consumers online utilising our secure and efficient transactable medium.. As Yossell we are committed to only providing our customers 100% faultless and original products<br><br>See our <a href="./?return_refund" style="color: blue">Return & Refund Guarantee</a>
					
					<center>
					</div>
					
			</div>

<!--pbook  -->
		
<!--endbook  -->

<?php }
			 else if (isset($_GET['return_refund'])) { ?>
			 	
			<div class="_cont_u_pg">
				<center><div class="_lone_pg_hd">Return & Refund Guarantee</div></center>
			


					<style type="text/css">
						.wedeparde{
							 height: 387px;
							 margin-top: 6px;
							 width: 828px;

						}

						.vera{
						font-weight: 600;
						    font-size: 24pt;
						    /* padding-top: 115px; */
						    padding-left: 9px;
						}

						.tosin{
							font-weight: 400;
   							 font-weight: 400;
   							 font-size: 11pt;
  							  padding-left: 9px;
  							  width: 154%;
  							  margin-top: 12px;
  							  padding-top: 8px;
  							  padding-bottom: 6px;
						}
						.basil{
							float: right;
							height: 387px;
							margin-top: -387px;
							width: 844px;
							padding-left:115px;
							margin-right: -12px;
						}

						@media (max-width: 800px){
							.wedeparde{
							    height: 513px;
							    margin-top: 6px;
							    width: 828px;
							    margin-bottom: -67px;


						}

							.vera {
							font-weight: 600;
						    font-size: 11pt;
						    margin-top: -191px;
						}

						.tosin {
						font-weight: 400;
					    font-size: 9pt;
					    padding-left: 20px;
					    padding-right: 20px;
					    width: 320px;
					    margin-top: 3px;
					    padding-top: 8px;
					    padding-bottom: 6px;
						}
						.basil{
							    float: right;
							    height: 168px;
							    margin-top: -445px;
							    width: 468px;
							    padding-left: 115px;
							    margin-right: -2px;
						}

					</style><br><br>



<style>
	.tubais{
		float: left;
		height: 391px;
		margin-top: 53px;
		width: 793px;
		padding-left:-4px;
		margin-right: -12px;
	}
	.califo{
		font-weight: 600;
		 font-size: 24pt;
		 color: #9a400b;
		  padding-top: -45px; 
		   padding-left: -8px;
	}
	.colons{
	width: 100%;
	overflow: hidden;
	padding: 9px;
	margin-top: 10px;
	border-left: 1px solid #DADADA;
	}
	.zarpos{
		float: right;
		height: 391px;
		margin-top: 23px;
		width: 719px;
		padding-left:115px;
		margin-right: -12px;
	}
	.chrisliar{
		font-weight: 600;
		 font-size: 24pt;
		 color: #9a400b; 
		 padding-top: -45px;
		 padding-left: 9px;
	}
	@media (max-width: 800px){
		.tubais{
	float: left;
    height: 0px;
    margin-top: 168px;
    width: 719px;
    padding-left: -4px;
    margin-right: -12px;
    margin-bottom: 450px;
	}
	.califo{
font-weight: 600;
    font-size: 11pt;
    color: #9a400b;
    padding-left: 9px;
    margin-top: -334px;
	}
	.colons{
	width: 55%;
	overflow: hidden;
	padding: 9px;
	margin-top: 10px;
	border-left: 1px solid #DADADA;
	}
	.zarpos{
    height: 202px;
    margin-top: 23px;
    width: 719px;
    padding-left: -4px;
    margin-right: -273px;
	}
	.chrisliar{
		font-weight: 600;
		 font-size: 11pt;
		 color: #9a400b; 
		 padding-top: -45px;
		 padding-left: 9px;
		 width: 55%;
	}
	}
</style>
			<div class="tubais">
          <h3 class="vera" style="font-size: 15pt">Scope Of Guarantee</h3>
		<br>

		 <p class="tosin" style="background-color: #6801f1; color: #FFF; box-shadow: 0px 10px 19px #0400f6a1;"><b style="color: yellow;">To ensure your security, we take additional steps in verifying the details on your order. If you receive a cancellation notification,all charges will be automatically refunded to your bank account</p>
    </p>
     <p class="tosin" style="background-color: #6801f1; color: #FFF; box-shadow: 0px 10px 19px #0400f6a1;">Returns & Refund is a guarantee provided by sellers for every product they sell on fortismall.com.
				When you receive a product that was bought and paid for on our site, and you discovered it is not as described or is of low quality, you can contact us to resolve these problems (according to the seller's set of returns guarantees).You will then need to return and then request a full refund for the item, or keep the item and agree a partial refund with seller. </p>
     <p class="tosin" style="background-color: #6801f1; color: #FFF; box-shadow: 0px 10px 19px #0400f6a1;">The following situations are not included:</p>
     <p class="tosin" style="background-color: #6801f1; color: #FFF; box-shadow: 0px 10px 19px #0400f6a1;">1. An item you claim is not as described, but the seller can prove that it is.</p>
    <p class="tosin" style="background-color: #6801f1; color: #FFF; box-shadow: 0px 10px 19px #0400f6a1;">2. Items are as described, but you no longer want them (unless the seller offers Easy Returns)
Guaranteed Protection Period</p>
     <p class="tosin" style="background-color: #6801f1; color: #FFF; box-shadow: 0px 10px 19px #0400f6a1;">You can submit refund requests up to 7 days after your order has been completed. You can do this by opening a dispute in the order using your message box. Please note that you can only open one dispute per order.</p>
    </p>
     <p class="tosin" style="background-color: #6801f1; color: #FFF; box-shadow: 0px 10px 19px #0400f6a1;" > You can submit refund requests up to 7 days after your order has been completed. You can do this by opening a dispute in the Ticket Option. Please note that you can only open one dispute per order.</p>
     <p class="tosin" style="background-color: #6801f1; color: #FFF; box-shadow: 0px 10px 19px #0400f6a1;"><b style="color: yellow;">Return Shipping Fee -</b> If you agreed with the seller to return your item, please also check the seller’s shipping terms. If the seller pays the return shipping fee, please make sure you first agree on the shipping method and how the seller will pay you back the shipping fee.</p>
    </p>

</div>


<?php } else if (isset($_GET['categories_navigation'])) { ?>


<div class="_lone_pg_hd ">  All Categories  </div>

	<?php $get_cat = $class_->runS(" SELECT * FROM `category` ");

	if (mysqli_num_rows($get_cat) > 0) {

		while ($row__ = mysqli_fetch_assoc($get_cat)) {
			$id = $row__['id'];
			$category = $row__['category'];
			?>	
				<div class="_cat__">
					<a class="_cat_link2 wow zoomIn" href="./?cat_=<?php echo $class_->urlF($category, 1); ?>">
						
						<?php echo $class_->Capita($category); ?>
					</a>
					
				</div>
			
				<div class="" id="civ<?php echo $id; ?>">

					<?php

						$get_sub_cat = $class_->runS(" SELECT * FROM `sub_category` WHERE `category` = '$category' ");

						if (mysqli_num_rows($get_sub_cat) > 0) {

							while ($row__s = mysqli_fetch_assoc($get_sub_cat)) {
								$sub_category = $row__s['sub_category'];
								?>
									<div class="_sub_sub_cat__">
										<a class="_cat_link1 wow zoomIn" href="./?cat_=<?php echo $class_->urlF($category, 1); ?>&s_cat_=<?php echo $class_->urlF($sub_category, 1); ?>">
											
											<?php echo $class_->Capita($sub_category); ?>
										</a>
										<div class="pa " id="<?php echo $id; ?>" ></div>
									</div>
								<?php

								$get_sub_sub_cat = $class_->runS(" SELECT * FROM `sub_sub_category` WHERE `sub_category` = '$sub_category' ");

								if (mysqli_num_rows($get_sub_sub_cat) > 0) {

									while ($row__ss = mysqli_fetch_assoc($get_sub_sub_cat)) {
										$sub_sub_category = $row__ss['sub_sub_category'];
										?>

											<div class="_sub_sub_cat__ wow zoomIn">
												<a class="_cat_link1 wow zoomIn" href="./?cat_=<?php echo $class_->urlF($category, 1); ?>&s_cat_=<?php echo $class_->urlF($sub_category, 1); ?>&ss_cat_=<?php echo $class_->urlF($sub_sub_category, 1); ?>">
													
													<?php echo $class_->Capita($sub_sub_category); ?>
												</a>
											</div>

										<?php
									}

								}

							}

						}
					?>

				</div> <?php
		}

	}

?>
<!--<div class="_cat__287D"><i class="fas fa-car-battery" style='font-size:20px; color: orange; margin-left: 3px;'></i>
					<a class="_cat_link2TH wow zoomIn " href="https://www.yossell.com/?cat_=s2zRQRGkTL-jsbzl-%-sSSLllRbkLl">Automobile Parts & accessories
					</a>
				</div>

				<style type="text/css">
						._cat__28 {
					    cursor: pointer;
					    width: 62%;
					    display: block;
					    overflow: hidden;
					    margin-top: 47px;
					    padding-bottom: 25px;
					    margin-left: 45px;
					}
					._cat__287D {
						cursor: pointer;
					    width: 91%;
					    display: block;
					    overflow: hidden;
					    margin-top: -20px;
					    padding-bottom: 3px;
					    margin-left: 23px;
					}
					._cat_link2TH {
					    width: 100%;
					    height: 42px;
					    text-align: left;
					    padding-top: 18px;
					    margin-top: 18px;
					    overflow: hidden;
					    padding: -5px 12px;
					    text-transform: capitalize;
					    font-weight: 400;
					    font-size: 10pt;
					    color: #050505;
					    margin-top: 12px;
					    margin-left: 10px;
					    margin-bottom: -21px;
}
					</style>
	<!-- menushift-->


<!--seww-->




		<?php } else if (isset($_GET['product_v']) || isset($_GET['bn'])) {

			if (isset($_GET['bn'])) {

				// Buy Now Data
				$bn_data_ = explode("-", $_GET['bn']);

				$_bn_quanty = $_GET['qt'];
				$_bn_thumb = $_GET['th_i'];
				$_bn_var = $bn_data_[0];
				$_bn_price = $bn_data_[1]*$_bn_quanty;

				$pay_desh_code = $_bn_quanty."-".$_bn_thumb."-".$_bn_var."-".$_bn_price;
				$pay_desh_code_v1 = md5($pay_desh_code);

			}

			$g_p_ID = $_GET['product_v'];
			$getThis_P = $class_->getP($g_p_ID);

			if (mysqli_num_rows($getThis_P) > 0) {

				$row_tP = mysqli_fetch_assoc($getThis_P);
				$p_id = $row_tP['id'];
				$name_ = $row_tP['name'];
				$image_ = $class_->getImageP($p_id);
				$name = $row_tP['name'];
				$price_range = $row_tP['price_range'];
				$description = $row_tP['description'];
				$name = $row_tP['name'];
				$category = $row_tP['category'];
				$sub_category = $row_tP['sub_category'];
				$slashed_price = $row_tP['slashed_price'];
				$discount_ = $row_tP['discount'];
				$store_owner = $row_tP['store_owner'];

				$this_total_pv = $class_->runS(" SELECT SUM(quantity) AS 'add' FROM `orders` WHERE `product_id` = '$p_id' AND `paid_status` = 'PAID' ");
				$this_total_pv_FBS = mysqli_fetch_assoc($this_total_pv);
				$this_total_pv_FBS = $this_total_pv_FBS['add'];

				$this_u_total_ts = $class_->runS(" SELECT SUM(quantity) AS 'add' FROM `orders` WHERE `seller_id` = '$store_owner' AND `paid_status` = 'PAID' ");
				$this_u_total_ts_FBS = mysqli_fetch_assoc($this_u_total_ts);
				$this_u_total_ts_FBS = $this_u_total_ts_FBS['add'];

				$r1 = $row_tP['rated'];
				$tr2 = $row_tP['total_rated'];

				$this_P_War = $row_tP['warranty'];
				$this_P_delT = $row_tP['delivery_time'];
				

				$this_SPEC = $row_tP['p_spec'];
				$get_Pow = $class_->runS("SELECT * FROM `user` WHERE `u_id` = '$store_owner' ");

				$row = mysqli_fetch_assoc($get_Pow);
				$this_P_u_id = $row['u_id'];
				$this_P_bName = $row['business_name'];
				$this_P_sell_eligible = $row['sell_eligible'];

				$get_WList_ = $class_->runS("SELECT id FROM `wish_list` WHERE `product_id` = '$p_id' ");
				$chk_WList_ = $class_->runS("SELECT id FROM `wish_list` WHERE `product_id` = '$p_id' AND `user` = '$this_u_id' ");
				$w_list = mysqli_num_rows($get_WList_)+0;
				$chk_WList_R = mysqli_num_rows($chk_WList_)+0;

				$getImage = $class_->runS(" SELECT * FROM `sub_products` WHERE `product_id` = '$p_id' ");
				$img_JS_count = 1;
				$getImage_COUNT = mysqli_num_rows($getImage);

				$total_Qnty = $class_->runS(" SELECT id FROM `sub_products` WHERE `product_id` = '$p_id' ");
				$total_Qnty_CT = mysqli_num_rows($total_Qnty)+0;

			if (isset($_GET['bn'])) { ?>

					<script type="text/javascript">
						function payWithPaystack(email, amt, inv_id, u_idd, this_phone){
						  var handler = PaystackPop.setup({
						    key: 'pk_live_678b05726033f11b42fcba701eb235714c0af5fc',
						    email: email,
						    amount: amt,
						    ref: ''+inv_id,
						    metadata: {
						       custom_fields: [
						          {
						              display_name: "" + u_idd,
						              variable_name: "" + inv_id,
						              value: "" + this_phone
						          }
						       ]
						    },
						    callback: function(response){

						        var r_ref = response.reference;

									  if (r_ref == inv_id) {
									  	window.location = "./?_bnc=<?php echo $pay_desh_code; ?>&product_v=<?php echo $_GET['product_v']; ?>&th_i=<?php echo $_GET['th_i']; ?>&qt=<?php echo $_GET['qt']; ?>&th_col=<?php echo $_GET['th_col']; ?>&p_own=<?php echo $_GET['store_owner']; ?>";
									  } else {
									  	alert("Sorry Payment Was Not Successful");
									  }

						    },
						    onClose: function(){
						        // alert('window closed');
						    }
						  });
						  handler.openIframe();
						}

						$(document).ready(function () {
							payWithPaystack('<?php echo $this_email; ?>', '<?php echo ($_bn_price-$this_my_coupon+$all_ship_f)*100; ?>', '<?php echo $this_u_id.'_'.time(); ?>', '<?php echo $this_u_id; ?>', '<?php echo $this_phone; ?>');
						})
					</script>

				<?php }; ?>

				<div class="flow_nav_Hd">
					<a class="_nav_liL__" href="./">Home</a>
					<a class="_nav_liL__" href="./?cat_=<?php echo $class_->urlF($category, 1); ?>"> <?php echo $class_->Capita($category); ?></a>
					<a class="_nav_liL__" href="./?cat_=<?php echo $class_->urlF($category, 1); ?>"> <?php echo $class_->Capita($sub_category); ?></a>
				</div>

				<div class="_flow_inPP _p_option">

					<div class="_p_detail_tp">

								

						<div class="_dooot_a _inP_TImg_">
							<div class=" _dooot_a _inP_TImg">

								<img imp="<?php echo $_track_count; ?>" id="<?php echo $id_gi; ?>" class="_thisS_p_img" src="./images/_product/<?php echo $image_; ?>">
							</div>
						</div>

						<!--signjoke-->

						<div class="in_P_Dtl">
							<div class="mobileHide">
							<div class="_inP_Mn__"><?php echo $class_->Capita($name); ?></div>
							</div>
   			


											<div class="_p_v_seg _dim_aa">
								<div class="m_none">
									<div class="_p_v_seg_r">

										<?php if ($getImage_COUNT > 0) {

											while ($get_sub_product_fetch = mysqli_fetch_assoc($getImage)) {

												$_track_count = $img_JS_count++;
												$id_gi = $get_sub_product_fetch['id'];
												$id_image = $get_sub_product_fetch['image'];
												$color_gi = $get_sub_product_fetch['color']; ?>
												<div  style="width: 20%; display: inline-block; float: left; border-bottom: 1px solid #EEE;">
													<img imp="<?php echo $_track_count; ?>" id="<?php echo $id_gi; ?>" class="_adtcart__ _this_p_img" src="./images/_product/<?php echo $id_image; ?>">
													<div class=" _adtcart__" imp="<?php echo $_track_count; ?>" src="./images/_product/<?php echo $id_image; ?>" id="<?php echo $id_gi; ?>" class=" _adtcart__ "style="font-weight: 700; color: blue;  "><span class="  _tgr__17 ">Buy</span></div>
												
											</div>
											<?php }

										}; ?>
							</div>
						</div>
<style>
	._tgr__17{
	width: 67%;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 4, 0.64);
    height: -2px;
    display: inline-block;
    float: left;
    color: #ff6600;
    text-align: center;
    height: 27px;
    padding-top: 5px;
    /* padding-bottom: 21px; */
    line-height: 17px;
    overflow: hidden;
    font-size: 19px;
    border-radius: 124px;
	}
</style>


					<div class="_ld_detail_aa"></div>

					<div class="mobileShow">

							<div class="_inP_Mn__"><?php echo $class_->Capita($name); ?></div>


</div>


							

								<div class="_p_v_seg">
								
								<div class="_start_box">
									<img class="_star_in_Box_" src="./asset/star.png">
									<img class="_star_in_Box_" src="./asset/star.png">
									<img class="_star_in_Box_" src="./asset/star.png">
									<img class="_star_in_Box_" src="./asset/star.png">
									<img class="_star_in_Box_" src="./asset/star.png">
									<div class="_p_price_Ip" style="width: <?php echo $class_->coveR($r1, $tr2); ?>%"></div>
								</div>
								<span class="_p_price_Iratings">(<?php echo $tr2; ?>) Ratings</span>

						<div class="_p_v_seg">
								<div class="_p_v_seg_r">
									<div class="_p_price_Ip" style="font-size: 17"><?php echo $class_->PriceR($price_range); ?></div></div>

							

							<div class="_p_v_seg">
								<div class="_p_v_seg_r "> <div class="_dis_count_ fl_none" style="background-color: #050505;
    box-shadow: 0px 10px 19px #ff6600; color: #FFF; font-weight: 600"><?php echo $discount_; ?>% Discount</div>  </div></div>

							</div>
							 
 
									
									
							

								
							

									<?php
									if ($store_owner !== $this_u_id) {
										?> <div class="_Wish_L _WLST _Wish_L_M" id="<?php echo $p_id; ?>" <?php if ($chk_WList_R == 1) { echo "style='background: #000000;'"; } ?>>Favourites<span class="pa">!</span> <?php echo $w_list; ?></div> <?php
									} else {
										?> <div class="_Wish_L" id="<?php echo $p_id; ?>"> <span class="pa" style="font-size: 14pt">!</span> <?php echo $w_list; ?> </div> <?php
									}

								?>



							
								
									
									<!--<h1 class="_in_Hd"><?php if ($this_P_sell_eligible == 2) { ?>
																		<?php }; ?>
									<a class="_in_Hdmax storekg" href="./?store_home=<?php echo $store_owner; ?>&st_hm=<?php echo uniqid(); ?>">More Of <?php echo $class_->Capita($this_P_bName); ?></a>

								</h1>
								<a class="_in_Hdmax storekg" href="./?terms_policy"  style="background-color: blue; box-shadow: 0px 10px 19px rgba(0, 114, 255, 0.6);">Terms & Conditions</a>
							</div>-->

				     <?php if ($this_my_coupon > 0) { ?>
                        <div class="in_flow_sum">
                            <h2 class="_label___">You've Saved</h2>
                            <div class="_info__ _c_t_dis">&raquo <?php echo $class_->_currency($cur_currency, $this_my_coupon); ?></div>
                        </div>
                    <?php } else { ?>
                        <div class="in_flow_sum">
                        
                            <form action="" method="POST" class="_val_coup">
                                <h2 class="_label___" style="margin-top: 0px;">Verify Voucher</h2>
                                <input class="_inp__ _this_cp" type="text" name="_coupoun_code" placeholder="If Any, Enter Voucher code">
                                <input class="_inp__ _chek_b button__ _bbY_d _b_green" type="submit" value="APPLY VOUCHER">
                            </form>

                        </div>
                    <?php } ?>

                        </div>
    
                        <p class="r"></p>
    
                    </form>


                    	<div class="mobileShow">
                    <div class="_p_v_seg">
                    				<button class="accordion" style="background-color: #ff6600;">Product Description</button>
								<div class="panel _p_v_seg_l"><br><a style="font-size: 10pt;font-weight: 500;width: 100%;color: #333;margin-bottom: -9px  margin-top: -8px;"><?php echo $class_->Capita($description); ?>
							</div>
						</div>
					</div>

				 


						<!--	<div class="_p_v_seg">
								<div class="_p_v_seg_l" style="font-size: 11pt; font-weight: 500; width: 640px; color: #ff005c; margin-bottom: 12px; margin-top: 15px"><?php echo $this_u_total_ts_FBS . "- Transactions Sucessful"; ?></div>
							</div> -->
								
									
<!--
							<div class="_p_v_seg">
							<div class="_p_v_seg">
								<div class="_p_v_seg_l" style="font-size: 10pt; font-weight: 500; width: 242px; color: #333; margin-bottom: -9px  margin-top: -8px;">&raquo Payment Secured By<img class="_this_p_img_q" style="padding-top: -1px; padding-right: -5px; width: 38%; height: 2%; margin-left: 4px; margin-left: 11px;}" src="./images/_product1/paystack.png"> </div>
							</div>	
									<div class="_p_v_seg_l docket" style=" font-size: 9pt; font-weight: 500; width: 100%;; color: #333; margin-bottom: -9px  margin-top: -8px;">&raquo System Delivery Duration: <img class="_this_p_img_q pyte" style=" padding-top: 5px; padding-right: 5px; width: 10%; height: 10%;  margin-left: 12px" src="./images/_product1/shipme.png">  Within 24 Hours - 18 Business Days</div>
							</div>-->
						
									
								<div class="_Wish_LKO" style="float: left;  font-weight: 560;"><img style='height: 19px; color: #FFF;' src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiIgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiBmaWxsPSIjMjIyMjIyIj4KICA8cGF0aCBvcGFjaXR5PSIuMjUiIGQ9Ik0xNiAwIEExNiAxNiAwIDAgMCAxNiAzMiBBMTYgMTYgMCAwIDAgMTYgMCBNMTYgNCBBMTIgMTIgMCAwIDEgMTYgMjggQTEyIDEyIDAgMCAxIDE2IDQiLz4KICA8cGF0aCBkPSJNMTYgMCBBMTYgMTYgMCAwIDEgMzIgMTYgTDI4IDE2IEExMiAxMiAwIDAgMCAxNiA0eiI+CiAgICA8YW5pbWF0ZVRyYW5zZm9ybSBhdHRyaWJ1dGVOYW1lPSJ0cmFuc2Zvcm0iIHR5cGU9InJvdGF0ZSIgZnJvbT0iMCAxNiAxNiIgdG89IjM2MCAxNiAxNiIgZHVyPSIwLjhzIiByZXBlYXRDb3VudD0iaW5kZWZpbml0ZSIgLz4KICA8L3BhdGg+Cjwvc3ZnPgo='> <?php echo $this_total_pv_FBS; ?>  Verified Purchase </div>

							

								
							<div class="_p_v_seg">
								<div class="_p_v_seg_l" style="font-size: 10pt; font-weight: 500; width: 242px; color: #333; margin-bottom: -9px  margin-top: -8px;">&raquo We Accept <img class="_this_p_img_q" style="padding-top: -1px; padding-right: -5px; width: 58%; height: 2%; margin-left: 4px; margin-left: 11px;}" src="./images/_product1/visa.png"> </div>
							</div>	

							<div class="_p_v_seg">
								<div class="_p_v_seg_l" style="font-size: 10pt; font-weight: 500; width: 318px; color: #333; margin-bottom: -9px  margin-top: -8px;">&raquo Logistics Channels <img class="_this_p_img_q" style="padding-top: -1px; padding-right: -5px; width: 58%; height: 2%; margin-left: 4px; margin-left: 11px;}" src="./images/_product1/ship.png"> </div>
							</div>	

									<div class="mobileShow">
							<div class="_p_v_seg">&raquo <img class="_this_p_img_q" style="padding-top: -1px; padding-right: -5px; width: 38%; height: 2%; margin-left: 4px; margin-left: 11px;}" src="./images/_product1/ssl.png"> </div>
							</div>	
									<div class="_p_v_seg">&raquo<a href="./?return_refund" style="color: #14171a">Return & Refund Guarantee</a>	
								</div>


							<a class="_v_store" href="./?store_home=<?php echo $store_owner; ?>&st_hm=<?php echo uniqid(); ?>">View Store Home</a>
</div>
		 </div>				
						
					
					
								
							<?php

								$f_Sr = 0;
								$fr_Sr = 0;
								$t_Sr = 0;
								$to_Sr = 0;
								$o_Sr = 0;

								$get_ARvv = $class_->runS("SELECT * FROM `review` WHERE `product` = '$p_id' ");
								$totalA_R = mysqli_num_rows($get_ARvv);

								if ($totalA_R == 0) {

									$f_Sr = $f_Sr_P = $fr_Sr = $fr_Sr_P = $t_Sr = $t_Sr_P = $to_Sr = $to_Sr_P = $o_Sr = $o_Sr_P = 0;

								} else {

									for ($i=1; $i <= 5; $i++) { 

										$get_Rvv = $class_->runS("SELECT * FROM `review` WHERE `product` = '$p_id' AND `star` = '$i' ");
										$total_R = mysqli_num_rows($get_Rvv);

										if ($i == 5) {
											$f_Sr = $total_R;
											$f_Sr_P = ceil(($f_Sr/$totalA_R)*100);
										}else if ($i == 4) {
											$fr_Sr = $total_R;
											$fr_Sr_P = ceil(($fr_Sr/$totalA_R)*100);
										} else if ($i == 3) {
											$t_Sr = $total_R;
											$t_Sr_P = ceil(($t_Sr/$totalA_R)*100);
										} else if ($i == 2) {
											$to_Sr = $total_R;
											$to_Sr_P = ceil(($to_Sr/$totalA_R)*100);
										} else if ($i == 1) {
											$o_Sr = $total_R;
											$o_Sr_P = ceil(($o_Sr/$totalA_R)*100);
										}

									}

								}

							?>

							<!-- <div class="_sc_rt">

								<div class="_RTS_">

									<h1 class="_in_Hd">Ratings</h1>

									<div class="_RSec">
										<span class="_colL_">5</span>
										<div class="_RFlH"> <div class="_inf_fll_" style="width: <?php echo $f_Sr_P."%" ?>;"></div> </div>
										<span class="_colL_">(<?php echo $f_Sr; ?>)</span>
									</div>

									<div class="_RSec">
										<span class="_colL_">4</span>
										<div class="_RFlH"> <div class="_inf_fll_" style="width: <?php echo $fr_Sr_P."%" ?>;"></div> </div>
										<span class="_colL_">(<?php echo $fr_Sr; ?>)</span>
									</div>

									<div class="_RSec">
										<span class="_colL_">3</span>
										<div class="_RFlH"> <div class="_inf_fll_" style="width: <?php echo $t_Sr_P."%" ?>;"></div> </div>
										<span class="_colL_">(<?php echo $t_Sr; ?>)</span>
									</div>

									<div class="_RSec">
										<span class="_colL_">2</span>
										<div class="_RFlH"> <div class="_inf_fll_" style="width: <?php echo $to_Sr_P."%" ?>;"></div> </div>
										<span class="_colL_">(<?php echo $to_Sr; ?>)</span>
									</div>

									<div class="_RSec">
										<span class="_colL_">1</span>
										<div class="_RFlH"> <div class="_inf_fll_" style="width: <?php echo $o_Sr_P."%" ?>;"></div> </div>
										<span class="_colL_">(<?php echo $o_Sr; ?>)</span>
									</div>
								</div>

							</div> 

						</div>

					</div>

							<?php }; ?>

				
									<div class="mobileShow">
									<div class="dropdown">
  <button onclick="myFunction()" class="dropbtn veroniker">About . Shipping . Product Details  </button>
  <div id="myDropdown" class="dropdown-content">


  						
										</div>

</div>
										



										<div class="_p_v_seg_l" style="font-size: 9pt; font-weight: 500; width: 640px; color: #17044e; margin-bottom: 12px; margin-top: 15px; margin-left: 15px">Sellers Credibility:	<div style="font-size: 9pt; font-weight: 500; width: 640px; color: #ff005c; margin-bottom: 12px; margin-top: 15px"><?php echo $this_u_total_ts_FBS . "- Transactions Sucessful"; ?></div>


  									<div class="_p_v_seg_l" style="font-size: 9pt; font-weight: 500; width: 790px; color: #17044e; margin-bottom: 12px; margin-top: 15px;"><img class="_this_p_img_q" style=" padding-top: 5px; padding-right: 5px; width: 7%; height: 7%;  margin-left: 12px" src="./images/_product1/protection.png"><a href="./?return_refund"> Get Full Refund if you don't receive your order</a></div>


									<div class="_p_v_seg_l" style="font-size: 9pt; font-weight: 500; width: 640px; color: #17044e; margin-bottom: 2px; margin-top: 1px">
									</div>


  	</div>


<br>

		<center><h3 style="text-transform: capitalize; color:#fd008c; margin-left: -526px;">PRODUCT DETAILS</h3></center>


  		<?php
							$this_SPEC_ARry = explode("|||", $this_SPEC);
							foreach ($this_SPEC_ARry as $key => $value) {
								$this_IN_ARry = explode("||", $value);
								?>
									

<div class="_div_spec__"> <b><?php echo $this_IN_ARry[0]; ?></b> : <?php echo $this_IN_ARry[1]; ?> </div>


							
								
							
<?php }; ?>

<center><img imp="<?php echo $_track_count; ?>" id="<?php echo $id_gi; ?>" class="_thisS_p_img" src="./images/_product/<?php echo $image_; ?>"></center>
</div>
</div>
</div>


								<script >
									/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
								</script>spec-->
</a></div>
				<div class="mobileHide">
				<center> <h1 class="_pVHd" style=" border-bottom: 1px solid #EEE; overflow: hidden; width: max-content; padding: 15px; font-weight: 700; display: block; background: #dad8d9; box-shadow: 0px 10px 19px #000000ed;     border-radius: 95px 0px;">Product Description</h1> </center>			
				<div class="felix" style="font-size: 10pt;font-weight: 500;width: 100%;color: #333;margin-bottom: -9px  margin-top: -8px;"><?php echo $class_->Capita($description); ?></div>
</div>	
				



						<?php if (strlen(trim($this_SPEC)) > 0) { ?>
					
					<div class="_flow_inPP _b_top">
						<div class="mobileHide">
						<center> <h1 class="_pVHd" style=" border-bottom: 1px solid #EEE; overflow: hidden; width: max-content; padding: 15px; font-weight: 700; display: block; background: #dad8d9; box-shadow: 0px 10px 19px #000000ed;     border-radius: 95px 0px;">More To Know</h1> </center>
					</div>
						<?php
							$this_SPEC_ARry = explode("|||", $this_SPEC);
							foreach ($this_SPEC_ARry as $key => $value) {
								$this_IN_ARry = explode("||", $value);
								?>
									<div class="mobileShow">
								<button class="accordion" style="background-color: #ff6600;"><?php echo $this_IN_ARry[0]; ?></button>
								<div class="panel" style="background-color: white; text-transform: capitalize;"><br><br>
   										<p><?php echo $this_IN_ARry[1]; ?></p><br><br>
								</div></div>
									

									<div class="mobileHide">
										<div class="felix"> <b style="font-size: 15pt"><?php echo $this_IN_ARry[0]; ?>:</b> <a style="font-size: 13pt; color: #050505; font-style: italic;"><?php echo $this_IN_ARry[1]; ?></a> </div>
									</div>
								<?php
							}
						?>

					</div>
				</div>
				<?php }; ?>

			<?php $get_ARvv_ = $class_->runS("SELECT * FROM `review` WHERE `product` = '$p_id' ORDER BY `id` DESC LIMIT 10 ");
					if (mysqli_num_rows($get_ARvv_)) { ?>
					
					<center> <br> <h1 class="_pVHd" style="background: orange; border-bottom: 1px solid #EEE; overflow: hidden;  padding: 15px; font-weight: 700;  display: block; background: #b6b6b6; box-shadow: 0px 10px 19px #000000ed; border-radius: 95px 0px;">CUSTOMERS REVIEW</h1> </center>
					
					<div class="_flow_inPP _b_top">							

						<?php
							while ($rowRv_ = mysqli_fetch_assoc($get_ARvv_)) {
								
								$star = $rowRv_['star'];
								$user = $rowRv_['user'];
								$date_time = $rowRv_['date_time'];
								$review = $rowRv_['review']; ?>

									<div class="_rv_FlwW" style="box-shadow: 0px 10px 19px #000000ed;">
<!-- wecome -->
										<div class="_s_Ll">
											<a class="_s_RowW" style="font-weight: 800; font-size: 14pt;" href="./?"><?php echo $class_->Capita($class_->getUD($user, "nm")); ?></a>
											<div class="_s_RowW" style="font-weight: 580; color: #050505; font-size: 12pt;"><?php echo $date_time; ?></div>
											<div class="_s_RowW" style="font-weight: 500; color: #ff6600;">Country: <?php echo $class_->Capita($class_->getUD($user, "ct")); ?></div>
										</div>

										<div class="_s_LlR">
											<div class="_start_box">
												<img class="_star_in_Box_" src="./asset/star.png">
												<img class="_star_in_Box_" src="./asset/star.png">
												<img class="_star_in_Box_" src="./asset/star.png">
												<img class="_star_in_Box_" src="./asset/star.png">
												<img class="_star_in_Box_" src="./asset/star.png">
												<div class="star_covr" style="width: <?php echo 100-($star*20); ?>%"></div>
											</div>
											<div class="_s_RowW"><?php echo $review; ?></div>
										</div>


								<?php

							}
						?>

				</div>
				</div>

				<?php }; ?>

			<?php if (strlen(trim($this_SPEC)) > 0) { ?>

				<?php $gett_SponP = $class_->runS("SELECT * FROM `products` WHERE `client_p` = '2' AND `id` != '$p_id' AND `sponsored` = '1' LIMIT 4 ");

					if (mysqli_num_rows($gett_SponP) > 0) { ?>

						<div class="_flow_inPP _b_top">

							<h1 class="_pVHd">Sponsored Products</h1> </center>
							<center>
								<?php $class_->callTemp($gett_SponP); ?>
							</center>

						</div>

					


				<?php }; ?>

				<?php $gett_OSP = $class_->runS("SELECT * FROM `products` WHERE `client_p` = '2' AND `store_owner` = '$store_owner' AND `category` = '$category' AND `sub_category` = '$sub_category' ORDER BY RAND() LIMIT 4 ");

				if (mysqli_num_rows($gett_OSP) > 0) { ?>

					<div class="_flow_inPP _b_top">

						<center> <h1 class="_pVHd"  style="background: orange; border-bottom: 1px solid #EEE; overflow: hidden;  padding: 15px; font-weight: 700;  display: block; background: #fdfbfb; box-shadow: 0px 10px 19px #000000ed; border-radius: 95px 0px;">Related To Your Choice </h1> </center>
						<center>
							<?php $class_->callTemp($gett_OSP); ?>
						</center>

					</div>

				<?php }; ?>

				<?php $gett_RCPV = $class_->runS("SELECT * FROM `products` WHERE `client_p` = '2' AND `store_owner` = '$sup_store_owner' AND `category` = '$category' AND `sub_category` = '$sub_category' ORDER BY RAND() LIMIT 4 ");

				if (mysqli_num_rows($gett_RCPV) > 0) { ?>


						<center> <h1 class="_pVHd" style="background: orange; border-bottom: 1px solid #EEE; overflow: hidden;  padding: 15px; font-weight: 700;  display: block; background: #fdfbfb; box-shadow: 0px 10px 19px #000000ed; border-radius: 95px 0px;"><?php echo $this_P_bName; ?> Favorites</h1> </center>
						<center>
							<?php $class_->callTemp($gett_RCPV); ?>
						</center>

					</div>

					<div class="_flow_not">
						<a class="_mor_fld bgreen" style=" border-bottom: 1px solid #EEE; overflow: hidden;  padding: 15px; font-weight: 700; color: #FFF; display: block; background:#333; box-shadow: 0px 10px 19px #0400f6a1; border-radius: 95px 0px;" href="./?store_home=<?php echo $sup_store_owner; ?>&st_hm=<?php echo uniqid(); ?>">Visit Store Home</a>
					</div>

				<?php }; ?>

				<?php $gett_OSPOS = $class_->runS("SELECT * FROM `products` WHERE `client_p` = '2' AND `store_owner` != '$store_owner' AND `category` = '$category' AND `sub_category` = '$sub_category' ORDER BY RAND() LIMIT 4 ");

				if (mysqli_num_rows($gett_OSPOS) > 0) { ?>

					<div class="_flow_inPP _b_top">

						<center> <h1 class="_pVHd" style="background: orange; border-bottom: 1px solid #EEE; overflow: hidden;  padding: 15px; font-weight: 700;  display: block; background: #fdfbfb; box-shadow: 0px 10px 19px #0400f6a1; border-radius: 95px 0px;">Similar From Other Stores</h1> </center>
						<center>
							<?php $class_->callTemp($gett_OSPOS); ?>
						</center>

					</div>

						<!--<div class="_flow_not">
						<a class="_mor_fld bgreen" href="./?store_home=<?php echo $store_owner; ?>&st_hm=<?php echo uniqid(); ?>">View More Products</a>
					</div>-->

				<?php }; ?>
				
			
				<?php

			}

		} else {


			foreach ($class_->dump(9) as $key => $value) {

				if ($value == "SP") {
					
					$more_link = "./?fil=sp";
					$gett_mP = $class_->runS(" SELECT * FROM `products` WHERE `client_p` = '2' AND `sponsored` = 'sp' AND `flash_deal_d` != '$fd_d' ORDER BY RAND() LIMIT 8 ");

				} else if ($value == "RC") {
					
					$more_link = "./?fil=rc";
					$gett_mP = $class_->runS(" SELECT * FROM `products` WHERE `client_p` = '2' AND`recommend` = 'rc' AND `flash_deal_d` != '$fd_d' ORDER BY RAND() LIMIT 8 ");

				} else if ($value == "NB") {
					
					$more_link = "./?fil=nb";
					$gett_mP = $class_->runS("SELECT * FROM `products` WHERE `client_p` = '2' AND `sponsored` != 'sp' AND `recommend` != 'rc' AND `flash_deal_d` != '$fd_d' ORDER BY RAND() LIMIT 4 ");

				}

				$this_count = mysqli_num_rows($gett_mP);
				if ($this_count > 0) { ?>

					<div class="_in__">

						<h1 class="_fl_timMP"><?php echo $class_->ReadHeader($value); ?></h1>
						
						<div class="__in_F__">

							<center>
								<?php $class_->callTemp($gett_mP); ?>
							</center>

						</div>

						<?php if ($this_count > 0) { ?>

							<div class="_flow_not">
								<a class="_mor_fld bgreen" href="<?php echo $more_link; ?>">View All</a>
							</div>


						<?php }; ?>

					</div>

				<?php } ?>
								
			<?php }

		}; ?>
</div>
	</div>



<div class="mobileShow">
<script src="https://apps.elfsight.com/p/platform.js" defer></script>
<div class="elfsight-app-98b59b18-66c8-4127-86db-006dd27eaa58"></div>
</div>


	<?php };

	if (!isset($_GET['dashboard'])) { ?>
<style type="text/css">
		.Ifind{
			border: 1px solid #EEE;
		    outline: none;
		    padding: 0px 15px;
		    width: 29%;
		    height: 46px;
		}
				.bebeto12{
			height: 46px;
			width: 15%;
			float: left;
		}
				.dokokoko12{
			color: #FFF;
			font-weight: 700;
			width: 20%;
			float: right;
			cursor: pointer;
			background-color: #ff6600;
			border-radius: 12px 0px;
			margin-right: 209px;
		}
			.seefind{
				margin-top: -48px;
    			margin-left: 378px;

			}
</style>
<div class="mobileHide">
	<div class="footer wow zoomIn" style="background-color: #000;">

		<h2 style="	color: white; margin-left: 134px;     margin-top: 17px;">GET LATEST DEALS</h2><br><p style="margin-left: 134px;	color: white;">Our best promotions sent to your inbox.</p><form class="seefind" action="https://sendlane.com/form-api/submission/eyJkb21haW4iOiJ5b3NzZWxsIiwiZm9ybV9pZCI6IjA4NmEzOTNhLWUyN2MtNGY2Ny04YjEyLTg2MTE4YjhjYWJiMiJ9" method="post"><input class="Ifind" name="1" placeholder="First name" type="Text"><input class="Ifind" name="3" placeholder="Email" type="Email" required="required"><button class="bebeto12 dokokoko12" type="submit"> SUBSCRIBE</button><img src="https://sendlane.com/form-api/impression/eyJkb21haW4iOiJ5b3NzZWxsIiwiZm9ybV9pZCI6IjA4NmEzOTNhLWUyN2MtNGY2Ny04YjEyLTg2MTE4YjhjYWJiMiJ9" style="display: none;"></form>
</div></div>


<div class="mobileShow">
	<div class="sendlane-form" data-form-key="eyJkb21haW4iOiJ5b3NzZWxsIiwiZm9ybV9pZCI6IjA4NmEzOTNhLWUyN2MtNGY2Ny04YjEyLTg2MTE4YjhjYWJiMiJ9"></div>
<script src="https://sendlane.com/scripts/pusher.js" async></script>
</div>
		<!--	<div class="mobileShow">	
					<div class="footer1">

									<center>

		 		<ul class="social-icons">
   				 	<li><a href="https://m.facebook.com/TradePortacom-178087339461803/?ref=bookmarks"><img src='./asset/Facebook.png'></a></li>
   				 	<li><a href="https://instagram.com/trade.porta"><img src='./asset/Instagram.png'></a></li>
				</ul>
		 		
		 	</center>

		 	<br>


		 		<div class="_ft_ic__4">
						
						<li><a href="./?about_us"><i class=" __copy4"></i>About Us</a></li><br>
						<li><a href="#rq_"><i class=" __copy4"></i>Contact Us</a></li><br>
						<div class="_order_inf" href="./?dashboard"><span class="pa __copy">i</span>Track My Orders</div><br>
						<li><a href="./?terms_policy"><i class=" __copy4"></i>Terms & Conditions</a></li><br>
						<li><a href="./?privacy"><i class=" __copy4"></i>Privacy Policy</a></li><br>
						<li><a href="./?fil=bs"><i class=" __copy54"></i>More Consumers Trends</a></li><br>
						<li><a href="./?fd_rg"><i class=" __copy"></i>Find Traders By Region</a></li><br>
					
				</div>
			</div>
			</div></div>-->


			
		<div class="mobileHide">
			<div class="footer wow fadeInDown" style="background-color: #000;">


						<h4 style="color: #ff6600; font-size: 1.09rem;">Enjoy Online Shopping on yossell.com – Global trade platform</h4><br>
					</p>

					<div class=" wow fadeInDown" style="color: #fff; font-size: .95rem;">

								Yossell Online Shopping destination. We love ourselves in a way of providing you basic solutions that prove you could possibly get that desired item you'd love to have for life at the best prices than anywhere else.  Our access to Original premium products gives us a wide edge of products at very low prices. Some of our popular categories include Online Shoppng For consumer products like |  Fashion | Technology | Smart Home Equipments| Kitchen | Clothing | Life etc. 

						<br><br><p style="color: #FFF;"> </p><p></p><br> To make your shopping experience swift and memorable, there are also added services like gift vouchers, consumer promotion activities across different categories and bulk purchases with hassle-free delivery. Enjoy free shipping rates for certain products and with the bulk purchase option, you can enjoy low shipping rates, discounted prices and flexible payment. When you shop on our platform, you can pay with your debit card or via paystack 100% trusted / convenient and secured payment solution. Get the best of lifestyle services online. Don't miss out on the biggest sales online which takes place on special dates yearly.

				</div></div>
				
						
			


				

		<div class="footerd">
				<div class="_ft_ic__2">
					<center>
					<h5><div class="__copy2">Quick links</div></h5><br>
						<li><a class="ft_lkn__ " style="color: #00000" href="./?about_us">About Us</a></li>
						<li><a class="ft_lkn__ " style="color: #00000" href="./?terms_policy">Terms & Conditions</a></li> 
						
					<li><a class="ft_lkn__ " style="color: #00000" href="./?privacy">Privacy Policy</a></li>
					<li><a class="ft_lkn__ " style="color: #00000" href="./?return_refund">Return & Refund </a></li>
					<li><a class="ft_lkn__ " style="color: #00000" href="./?terms_sale">Terms & Conditions Of Sale </a></li>

				</div>
				</center>
			
			<div class="_ft_ic__2">
					<center>
					<h5><div class="__copy2">Let Us Help You</div></h5><br>

					<?php if ($on_ == 1) { ?>
							<center>
							<?php if ($this_sell_eligible == 2) { ?>
								<li><a class="ft_lkn__" href="./?dashboard">Admin Control Panel</a></li>
							<?php } else { ?>
								<li><a class="ft_lkn__ _sell_inf">Make Money With US</a></li>
							<?php }; ?>

							<li><a class="ft_lkn__ _profile_inf" href="#PROFILE">My Account</a></li>

							<?php if ($this_buy_eligible != 2) { ?>			
								<li><a class="ft_lkn__ _buy_inf">Setup a Buyer Account</div></a></li>
							<?php } else { ?>
								<li><a class="ft_lkn__ _order_inf">Track Orders</a></li>
								<li><a class="ft_lkn__ _wish_inf"> Wish List</a></li>
							<?php }; ?>

							<li><a class="ft_lkn__" href="./?logout">Log Out</a></li>

						<?php } else { ?>
							<li><a class="ft_lkn__" href="./?register">  Create Account</a></li>
							<li><a class="ft_lkn__" href="./?login"> Login</a></li>
						<?php }; ?>
				</div>
				</center>

				<div class="_ft_ic__2">
				<center>
					
   				 	<p style="color: #FFF">24/7 Customers Service</p>
   				 	<h3 class="ft_lkn__" style="font-size: 19pt; color: #00000;">CALL US: +234 803 137 0588</h3><br><br>
   				 	<h3  style="font-size: 19pt; color: #00000;">OR: +234 807 742 1808</h3><br><br>
   				 	<p style="color: #FFF">EMAIL SUPPORT</p>
   				 	<a class="ft_lkn__" href="mailto:support@yossell.com " style="font-size: 19pt; text-transform: lowercase; color: #fff;">support@yossell.com</h3>
				</ul>
				</div>
				</center>




						<div class="footerd"> 
							<center> <a class=" " href="https://www.facebook.com/yosselltm/"><img  style="height: 70px; width: 70px;" src='./asset/Facebook.png'></a>
   				 	<a class=" " href="https://www.instagram.com/yosselltm"><img  style="height: 70px; width: 70px;" src='./asset/instagram.png'></a>
   				 	<a class=" " href=" "><img  style="height:70px; width: 70px;" src='./asset/youtube.png'></a>
   				 	<!--<a class=" " href="https://www.twitter.com/fortis_mall"><img  style="height: 40px; width: 40px;" src='./asset/twitter.png'></a>-->
 						</center>
						
					</div>
					</div>
					<div class="mobileHide">
				<div class="footer">
				<center>
				<p class="__copy2" style="font-size: 11pt;">&copy Since 2019 - yossell.com All Rights Reserved</p> <br>
					
				</div>
		 	</center>
		 	</div>
		 	</div>


</a></center></div>

		 	<!---Mobile footer starts here--->
		 	 
		 				<div class="mobileShow">
								


<p><a onclick="javascript:ShowHide('HiddenDiv')"><div class="footer" style="background-color: #000;">


						<h4 style="color: #fff; font-size: 1.09rem;">Enjoy Online Shopping on yossell.com – Global trade platform...<i style="    color: #FFF; padding: 5px; border-radius: 5px; display: inline-block; float: right; text-transform: capitalize; background-color: #ff6600; box-shadow: 0px 8px 16px 0px #ff660054; font-weight: 700; font-size: 13px;">Read More</i> </h4><br>
					</a></p>
<div class="mid" id="HiddenDiv" style="display: none;"><font style="color: #fff; font-size: 0.9rem;">Yossell Online Shopping destination. We love ourselves in a way of providing you basic solutions that prove you could possibly get that desired item you'd love to have for life at the best prices than anywhere else.  Our access to Original premium products gives us a wide edge of products at very low prices. Some of our popular categories include Online Shoppng For consumer products like |  Fashion | Technology | Smart Home Equipments| Kitchen | Clothing | Life etc.

	<br><br><p style="color: #FFF;"> </p><p></p><br> To make your shopping experience swift and memorable, there are also added services like gift vouchers, consumer promotion activities across different categories and bulk purchases with hassle-free delivery. Enjoy free shipping rates for certain products and with the bulk purchase option, you can enjoy low shipping rates, discounted prices and flexible payment. When you shop on our platform, you can pay with your debit card or via paystack 100% trusted / convenient and secured payment solution. Get the best of lifestyle services online. Don't miss out on the biggest sales online which takes place on special dates yearly.





				

		 		<!--<div class="_ft_ic__2">
		 			<center>
		 		<h5><div class="__copy2">Yossell Corporate</div></h5>
						<li><a class="ft_lkn__ " style="color: #00000" href="./?wholesale_centre">Wholesale Centre</a></li>
						<li><a class="ft_lkn__ " style="color: #00000" href="./?logistics_centre">Logistics Centre</a></li>
						<li><a class="ft_lkn__ " style="color: #00000" href="./?realestate_centre">Real Estate Centre</a></li>
						<li><a class="ft_lkn__ " style="color: #00000" href="./?engineering_centre">Engineering Centre</a></li>
						<li><a class="ft_lkn__ " style="color: #00000" href="./?graphics_centre">Graphics Centre</a></li>
						<li><a class="ft_lkn__ " style="color: #00000" href="./?publishing_centre">Publishing Centre</a></li>
				</div> -->
				</center>
				
				<div class="mobileShow">
				<div class="_ft_ic__2">
					<center>
					<h5><div class="__copy2">Quick links</div></h5><br>
						<a class="ft_lkn__ " style="color: #00000" href="./?about_us">About Us</a>
						<a class="ft_lkn__ " style="color: #00000" href="./?terms_policy">Terms & Conditions</a>
						
					<a class="ft_lkn__ " style="color: #00000" href="./?privacy">Privacy Policy</a>
					<a class="ft_lkn__ " style="color: #00000" href="./?return_refund">Return & Refund </a>
					<a class="ft_lkn__ " style="color: #00000" href="./?terms_sale">Terms & Conditions Of Sale </a>
				</center></div>
				</div>
			
			<div class="mobileShow">
			<div class="_ft_ic__2">
					<center>
					<h5><div class="__copy2">Let Us Help You</div></h5><br>

					<?php if ($on_ == 1) { ?>
							<center>
							<?php if ($this_sell_eligible == 2) { ?>
								<a class="ft_lkn__" href="./?dashboard">Admin Control Panel</a>
							<?php } else if ($this_sell_eligible == 3) { ?>
								<a class="_notice_pix_g">Your account is awaiting approval for selling.<br>You will be contacted shortly.</a>
							<?php } else { ?>
								<a class="ft_lkn__ _sell_inf">Make Money With US</a>
							<?php }; ?>

							<a class="ft_lkn__ _profile_inf" href="#PROFILE">My Account</a>

							<?php if ($this_buy_eligible != 2) { ?>			
								<a class="ft_lkn__ _buy_inf">Setup a Buyer Account</div></a><
							<?php } else { ?>
								<a class="ft_lkn__ _order_inf">Track Orders</a><
								<a class="ft_lkn__ _wish_inf"> Wish List</a><
							<?php }; ?>

							<a class="ft_lkn__" href="./?logout">Log Out</a><

						<?php } else { ?>
							<a class="ft_lkn__" href="./?register">  Create Account</a><
							<a class="ft_lkn__" href="./?login"> Login</a><
						<?php }; ?>
				

						<br><br><br>
				
					
   				 	<p style="color: #FFF">24/7 Customers Service</p>
   				 	<h3 class="ft_lkn__" style="font-size: 12pt; color: #00000;">CALL US: +234 803 137 0588</h3><br><br>
   				 	<h3 class="ft_lkn__" style="font-size: 12pt; color: #00000;">OR: +234 807 742 1808</h3><br><br>
   				 	<p style="color: #FFF">EMAIL SUPPORT</p>
   				 	<a  href="mailto:support@yossell.com ft_lkn__" style="font-size: 12pt; text-transform: lowercase; color: #fff;">support@yossell.com</h3>
				</div></div>
				</center>
				
</div>
</div>
</div>
</div></div>

							<div class="mobileShow">

						<div class="footerd"> 
							<center> <a class=" " href="https://www.facebook.com/yosselltm/"><img  style="height: 44px; width: 44px;" src='./asset/Facebook.png'></a>
   				 	<a class=" " href="https://www.instagram.com/yosselltm"><img  style="height: 44px; width: 44px;" src='./asset/instagram.png'></a>
   				 	<a class=" " href="https://www.youtube.com/channel/UCmDD76KCxY7IbkoOlNsRS2Q"><img  style="height:44px; width: 44px;" src='./asset/youtube.png'></a>
   				 	<!--<a class=" " href="https://www.twitter.com/fortis_mall"><img  style="height: 40px; width: 40px;" src='./asset/twitter.png'></a>-->
 						</center>
						
					</div>
					</div>
				</div>

				<div class="mobileShow">
				<div class="footer">
				<center>
				<p class="__copy2" style="font-size: 11pt;">&copy Since 2019 - yossell.com All Rights Reserved</p> <br>
					
				</div>
		 	</center></div>
		 	
</div>
<script type="text/javascript">// <![CDATA[
function ShowHide(divId)
{
if(document.getElementById(divId).style.display == 'none')
{
document.getElementById(divId).style.display='block';
}
else
{
document.getElementById(divId).style.display = 'none';
}
}
// ]]></script></font></div>
<!--
<div class="mobileShow">

					<div class="footer">
				

<button class="accordion">Connect With Us Now</button>
<div class="panel"><br>
 <a href="http://facebook.com/yossell" ><img style="float: left; margin-top: 8px; width: 16%;  display: block;  overflow: hidden;  cursor: pointer; height: 46px; font-size: 28px; color: white; margin-top: 10px; margin-right:  4px; margin-left: 8px;" src='./asset/Facebook.png'></a>
  <a class="fa fa-phone aquamann" href="tel:+234 8141786417" style="font-size: 28px; color: white; margin-top: 18px; margin-right: 8px;
    margin-left: 9px;"></a>
    <a href="mailto:mailyossell@gmail.com"><img  class="aquamann" style="font-size: 28px; color: white; margin-top: 18px;
    margin-top: 9px; margin-right: 7px; margin-left: -10px;;" src='./asset/gmail.png' /></a>
    <a  href="http://instagram.com/fortis_mall" ><img style="width: 16%; display: block; overflow: hidden; cursor: pointer; height: 46px; float: left; margin-top: 8px; margin-left: 21px;" src='./images/_product1/insta.png' ></a>

     <a  href="https://www.twitter.com/fortis_mall" ><img style="width: 16%; display: block; overflow: hidden; cursor: pointer; height: 46px; float: left; margin-top: 8px; margin-left: 9px;" src='./asset/twitter.png' ></a>
    -->
    

<!--
<button class="accordion">About Yossell</button>
<div class="panel"><br>
  
   <a class="__copy2 " style="font-size: 11pt; font-weight: 700" href="./?about_us">About Us</a><br><br>
   <a class="__copy2 " style="font-size: 11pt; font-weight: 700" href="./?contact_us">Contact Us</a><br><br>
    <a class="__copy2" href="./?terms_policy" style="font-size: 11pt; font-weight: 700">Terms & Conditions</a><br><br>
    <a class="__copy2 " style="font-size: 11pt; font-weight: 700" href="./blog/index.php">Blog</a><br><br>
   
</div>

<button class="accordion">Shopping On Yossell.com</button>
<div class="panel"><br>
  <a class="__copy2" href="./?privacy" style="font-size: 11pt; font-weight: 700">Privacy</a><br><br>
    <a class="__copy2" href="./?return_refund" style="font-size: 11pt; font-weight: 700">Return Refund</a><br><br>
     <a class="__copy2" href="./?terms_sale" style="font-size: 11pt; font-weight: 700">Terms Of Sale</a><br><br>




</div>
-->



		<!--  
		  <img > <a class="fa fa-facebook aquamann " href="https://" src=""></a>
			<img> <a class=" aquamann" src="" href=""  ></a>-->

		



<!--[ mobile sticky ] 
<br>
<br>
<br>
	
						 footer ]
					  <div id="footer11">
					    <div class="container">
					      <p class="footer-block">
<div class="movingleft">
				
				<form class="_top_search">
						<input class="_inP_" type="text" name="s" placeholder="What Are You Looking For.......">
						<input type="submit" class="_inP_ _inP__btn" name="_serach_" value="SEARCH">
					</form>
					<div class="_m_sec pa _s_mb sss___" style="color: #FFF ; font-size: 15pt;">t</div>
				<?php if ($on_ == 1) { ?>

				<div class="_m_sec _s_mb  _wish_inf" > <span class="pa _side_l__oa1" style="color: #FFF">v</div>
						
			<a class="patent" style=" font-size: 20pt;  font-weight: 400; margin-top: -14px;" href="./?cart" > <span style="color: #FFF" class="_side_l__oa1 fas fa-shopping-cart"></span> <div class="c_num c_num_"><?php echo $total_cart; ?></div></a>
			<div class="_m_sec _s_mb  _order_inf"> <span class="pa _side_l__oa1" style="color: #FFF">a</div> 

		<?php if ($this_sell_eligible == 2) { ?>
				<a class="_m_sec _s_mb  _profile_inf" href="#PROFILE"> <span class="pa _side_l__oa1" style="color: #FFF">L</a>
		<?php } else { ?>

		<a class="_m_sec _s_mb  _profile_inf" href="#PROFILE"> <span class="pa _side_l__oa1" style="color: #FFF">L</a>
		<?php }; ?>


		
			<!--<a class="_m_sec _s_mb"  href="./email_attachemnt/index.php"> <span class="pa _side_l__oa1" style="color: #FFF">=</a>
	<?php } else { ?>
		<a class="_m_sec _s_mb" href="./?register"> <span class="pa _side_l__oa" style="color: #FFF; font-size: 15pt; margin-left: 14px;">0</span> </a>
		<a class="_m_sec _s_mb" href="./?login"> <span class="pa _side_l__oa" style="color: #FFF; font-size: 15pt; margin-left: 14px; ">~</span> </a>
	
			<?php }; ?>
			<a class="_m_sec _s_mb  " href="./"> <span class="pa _side_l__oa1" style="color: #FFF ; font-size: 15pt;">o</a>
</div>
						
				</div>
					    </div>
					  </div>
</div>-->
<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "10px";
    } 
  });
}
</script>		 
	<?php }; ?>




<script src="js/wow.min.js"></script>
              <script>
              new WOW().init();
              </script>




	<div class="_n_Pane_">
		<div class="_no_PP"></div>
	</div>

	<div class="_ovL_Pane">
		<div class="_in_lay_b" id="_in_lay_b_02">
			<div class="_pan_head_">
				<div class="close_MM pa">%</div>
				<div class="_tab_name"></div>
			</div>
			<div class="_in_ovPane"></div>
		</div>
	</div>

	<div class="_hP"></div>

	
    <script type="application/javascript" src="https://sdki.truepush.com/sdk/v2.0.2/app.js" async></script>
    <script>
    var truepush = window.truepush || [];
            
    truepush.push(function(){
        truepush.Init({
            id: "5e9dbdfec898449889c15c00"
        },function(error){
          if(error) console.error(error);
        })
    })
    </script>
    
    
    <script>
      truepush.GetSubscriberId(function(error, data){
        console.log("error",error,"Id", data);
      })
    </script>
    
	
</body>
</html>