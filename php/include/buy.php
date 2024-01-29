<script type="text/javascript">
	$("._side_l__").attr("style", "grey");
	$(".dbh_b").css({"color": "unset", "background": "#FFFFFF"});
</script>

<?php include "../db.php"; ?>

	<?php if ($this_buy_eligible == 2) { ?> <div class="_notice_pix_g">Your account is activated for buying.</div> <?php } else { ?> <div class="_notice_pix">Please update your account to start buying.</div> <?php } ?>

	<form method="POST" class="_buy__">

		<label class="_label__">Select Account Type</label>

		<!-- <div class="pa">abcdefghijklmnopqurstuvwxyz ABCDEFGHIJKLMNOPQURSTUVWXYZ</div> -->

		<div class="_inp__seg">

			<center>

				<div <?php if ($this_consumer == 1) { ?> seltd="on" <?php } ?> <?php if ($this_consumer == 1) { ?> style="background-color: #0400f6; color: #FFFFFF;" <?php } ?>
				class="_inp_c _inp_"> <span class="_in_tt_ _in_tt_c" <?php if ($this_consumer == 1) { ?> style="color: #FFFFFF;" <?php } ?> >Consumer</span> <span class="pa _in_tt_ _in_tt_c" <?php if ($this_consumer == 1) { ?> style="color: #FFFFFF;" <?php } ?> >U</span> </div>

				<div <?php if ($this_retailer == 1) { ?> seltd="on" <?php } ?> <?php if ($this_retailer == 1) { ?> style="background-color: #0400f6; color: #FFFFFF;" <?php } ?>
				class="_inp_r _inp_"> <span class="_in_tt_ _in_tt_r" <?php if ($this_retailer == 1) { ?> style="color: #FFFFFF;" <?php } ?> >Retailer</span> <span class="pa _in_tt_ _in_tt_r" <?php if ($this_retailer == 1) { ?> style="color: #FFFFFF;" <?php } ?> >U</span> </div>

				<input hidden="on" class="_t_c" type="text" name="consumer" value="<?php echo $this_consumer; ?>">
				<input hidden="on" class="_t_r" type="text" name="retailer" value="<?php echo $this_retailer; ?>">
			
			</center>
			
		</div>

		<label class="_label__">Full Name</label>
		<input class="_inp__" type="text" name="full_name" placeholder="e.g. Joh Doe" value="<?php echo $class_->Capita($this_full_name); ?>">

		<label class="_label__">Sex</label>
		<select class="_inp__" name="sex">
			<option value="<?php echo $class_->checkSex($this_sex, "Select Sex"); ?>"><?php echo $class_->Capita($class_->checkSex($this_sex, "Select Sex")); ?></option>
			<option value="male">Male</option>
			<option value="female">Female</option>
		</select>

		<label class="_label__">Address + Postal Code</label>
		<input class="_inp__" type="text" name="address" placeholder="e.g. Oak Lummama, 342001, AZ" value="<?php echo $class_->Capita($this_address); ?>">

		<label class="_label__">Country</label>
		<select class="_inp__" name="country">
			<option value="<?php echo $class_->checkSex($this_country, ""); ?>"><?php echo $class_->Capita($class_->checkSex($this_country, "Select Country")); ?></option>
			<?php
				foreach ($class_->dump(2) as $key => $value) {
					?>  <option value="<?php echo strtolower($value); ?>"><?php echo $class_->Capita($value); ?></option> <?php
				}
			?>
		</select>

		<label class="_label__">State / Province</label>
		<input class="_inp__" type="text" name="state" placeholder="e.g. Arizona" value="<?php echo $class_->Capita($this_state); ?>">

		<label class="_label__">Phone Number</label>
		<input class="_inp__" type="text" name="phone" placeholder="e.g. +1 342 3372 234" value="<?php echo $this_phone; ?>">

		<input class="_inp__ button__ _bbY_d" type="submit" value="UPDATE">

	</form>