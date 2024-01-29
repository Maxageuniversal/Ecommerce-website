<?php
	
	include "../db.php";
	$_ed_P = $_POST['_ed_P'];

	$getP_E = $class_->runS("SELECT * FROM `products` WHERE `id` = '$_ed_P' ");
	$getP_E_FEt = mysqli_fetch_assoc($getP_E);
	
	$tP_id = $getP_E_FEt['id'];
	$tP_name = $getP_E_FEt['name'];
	$tP_price_range = $getP_E_FEt['price_range'];
	$tP_category = $getP_E_FEt['category'];
	$tP_sub_category = $getP_E_FEt['sub_category'];
	$tP_discount = $getP_E_FEt['discount'];
	$tP_store_owner = $getP_E_FEt['store_owner'];
	$tP_date_time = $getP_E_FEt['date_time'];
	$tP_description = $getP_E_FEt['description'];
	$tP_model_number = $getP_E_FEt['model_number'];
	$tP_brand = $getP_E_FEt['brand'];

?>

<script type="text/javascript">
	$("._tab_name").html("Edit Product (<?php echo $tP_name; ?>)");
</script>

<form method="POST" class="_form_flow__ _e_Form" t_id="<?php echo $tP_id; ?>">

	
	<label class="_label__">Select Category</label>
	<select class="_inp__ _m_cat" name="category">
		<option value="<?php echo $tP_category; ?>"><?php echo strtoupper($tP_category); ?></option>
		<?php
			foreach ($class_->dump(4) as $key => $value) {
				?>  <option value="<?php echo strtolower($value); ?>"><?php echo $class_->Capita($value); ?></option> <?php
			}
		?>
	</select>

	<div class="_inp__seg _load_cc_">
		
		<?php $_m_cat = strtolower($tP_sub_category);
		$get_sub_cat = $class_->runS(" SELECT * FROM `sub_category` WHERE `category` = '$_m_cat' "); ?>

		<label class="_label__">Select Category</label>
		<select class="_inp__" name="sub_category">
			<option value="<?php echo strtolower($tP_sub_category); ?>"><?php echo $class_->Capita($tP_sub_category); ?></option>

			<?php while ($row__ = mysqli_fetch_assoc($get_sub_cat)) {
				$sub_cat_row = $row__['sub_category']; ?> 
					<option value="<?php echo strtolower($sub_cat_row); ?>"><?php echo $class_->Capita($sub_cat_row); ?></option>
			<?php }; ?>

		</select>

	</div>

	<label class="_label__">Product Name</label>
	<input class="_inp__" type="text" name="p_name" placeholder="e.g. Iphone X" value="<?php echo $class_->Capita($tP_name); ?>">

	<label class="_label__">Price Range</label>
	<input class="_inp__" type="text" name="price_range" placeholder="e.g. 1000" value="<?php echo $tP_price_range; ?>">

	<label class="_label__">Discount</label>
	<input class="_inp__" type="number" min="1" max="99" name="s_discount" placeholder="e.g. 1-99%" value="<?php echo $tP_discount; ?>">

	<label class="_label__">USD Price Range</label>
	<input class="_inp__" type="text" name="p_model_number" value="<?php echo $tP_model_number; ?>">

	<label class="_label__">Product Description</label>
	<textarea class="_inp__" name="p_desc" placeholder="Product description"><?php echo $tP_description; ?></textarea>

	<input class="_inp__ button__ _bbY_edP" type="submit" value="UPDATE">

</form>