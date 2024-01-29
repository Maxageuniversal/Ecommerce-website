<script type="text/javascript">
	$("._side_l__").attr("style", "grey");
	$(".dbh_ms").css({"color": "unset", "background": "#FFFFFF"});
	$("._tab_name").html("My Products");
	$("._in_lay_b").attr("id", "_in_lay_b_02");
</script>
<?php

	include "../db.php";

	$getW_P = $class_->runS("SELECT * FROM `products` WHERE `store_owner` = '$this_u_id'  ORDER BY id DESC ");
	if (mysqli_num_rows($getW_P) > 0) { ?>
		
		<div class="rd_edge">

			<?php while ($getW_P_FEt = mysqli_fetch_assoc($getW_P)) {
					
				$id = $getW_P_FEt['id'];
				$name = $getW_P_FEt['name'];
				
				$store_owner = $getW_P_FEt['store_owner'];
				$date_time = $getW_P_FEt['date_time'];
				$client_p = $getW_P_FEt['client_p'];
				$recommend = $getW_P_FEt['recommend'];
				$sponsored = $getW_P_FEt['sponsored'];
				$t_stamp = $getW_P_FEt['time_stamp'];

				$price_range = $getW_P_FEt['price_range'];
				$discount_ = $getW_P_FEt['discount'];

				$flash_deal_d = $getW_P_FEt['flash_deal_d'];
				$flash_deal_tf = $getW_P_FEt['flash_deal_tf'];

				$d_none = "";
				if ($flash_deal_d !== $fd_d) {
					$d_none = "d_none";
				}

				$style_rc = "";
				if ($recommend == "rc") {
					$style_rc = "background-color: black; color: #FFF;";
				}

				$style_sp = "";
				if ($sponsored == "sp") {
					$style_sp = "background-color: #ff6600; color: #FFF;";
				}

				if ($client_p == 1) {
					$image = "./asset/img.png";
				} else {
					$image = "./images/_product/" . $class_->getImageP($id);
				}

				?>

					<div class="_flat_Mall_" id="_fM<?php echo $id; ?>">

						<?php
							if ((time()-$t_stamp) < (60*60*24)) {
								?> <div class="__model__M_New">NEW</div> <?php
							}
						?>

						<img class="w_img" src="<?php echo $image; ?>">
						<div class="_div_shr _div_shr_01">
							<div class="_pN<?php echo $id; ?>"><?php echo strtoupper($name); ?></div>
							<div class="_this_p_dtl _this_p_dtl_nP">
								<div class="_p_price_Ip_FL _pP<?php echo $id; ?>"><?php echo $class_->PriceR($price_range); ?></div>
								<div class="_p_price_Ip_FL fl_none _pD<?php echo $id; ?> " style="text-decoration: line-through; color: gray; font-size: 16pt;"><?php echo $class_->discountR($price_range, $discount_); ?></div>
								<div class="_w_d"><?php echo $date_time; ?></div>
							</div>
						</div>
						<div class="_div_shr _div_shr_02">

							<div class="pa _lEdP" id="_ed_PLoad<?php echo $id; ?>">
								<center><img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiIgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiBmaWxsPSIjMjIyMjIyIj4KICA8cGF0aCBvcGFjaXR5PSIuMjUiIGQ9Ik0xNiAwIEExNiAxNiAwIDAgMCAxNiAzMiBBMTYgMTYgMCAwIDAgMTYgMCBNMTYgNCBBMTIgMTIgMCAwIDEgMTYgMjggQTEyIDEyIDAgMCAxIDE2IDQiLz4KICA8cGF0aCBkPSJNMTYgMCBBMTYgMTYgMCAwIDEgMzIgMTYgTDI4IDE2IEExMiAxMiAwIDAgMCAxNiA0eiI+CiAgICA8YW5pbWF0ZVRyYW5zZm9ybSBhdHRyaWJ1dGVOYW1lPSJ0cmFuc2Zvcm0iIHR5cGU9InJvdGF0ZSIgZnJvbT0iMCAxNiAxNiIgdG89IjM2MCAxNiAxNiIgZHVyPSIwLjhzIiByZXBlYXRDb3VudD0iaW5kZWZpbml0ZSIgLz4KICA8L3BhdGg+Cjwvc3ZnPgo=" style="padding: 10px; top: 30%; position: absolute; background: #FFF; border-radius: 100px;" /></center>
							</div>

							<a class="pa _mP_Act" target="_blank" href="./?product_v=<?php echo $id; ?>" id="<?php echo $id; ?>">&</a>
							<div class="pa _mP_Act _col_red _delProd" id="<?php echo $id; ?>">$</div>
							<div class="pa _mP_Act _ed_P " id="<?php echo $id; ?>">z</div>
							<div class="pa _mP_Act" id="<?php echo $id; ?>">u</div>
							<div class="pa _mP_Act add_m_pp" id="<?php echo $id; ?>">+</div>

							<div title="RECOMMEND" class="pa _mP_Act _rC _rC<?php echo $id; ?>" style="<?php echo $style_rc; ?>" id="<?php echo $id; ?>">!</div>
							<div title="SPONSORED" class="pa _mP_Act _sP _sP<?php echo $id; ?>" style="<?php echo $style_sp; ?>" id="<?php echo $id; ?>">:</div>
							<div class="<?php echo $d_none; ?> _mP_Act _fd _fd<?php echo $id; ?>" style="background: gold; color: white; border-color: #FFF; font-size: 10pt; font-weight: 800; color: #000; margin-right: 15px;">Q<?php echo $flash_deal_tf; ?></div>
							<select id="<?php echo $id; ?>" class="_sfd">
								<option value="">Flash Sale</option>
								<option value="1">Q1 Of Today</option>
								<option value="2">Q2 Of Today</option>
								<option value="3">Q3 Of Today</option>
								<option value="4">Q4 Of Today</option>
								<option value="r">REMOVE</option>
							</select>
							<!-- <img src="./asset/91.gif" class="_wl_Can _dim_w" id="_l<?php echo $id; ?>" /> -->
						</div>
						
					</div>
						

				<?php

			} ?>

		</div>

	<?php } else { ?>

		<div class="_exp_Div">
			No product found!
		</div>

	<?php } ?>