<?php
	
	include "../db.php";
	$add_m_pp = $_POST['add_m_pp'];

	$getP_E = $class_->runS("SELECT * FROM `products` WHERE `id` = '$add_m_pp' ");
	$getP_E_FEt = mysqli_fetch_assoc($getP_E);
	
	$tP_id = $getP_E_FEt['id'];
	$tP_name = $getP_E_FEt['name'];
	$tP_category = $getP_E_FEt['category'];

?>
<script type="text/javascript">
	$("._tab_name").html("Add Photos (<?php echo $class_->Capita($tP_name); ?>)");
</script>

<div class="_ex_Img">
	<?php
	$getImage = $class_->runS(" SELECT * FROM `sub_products` WHERE `product_id` = '$add_m_pp' ");
	while ($getImage_FEt = mysqli_fetch_assoc($getImage)) {
		$id_gi = $getImage_FEt['id'];
		$product_id_gi = $getImage_FEt['product_id'];
		$product_image_gi = $getImage_FEt['image'];
		$color_gi = $getImage_FEt['color']; ?>
		<div class="_in_sx_" id="eImg<?php echo $id_gi; ?>" style="border: 1px solid <?php echo strtoupper($color_gi); ?>;">
			<img class="_ed_ImG" src="./images/_product/<?php echo $product_image_gi; ?>">
			<div class="delImg _col_"><?php echo strtoupper($color_gi); ?></div>
			<div class="delImg" srr="images/_product/<?php echo $product_image_gi; ?>" id="<?php echo $id_gi; ?>">REMOVE</div>
		</div>
	<?php }; ?>
</div>

<form class="_ed_Im_Form" enctype="multipart/form-data" t_add="<?php echo $tP_id; ?>">

	<label class="_label__">Select Image</label>

	<div class="_spec_area">
		<div class="_ov_lay">
			<input class="_empty_ _in_file__ _in_file___p" type="file" name="_add_img"> <p class="_in_tt__">Select / Drop Photo</p>
		</div>
		<div class="certificate_prev _p_prev_p">
			<img class="_add_mo_pp p_image _f_image _f_image_p _f_img__" src="./asset/img.png">
		</div>
	</div>

	<div class="_inp_seg____">
		<label class="_label__">Select Color</label>
		<input type="text" class="_empty_ _inp__" name="color" placeholder="Image Color" class="_addImg">
	</div>

	<div class="_spec_area">
		<div class="_add_spec">ADD PRICE-TAG</div>
		<input hidden="on" type="text" class="spec_col" name="price_tag" />
	</div>

	<input type="submit" name="_ad_im" value="ADD PRODUCT" class="_inp__ button__">

</form>