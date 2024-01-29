

<?php

include "../db.php";

if ($_POST['typq'] == 2) {
	$getMyTc = $class_->runS(" SELECT * FROM `ticket` ORDER BY id ASC ");
} else {
	$getMyTc = $class_->runS(" SELECT * FROM `ticket` WHERE `ticket_creator` = '$this_u_id' ");
}

if (mysqli_num_rows($getMyTc) > 0) { ?>

	<script type="text/javascript">
		$("._in_lay_b").attr("id", "_in_lay_b_02");
	</script>

	<div class="rd_edge _p10">
	
		<table class="_table__">

			<tr class="_m_tr">
				<td>Message ID</td>
				<td>Date</td>
				<td>Subject</td>
				<td>Dept.</td>
				<td>Sender</td>
				<td>Status</td>
			</tr>

			<?php while ($row_tc  = mysqli_fetch_assoc($getMyTc)) {
				$tc_id = $row_tc['tc_id'];
				$ticket_creator = $row_tc['ticket_creator'];
				$admin_dept = $row_tc['admin_dept'];
				$subject = $row_tc['subject'];
				$status = $row_tc['status'];
				$date_time = $row_tc['date_time']; ?>

				<tr class="_tr_tc" id="<?php echo $tc_id; ?>">
					<td class="_td"><b><div class="_tc_status">Open</b></td>
					<td class="_td"><?php echo $date_time; ?></td>
					<td class="_td txt_cap"><?php echo $subject; ?></td>
					<td class="_td txt_cap"><?php echo $admin_dept; ?></td>
					<td class="_td txt_cap"><?php echo $class_->Capita($class_->getUD($ticket_creator, "nm")); ?></td>
					<td class="_td"><div class="_tc_status"><?php echo $status; ?></div></td>
				</tr>

			<?php }; ?>

		</table>

	</div>

<?php } else { ?>
	<div class="_exp_Div">
		No Message composed!
	</div>
<?php }; ?>