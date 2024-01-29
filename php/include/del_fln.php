<?php
	
	include "../db.php";
	$_del_fln__ = $_POST['_del_fln__'];
	$class_->runS(" DELETE FROM `flash_news` WHERE `id` = '$_del_fln__' ");
	echo "DELETED";

?>