<?php

	include "../db.php";

	$tc_dept = strtolower(mysqli_real_escape_string($con_, $_POST['tc_dept']));
	$tc_sub = strtolower(mysqli_real_escape_string($con_, $_POST['tc_sub']));
	$tc_body = strtolower(mysqli_real_escape_string($con_, $_POST['tc_body']));

	$tc_image = $_FILES['tc_image']['name'];
	$tc_image_tmp = $_FILES['tc_image']['tmp_name'];
	$tc_image_ext = substr($tc_image, -3);

	if (strlen(trim($_POST['tc_dept'])) == 0) {
		echo "Select admin department!";
		exit();
	}

	if (strlen(trim($_POST['tc_sub'])) == 0) {
		echo "Provide a ticket subject!";
		exit();
	}

	if (strlen(trim($_POST['tc_body'])) == 0) {
		echo "Ticket body is empty!";
		exit();
	}

	$ticket_id = $thisId.time();

	if (strlen($tc_image_ext) > 0) {
		
		if (!in_array($tc_image_ext, $_ary_img_act)) {
			echo "Only JPG and PNG file accepted!";
			exit();
		}

		$tc_image = uniqid().$this_u_id.time()."tc_img.".$tc_image_ext;
		move_uploaded_file($tc_image_tmp, "../../images/_tc_img/".$tc_image);

	}

	$class_->runS(" INSERT INTO `message` (`sender`, `receiver`, `text`, `date_time`, `type`, `tc_id`, `image`) VALUES ('$this_u_id', 'admin', '$tc_body', '$date_', 'TICKET', '$ticket_id', '$tc_image') ");

	$tcc = $class_->runS(" INSERT INTO `ticket` (`tc_id`, `ticket_creator`, `admin_dept`, `subject`, `date_time`) VALUES ('$ticket_id', '$this_u_id', '$tc_dept', '$tc_sub', '$date_') ");

	if ($tcc) {
		
		echo 1;

	}

?>


