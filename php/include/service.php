<script type="text/javascript">
	$("._side_l__").attr("style", "grey");
	$(".dbh_se").css({"color": "unset", "background": "#FFFFFF"});
</script>
<?php include "../db.php"; ?>

	<?php if ($this_service_eligible == 2) { ?> <div class="_notice_pix_g">Your account is activated for service.</div> <?php } else { ?> <div class="_notice_pix">Please update your account to start providing services.</div> <?php } ?>

	<form method="POST" class="_service__">

		<label class="_label__">Service Category</label>
		<select class="_inp__" name="s_categ">
			<option value="<?php echo $class_->checkSex($this_s_cat, "Select Service Category"); ?>"><?php echo $class_->Capita($class_->checkSex($this_s_cat, "Select Service Category")); ?></option>
			<option value="individual">Individual</option>
			<option value="company">Company</option>
		</select>

		<label class="_label__">Individual / Company Name</label>
		<input class="_inp__" type="text" name="b_name" placeholder="e.g. Coca Cola" value="<?php echo $class_->Capita($this_business_name); ?>">

		<label class="_label__">Service Location</label>
		<input class="_inp__" type="text" name="b_loc" placeholder="e.g. Lagos" value="<?php echo $class_->Capita($this_b_loc); ?>">

		<label class="_label__">Area Of Specialization</label>
		<input class="_inp__" type="text" name="a_o_spec" placeholder="e.g. Painting" value="<?php echo $class_->Capita($this_a_o_spec); ?>">

		<label class="_label__">Service Description</label>
		<textarea class="_inp__" name="service_description" placeholder="Service description"><?php echo $this_service_description; ?></textarea>

		<input class="_inp__ button__ _bbY_d" type="submit" value="UPDATE">

	</form>