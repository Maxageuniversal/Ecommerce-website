<?php

	include "../db.php";

	$_quantity = $_POST['quantity'];
	$_p_tag_trace =  explode("+", $_POST['_p_tag_trace']);
	$_p_tag =  $_p_tag_trace[0];
	$_p_tag_trace =  $_p_tag_trace[1];
	$cart_thumb_id = $_GET['p_id'];

	$_p_tag_explo = explode("-", $_p_tag);

	$_p_tag = $_p_tag_explo[0]."-".$_p_tag_explo[1]."-".$_quantity;

	if ($_quantity == null || $_quantity < 1) {
		echo "Select quantity";
		exit();
	}

	$check_p_t_trace = $class_->runS(" SELECT price_tag_trace FROM `sub_products` WHERE `id` = '$cart_thumb_id' AND `price_tag_trace` = '$_p_tag_trace' ");

	if (mysqli_num_rows($check_p_t_trace) > 0) {

		// Added to cart
		$class_->runS(" UPDATE `sub_products` SET `added_to_cart` = added_to_cart+1 WHERE `id` = '$cart_thumb_id' ");
		
		$add_cart = $class_->runS(" INSERT INTO `cart` (`user`, `cart_id`, `cart_thumb_id`, `date_time`, `price_tag`, `price_tag_trace`) VALUES ('$this_u_id', '$this_cart_id', '$cart_thumb_id', '$date_', '$_p_tag', '$_p_tag_trace') ");

		if ($add_cart) {

			$get_cart = $class_->runS(" SELECT id FROM `cart` WHERE `user` = '$this_u_id' ");
			$total_cart_ = mysqli_num_rows($get_cart);

			echo "Product added to cart successfully.";
			
			?>
				<script type="text/javascript">
					$("._ld_detail_aa").html("<div class='_nil_area'><center>Product added to cart successfully.</center></div>");
					setTimeout(function () {
						$("._ld_detail_aa").html("");
					}, 2000);
					$(".c_num_").html("<?php echo $total_cart_; ?>");
				</script>
			<?php

		}

	} else {
		echo "Price has been changed!";
	}

?>