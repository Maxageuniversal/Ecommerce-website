<script type="text/javascript">
$("._side_l__").attr("style", "grey");
$(".dbh_b").css({"color": "unset", "background": "#FFFFFF"});
$("._tab_name").html("Tracking Details");
</script>

<?php include "../db.php"; $data_ = explode("_", $_POST['_TrSt']); $id__ = $data_[0]; ?>

<style type="text/css">
._p20{
padding: 10px;
box-shadow: 0px 8px 16px 0px rgba(53, 50, 242, 0.4);
}
</style>

<div class="rd_edge _p20">

	<!-- <form class="_top_search">
		<input class="_inP_" type="text" placeholder="Search for products, services...">
		<input type="submit" class="_inP_ _inP__btn" name="_serach_" value="TRACK">
	</form> -->

	<?php

		$getMyOd = $class_->runS(" SELECT * FROM `orders` WHERE `id` = '$id__' ");
		if (mysqli_num_rows($getMyOd) > 0) {

		$row_tc  = mysqli_fetch_assoc($getMyOd);

		$id = $row_tc['id'];

		$date_time = $row_tc['date_time'];
		$tr_user = $row_tc['user'];
		$seller_id = $row_tc['seller_id'];
		$quantity = $row_tc['quantity'];
		$f_status = $row_tc['f_status'];
		$paid_status = $row_tc['paid_status'];

		$thumb_p_id = $row_tc['thumb_p_id'];
		$product_id = $row_tc['product_id'];

		$status = $row_tc['status']+0;
		$tr_time = $row_tc['tr_time'];
		$tr_loc = $row_tc['tr_loc'];
		$tr_day = $row_tc['tr_day'];

		$invoice_id = $row_tc['invoice_id'];
		$color = $row_tc['color'];
		$size = $row_tc['size'];
		$price = $row_tc['price'];

		$thumbIMG = $class_->runS(" SELECT image FROM `sub_products` WHERE `id` = '$thumb_p_id' ");
		$thumbIMG_FEt = mysqli_fetch_assoc($thumbIMG);
		$id_image = $thumbIMG_FEt['image'];

		$tr_getP = $class_->getP($product_id);
		$tr_getPF = mysqli_fetch_assoc($tr_getP);

		$tr_id = $tr_getPF['id'];
		$tr_name = $tr_getPF['name'];
		$tr_model_number = $tr_getPF['model_number'];


		?>

		<!-- --------------------------+++ 
		 
		<a class="_m_sec _s_mb " href="http://wa.me/" ><span class="pa " style="color: rgb(255, 0, 0);; text-transform: unset;font-size: 28pt; margin-top: 15px; margin-left: 17px;">=</span>  </a> 
    
    -->

		<div class="_flat_Mall_" id="_fM<?php echo $id; ?>" crt="<?php echo $value_1; ?>">

			<?php
				if ((time()-$t_stamp) < (60*60*24)) {
					?> <div class="__model__M_New">NEW</div> <?php
				}
			?>

			<div class="_flow___">
				<div class="_img_fl_rst"><img class="w_img" src="./images/_product/<?php echo $id_image; ?>"></div>
				<div class="_div_shr _div_shr_01">
					<div class="_pN<?php echo $id; ?>"><?php echo strtoupper($tr_name); ?></div>
					
					<div class="_this_p_dtl _this_p_dtl_nP m_none">
						<div class="_p_price_Ip_FL"><?php echo $class_->_currency($cur_currency, $price*$quantity); ?></div>
						<div class="_dis_count_ fl_none _ab<?php echo $id; ?>">Status: <?php echo $status; ?>%</div>
						<div class="_dis_count_ _w_d"><?php echo $date_time; ?></div>
					</div>

					<br>

					<div class="_fl_O m_none">
						<div style="width: <?php echo $status; ?>%" class="_fl_In _inF<?php echo $id; ?>"></div>
					</div>

				</div>

			</div>

			<div class="_tr_detail_">

					<?php if ($seller_id == $this_u_id) { ?>

						<div class="pa _mP_Act _u_tr_detail _trd<?php echo $id; ?>" id="<?php echo $id; ?>">&</div>

						<form class="_up_tr_form _rvForm<?php echo $id; ?>" method="POST" data="<?php echo $id; ?>">
							<input class="_inp__" type="number" max="100" name="_tr_perc" placeholder="Tracking progress (%)">
							<input class="_inp__" type="text" name="_tr_location" placeholder="Current location">
							<select class="_inp__" name="_tr_day">
								<option value="">Select Day</option>
								<?php foreach ($class_->dump(5) as $key => $value): ?>
									<option value="<?php echo strtolower($value); ?>"> <?php echo$class_->Capita($value); ?></option>
								<?php endforeach ?>
							</select>
							<input class="_inp__" type="time" name="_tr_time" placeholder="Current location">
							<input class="_inp__ button__" type="submit" name="_tr_sub_mit" value="UPDATE STATUS">
						</form>

						

					<?php }; ?>
					
				</div>

				<style type="text/css">
					._up_tr_form{
						margin: 1%;
						width: 98%;
						padding: 20px;
						border: 1px solid rgba(0, 175, 239, 0.19);
						background-color: rgba(0, 175, 239, 0.09);
						overflow: hidden;
						display: none;
					}
				</style>



			<div class="_c_button_">
				<span class="_in_s_r_sold irx"> <span class="fwi">Unique Code </span> <?php echo $tr_model_number; ?></span>
				<span class="_in_s_r_sold irx tl<?php echo $id; ?>"> <span class="fwi">Location:</span> <?php echo $tr_loc; ?></span>
				<span class="_in_s_r_sold irx tt<?php echo $id; ?>"> <span class="fwi">Time:</span> <?php echo $tr_time; ?></span>
				<span class="_in_s_r_sold irx td<?php echo $id; ?>"> <span class="fwi">Arrival day:</span> <?php echo $tr_day; ?></span>
				<span class="_in_s_r_sold irx"> <span class="fwi">Color:</span> <?php echo $color; ?></span>
				<span class="_in_s_r_sold irx"> <span class="fwi">Quantity:</span> <?php echo $quantity; ?></span>
				<span class="_in_s_r_sold irx"> <span class="fwi">Variation:</span> <?php echo $size.$capacity; ?></span>
				<span class="_in_s_r_sold irx"> <span class="fwi">Price:</span> <?php echo $class_->_currency($cur_currency, $price*$quantity); ?></span>
			</div>

		</div>

		<?php $ch_inv = $class_->runS(" SELECT * FROM `invoice` WHERE `invoice_id` = '$invoice_id' ");

		$ch_inv_ = mysqli_num_rows($ch_inv);
		$row_inv = mysqli_fetch_assoc($ch_inv);

		if ($ch_inv_ == 1) {

			$tr_get_u = $class_->runS("SELECT full_name FROM `user` WHERE `u_id` = '$tr_user' ");
			$tr_row = mysqli_fetch_assoc($tr_get_u);
			$tr_this_full_name = $tr_row['full_name'];

		?>

			<div class="_in_Frm_xLF _col_c_sum" style="font-size: 20pt;">Shipping Details</div>

			<span class="_in_s_r_sold irx"> <span class="fwi">Buyer:</span> <?php echo $class_->Capita($tr_this_full_name); ?></span>
			<span class="_in_s_r_sold irx"> <span class="fwi">Address:</span> <?php echo $class_->Capita($row_inv['address']); ?></span>
			<span class="_in_s_r_sold irx"> <span class="fwi">Phone:</span> <?php echo $class_->Capita($row_inv['phone']); ?></span>
			<span class="_in_s_r_sold irx"> <span class="fwi">Email:</span> <?php echo $class_->Capita($row_inv['email']); ?></span>

			<?php
				if ($f_status == "UNCLAIMED" && ($tr_user == $this_u_id || $admin_ == 1)) {
					?>
					<div class="_p__pro p_none m_none">
						<div class=" _50_btn23 _cf_pClmd bor m_none" id="<?php echo $product_id . '_' . $id; ?>" style="box-shadow: 0px 10px 19px #ff6600;
    border-radius: 95px 0px; width: 85%">Confirm & Write Review</div>



						<?php if ($f_status == "CLAIMED" && $admin_ == 1) { ?>
							<div class="_buy_inf _50_btn23 br_ _mk_Pd" id="<?php echo $id__; ?>">Paid</div>
						<?php } ?>

					</div>
					<?php
				}
			?>

			<!-- --------------------- -->

		<?php }; ?>

	<?php }; ?>

</div>