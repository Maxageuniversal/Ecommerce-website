<script type="text/javascript">
	$("._side_l__").attr("style", "grey");
	$(".dbh_b").css({"color": "unset", "background": "#FFFFFF"});
	$("._tab_name").html("Review Product");
</script>

<?php
	include "../db.php"; $data_ = explode("_", $_POST['_cf_pClmd']);
	$_Rvp = $data_[0];
	$_idd_ = $data_[1];
	$class_->runS(" UPDATE `orders` SET `f_status` = 'CLAIMED' WHERE `id` = '$_idd_' ");
?>

<style type="text/css">
	._p20{
		padding: 10px;
	}
</style>

<div class="rd_edge _p20">

	<script type="text/javascript">
		$("._cl<?php echo $_idd_; ?>").html("CLAIMED").css({"background": "rgba(0, 255, 10, 0.58)"});
		$("._inCO<?php echo $_idd_; ?>").css({"background": "rgba(0, 255, 10, 0.58)"});
	</script>
	
	<form action="./php/worker/worker.review.php?p_id=<?php echo $_Rvp; ?>" method="POST" class="_rTForm">

		<div class="_RtL">
			<?php
				for ($i=5; $i > 0; $i--) { 
					?>

						<div class="_RSec">
							<span class="_colL_Rt"><?php echo $i . " star"; ?></span>
							<div class="_RS_P"> 
								<?php
									for ($iI=1; $iI <= $i; $iI++) { 
										?>
											<img class="_star_in_Box_Rt" src="./asset/large_star.png">
										<?php
									}
								?>
							</div>
							<span class="_colL_"> <input class="_radio_rate" id="<?php echo $i; ?>" type="radio" name="rate"> </span>
						</div>

					<?php
				}
			?>
		</div>

		<input hidden="on" type="text" name="_RTT" class="_RTT">
		<textarea class="_inp__RtTxt" name="_inp__RtTxt" placeholder="Write review..."></textarea>

		<img class="_spl_load _rvLoad" style="height: 20px;" src="./asset/91.gif">
		<input class="_inp__ button__ _rvVw" type="submit" name="_sub_rev" value="POST REVIEW">

	</form>

</div>