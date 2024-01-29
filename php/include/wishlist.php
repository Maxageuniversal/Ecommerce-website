<script type="text/javascript">
	$("._side_l__").attr("style", "grey");
	$(".dbh_wl").css({"color": "unset", "background": "#FFFFFF"});
	$("._tab_name").html("MY WISHLIST").css({"color": "white", });
</script>

<?php
	
	include "../db.php";

	$chk_WList_ = $class_->runS("SELECT * FROM `wish_list` WHERE `user` = '$this_u_id' ORDER BY `id` DESC ");
	$chk_WList_R = mysqli_num_rows($chk_WList_);

	if ($chk_WList_R > 0) {

		while ($rowW = mysqli_fetch_assoc($chk_WList_)) {
			$wp_id = $rowW['product_id'];
			$w_date_ = $rowW['date_time'];

			$getW_P = $class_->runS("SELECT name, image, price, slashed_price, store_owner, time_stamp FROM `products` WHERE `id` = '$wp_id' ORDER BY `id` DESC ");
			$getW_P_FEt = mysqli_fetch_assoc($getW_P);			

			$name = $getW_P_FEt['name'];
			$image = $class_->getImageP($wp_id);
			$price = $getW_P_FEt['price'];
			$slashed_price = $getW_P_FEt['slashed_price'];
			$store_owner = $getW_P_FEt['store_owner'];

			$t_stamp = $getW_P_FEt['time_stamp'];

			?>

			<div class="_flat_Mall_" id="_fM<?php echo $wp_id; ?>">

				<?php
					if ((time()-$t_stamp) < (60*60*24)) {
						?> <div class="__model__M_New">NEW</div> <?php
					}
				?>

				<img class="w_img" src="./images/_product/<?php echo $image; ?>">
				<div class="_div_shr _div_shr_01">
					<div><?php echo strtoupper($name); ?></div>
					<div class="_this_p_dtl _this_p_dtl_nP">
						<div class="_w_d"><?php echo $w_date_; ?></div>
					</div>
				</div>
				<div class="_div_shr _div_shr_02">
					<a class="_buy_Flat" href="./?product_v=<?php echo $wp_id; ?>">VIEW PRODUCT</a>
					<img src="./asset/cancel.png" class="_wl_Can _can_W" id="<?php echo $wp_id; ?>" />
					<img src="./asset/91.gif" class="_wl_Can _dim_w" id="_l<?php echo $wp_id; ?>" />
				</div>
			</div>

			<?php
		}

	} else { ?>
		<div class="_exp_Div">

							<a href="./"><img class="_this_p_img_q" style=" padding-top: 5px; padding-right: 5px; width: 65%; height: 55%;  margin-left: 12px" src="./images/_product1/wishall.png"><h4 class="tymix" style="color: #000;">Wish Now</h4></a>

						
						</div>
	<?php }

?>
