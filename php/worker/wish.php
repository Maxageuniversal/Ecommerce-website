<?php
	
	include "../db.php";

	$_WLST = $_POST['_WLST'];

	$chk_WList_ = $class_->runS("SELECT id FROM `wish_list` WHERE `product_id` = '$_WLST' AND `user` = '$this_u_id' ");
	$chk_WList_R = mysqli_num_rows($chk_WList_);

	if ($chk_WList_R == 0) {

		$class_->runS(" INSERT INTO `wish_list` (`user`, `product_id`, `date_time`) VALUES ('$this_u_id', '$_WLST', '$date_') ");

		// Conclude --
		$get_WList_ = $class_->runS("SELECT id FROM `wish_list` WHERE `product_id` = '$_WLST' ");
		$w_list = mysqli_num_rows($get_WList_)+0;

	?>

		<script type="text/javascript">
			$("._Wish_L_M").css({"background": "#00a311"}).html("<span class='pa'>!</span> Save For Later - <?php echo $w_list; ?>");
		</script>

	<?php } else {

		$class_->runS(" DELETE FROM `wish_list` WHERE `product_id` = '$_WLST' ");

		// Conclude --
		$get_WList_ = $class_->runS("SELECT id FROM `wish_list` WHERE `product_id` = '$_WLST' ");
		$w_list = mysqli_num_rows($get_WList_)+0;

		if ($_POST['_sRc'] == "wDb") {
			?>

			<script type="text/javascript">
				$("#_fM<?php echo $_WLST; ?>").slideUp(300, function () {
					$(this).remove();
				});
			</script>

			<?php 
		} else {
			?>

			<script type="text/javascript">
				$("._Wish_L_M").css({"background": "#999191"}).html("<span class='pa'>!</span> Wishlist - <?php echo $w_list; ?>");
			</script>

			<?php
		}

	}