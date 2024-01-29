<?php

	include "../db.php";
	$_data = explode("_", $_POST['_od_']);
	$_od_ = $_data[0];
	$seller_id_ = $_data[1];
	
?>


<script type="text/javascript">
	$("._side_l__").attr("style", "grey");
	$(".dbh_od").css({"color": "unset", "background": "#FFFFFF"});
</script>

<div class="_ext_ff">
	
	<div class="_ex_hd _ex_hd_none"> #<?php echo $_od_; ?> </div>

	<div class="rd_edge">

	<?php

		$getMyOd = $class_->runS(" SELECT * FROM `orders` WHERE `invoice_id` = '$_od_' ORDER BY id ASC  ");
		if (mysqli_num_rows($getMyOd) > 0) { ?>

		<div class="_ff">
			
			<table class="_table__">

				<tr class="_m_tr">
					<td>Action</td>
					<td>Order Type</td>
					<td>Color</td>

					<td>Fulfillment Status</td>

					<?php if ($seller_id_ == $this_u_id) { ?>
						<td>Payment Status</td>
					<?php }; ?>
					
					<td>Price</td>
				</tr>

				<tbody>

					<?php

						$price_;
						while ($row_tc  = mysqli_fetch_assoc($getMyOd)) {

						$id = $row_tc['id'];
						$user = $row_tc['user'];
						$date_time = $row_tc['date_time'];
						$seller_id = $row_tc['seller_id'];
						$quantity = $row_tc['quantity'];
						$size = $row_tc['size'];
						$color = $row_tc['color'];
						$capacity = $row_tc['capacity'];
						$price = $row_tc['price'];
						$status = $row_tc['status'];
						$f_status = $row_tc['f_status'];
						$paid_status = $row_tc['paid_status'];

						if ($seller_id == $this_u_id) {
							$o_state = "Incoming";
							$col_o_state = "rgba(0, 255, 10, 0.58)";
						} else {
							$o_state = "Outgoing";
							$col_o_state = "rgba(255, 152, 0, 0.41)";
						}

						if ($f_status == "CLAIMED") {
							$col_o_state = "rgba(0, 255, 10, 0.58)";
						}

					?>

						<tr class="_od_">


							<td class="_td _u_dom_act">
								<b class="_col_1cb _TrSt" id="<?php echo $id.'_'.$this_u_id; ?>">Track Order</b>
							</td>

							<td class="_td"><span style="background: <?php echo $col_o_state; ?>" class="_o_state box _inCO<?php echo $id; ?>"><?php echo $o_state; ?></span></td>
							<td class="_td"> <div class="_p_c_dtl" style="background: <?php echo strtoupper($color); ?>;"></div> <?php echo strtoupper($color); ?> </td>

							<td class="_td"><span style="background: <?php echo $col_o_state; ?>" class="_o_state box _cl<?php echo $id; ?>"><?php echo $f_status; ?></span></td>

							<?php if ($seller_id == $this_u_id) { ?>
								<td class="_td"><span style="background: <?php echo $col_o_state; ?>" class="_o_state box"><?php echo $paid_status; ?></span></td>
							<?php }; ?>
							
							<td class="_td"><?php echo $class_->_currency($cur_currency, $price*$quantity); ?></td>
						</tr>

					<?php }; ?>
					
				</tbody>

			</table>

		</div>

		<?php } else { ?>
			<div class="_exp_Div">
				No Order Found!
			</div>
		<?php }; ?>

	</div>

</div>

<style type="text/css">
	._p_c_dtl{
		display: inline;
		padding: 5px;
		border-radius: 100px;
		text-align: center;
		color: #FFF;
		font-weight: 600;
		width: 20px;
		float: left;
		margin-right: 8px;
		height: 20px;
	}
</style>