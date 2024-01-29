<?php include "../db.php"; ?>
		
	<!--<a href="mailto:deluxebyseyi@gmail.com" class="_l_sec" style="background: green; border-bottom: 1px solid #EEE; width: 100%;"> Feedback</a>-->
	<style type="text/css">
			._cat__287DP{
		    cursor: pointer;
		    width: 91%;
		    display: block;
		    overflow: hidden;
		    margin-top: 18px;
		    padding-bottom: 3px;
		    margin-left: 23px;
		}
			._top_text_01DB{
			margin-bottom: 20px;
		    width: 100%;
		    display: block;
		    overflow: hidden;
		    padding: 15px;
		    font-size: 8pt;
		    cursor: pointer;
		    text-transform: uppercase;
		    font-weight: 400;
		    color: #050505;
		    margin-top: -14px;
		}
	</style>

	<center><div class="_this_p_img_qtt"><img style="height: 60px; width: 60px; margin-top: 6px; margin-bottom: -28px;" src="./asset/yossell.png"></div></center>


	<?php if ($on_ == 1) { ?>
		<div class="_cat__287DP"><br>
			<a class="_cat__ _profile_inf" href="#PROFILE"><span class=" _side_l__oa dbh_" style="color: #ff6600; font-size: 12pt; font-weight: 500;">My Yossell Account       </span > >> </a><br><br>
		<?php if ($this_sell_eligible == 2) { ?>
			<a class="_top_text_01DB" href="./?dashboard"><span class="pa _side_l__oa dbh_" style="color: #ff6600; font-size: 9pt; font-weight: 500;">d</span>Admin Panel</a>
		<?php } else if ($this_sell_eligible == 3) { ?>
			<div class="_notice_pix_g">Awaiting Approval for Trading.<br>You Will Be Contacted Shortly.</div>
		<?php } else { ?>
			<div class="_top_text_01DB _sell_inf" style="background: red;"><span class="pa _side_l__oa dbh_"style="color: #ff6600; font-size: 9pt; font-weight: 500;">f</span>Trade Now</div>
		<?php }; ?>	

		<?php if ($this_buy_eligible != 2) { ?>			
			<div class="_top_text_01DB _buy_inf"><span class="pa _side_l__oa dbh_" style="color: #ff6600; font-size: 9pt; font-weight: 500;">.</span>Buy Now</div>
		<?php } else { ?>
			<div class="_top_text_01DB _ticket_inf" href="./?dashboard"><span class="pa _side_l__oa" style="color: #ff6600; font-size: 9pt; font-weight: 500;">/</span> Messages</div>
			<div class="_top_text_01DB _order_inf" href="./?dashboard"><span class="pa _side_l__oa" style="color: #ff6600; font-size: 9pt; font-weight: 500;">f</span> My Orders</div>
			<div class="_top_text_01DB _wish_inf" > <span class="pa _side_l__oa" style="color: #ff6600; font-size: 9pt; font-weight: 500;">!</span> Saved Items</div>
		<?php }; ?>

		<a class="_top_text_01DB" href="./?logout"><span class="pa _side_l__oa dbh_" style="color: #ff6600; font-size: 9pt; font-weight: 500;">O</span>Sign Out</a>

	<?php } else { ?>
		<div class="_cat__287DP">
		<a class="_top_text_01DB" href="./?register"> <span class="pa _side_l__oa" style="color: #ff6600; font-size: 9pt; font-weight: 500;">B</span> Join Us</a>
		<a class="_top_text_01DB" href="./?login"> <span class="pa _side_l__oa" style="color: #ff6600; font-size: 9pt; font-weight: 500;">B</span> Login</a>
	</div>
	<?php }; ?>
