<script type="text/javascript">
	$("._side_l__").attr("style", "grey");
	$(".dbh_pro").css({"color": "white", "background": "#FFFFFF"});
</script>

<script type="text/javascript">
	$("._tab_name").html("MY ACCOUNT");
</script>

<?php

	include "../db.php"; ?>

			<center><div class="_this_p_img_qtt"><img style="height: 76px; width: 76px; margin-top: 6px;" src="./asset/yossell.png"></div></center>


						<?php if ($on_ == 1) { 

							if ($this_email_list == 0) {
								$mail_list_style = "background: #33b540;";
							} else {
								$mail_list_style = "background: #0ae14f;";
							}
					?>


 
				
			<center><div class="_p_tplm__">User Full Name</div>
			<div class="_p_btlm__"><?php echo $this_full_name; ?></div></center>

			
			<div class="_p_tplm__ m_list_">
				<div class=" _tgr__01 m_none m_btn" style="<?php echo $mail_list_style; ?>">Mail Me Promotional Deals</div>
			</div>


	<div class="_p__pro p_none m_none">
		<div class="_sel_inf _50_btn">Edit Selling Info</div>
		<div class="_buy_inf _50_btn br_">Edit Buying Info</div>
	</div>

		<?php if ($this_sell_eligible == 2) { ?>
			<a class="_top_text_02" href="./?dashboard" style="box-shadow: 0px 10px 19px #ff6600; border-radius: 95px 0px; background-color: #050505; color: #fff; text-align: center;"><span class="pa _side_l__oa dbh_ " ">G</span>Dashboard & Create Products</a>

				<?php }; ?>
	<div class="rd_edge">

		<div class="_p__pro">

			<div class="_uni_hd__">Account Details</div>

			<div class="_p_tplm__">User Email Address</div>
				<div class="_p_btlm__ _txsh1" style="text-transform: lowercase;"><?php echo $this_email; ?></div>

			<div class="_p_tplm__">Shipping Home Address</div>
			<div class="_p_btlm__"><?php echo $this_address; ?></div>

			<div class="_p_tplm__">State</div>
			<div class="_p_btlm__"><?php echo $this_state; ?></div>

			<div class="_p_tplm__">Phone Number</div>
			<div class="_p_btlm__"><?php echo $this_phone; ?></div>

			

			<div class="_p_tplm__">Gender</div>
			<div class="_p_btlm__"><?php echo $this_sex; ?></div>

			<div class="_p_tplm__">Joined</div>
			<div class="_p_btlm__"><?php echo $this_date_joined; ?></div>

		</div>

			<div class="_p__pro p_none m_none">
	<a href="./?logout" class="_p_tplm__">
				<div class="_tgr__ _50_btn23" style="box-shadow: 0px 10px 19px #ff6600;
    border-radius: 95px 0px;">Log Me out</div>
			</a>
		</div>

		<?php } else { ?>

			<div class="_p__pro p_none m_none">
	<a  href="./?register" class="_p_tplm__">
				<div class="_tgr__ _50_btn23" style="box-shadow: 0px 10px 19px #ff6600; float: left;
    border-radius: 95px 0px;">Join Us Free</div>
			</a>
		

	<a  href="./?login" class="_p_tplm__">
				<div class="_tgr__ _50_btn23" style="box-shadow: 0px 10px 19px #ff6600; float: right;
    border-radius: 95px 0px;">Log Me In</div>
			</a>
		</div>
</div>


<?php }; ?>

		

	<!--	<div class="_p__pro"><a class="_side_l__ dbh_tc _call_module" > <span class="pa _side_l__oa">w</span>Messages</a>

			<div class="_uni_hd__">Account Configuration</div>

			<div class="_p_tplm__">
				<div class="_tgr__">Selling Status</div>
				<div class="pa _tgr__01 m_none" style="<?php echo $s_s_style; ?>">U</div>
			</div>

		
</div>
	</div>-->

