<script type="text/javascript">
	$("._side_l__").attr("style", "grey");
	$(".dbh_s").css({"color": "unset", "background": "#FFFFFF"});
	$("._tab_name").html("Selling Account ");
</script>

<?php

include "../db.php";

if ($this_sell_eligible == 3) { ?>

	<div class="_notice_pix_g">Your account is awaiting approval for selling.<br>You will be contacted shortly.</div>

<?php } else if ($this_sell_eligible == 2 && !isset($_GET['p'])) { ?>

	<div class="_notice_pix_g">Your account is activated for selling.</div>

	<!-- <div class="_ov_hd">
		<a class="_o_link__" href="">Add Category</a>
		<a class="_o_link__" href="">Add Product</a>
	</div> -->

<form method="POST" class="_form_flow__ _a_p__">

		<div class="_inp_seg____">
			<label class="_label__">Select Category</label>
			<select class="_inp__ _m_cat" name="category">
				<option value="">Select Category</option>
				<?php
					foreach ($class_->dump(4) as $key => $value) {
						?>  <option value="<?php echo strtolower($value); ?>"><?php echo $class_->Capita($value); ?></option> <?php
					}
				?>
			</select>
		</div>

		<div class="_inp_seg____">
			<label class="_label__">Product Name</label>
			<input class="_inp__" type="text" name="p_name" placeholder="e.g. Cup Cake">
		</div>

		<div class="_inp_seg____">
			<label class="_label__">Generate Model Number</label>
			<input class="_inp__" type="text" name="model_number" placeholder="e.g. cya00192">
		</div>

		<div class="_load_cc_">Select Category</div>

		<div class="_inp_seg____">
			<label class="_label__">Price Range</label>
			<input class="_inp__" type="text" name="price_range" placeholder="e.g. 2000">
		</div>

		<div class="_inp_seg____">
			<label class="_label__">Discount</label>
			<input class="_inp__" type="number" name="discount" placeholder="e.g. 1%">
		</div>

		
			<div class="_add_spec">Add Shipping Duration, Return Policy & More Info</div>
			<input hidden="on" type="text" class="spec_col" name="p_spec" />
		</div>

		<div class="_spec_area">
			<div class="_inp_seg____a">
				<label class="_label__">Product Description</label>
				<textarea class="_inp__" name="p_desc" placeholder="Product description"></textarea>
			</div>
		</div>

		<!--<div class="_spec_area">
			<div class="_inp_seg____a">
				<label class="_label__">Key Features</label>
				<textarea class="_inp__" name="p_d_description" placeholder="Key Features"></textarea>
			</div>
		</div>

		<div class="_spec_area">
			<div class="_inp_seg____a">
				<label class="_label__">Product Benefits</label>
				<textarea class="_inp__" name="p_dd_description" placeholder="Product Benefits"></textarea>
			</div>
		</div>-->

		<input class="_inp__ button__ _bbY_d" type="submit" value="UPDATE">

	</form>

<?php } else {

	if ($this_sell_eligible == 4) { ?>
		<div class="_notice_pix">Your request to become a seller has been declined.<br>Take your time to review your details and re-apply.</div>
	<?php } else { ?>
		<div class="_notice_pix">Please update your account to start selling.</div>
	<?php }; ?>

	<form method="POST" class="_form_flow__ _sell__">

		<label class="_ovL_Pane">Account Status</label>

		<!-- <div class="pa">abcdefghijklmnopqurstuvwxyz ABCDEFGHIJKLMNOPQURSTUVWXYZ</div> -->

		<div class="_inp__seg">

			<center>

				<div <?php if ($this_seller_manufacturer == 1) { ?> seltd="on" <?php } ?> <?php if ($this_seller_manufacturer == 1) { ?> style="background-color: #ffaa28; color: #FFFFFF;" <?php } ?>
				class="_inp_m _inp_"> <span class="_in_tt_ _in_tt_c" <?php if ($this_seller_manufacturer == 1) { ?> style="color: #FFFFFF;" <?php } ?> >Manufacturer</span> <span class="pa _in_tt_ _in_tt_c" <?php if ($this_seller_manufacturer == 1) { ?> style="color: #FFFFFF;" <?php } ?> >U</span> </div>

				<div <?php if ($this_seller_retailer == 1) { ?> seltd="on" <?php } ?> <?php if ($this_seller_retailer == 1) { ?> style="background-color: #ffaa28; color: #FFFFFF;" <?php } ?>
				class="_inp_r _inp_"> <span class="_in_tt_ _in_tt_r" <?php if ($this_seller_retailer == 1) { ?> style="color: #FFFFFF;" <?php } ?> >Retailer</span> <span class="pa _in_tt_ _in_tt_r" <?php if ($this_seller_retailer == 1) { ?> style="color: #FFFFFF;" <?php } ?> >U</span> </div>

				<input hidden="on" class="_t_c" type="text" name="manufacturer" value="<?php echo $this_seller_manufacturer; ?>">
				<input hidden="on" class="_t_r" type="text" name="retailer" value="<?php echo $this_seller_retailer; ?>">
			</center>
			
		</div>

		<label class="_label__">Business Name</label>
		<input class="_inp__" type="text" name="business_name" placeholder="e.g. Coca Cola" value="<?php echo $class_->Capita($this_business_name); ?>">

		<label class="_label__">Business Phone</label>
		<input class="_inp__" type="text" name="b_phone" placeholder="e.g. +47 890 457" value="<?php echo $class_->Capita($this_b_phone); ?>">

		<label class="_label__">Business Date Of Establishment</label>
		<input class="_inp__ _b_date" type="text" name="b_date" placeholder="e.g. 03-04-2018" value="<?php echo $class_->Capita($this_b_date); ?>">

		<label class="_label__">Business Location</label>
		<input class="_inp__" type="text" name="b_loc" placeholder="e.g. Lagos" value="<?php echo $class_->Capita($this_b_loc); ?>">

		<div class="_inp__seg _seg_sell_">
		
			<label class="_label__">Account Image</label>
			<div class="_ov_lay"><input class="_in_file__ _in_file___p" type="file" name="p_img"> <p class="_in_tt__">Select / Drop Photo</p> </div>
			<div class="certificate_prev _p_prev_p"> <img class="p_image _f_image _f_image_p" src="<?php echo $class_->verifyImage("../../images/_p_img/".$this_image); ?>"> </div>

		</div>

		<div class="_inp__seg _seg_sell_">
		
			<label class="_label__">Business Certificate</label>
			<div class="_ov_lay"><input class="_in_file__ _in_file___c" type="file" name="c_img"> <p class="_in_tt__">Select / Drop Photo</p> </div>
			<div class="certificate_prev _p_prev_c"> <img class="_f_image _f_image_c" src="<?php echo $class_->verifyImage("../../images/_c_img/".$this_company_certificate); ?>"> </div>			

		</div>

		<input class="_inp__ button__ _bbY_d" type="submit" value="UPDATE">

	</form>

<?php } ?>