</div>
<!--
	<div class=" ">    </div>

	<?php $get_cat = $class_->runS(" SELECT * FROM `category` ");

	if (mysqli_num_rows($get_cat) > 0) {

		while ($row__ = mysqli_fetch_assoc($get_cat)) {
			$id = $row__['id'];
			$category = $row__['category'];
			?>	
				<div class="_cat__">
					<a class="_cat_link2 wow zoomIn" href="./?cat_=<?php echo $class_->urlF($category, 1); ?>">
						
						<?php echo $class_->Capita($category); ?>
					</a>
					<div class="pa toggl__ toggl__<?php echo $id; ?>" id="<?php echo $id; ?>">S</div>
					<div class="pa toggl__r toggl__r<?php echo $id; ?>" id="<?php echo $id; ?>" style="color: red;">R</div>
				</div>
			
				<div class="cat_in_v" id="civ<?php echo $id; ?>">

					<?php

						$get_sub_cat = $class_->runS(" SELECT * FROM `sub_category` WHERE `category` = '$category' ");

						if (mysqli_num_rows($get_sub_cat) > 0) {

							while ($row__s = mysqli_fetch_assoc($get_sub_cat)) {
								$sub_category = $row__s['sub_category'];
								?>
									<div class="_sub_cat__ wow zoomIn">
										<a class="_cat_link1 wow zoomIn" href="./?cat_=<?php echo $class_->urlF($category, 1); ?>&s_cat_=<?php echo $class_->urlF($sub_category, 1); ?>">
											
											<?php echo $class_->Capita($sub_category); ?>
										</a>
										<div class="pa toggl__" id="<?php echo $id; ?>" style="font-size: 7pt;"></div>
									</div>
								<?php

								$get_sub_sub_cat = $class_->runS(" SELECT * FROM `sub_sub_category` WHERE `sub_category` = '$sub_category' ");

								if (mysqli_num_rows($get_sub_sub_cat) > 0) {

									while ($row__ss = mysqli_fetch_assoc($get_sub_sub_cat)) {
										$sub_sub_category = $row__ss['sub_sub_category'];
										?>

											<div class="_sub_sub_cat__ wow zoomIn">
												<a class="_cat_link1 wow zoomIn" href="./?cat_=<?php echo $class_->urlF($category, 1); ?>&s_cat_=<?php echo $class_->urlF($sub_category, 1); ?>&ss_cat_=<?php echo $class_->urlF($sub_sub_category, 1); ?>">
													
													<?php echo $class_->Capita($sub_sub_category); ?>
												</a>
											</div>

										<?php
									}

								}

							}

						}
					?>

				</div> <?php
		}

	}

