<?php

include "../db.php";
$_m_cat = strtolower($_POST['_m_cat']);
$get_sub_cat = $class_->runS(" SELECT * FROM `sub_category` WHERE `category` = '$_m_cat' ");

if (mysqli_num_rows($get_sub_cat) > 0) { ?>

	<div class="_inp_seg____">

		<label class="_label__" style="margin-top: 0px;">Sub-Category</label>
		<select class="_inp__ _m_sub_cat" name="sub_category">
			<option value="">Select Sub-Category</option>
			<?php while ($row__ = mysqli_fetch_assoc($get_sub_cat)) {
				$sub_cat_row = $row__['sub_category']; ?> 
					<option value="<?php echo strtolower($sub_cat_row); ?>"><?php echo $class_->Capita($sub_cat_row); ?></option>
			<?php }; ?>
		</select>

	</div>

	<div class="_load_sub_cc_">Select Sub Sub-Category</div>

<?php

	$get_brand = $class_->runS(" SELECT brand_name FROM `brand` WHERE `category` = '$_m_cat' ORDER BY brand_name ASC ");
	if (mysqli_num_rows($get_brand) > 0) { ?>

		<div class="_inp_seg____">

			<label class="_label__">Product Brand</label>
			<select class="_inp__" name="p_brand">
				<option value="">Select Product Brand</option>
			<?php
			while ($rw = mysqli_fetch_assoc($get_brand)) {
				$array_ = $rw['brand_name'];
				?>
					<option value="<?php echo strtolower($array_); ?>"><?php echo $class_->Capita($array_); ?></option>
				<?php
			} ?>
			</select>
		</div>
	<?php }

} else { ?>

	<label class="_label__" style="color: red;">No Sub Category found!</label>

<?php }; ?>