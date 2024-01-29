<?php

	include "../db.php";

	$t_add = $_GET['t_add'];
	$color = trim(strtolower(mysqli_real_escape_string($con_, $_POST['color']))); 
	$price_tag = trim(strtolower(mysqli_real_escape_string($con_, $_POST['price_tag'])));

	$price_tag_trace = md5($price_tag);

	$_add_img = $_FILES['_add_img']['name'];
	$_add_img_tmp = $_FILES['_add_img']['tmp_name'];
	$_add_img_ext = substr($_add_img, -3);

	$_add_img_size = $_FILES['_add_img']['size'];
	

	if (strlen(trim($_POST['color'])) == 0) {
		echo "Add image color!";
		exit();
	}

	if ($_add_img_ext == null) {
		echo "Please select at leaset one image!";
		exit();

	}

	$_add_img = $this_u_id.time()."pp_img.".$_add_img_ext;

	$class_->runS(" UPDATE `products` SET `client_p` = '2' WHERE `id` = '$t_add' ");

	$up_d = $class_->runS(" INSERT INTO `sub_products` (`product_id`, `image`, `color`, `price_tag`, `price_tag_trace`, `store_owner`) VALUES ('$t_add', '$_add_img', '$color', '$price_tag', '$price_tag_trace', '$this_u_id') ");

	if ($up_d) {
		move_uploaded_file($_add_img_tmp, "../../images/_product/".$_add_img);
		echo "Product Added";
		?>
			<script type="text/javascript">

				$("._inp_seg_").remove();
				$("._empty_, .spec_col").val(null);
				$("._p_prev_p").html("<img class='_add_mo_pp p_image _f_image _f_image_p _f_img__' src='./asset/img.png'></div>");
				// $("._add_mo_pp").attr("src": "../../asset/img.png");

				$("._c_size_").attr("slt","1").css({"background": "#FFF", "color": "unset"});
				$("._c_size_").animate({"border-radius": "0px"});

				$("._c_capacity_").attr("slt","1").css({"background": "#FFF", "color": "unset"});
				$("._c_capacity_").animate({"border-radius": "0px"});

				$("._ex_Img").append("<div class='_in_sx_' style='border: 1px solid <?php echo strtoupper($color); ?>;'><img class='_ed_ImG' src='./images/_product/<?php echo $_add_img; ?>'><div class='delImg _col_'><?php echo strtoupper($color); ?></div><div class='delImg'>REMOVE</div></div>");

			</script>
		<?php
	}