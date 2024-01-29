<?php

	include "../db.php";

	$_data_this_user = $_POST['_sel_u_p'];

	$get_this_u = $class_->runS("SELECT * FROM `user` WHERE `id` = '$_data_this_user' ");
	$check_this_g_u = $class_->row($get_this_u);

	if ($check_this_g_u > 0) {

		$_this_row = mysqli_fetch_assoc($get_this_u);

		$_data_thisId = $_this_row['id'];
		$_data_this_u_id = $_this_row['u_id'];
		$_data_this_email = $_this_row['email'];
		$_data_this_full_name = $_this_row['full_name'];

		$_data_this_image = $_this_row['image'];
		$_data_this_cart_id = $_this_row['cart_id'];

		?>

			<script type="text/javascript">
				$("._tab_name").html("<?php echo $class_->Capita($_data_this_full_name); ?>");
				$("._in_lay_b").css({"max-width": "100%", "width": "100%"})
			</script>

		<?php

		$reserved_admin = array("WU6QP111532100796", $_data_this_u_id);

		$admin_ = 0;
		if (in_array($_data_this_u_id, $reserved_admin)) {
			$admin_ = 1;
		}

		$get_cart = $class_->runS(" SELECT * FROM `cart` WHERE `user` = '$_data_this_u_id' ");
		$total_cart = mysqli_num_rows($get_cart)+0;

		$_data_this_sex = $_this_row['sex'];
		$_data_this_state = $_this_row['state'];
		$_data_this_country = $_this_row['country'];
		$_data_this_consumer = $_this_row['consumer'];
		$_data_this_retailer = $_this_row['retailer'];
		$_data_this_address = $_this_row['address'];
		$_data_this_phone = $_this_row['phone'];
		$_data_this_buy_eligible = $_this_row['buy_eligible'];
		
		$_data_this_seller_manufacturer = $_this_row['seller_manufacturer'];
		$_data_this_seller_retailer = $_this_row['seller_retailer'];
		$_data_this_business_name = $_this_row['business_name'];
		$_data_this_company_certificate = $_this_row['company_certificate'];
		$_data_this_b_date = $_this_row['b_date'];
		$_data_this_b_phone = $_this_row['b_phone'];
		$_data_this_sell_eligible = $_this_row['sell_eligible'];

		$_data_this_a_o_spec = $_this_row['a_o_spec'];
		$_data_this_s_cat = $_this_row['s_cat'];
		$_data_this_b_loc = $_this_row['b_loc'];
		$_data_this_b_phone = $_this_row['b_phone'];

		$_data_this_service_description = $_this_row['service_description'];
		$_data_this_service_eligible = $_this_row['service_eligible'];

		$_data_this_date_joined = $_this_row['date_joined'];

		$_data_this_store_coupon = $_this_row['store_coupon'];
		$_data_this_my_coupon = $_this_row['my_coupon'];
		$_data_this_email_list = $_this_row['email_list'];

		if ($_data_this_email_list == 0) {
			$mail_list_style = "background: #373837;";
		} else {
			$mail_list_style = "background: #0ae14f;";
		} ?>

		<div class="rd_edge">

			<div class="_ovL_Pane">

				<div class="_ovL_Pane">Account Details</div>

				<div class="_p_tplm__">Full Name</div>
				<div class="_p_btlm__"><?php echo $_data_this_full_name; ?></div>

				<div class="_p_tplm__">Address</div>
				<div class="_p_btlm__"><?php echo $_data_this_address; ?></div>

				<div class="_p_tplm__">Phone Number</div>
				<div class="_p_btlm__"><?php echo $_data_this_phone; ?></div>

				<div class="_p_tplm__">Joined</div>
				<div class="_p_btlm__"><?php echo $_data_this_date_joined; ?></div>

			</div>

			<div class="_p__pro">

				<div class="_uni_hd__">Account Configuration</div>

			

				<div class="_p_tplm__ m_list_">
					<div class="_tgr__">Mail-list</div>
					<div class="pa _tgr__01 m_none m_btn" style="<?php echo $mail_list_style; ?>">U</div>
				</div>

				<div class="_p_tplm__">
					<div class="_tgr__">Selling Status</div>
					<div class="pa _tgr__01 m_none" style="<?php echo $s_s_style; ?>">U</div>
				</div>

			</div>

			<div class="_notice_pix">Buying Details</div>

			<div class="pad_area">

				<label class="_label__">Account Type</label>

				<div class="_inp__seg">

					<center>

						<div <?php if ($_data_this_consumer == 1) { ?> seltd="on" <?php } ?> <?php if ($_data_this_consumer == 1) { ?> style="background-color: #0400f6; color: #FFFFFF;" <?php } ?>
						class="_inp_c _inp_"> <span class="_in_tt_ _in_tt_c" <?php if ($_data_this_consumer == 1) { ?> style="color: #FFFFFF;" <?php } ?> >Consumer</span> <span class="pa _in_tt_ _in_tt_c" <?php if ($_data_this_consumer == 1) { ?> style="color: #FFFFFF;" <?php } ?> >U</span> </div>

						<div <?php if ($_data_this_retailer == 1) { ?> seltd="on" <?php } ?> <?php if ($_data_this_retailer == 1) { ?> style="background-color: #0400f6; color: #FFFFFF;" <?php } ?>
						class="_inp_r _inp_"> <span class="_in_tt_ _in_tt_r" <?php if ($_data_this_retailer == 1) { ?> style="color: #FFFFFF;" <?php } ?> >Retailer</span> <span class="pa _in_tt_ _in_tt_r" <?php if ($_data_this_retailer == 1) { ?> style="color: #FFFFFF;" <?php } ?> >U</span> </div>

						<input hidden="on" class="_t_c" type="text" name="consumer" value="<?php echo $_data_this_consumer; ?>">
						<input hidden="on" class="_t_r" type="text" name="retailer" value="<?php echo $_data_this_retailer; ?>">
					
					</center>
					
				</div>

				<label class="_label__">Full Name</label>
				<input disabled="on" class="_inp__" type="text" name="full_name" placeholder="e.g. Joh Doe" value="<?php echo $class_->Capita($_data_this_full_name); ?>">

				<label class="_label__">Sex</label>
				<select class="_inp__" name="sex">
					<option value="<?php echo $class_->checkSex($_data_this_sex, "Select Sex"); ?>"><?php echo $class_->Capita($class_->checkSex($_data_this_sex, "Select Sex")); ?></option>
					<option value="male">Male</option>
					<option value="female">Female</option>
				</select>

				<label class="_label__">Address</label>
				<input disabled="on" class="_inp__" type="text" name="address" placeholder="e.g. Oak Lummama, 342001, AZ" value="<?php echo $class_->Capita($_data_this_address); ?>">

				<label class="_label__">Country</label>
				<select class="_inp__" name="country">
					<option value="<?php echo $class_->checkSex($_data_this_country, ""); ?>"><?php echo $class_->Capita($class_->checkSex($_data_this_country, "Select Country")); ?></option>
					<?php
						foreach ($class_->dump(2) as $key => $value) {
							?>  <option value="<?php echo strtolower($value); ?>"><?php echo $class_->Capita($value); ?></option> <?php
						}
					?>
				</select>

				<label class="_label__">State / Province</label>
				<input disabled="on" class="_inp__" type="text" name="state" placeholder="e.g. Arizona" value="<?php echo $class_->Capita($_data_this_state); ?>">

				<label class="_label__">Phone Number</label>
				<input disabled="on" class="_inp__" type="text" name="phone" placeholder="e.g. +1 342 3372 234" value="<?php echo $_data_this_phone; ?>">

			</div>




			<div class="_notice_pix">Selling Details</div>

			<div class="pad_area">
				
				<label class="_label__">Account Status</label>

				<div class="_inp__seg">

					<center>

						<div <?php if ($_data_this_seller_manufacturer == 1) { ?> seltd="on" <?php } ?> <?php if ($_data_this_seller_manufacturer == 1) { ?> style="background-color: #0400f6; color: #FFFFFF;" <?php } ?>
						class="_inp_m _inp_"> <span class="_in_tt_ _in_tt_c" <?php if ($_data_this_seller_manufacturer == 1) { ?> style="color: #FFFFFF;" <?php } ?> >Manufacturer</span> <span class="pa _in_tt_ _in_tt_c" <?php if ($_data_this_seller_manufacturer == 1) { ?> style="color: #FFFFFF;" <?php } ?> >U</span> </div>

						<div <?php if ($_data_this_seller_retailer == 1) { ?> seltd="on" <?php } ?> <?php if ($_data_this_seller_retailer == 1) { ?> style="background-color: #0400f6; color: #FFFFFF;" <?php } ?>
						class="_inp_r _inp_"> <span class="_in_tt_ _in_tt_r" <?php if ($_data_this_seller_retailer == 1) { ?> style="color: #FFFFFF;" <?php } ?> >Retailer</span> <span class="pa _in_tt_ _in_tt_r" <?php if ($_data_this_seller_retailer == 1) { ?> style="color: #FFFFFF;" <?php } ?> >U</span> </div>

						<input hidden="on" class="_t_c" type="text" name="manufacturer" value="<?php echo $_data_this_seller_manufacturer; ?>">
						<input hidden="on" class="_t_r" type="text" name="retailer" value="<?php echo $_data_this_seller_retailer; ?>">
					</center>
					
				</div>

				<label class="_label__">Business Name</label>
				<input disabled="on" class="_inp__" type="text" name="business_name" placeholder="e.g. Coca Cola" value="<?php echo $class_->Capita($_data_this_business_name); ?>">

				<label class="_label__">Business Phone</label>
				<input disabled="on" class="_inp__" type="text" name="b_phone" placeholder="e.g. +47 890 457" value="<?php echo $class_->Capita($_data_this_b_phone); ?>">

				<label class="_label__">Business Date Of Establishment</label>
				<input disabled="on" class="_inp__ _b_date" type="text" name="b_date" placeholder="e.g. 03-04-2018" value="<?php echo $class_->Capita($_data_this_b_date); ?>">

				<label class="_label__">Business Location</label>
				<input disabled="on" class="_inp__" type="text" name="b_loc" placeholder="e.g. Lagos" value="<?php echo $class_->Capita($_data_this_b_loc); ?>">

				<div class="_inp__seg _seg_sell_">
				
					<label class="_label__">Account Image</label>
					<!-- <div class="_ov_lay"><input class="_in_file__ _in_file___p" type="file" name="p_img"> <p class="_in_tt__">Select / Drop Photo</p> </div> -->
					<a class="__flr___" target="_blank" href="<?php echo $class_->verifyImage("../../images/_p_img/".$_data_this_image); ?>">VIEW IMAGE</a>
					<div class="certificate_prev _p_prev_p fl_none"> <img class="p_image _f_image _f_image_p" src="<?php echo $class_->verifyImage("../../images/_p_img/".$_data_this_image); ?>"> </div>

				</div>

				<div class="_inp__seg _seg_sell_">
				
					<label class="_label__">Business Certificate</label>
					<!-- <div class="_ov_lay"><input class="_in_file__ _in_file___c" type="file" name="c_img"> <p class="_in_tt__">Select / Drop Photo</p> </div> -->
					<a class="__flr___" target="_blank" href="<?php echo $class_->verifyImage("../../images/_c_img/".$_data_this_company_certificate); ?>">VIEW IMAGE</a>
					<div class="certificate_prev _p_prev_c fl_none"> <img class="_f_image _f_image_c" src="<?php echo $class_->verifyImage("../../images/_c_img/".$_data_this_company_certificate); ?>"> </div>			

				</div>

			</div>



			<?php if ($admin_ == 1) { ?>
				<div class="_p__pro p_none m_none _act_pp__">
					<div class="_app_inf _50_btn23" id="<?php echo $_data_this_user; ?>">Approve</div>
					<div class="_del_inf _50_btn23 br_" id="<?php echo $_data_this_user; ?>">Decline</div>
				</div>
			<?php }; ?>

		</div>

	<?php } else {
		
	} ?>

<style type="text/css">
	.pad_area{
		padding: 15px;
		display: block;
		overflow: hidden;
	}
	.__flr___{
		float: right;
		display: inline-block;
		padding: 10px 15px;
		border: 1px solid #EEE;
		border-radius: 3px;
	}
</style>