<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
	<meta http-equiv="Content-Type" content="text/html; charset=gb18030">
	<title>My Massage</title>
	


<?php

	include "../db.php";
	$_tr_tc = $_POST['_tr_tc'];
	$getMyTc = $class_->runS(" SELECT * FROM `message` WHERE `tc_id` = '$_tr_tc' ");

?>

<div class="rd_edge _p10">
	
	<div class="_m_feed">

		<?php while ($row_tc  = mysqli_fetch_assoc($getMyTc)) {

			$id = $row_tc['id'];
			$sender = $row_tc['sender'];
			$receiver = $row_tc['receiver'];
			$text = $row_tc['text'];
			$image = $row_tc['image'];
			$status = $row_tc['status'];
			$date_time = $row_tc['date_time'];
			$type = $row_tc['type'];
			$tc_id = $row_tc['tc_id']; ?>

			<div class="_msg_row" style="<?php if ($sender == $this_u_id) {
				echo "border-color: #1cb;";
			} else { echo "border-color: orange;";  } ?>">

				<?php if (!empty($image)) { ?>
					<img class="_img_tc_" src="./images/_tc_img/<?php echo $image; ?>">
				<?php } ?>

				<p class="_p_text"><?php echo $text; ?></p>
				<div class="_div_dtl_"><?php echo $date_time; ?> | <?php echo $class_->Capita($class_->getUD($sender, "nm")); ?></div>
			</div>

		<?php }; ?>
		
	</div>

	<form class="m_txt_area" action="" method="POST" tc_id="<?php echo $_tr_tc; ?>">
		<textarea class="_inp_msg _msgg_" name="_text" placeholder="Type your message..."></textarea>
		<input type="submit" class="_inp_msg _inp_msg_btn _bbY_d" name="_s_msg" value="SEND">
	</form>
	
</div>

<style type="text/css">
._img_tc_{
	width: 100%;
	max-width: 300px;
	display: block;
	padding: 5px;
	border: 1px solid #EEE;
	overflow: hidden;
	border-radius: 5px;
	margin-bottom: 5px;
}
._p_text{
	display: block;
	overflow: hidden;
	font-size: 13pt;
}
._div_dtl_{
	font-size: 10pt;
	display: block;
	overflow: hidden;
	color: orange;
	margin-top: 5px;
	padding-left: 10px;
	text-transform: capitalize;
	border-left: 2px solid #EEE;
}
</style>

</head>
<body>

</body>
</html>