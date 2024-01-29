<?php

include "../db.php";
$_m_sub_cat = strtolower($_POST['_m_sub_cat']);
$get_sub_sub_cat = $class_->runS(" SELECT * FROM `sub_sub_category` WHERE `sub_category` = '$_m_sub_cat' ");

if (mysqli_num_rows($get_sub_sub_cat) > 0) { ?>

	<div class="_inp_seg____">

		<label class="_label__" style="margin-top: 0px;">Sub Sub-Category</label>
		<select class="_inp__" name="sub_sub_category">
			<option value="">Select Sub-Category</option>
			<?php while ($row__ = mysqli_fetch_assoc($get_sub_sub_cat)) {
				$sub_sub_cat_row = $row__['sub_sub_category']; ?> 
					<option value="<?php echo strtolower($sub_sub_cat_row); ?>"><?php echo $class_->Capita($sub_sub_cat_row); ?></option>
			<?php }; ?>
		</select>

	</div>

<?php } else { ?>

	<label class="_label__" style="color: red;">No Sub Sub-Category found!</label>

<?php }; ?>