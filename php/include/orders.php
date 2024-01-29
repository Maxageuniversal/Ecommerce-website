<script type="text/javascript">
	$("._side_l__").attr("style", "grey");
	$(".dbh_od").css({"color": "unset", "background": "#FFFFFF"});
</script>

<script type="text/javascript">
	$("._tab_name").html("MY ORDERS");
	$("._in_lay_b").attr("id", "_in_lay_b_02");
</script>

<?php

	include '../db.php';

	if ($admin_ == 1) {
		$getMyOd_ = $class_->runS(" SELECT DISTINCT invoice_id FROM `orders` ORDER BY id DESC ");
	} else {
		$getMyOd_ = $class_->runS(" SELECT DISTINCT invoice_id FROM `orders` WHERE `user` = '$this_u_id' OR `seller_id` = '$this_u_id'ORDER BY id DESC ");
	}
	if (mysqli_num_rows($getMyOd_) > 0) { ?>

<div class="rd_edge">

	<!-- <div class="_ff">
		<a class="_in_Lk" href="">Outgoing</a>
		<a class="_in_Lk" href="">Incoming</a>
		<a class="_in_Lk" href="">Unfulfilled</a>
		<a class="_in_Lk" href="">Fulfilled</a>
	</div> -->

	<div class="_ff">
		
		<table class="_table__">

			<tr class="_m_tr">
				<td>Order ID</td>
				<td>Order Type</td>
				<td>Date</td>
				<td>Customer</td>
				<td>Payment Status</td>
				<td>Total</td>
			</tr>

			<tbody>
				
			</tbody>

				<?php

					$price_;
					while ($row_tc  = mysqli_fetch_assoc($getMyOd_)) {

					$invoice_id = $row_tc['invoice_id'];

					$thisOd = $class_->runS(" SELECT * FROM `orders` WHERE `invoice_id` = '$invoice_id' LIMIT 1 ");
					$row_to  = mysqli_fetch_assoc($thisOd);
					$user = $row_to['user'];
					$date_time = $row_to['date_time'];
					$seller_id = $row_to['seller_id'];
					$paid_status = $row_to['paid_status'];

					if ($seller_id == $this_u_id) {
						$o_state = "Incoming";
						$col_o_state = "rgba(0, 255, 10, 0.58)";
					} else {
						$o_state = "Outgoing";
						$col_o_state = "rgba(255, 152, 0, 0.41)";
					}

					if ($paid_status == "UNPAID") {
						$col_p_state = "#f00";
					} else {
						$col_p_state = "rgba(0, 255, 10, 0.58)";
					}
					
					$thisOdP = $class_->runS(" SELECT SUM(price*quantity) AS 'add' FROM `orders` WHERE `invoice_id` = '$invoice_id' ");
					$sum_price = mysqli_fetch_assoc($thisOdP);
					$sum_price = $sum_price['add'];

				?>

					<tr class="_od_" id="<?php echo $invoice_id . '_' . $seller_id; ?>">
						<td class="_td"><b class="_col_1cb">VIEW ORDER</b></td>
						<td class="_td"><span style="background: <?php echo $col_o_state; ?>" class="_o_state box"><?php echo $o_state; ?></span></td>
						<td class="_td _th_d" title="<?php echo $date_time; ?>"><div class="_in_tbl"><?php echo substr($date_time, 0,12); ?></div></td>
						<td class="_td"><?php echo $class_->Capita($class_->getUD($user, "nm")); ?></td>
						<td class="_td"><div class="_tc_status _o_state box" style="background: <?php echo $col_p_state; ?>"><?php echo $paid_status; ?></div></td>
						<td class="_td"><?php echo $class_->_currency($cur_currency, $sum_price); ?></td>
					</tr>

				<?php }; ?>

		</table>

	</div>

</div>

	<?php } else { ?>
		<div class="_exp_Div">
			No orders found!
		</div>
	<?php }; ?>