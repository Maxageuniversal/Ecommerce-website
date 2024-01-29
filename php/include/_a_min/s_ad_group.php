<?php

include "../../db.php"; $_ad_tlink_ = $_POST['_ad_tlink_'];

if ($_ad_tlink_ == "aB") { ?>

	<form method="POST" class="_form_flow__ _a_group" id="<?php echo $_ad_tlink_; ?>">
		<label class="_label__ _label__tY">About Us</label>
		<textarea class="_inp__ _this_cp" name="about" placeholder="e.g. About Us"><?php echo $all_about; ?></textarea>
		<input class="_inp__ button__ _bbY_d _b_green" type="submit" value="CREATE PAGE">
	</form>

<?php } else if ($_ad_tlink_ == "rT") { ?>

	<form method="POST" class="_form_flow__ _a_group" id="<?php echo $_ad_tlink_; ?>">
		<label class="_label__ _label__tY">Return Policy</label>
		<textarea class="_inp__ _this_cp" name="rt_privacy" placeholder="e.g. Return Privacy"><?php echo $all_privacy; ?></textarea>
		<input class="_inp__ button__ _bbY_d _b_green" type="submit" value="CREATE PAGE">
	</form>


<?php } else if ($_ad_tlink_ == "sC") { ?>

	<form method="POST" class="_form_flow__ _a_group" id="<?php echo $_ad_tlink_; ?>">
		<label class="_label__ _label__tY">Set Coupon</label>
		<input class="_inp__ _this_cp" type="text" name="coupon" placeholder="e.g. 1000" value="<?php echo $all_coupon; ?>">
		<input class="_inp__ _this_cp" value="<?php echo $all_coupon_trace; ?>" type="text" name="coupon_code" placeholder="e.g. JULYOKAY" value="Coupon code">
		<input class="_inp__ button__ _bbY_d _b_green" type="submit" value="SET COUPON">
	</form>

<?php } else if ($_ad_tlink_ == "sF") { ?>

	<form method="POST" class="_form_flow__ _a_group" id="<?php echo $_ad_tlink_; ?>">
		<label class="_label__ _label__tY">Shipping Fee</label>
		<input class="_inp__ _this_cp" type="text" name="sh_fee" placeholder="e.g. 1000" value="<?php echo $all_ship_f; ?>">
		<input class="_inp__ button__ _bbY_d _b_green" type="submit" value="POST SHIPPING FEE">
	</form>

<?php } else if ($_ad_tlink_ == "mMl") {

	$get_m_list = $class_->runS("SELECT email FROM `user` WHERE `email_list` = '1' ");
	$check_g_m_list = $class_->row($get_m_list);

	if ($check_g_m_list > 0) {

		while ($row = mysqli_fetch_assoc($get_m_list)) {
			$__email = $row['email']; ?>
			<div class="_in_s_r_sold" style="text-transform: lowercase;" href="mailto:"><?php echo strtolower($__email); ?></div>
			<?php
		}

	}

} else if ($_ad_tlink_ == "mU") {
	
	$get_u_list = $class_->runS("SELECT id, u_id, full_name FROM `user` ORDER BY id DESC ");
	$check_g_m_list = $class_->row($get_u_list);

	if ($check_g_m_list > 0) {

		while ($row = mysqli_fetch_assoc($get_u_list)) {
			$__id = $row['id'];
			$_full_name = $row['full_name']; ?>
			<div class="_in_s_r_sold _sel_u_p" id="<?php echo $__id; ?>"><?php echo $class_->Capita($_full_name); ?></div>
			<?php
		}

	}

} else if ($_ad_tlink_ == "dN") { ?>
	
	 DASHBOARD NEWS 
	<form method="POST" class="_form_flow__ _a_group" id="<?php echo $_ad_tlink_; ?>">

		<label class="_label__ _label__tY">Dashboard News</label>
		<textarea class="_inp__" name="db_news" placeholder="e.g. Dashboard News"><?php echo $this_news_header; ?></textarea>

		<input class="_inp__ button__ _bbY_d _b_green" type="submit" value="POST NEWS">

	</form>

<?php } else if ($_ad_tlink_ == "mC") { ?>
	
	<!-- CATEGORY -->
	<form method="POST" class="_form_flow__ _a_group" id="<?php echo $_ad_tlink_; ?>">

		<label class="_label__ _label__tY">Category Name</label>
		<input class="_inp__" type="text" name="category" placeholder="e.g. Electronics">

		<input class="_inp__ button__ _bbY_d _b_green" type="submit" value="CREATE CATEGORY">

		<br> <br>

		<?php $get_cat_ = $class_->runS(" SELECT * FROM `category` ");
		while ($row__gc = mysqli_fetch_assoc($get_cat_)) {
			$id_gc = $row__gc['id'];
			$category_gc = $row__gc['category']; ?>

			<div class="_in_s_r_sold _del_cssb" id="<?php echo $id_gc; ?>" typ="CAT"><?php echo $category_gc; ?></div>
		<?php } ?>

	</form>

<?php } else if ($_ad_tlink_ == "fN") { ?>
	
	<!-- CATEGORY -->
	<form method="POST" class="_form_flow__ _a_group" id="<?php echo $_ad_tlink_; ?>">

		<label class="_label__ _label__tY">Create Flash-News</label>
		<input class="_inp__" type="text" name="news_header" placeholder="e.g. News Header">

		<input class="_inp__ button__ _bbY_d _b_green" type="submit" value="CREATE NEWS">

	</form>

	<?php $get_fn = $class_->runS(" SELECT * FROM `flash_news` ORDER BY id DESC ");
		if (mysqli_num_rows($get_fn) > 0) { ?>

			<div class="box">
				<?php
					while ($row_fn = mysqli_fetch_assoc($get_fn)) {
						?>
							<div class="_in_s_r_sold rmv<?php echo $row_fn['id']; ?> _del_fln__" id="<?php echo $row_fn['id']; ?>">
								<?php echo $row_fn['news_header']; ?>
								<a style="font-weight: bold;" href="#"> CLICK TO REMOVE</a>
							</div>
						<?php
					}
				?>
			</div>

	<?php }; ?>

<?php } else if ($_ad_tlink_ == "mSC") { ?>
	
	<!-- SUB-CATEGORY -->
	<form method="POST" class="_form_flow__ _a_group" id="<?php echo $_ad_tlink_; ?>">

		<label class="_label__ _label__tY">Select Category</label>
		<select class="_inp__" name="category">
			<option value="">Select Category</option>
			<?php
				foreach ($class_->dump(4) as $key => $value) {
					?>  <option value="<?php echo strtolower($value); ?>"><?php echo $class_->Capita($value); ?></option> <?php
				}
			?>
		</select>

		<label class="_label__ _label__tY">Sub-Category Name</label>
		<input class="_inp__" type="text" name="sub_category" placeholder="e.g. Electronics">

		<input class="_inp__ button__ _bbY_d _b_green" type="submit" value="CREATE SUB CATEGORY">

		<br> <br>

		<?php $get_cat_ = $class_->runS(" SELECT * FROM `sub_category` ");
		while ($row__gc = mysqli_fetch_assoc($get_cat_)) {
			$id_gc = $row__gc['id'];
			$category_gc = $row__gc['category'];
			$sub_category_gc = $row__gc['sub_category']; ?>
			<div class="_in_s_r_sold _del_cssb" id="<?php echo $id_gc; ?>" typ="SCAT"><?php echo $category_gc . ' &raquo <b>' . $sub_category_gc; ?></b></div>
		<?php } ?>

	</form>

<?php } else if ($_ad_tlink_ == "mSSC") { ?>
	
	<!-- SUB-CATEGORY -->
	<form method="POST" class="_form_flow__ _a_group" id="<?php echo $_ad_tlink_; ?>">

		<label class="_label__ _label__tY">Select Category</label>
		<select class="_inp__" name="category">
			<option value="">Select Category</option>
			<?php
				foreach ($class_->dump(4) as $key => $value) {
					?>  <option value="<?php echo strtolower($value); ?>"><?php echo $class_->Capita($value); ?></option> <?php
				}
			?>
		</select>

		<label class="_label__ _label__tY">Select Sub-Category</label>
		<select class="_inp__" name="sub_category">
			<option value="">Select Sub-Category</option>
			<?php
				foreach ($class_->dump(8) as $key => $value) {
					?>  <option value="<?php echo strtolower($value); ?>"><?php echo $class_->Capita($value); ?></option> <?php
				}
			?>
		</select>

		<label class="_label__ _label__tY">Sub Sub-Category Name</label>
		<input class="_inp__" type="text" name="sub_sub_category" placeholder="e.g. Game Console">

		<input class="_inp__ button__ _bbY_d _b_green" type="submit" value="CREATE SUB SUB-CATEGORY">

		<br> <br>

		<?php $get_cat_ = $class_->runS(" SELECT * FROM `sub_sub_category` ");
		while ($row__gc = mysqli_fetch_assoc($get_cat_)) {
			$id_gc = $row__gc['id'];
			$category_gc = $row__gc['category'];
			$sub_category_gc = $row__gc['sub_category'];
			$sub_sub_category_gc = $row__gc['sub_sub_category']; ?>
			<div class="_in_s_r_sold _del_cssb" id="<?php echo $id_gc; ?>" typ="SSCAT"><?php echo $category_gc . " &raquo <b style='color: #1cb;'>" . $sub_category_gc . "</b> &raquo <b>" . $sub_sub_category_gc; ?></b></div>
		<?php } ?>

	</form>

<?php } else if ($_ad_tlink_ == "mB") { ?>
	
	<!-- BRAND -->
	<form method="POST" class="_form_flow__ _a_group" id="<?php echo $_ad_tlink_; ?>">

		<div class="_inp__seg _seg_sell_">
		
			<label class="_label__ _label__tY">Brand Image</label>
			<div class="_ov_lay"><input class="_in_file__ _in_file___p" type="file" name="img_1"> <p class="_in_tt__">Select / Drop Photo</p> </div>
			<div class="certificate_prev _p_prev_p"> <img class="p_image _f_image _f_image_p _f_img__" src="./asset/img.png"> </div>

		</div>

		<label class="_label__ _label__tY">Brand Name</label>
		<input class="_inp__" type="text" name="brand_name" placeholder="e.g. Ifinix">

		<label class="_label__ _label__tY">Select Category</label>
		<select class="_inp__" name="category">
			<option value="">Select Category</option>
			<?php
				foreach ($class_->dump(4) as $key => $value) {
					?>  <option value="<?php echo strtolower($value); ?>"><?php echo $class_->Capita($value); ?></option> <?php
				}
			?>
		</select>

		<input class="_inp__ button__ _bbY_d _b_green" type="submit" value="CREATE BRAND">

	</form>

<?php } else if ($_ad_tlink_ == "mBi") { ?>
	
	<!-- BILL BOARD -->
	<form method="POST" class="_form_flow__ _a_group" id="<?php echo $_ad_tlink_; ?>">

		<div class="_inp__seg _seg_sell_">
		
			<label class="_label__ _label__tY">Billboard Image</label>
			<div class="_ov_lay"><input class="_in_file__ _in_file___p" type="file" name="img_1"> <p class="_in_tt__">Select / Drop Photo</p> </div>
			<div class="certificate_prev _p_prev_p"> <img class="p_image _f_image _f_image_p _f_img__" src="./asset/img.png"> </div>

		</div>

		<label class="_label__ _label__tY">Select Category</label>
		<select class="_inp__" name="category">
			<option value="">Select Category</option>
			<?php
				foreach ($class_->dump(4) as $key => $value) {
					?>  <option value="<?php echo strtolower($value); ?>"><?php echo $class_->Capita($value); ?></option> <?php
				}
			?>
		</select>

		<label class="_label__ _label__tY">Board Type</label>
		<select class="_inp__" name="type">
			<option value="">Select Billboard Type</option>
			<?php
				foreach ($class_->dump(7) as $key => $value) {
					?>  <option value="<?php echo strtolower($value); ?>"><?php echo $class_->Capita($value); ?></option> <?php
				}
			?>
		</select>

		<label class="_label__ _label__tY">Board Link</label>
		<input class="_inp__" type="text" name="board_link" placeholder="e.g. http://www.example.com">

		<label class="_label__ _label__tY">Board Position</label>
		<select class="_inp__ _m_cat" name="position">
			<option value="">Select Position</option>
			<?php
				foreach ($class_->dump(6) as $key => $value) {
					?>  <option value="<?php echo strtolower($value); ?>"><?php echo $class_->Capita($value); ?></option> <?php
				}
			?>
		</select>

		<input class="_inp__ button__ _bbY_d _b_green" type="submit" value="CREATE BILLBOARD">

	</form>

<?php } ?>