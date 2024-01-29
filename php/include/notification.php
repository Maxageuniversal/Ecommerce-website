

<style type="text/css">
	._p_text{
		background: black;
		color: #FFFFFF;
		padding-top: 12px;
		padding-bottom: 12px;
		padding-left: 8px;
		padding-right: 8px;
	}
</style>
 <script type="text/javascript">
	$("._side_l__").attr("style", "grey");
	$(".dbh_nty").css({"color": "unset", "background": "#FFFFFF"});
	$("._tab_name").html("Notification");
</script>

<?php

include "../db.php";

$get_Nty = $class_->runS("SELECT * FROM `notification` WHERE `receiver` = '$this_u_id' ORDER BY id DESC ");

if (mysqli_num_rows($get_Nty) > 0) { ?>
	
	<div class="rd_edge bor">

		<?php
			while ($fet_nty = mysqli_fetch_assoc($get_Nty)) {
				$id = $fet_nty['id'];
				$sender = $fet_nty['sender'];
				$receiver = $fet_nty['receiver'];
				$text = $fet_nty['text'];
				$status = $fet_nty['status'];
				$date_time = $fet_nty['date_time'];

				$class_->runS("UPDATE `notification` SET `status` = '1' WHERE `id` = '$id' ");

				?>

				<div class="_msg_row wow flip" style="<?php if ($status == 0) {
					echo "border-color: #1cb; background: rgba(17, 204, 187, 0.08);";
				} else { echo "border-color: #EEE;";  } ?>">
					<p class="_p_text wow fadeIn"><?php echo $text; ?></p>
					<div class="_in_s_r_sold" style="color: #000; margin-top: 10px;"><?php echo $date_time . " | " . $sender; ?></div>

					
					
				</div>

			<?php }
		?>

	</div>

	<script src="js/wow.min.js"></script>
              <script>
              new WOW().init();
              </script>

			

	<script type="text/javascript">
		$(".c_num").html("0");
	</script>

<?php } else { ?>
	<div class="_exp_Div">

	</div>
<?php }; ?>


	<div class="_msg_row">
				<p class="_p_text wow delay 5s flip">Payment Made Easy, You can take a photo of the items you intend to purchase, Make a payment to the following Bank account detail below:<br> <br> Blue Connect Nig Company <br> 1007054997, <br> KeyStone Bank.<br> </b><br><br>Then send the screenshot of the transaction & the photos of the items you intent to purchase to our customer care whatsapp account by clicking this link <a href="http://wa.me/2348031370588" style="color: green; font-weight: 400;">Whatsapp here</a>.<a class=" " style="color: #FFFFFF; font-weight: 400; "> It's that easy</a></p>
					</div>