?>-->

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">

		<div class=" _cat__" style="text-transform: uppercase; font-weight: 500;">  Our categories  </div>

				<div class="_cat__28"><i class="fa fa-television" style="font-size:20px; color:#ff6600"></i>
					<a class="_cat_link2TH wow zoomIn" href="https://yossell.com/?cat_=LTLSzbRVkSl">
						
						Electronics
					</a>
				</div>
					

				<div class="_cat__28"><i class="fa fa-tshirt" style="font-size:20px; color:#ff6600"></i>
					<a class="_cat_link2TH wow zoomIn" href="https://yossell.com/?cat_=sjjsbLT">
						
						Apparel
					</a>
				</div>
					

				<div class="_cat__28"><i class="fa fa-couch" style="font-size:20px; color:#ff6600"></i>
					<a class="_cat_link2TH wow zoomIn" href="https://yossell.com/?cat_=E2bVkz2bL">
						
						Furniture
					</a>
				</div>


				<div class="_cat__28"><i class="fa fa-dumbbell" style="font-size:20px; color:#ff6600"></i>
					<a class="_cat_link2TH wow zoomIn" href="https://yossell.com/?cat_=ljRbzl-%-LVzLbzskVQLVz">
						
						Sports & Entertianment
					</a>
				</div>


				<div class="_cat__28"><i class="fa fa-user-shield" style="font-size:20px; color:#ff6600"></i>
					<a class="_cat_link2TH wow zoomIn" href="https://www.yossell.com/?cat_=GLs2zI-%-jLblRVsT-SsbL">
						
						Beauty & Personal Care
					</a>
				</div>


				<div class="_cat__28"><i class="fa fa-gem" style="font-size:20px; color:#ff6600"></i>
					<a class="_cat_link2TH wow zoomIn" href="https://www.yossell.com/?cat_=ALrLTbI,-zkQLjkLSL-%-LIL-rLsbl">
						
						Jewelry, Timepiece & Eyewear
					</a>
				</div>

				
						<div class="_cat__28"><i class="fa fa-tools" style="font-size:20px; color:#ff6600"></i>
					<a class="_cat_link2TH wow zoomIn" href="https://www.yossell.com/?cat_=zRRTl-%-Msb9rsbL">
						
						Tools & Hardwear
					</a>
				</div>

				
					<div class="_cat__28"><i class="fa fa-subway" style="font-size:20px; color:#ff6600"></i>
					<a class="_cat_link2TH wow zoomIn" href="https://www.yossell.com/?cat_=QsSMkVLbI">
						
						Machinery
					</a>
				</div>

				

				<div class="_cat__28"><i class="fa fa-coins" style="font-size:20px; color:#ff6600"></i>
					<a class="_cat_link2TH wow zoomIn" href="https://www.yossell.com/?cat_=EsGbkSszkRV-lLbqkSLl">
						
						Fabrication Services
					</a>
				</div>


				<div class="_cat__28"><i class="fa fa-car-battery" style="font-size:20px; color:#ff6600"></i>
					<a class="_cat_link2TH wow zoomIn" href="https://www.yossell.com/?cat_=s2zRQRGkTL-jsbzl-%-sSSLllRbkLl">
						
						Automobile Parts & accessories
					</a>
				</div>

					<div class="_cat__28"><i class="fa fa-cookie" style="font-size:20px; color:#ff6600"></i>
					<a class="_cat_link2TH wow zoomIn" href="./?categories_navigation">
						
						See All categories
					</a>
				</div>



				



					<style type="text/css">
						._cat__28 {
					    cursor: pointer;
					    width: 66%;
					    display: block;
					    overflow: hidden;
					    margin-top: 8px;
					    padding-bottom: 25px;
					    margin-left: 45px;
					}
					._cat__287D {
						cursor: pointer;
					    width: 91%;
					    display: block;
					    overflow: hidden;
					    margin-top: -20px;
					    padding-bottom: 3px;
					    margin-left: 23px;
					}
					._cat_link2TH {
					    width: 100%;
					    height: 42px;
					    text-align: left;
					    padding-top: 18px;
					    margin-top: 18px;
					    overflow: hidden;
					    padding: -5px 12px;
					    text-transform: capitalize;
					    font-weight: 400;
					    font-size: 10pt;
					    color: #050505;
					    margin-top: 12px;
					    margin-left: 10px;
					    margin-bottom: -21px;
}
					</style>

<div class=" _cat__" style="text-transform: uppercase; font-weight: 500;">  quick links  </div>


<div class="_cat__28"><i class="fa fa-info" style="font-size:20px; color:#ff6600"></i>
					<a class="_cat_link2TH wow zoomIn" href="./?about_us">
						
						About Us
					</a>
				</div>
<div class="_cat__28"><i class="fa fa-phone" style="font-size:20px; color:#ff6600"></i>
					<a class="_cat_link2TH wow zoomIn" href="./?about_us">
						
						Call Us: +234 803 137 0588
					</a>
				</div>

<!--
<div class="_top_text_01" style="text-align: center;">
	<?php if ($on_ == 1) { ?>
						<?php if ($this_sell_eligible == 2) { ?>
							
			<a class="_cat_link2" " href="./?dashboard"><span class="pa _side_l__oa dbh_">d</span>Admin</a>
		
			
		<?php }; ?>

	<?php } else { ?>
		<a class="catway" href="./?register"> <span class="pa ">B</span> Join Us</a>
		<a class="catway" href="./?login"> <span class="pa ">B</span> Login</a>
	<?php }; ?>
			</div>
		<style type="text/css">
			.catway{
	float: left;
	color: #FFF;
	height: 100%;
	overflow: hidden;
	padding: 10px 10px;
	text-transform: uppercase;
	font-weight: 600;
}
			}
		</style>