<?php

    
    include "../db.php";
    $_this_p_img = $_POST['_this_p_img'];

    $getCartP_Sub_Product_ = $class_->getSP($_this_p_img);
    $get_sub_product_fetch_ = mysqli_fetch_assoc($getCartP_Sub_Product_);
    $id_gi_ = $get_sub_product_fetch_['product_id'];
    
    if ($on_ == 0) { ?>
        <div class="_nil_area"><center><a class="_t_link___" href="./?register&cid=<?php echo uniqid(); ?>&triv=<?php echo $id_gi_; ?>&triv_po=<?php echo $_this_p_img; ?>">Sign Up</a> or <a class="_t_link___" href="./?login&cid=<?php echo uniqid(); ?>&triv=<?php echo $id_gi_; ?>&triv_po=<?php echo $_this_p_img; ?>">Login</a> to start shopping.</center></div>
   <?php exit(); } else if ($this_buy_eligible !== '2') { ?>
        <div class="_nil_area">
            <center>Before You Purchase Now</center>
            <center><div class="_b_green _by_nm comp_pro">Enter Shipping Details</div></center>
        </div>
    <?php exit(); }

    $sub_p = $class_->runS(" SELECT * FROM `sub_products` WHERE `id` = '$_this_p_img' ");

    if (mysqli_num_rows($sub_p)) {

        $sub_p_FEt = mysqli_fetch_assoc($sub_p);
        $id_gi = $sub_p_FEt['id'];
        $color_gi = $sub_p_FEt['color'];
        $id_image = $sub_p_FEt['image'];
        $price_tag = $sub_p_FEt['price_tag'];
        $price_tag_trace = $sub_p_FEt['price_tag_trace'];
        $product_id_gi = trim($sub_p_FEt['product_id']);

        $getPD = $class_->runS(" SELECT store_owner, flash_deal_d, flash_deal_tf FROM `products` WHERE `id` = '$product_id_gi' ");

        if (mysqli_num_rows($getPD) > 0) {

            $getW_P_FEt = mysqli_fetch_assoc($getPD);
            $store_owner = $getW_P_FEt['store_owner'];

            $flash_deal_d = $getW_P_FEt['flash_deal_d'];
            $flash_deal_tf = $getW_P_FEt['flash_deal_tf'];

            $tf_c_DWN = $class_->tf_c_DWN($flash_deal_tf);

            if ($flash_deal_tf > $tf && $flash_deal_d == $fd_d) {
               ?>
                    <script type="text/javascript">
                        var _fl_timMP = document.querySelector("._fl_timMP");
                        td("<?php echo $tf_c_DWN; ?>", _fl_timMP, "Flash Sales: ");
                    </script>
                    <div class="_nil_area"><center>This product is on flash deals, wait till</center></div>
                    <center><div class="_fl_timMP" style="background-color: #DADADA; padding: 10px;">Loading time remaining...</div></center>
                <?php
               exit();
            }

            if ($store_owner !== $this_u_id) { ?>

                <div class="_nil_area box">
    
<div class="_nil_area box">
    
                    <h1 class="_in_Frm_xLF" style="font-size: 15pt; margin-bottom: 10px;">You've Just Picked</h1>
    
                    <form class="_add_cRT" method="POST" p_id="<?php echo $id_gi; ?>">
    
                        <div class="_o_seg_">
                            <img class="_img_ad_c" src="./images/_product/<?php echo $id_image; ?>">
                            <label class="_label__"><?php echo $color_gi; ?></label>
                        </div>

                        <div class="_o_seg_1">
                            
                            <div class="_inp_seg____a" style="padding: 0px;">
                                <input class="_num_add_c _empty_ _inp__ _inp__q_c" type="number" name="quantity" placeholder="You must Enter Quantity Here" max="<?php echo $id_quantity; ?>">
                            </div>
    
                            <?php if (strlen($price_tag) > 0) { ?>
                                <div class="_inp_seg____a" style="padding: 0px;">

                                     <div class="" style=" width: 100%; overflow: hidden; display: block; text-align: center; background-color: #050505;
    border-bottom: 5px solid #ff6600; padding: 1px; margin-top: 13px; color: #ffffff; text-transform: capitalize;">Tap On The Below Variation Before You Buy Now<br></div><br>
                                    <?php

                                        $ar__ = explode("+", $price_tag);

                                        for ($i=0; $i < count($ar__); $i++) { 

                                           $this_vv = $ar__[$i];
                                           $this_vv_ar = explode("-", $this_vv);

                                            $size_cap = $this_vv_ar[0];
                                            $price = $this_vv_ar[1];
                                            $quantity = $this_vv_ar[2];

                                           ?> 
                                            <div dta="<?php echo $this_vv . '+' . $price_tag_trace; ?>" dtap="<?php echo $class_->_currency($cur_currency, $price); ?>" dtaq=" <?php echo $class_->_currency($cur_currency, $quantity); ?>" id="<?php echo $size_cap; ?>" slt="1" class="_c_capacity_ "><?php echo $size_cap; ?></div> <?php

                                        }
    
                                    ?>
                                    <br><br><br>
                                    <textarea hidden="on" class="_inp__p_c" name="_p_tag_trace"></textarea>
                                    <!--<div class="in_flow_sum _qtag"  style="font-size: 10pt;  color: #050505;"></div>-->
                                <div class="in_flow_sum _ptag" style="font-size: 10pt;  color: #050505;"></div>
                                 <div class="in_flow_sum _stag" style="font-size: 10pt;  color: #050505;"></div>
                                </div>
                            <?php }; ?>
    
                            
                               

                               <input type="submit" name="_add_cc_" class="_b_green _by_nm purchpool" value="ADD-TO-CART">
                       
   <!--   <div class="by_now _b_green _by_nm _bdn  purchpool" th_col="<?php echo $color_gi; ?>" th_i="<?php echo $_this_p_img; ?>" id="<?php echo $product_id_gi; ?>" >BUY NOW</div> -->


                </div>
                  <div class="" style=" width: 100%; overflow: hidden; display: block; text-align: center; background-color: #050505;
    border-bottom: 5px solid #ff6600; padding: 1px; margin-top: 13px; color: #ffffff; text-transform: capitalize;">This order form is provided in a secure environment and to help protect against fraud, your transaction is now encrypted.<br></div>
            <?php } else { ?>

                <div class="_nil_area"><center>You cannot shop your own product.</center></div>

            <?php }

        }

    ?>

<?php }; ?>