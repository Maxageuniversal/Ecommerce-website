<?php

	include "../db.php";
	$_st_ate = $_POST['_st_ate'];

	$get_u_statu = $class_->runS(" SELECT * FROM `user` WHERE `state` = '$_st_ate' AND `sell_eligible` = 2 ORDER BY id DESC ");
	$check_g_m_list = $class_->row($get_u_statu);

	if ($check_g_m_list > 0) { ?>

		<div class="_lone_pg_hd">Available Stores from <?php echo $class_->Capita($_st_ate); ?></div>

		<?php while ($row = mysqli_fetch_assoc($get_u_statu)) {
			$_u_id = $row['u_id'];
			$_full_name = $row['full_name'];
			$_data_this_image = $row['image'];
			$_business_name = $row['business_name']; ?>

				<a class="_aut_hh" href="./?store_home=<?php echo $_u_id; ?>&st_hm=<?php echo uniqid(); ?>">
					<img class="tab_image__" src="./images/_p_img/<?php echo $_data_this_image; ?>">
					<div class="_u_bx_tab__name"><?php echo $class_->Capita($_business_name); ?></div>	
				</a>

			<?php
		}

	}