$(document).ready(function () {

	/*html2canvas(document.querySelector("body")).then(canvas => {
	    document.body.appendChild(canvas)
	});*/

	callClickLay();

	$("._t__menu").click(function () {
		$("._div_cat__").fadeToggle(0);
	})

	MassiVModule();

	$("._div_cat__").mouseleave(function () {
		$("._div_cat__").fadeToggle(0);
	})

	$("._click_pro__").click(function () {
		$("._click_lay___").fadeToggle(0);
	})

	$("._dktp_cat_").each(function () {
		
		$(this).mouseover(function () {
			var _dktp_cat_ = $(this).attr("id");
			$(".__div_f_segg__").fadeOut(0);
			$("#q"+_dktp_cat_).fadeIn(0);
		})

	})

	$("._nnty___").click(function () {
		_load_s();
		Notification_();
	});

	$(".__country____").change(function () {
		var ct_count = $(this).val();

		$.post("./php/include/get_region.php", {ct_count:ct_count}, function (data) {

			$("._st_ate").html(data);

			$("._st_ate").change(function () {
				var _st_ate = $(this).val();
				$(".rsp___").show().html("Looking for stores...");
				$.post("./php/include/get_stores.php", {_st_ate:_st_ate}, function (data) {
					$(".rsp___").html(data);
				});
			});

		});

	});


	$(".sss___").click(function () {
		$(".subtile").fadeToggle(200);
	});

	// Process Buy Form
	$("._val_coup").submit(function (e) { 

		e.preventDefault();
		var formdata = new FormData(this);

		DisableQ($("._bbY_d"), 1);

		$.ajax({
		    url: "./php/worker/worker.validate.php?sub_=1",
		    type: "POST",
		    data: formdata,
		    mimeTypes:"multipart/form-data",
		    contentType: false,
		    cache: false,
		    processData: false,

		    success: function(data){

		    	DisableQ($("._bbY_d"), 2);

		    	_float_n(data);
		    	
		    },error: function(){ DisableQ($("._bbY_d"), 1); _float_n("success!"); }

		 });
	 
	});

	$("._t_dmenu").click(function () {
		$(".Atiluta").slideToggle(300);
	})

	$("._t_menu").click(function () {

		$(".nav_menu_").remove();
		$("body").append("<div class='nav_menu_'><div class='__nav_mm'><img class='_lder__' src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiIgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiBmaWxsPSIjMjIyMjIyIj4KICA8cGF0aCBvcGFjaXR5PSIuMjUiIGQ9Ik0xNiAwIEExNiAxNiAwIDAgMCAxNiAzMiBBMTYgMTYgMCAwIDAgMTYgMCBNMTYgNCBBMTIgMTIgMCAwIDEgMTYgMjggQTEyIDEyIDAgMCAxIDE2IDQiLz4KICA8cGF0aCBkPSJNMTYgMCBBMTYgMTYgMCAwIDEgMzIgMTYgTDI4IDE2IEExMiAxMiAwIDAgMCAxNiA0eiI+CiAgICA8YW5pbWF0ZVRyYW5zZm9ybSBhdHRyaWJ1dGVOYW1lPSJ0cmFuc2Zvcm0iIHR5cGU9InJvdGF0ZSIgZnJvbT0iMCAxNiAxNiIgdG89IjM2MCAxNiAxNiIgZHVyPSIwLjhzIiByZXBlYXRDb3VudD0iaW5kZWZpbml0ZSIgLz4KICA8L3BhdGg+Cjwvc3ZnPgo='></div><div class='nav_menu_2 close_MM pa '>% </div></div>");
		$(this).hide(0);

		$(".nav_menu_").fadeIn(300, function () {

			$(".__nav_mm").html("<img class='_lder__' src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiIgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiBmaWxsPSIjMjIyMjIyIj4KICA8cGF0aCBvcGFjaXR5PSIuMjUiIGQ9Ik0xNiAwIEExNiAxNiAwIDAgMCAxNiAzMiBBMTYgMTYgMCAwIDAgMTYgMCBNMTYgNCBBMTIgMTIgMCAwIDEgMTYgMjggQTEyIDEyIDAgMCAxIDE2IDQiLz4KICA8cGF0aCBkPSJNMTYgMCBBMTYgMTYgMCAwIDEgMzIgMTYgTDI4IDE2IEExMiAxMiAwIDAgMCAxNiA0eiI+CiAgICA8YW5pbWF0ZVRyYW5zZm9ybSBhdHRyaWJ1dGVOYW1lPSJ0cmFuc2Zvcm0iIHR5cGU9InJvdGF0ZSIgZnJvbT0iMCAxNiAxNiIgdG89IjM2MCAxNiAxNiIgZHVyPSIwLjhzIiByZXBlYXRDb3VudD0iaW5kZWZpbml0ZSIgLz4KICA8L3BhdGg+Cjwvc3ZnPgo='>").animate({"left": "0%"}, 250);

			$.post("./php/include/menu_cat.php", function (data) {
				$(".__nav_mm").html(data);

				MassiVModule();

				$(".toggl__").each(function () {
					$(this).click(function () {
						var toggl__ = $(this).attr("id");
						$(".cat_in_v").slideUp(300);
						$("#civ"+toggl__).slideDown(300);
						
						
						$(".toggl__").show(0);
						$(".toggl__r").hide(0);

						$(this).hide();

						$(".toggl__r"+toggl__).show(0);

					})
				})

				$(".toggl__r").each(function () {
					$(this).click(function () {
						var toggl__r = $(this).attr("id");
						$("#civ"+toggl__r).slideUp(300);

						$(".toggl__r").hide(0);
						$(".toggl__"+toggl__r).show(0);
					})
				})

			});

			$(".nav_menu_2").click(function () {
				$(".__nav_mm").animate({"left": "-100%"}, 250, function () {
					$("body").css({"position": "unset"});
					$(".nav_menu_").remove();
					$("._t_menu").show(0);
				});
			})

		});

	})

	var _wid = $(".mspeaker").width();
	$(".maria").css({"width": _wid+"px"});

	var var_h = $(".mspeaker").height()/2;
	$("._tv_othrded_btred").css({"height": var_h/2 + "px", "line-height": var_h/2 + "px"});	

	var sl_count = 1;
	setInterval(function () {

		var _wid = $(".mspeaker").width();
		$(".maria").css({"width": _wid+"px"});

		var var_h = $(".mspeaker").height()/2;
		$("._tv_othrded_btred").css({"height": var_h/2 + "px", "line-height": var_h/2 + "px"});

		var flow_flex = sl_count++;
		$("._"+(flow_flex+1)).css({"background": "#89ff00"});
		$(".dspeaker").animate({"margin-left": "-="+_wid+"px"}, 1000, function () {
			
			if (flow_flex == 7) {
				sl_count = 1;
				$(".dspeaker").css({"margin-left": 0});
				$("._1").css({"background": "#89ff00"});
			}

		});

	}, 5000, false);

	$("._delc").each(function () {
		
		var this_s = $(this);
		this_s.click(function () {
			
			var _A_CART = this_s.attr("id");
			var SRC = this_s.attr("srr");
			DisableQ(this_s, 1);
			
			$.post("./php/worker/worker.cart.transact.php", {_A_CART:_A_CART, SRC:SRC}, function (data) {
				$("._hP").html(data);
				DisableQ(this_s, 2);
			});

		});

	})

	$(".close_MM").click(function () { $("._ovL_Pane").fadeOut(200); })

	$("._WLST").click(function () {
		var _WLST = $(this).attr("id");
		DisableQ($(this), 1);
		$.post("./php/worker/wish.php", {_WLST:_WLST}, function (data) {
			DisableQ($("._WLST"), 2);
			$("._hP").html(data);
		})
	});

	$("._call_module").each(function () {

		$(this).click(function () {

			_load_s();

			var _call_module_ = $("._option_");
			DisableQ(_call_module_, 1);

			var _call_module = $(this).attr("id");

			if (_call_module.toLowerCase() == "sad") {

				$.post("./php/include/s_ad.php", function (data) {
							
					DisableQ(_call_module_, 2);
					$("._in_ovPane").html(data);
					EscC();
					$("._ovvvv_").fadeOut(200);

					$("._ad_tlink_").each(function function_name() {
						$(this).click(function () {
							var _ad_tlink_ = $(this).attr("id");

							DisableQ($("._in_Lk"), 1);

							if (_ad_tlink_ == "tC") {

								_load_s();
								LoadTicket(2);

							} else if (_ad_tlink_ == "oD") {

								_load_s();
								CallOrders();

							} else {
								$.post("./php/include/_a_min/s_ad_group.php", {_ad_tlink_:_ad_tlink_}, function (data) {
							
									DisableQ($("._in_Lk"), 2);
									$("._a_d_min_a").html(data);

									if (_ad_tlink_ == "mC" || _ad_tlink_ == "mSC" || _ad_tlink_ == "mSSC") {
										$("._del_cssb").each(function () {

											$(this).click(function () {
												var id__ = $(this).attr("id");
												var typ = $(this).attr("typ");
												$.post("./php/worker/_man_cat_del.php", {id__:id__, typ:typ}, function (data) {
													_float_n(data);
												});
											})

										})
									}
									$("._del_fln__").each(function () {
										$(this).click(function () {
											var _del_fln__ = $(this).attr("id");
											$.post("./php/worker/del_fln.php", {_del_fln__:_del_fln__}, function (data) {
												$(".rmv" + _del_fln__).html(data);
												$(".rmv" + _del_fln__).hide(300, function () {
													$(this).remove();
												})
											});
										})
									})

									$("._sel_u_p").each(function function_name() {
										$(this).click(function () {
											var _sel_u_p = $(this).attr("id");
											$.post("./php/include/u_p_fle.php", {_sel_u_p:_sel_u_p}, function (data) {
												$("._in_ovPane").html(data);
												EscC();

												$("._app_inf").click(function () {
													var _app_inf = $(this).attr("id");
													$("._act_pp__").hide();
													$.post("./php/worker/worker.apv.php?p=1", {_app_inf:_app_inf}, function (data) {
														$("._in_ovPane").html(data);
														EscC();
														$("._act_pp__").show(0);
													});
												})

												$("._del_inf").click(function () {
													var _del_inf = $(this).attr("id");
													$("._act_pp__").hide();
													$.post("./php/worker/worker.del.php?p=1", {_del_inf:_del_inf}, function (data) {
														$("._in_ovPane").html(data);
														EscC();
														$("._act_pp__").show(0);
													});
												})

											});
										});
									});

									if (_ad_tlink_ == "mBi" || _ad_tlink_ == "mB") {
										$("._in_file___p").change(function () {
										  var reader = new FileReader();
										  reader.onload = function (e) {
										  	
										  	$("._p_prev_p").animate({"opacity": 1}, 500);
										    $("._f_image_p").attr('src', e.target.result);
										    // $("#prev_a").fadeIn(200);
										  };
										  reader.readAsDataURL(this.files[0]);
										});
									}

									$("._a_group").submit(function (e) { 
					  
										e.preventDefault();
										var formdata = new FormData(this);

										var trace_ = $(this).attr("id");

										$.ajax({
										    url: "./php/worker/ad.manage.php?trace_=" + trace_,
										    type: "POST",
										    data: formdata,
										    mimeTypes:"multipart/form-data",
										    contentType: false,
										    cache: false,
										    processData: false,

										    success: function(data){

										    	_float_n(data);
										    	
										    },error: function(){ DisableQ($("._bbY_d"), 1); Loader(1); _float_n("Internet connection is bad!"); }

										 });
									 
									});

								});
							}

						});
					});

				});

} else if (_call_module.toLowerCase() == "ts") {

				Ticket_();

			} else if (_call_module.toLowerCase() == "_ms") {

				$.post("./php/include/my_shop.php", function (data) {
							
					Loader(2); DisableQ(_call_module_, 2);
					$("._in_ovPane").html(data);
					EscC();
					$("._ovvvv_").fadeOut(200);

					$("._delProd").each(function () {
						$(this).click(function () {
							$(this).remove();
							var _delProd = $(this).attr("id");
							$("#_ed_PLoad"+_delProd).show();
							$.post("./php/worker/worker.del_product.php", {_delProd:_delProd}, function (data) {
								_float_n(data);
							})
						})
					})


					$("._rC").each(function () {
						$(this).click(function () {
							var this_s = $(this);
							this_s.hide();
							var _rC = $(this).attr("id");
							$("#_ed_PLoad"+_rC).show();
							$.post("./php/worker/worker.rec_product.php", {_rC:_rC}, function (data) {
								this_s.show(0);
								$("#_ed_PLoad"+_rC).hide();
								_float_n(data);
							})
						})
					})

					$("._sfd").each(function () {
						$(this).change(function () {
							var this_s = $(this);
							this_s.hide();
							var _sfd = $(this).attr("id");
							var _sfd_tf = $(this).val();
							$("#_ed_PLoad"+_sfd).show();
							$.post("./php/worker/worker.fd_product.php", {_sfd:_sfd, _sfd_tf:_sfd_tf}, function (data) {
								this_s.show(0);
								$("#_ed_PLoad"+_sfd).hide();
								_float_n(data);
							})
						})
					})

					$("._sP").each(function () {
						$(this).click(function () {
							var this_s = $(this);
							this_s.hide();
							var _sP = $(this).attr("id");
							$("#_ed_PLoad"+_sP).show();
							$.post("./php/worker/worker.spon_product.php", {_sP:_sP}, function (data) {
								this_s.show(0);
								$("#_ed_PLoad"+_sP).hide();
								_float_n(data);
							})
						})
					})

					// Add More Products from MY SHOP
					AddMorePCall($(".add_m_pp"));						

					$("._ed_P").each(function () {

						$(this).click(function () {

							var _ed_P = $(this).attr("id");
							$("._ovL_Pane").fadeIn(200);
							$("._in_ovPane").html("<center><img style='height: 25px;' src='./asset/91.gif'></center>");

							_load_s();

							$.post("./php/include/edit_p.php", {_ed_P:_ed_P}, function (data) {
								$("._in_ovPane").html(data);
								EscC();

								$("._m_cat").change(function () {
									$("._load_cc_").show(0).html("<center><img style='height: 30px; margin: 10px;' src='./asset/91.gif'></center>")
									var _m_cat = $(this).val();
									$.post("./php/include/_ext_sub_cat.php", {_m_cat:_m_cat}, function (data) {
										$("._load_cc_").html(data);

										$("._m_sub_cat").change(function () {
											$("._load_sub_cc_").show(0).html("<center><img style='height: 30px; margin: 10px;' src='./asset/91.gif'></center>")
											var _m_sub_cat = $(this).val();
											$.post("./php/include/_ext_sub_sub_cat.php", {_m_sub_cat:_m_sub_cat}, function (data) {
												$("._load_sub_cc_").html(data);
											})
										})

									});
								});

								// Edit Product
								$("._e_Form").submit(function (e) { 
				  
									e.preventDefault();
									var formdata = new FormData(this);

									DisableQ($("._bbY_edP"), 1);
									var t_id = $(this).attr("t_id");

									$.ajax({
									    url: "./php/worker/worker.edit_p.php?t_id="+t_id,
									    type: "POST",
									    data: formdata,
									    mimeTypes:"multipart/form-data",
									    contentType: false,
									    cache: false,
									    processData: false,

									    success: function(data){

									    	DisableQ($("._bbY_edP"), 2);

									    	_float_n(data);
									    	
									    },error: function(){ DisableQ($("._bbY_edP"), 1); _float_n("Internet connection is bad!"); }

									 });
								 
								});

							})

						})
					})

				});

			} else if (_call_module.toLowerCase() == "_orders") {

				_load_s();
				CallOrders();

			} else if (_call_module.toLowerCase() == "_wl") {

				_load_s();
				Wish_();

			} else if (_call_module.toLowerCase() == "_profile") {

				_load_s();
				Sell_();

			} else if (_call_module.toLowerCase() == "_buy") {

				_load_s();
				Buy_();

			} else if (_call_module.toLowerCase() == "_notification") {

				_load_s();
				Notification_();

			} else if (_call_module.toLowerCase() == "_sell") {
				
				$.post("./php/include/sell.php", function (data) {
							
					Loader(2); DisableQ(_call_module_, 2);
					$("._in_ovPane").html(data);
					EscC();
					$("._ovvvv_").fadeOut(200);
					// $("._b_date").datepicker();

					var id_tracker = 1;

					$("._add_spec").click(function () {

						var id_tracker_ = "_q"+id_tracker++;
						$("<div class='_inp_seg_ "+id_tracker_+"'><input class='_inp__Spec spn"+id_tracker_+"' type='text' placeholder='Specification Name'><input class='_inp__Spec xL__inp__Spec spc"+id_tracker_+"' type='text' placeholder='Specification'><div class='_inP_Q pa _ml_n' id='"+id_tracker_+"'>%</div></div>").insertBefore($(this));

						$("#"+id_tracker_).click(function () {
							var _inP_Q = $(this).attr("id");
							$("."+id_tracker_).remove();
						});

					});

					// ADD PRODUCT
					$(".f_s_county").change(function () {

						var f_s_county = $(this).val();
						var in_text = $(".f_s_county_inp").val().trim();

						if (in_text.length == 0) {
							var new_in_text = f_s_county;
						} else {
							var new_in_text = in_text + "," + f_s_county;
						}

						$(".f_s_county_inp").val(new_in_text.trim());
						$(".console_f_s_county").append("<span class='_column_'>"+f_s_county+"</span>");

					});

					$("._add_m_photos_").click(function () {
						var _f_img__ = $("._f_img__").attr("src");
						$("._f_img__").css({"border": "unset"});
						if (_f_img__.length == 0) {
							$("._f_img__").css({"border-bottom": "3px solid red"});
						} else {
							$(this).fadeOut(0);
							$("._dim_im_sect__").slideDown(300);
						}
						
					});

					$("._m_cat").change(function () {
						$("._load_cc_").show(0).html("<center><img style='height: 30px; margin: 10px;' src='./asset/91.gif'></center>")
						var _m_cat = $(this).val();
						$.post("./php/include/_ext_sub_cat.php", {_m_cat:_m_cat}, function (data) {
							$("._load_cc_").html(data);

							$("._m_sub_cat").change(function () {
								$("._load_sub_cc_").show(0).html("<center><img style='height: 30px; margin: 10px;' src='./asset/91.gif'></center>")
								var _m_sub_cat = $(this).val();
								$.post("./php/include/_ext_sub_sub_cat.php", {_m_sub_cat:_m_sub_cat}, function (data) {
									$("._load_sub_cc_").html(data);
								})
							})

						});
					});

					$("._a_p__").submit(function (e) { 
	  
						e.preventDefault();

						var thiss = this;

						DisableQ($("._bbY_d"), 1);
						Loader(1);

						$(".spec_col").val("");
						var _spec_array = [];
						var formdata = null;

						formdata = new FormData(thiss);	 

						$("._inP_Q").each(function () {

							var this__inP_Q = $(this);
							var this__inP_Q_id = this__inP_Q.attr("id"); 

							var this_text = $(".spn"+this__inP_Q_id).val() + "||" + $(".spc"+this__inP_Q_id).val();
							_spec_array.push(this_text);
							$(".spec_col").val(_spec_array.join("|||"));

							formdata = new FormData(thiss);

						});			

						$.ajax({

						    url: "./php/worker/worker.add_p.php?sub_=1",
						    type: "POST",
						    data: formdata,
						    mimeTypes:"multipart/form-data",
						    contentType: false,
						    cache: false,
						    processData: false,

						    success: function(data){

						    	DisableQ($("._bbY_d"), 2); Loader(2);

						    	_float_n(data);

						    	var data_ = data.split("_");

						    	if (data_[0] == 1) {
						    		$("._ovL_Pane").fadeIn(200);
									$("._in_ovPane").html("<center><img style='height: 25px;' src='./asset/91.gif'></center>");
									AddMorePCallLoader(data_[1]);
						    	}
						    	
						    },error: function(){ DisableQ($("._bbY_d"), 1); Loader(1); _float_n("Internet connection is bad!"); }

						});
					 
					});

					CallEditSell();

				});

			} else if (_call_module.toLowerCase() == "_service") {
				
				$.post("./php/include/service.php", function (data) {
							
					Loader(2); DisableQ(_call_module_, 2);
					$("._in_ovPane").html(data);
					EscC();
					$("._ovvvv_").fadeOut(200);

					// Sell Buy Form
					$("._service__").submit(function (e) { 
	  
						e.preventDefault();
						var formdata = new FormData(this);

						DisableQ($("._bbY_d"), 1);
						Loader(1);

						$.ajax({
						    url: "./php/worker/worker.service.php?sub_=1",
						    type: "POST",
						    data: formdata,
						    mimeTypes:"multipart/form-data",
						    contentType: false,
						    cache: false,
						    processData: false,

						    success: function(data){

						    	DisableQ($("._bbY_d"), 2); Loader(2);

						    	_float_n(data);
						    	
						    },error: function(){ DisableQ($("._bbY_d"), 1); Loader(1); _float_n("Internet connection is bad!"); }

						 });
					 
					});

				});

			}

		})

	})
	
});

function Update() {

	$(".spec_col").val("");
	var _spec_array = [];

	$("._inP_Q").each(function () {

		var this__inP_Q = $(this);
		var this__inP_Q_id = this__inP_Q.attr("id"); 

		var this_text = $(".spn"+this__inP_Q_id).val() + "||" + $(".spc"+this__inP_Q_id).val();
		_spec_array.push(this_text);
		$(".spec_col").val(_spec_array.join("|||"));

		alert();

	});

}

function DisableQ(view_, call) {
	if (call == 1) {
		view_.attr("disabled","disabled");
	} else {
		view_.removeAttr("disabled");
	}
}

function SelectorZ(_sel_Z, _inp_txt, color, _type) {
	
	_sel_Z.each(function () {
		$(this).click(function () {

			$(".by_now").show();

			var _sel_this = $(this);
			var _sel_ = _sel_this.attr("id");
			var dtaq = _sel_this.attr("dtaq");
			var dtap = _sel_this.attr("dtap");
			var dta = _sel_this.attr("dta");

			$("._ptag").html("Grand Total: <b class='inherit'>" + dtap + "</b>");
			$("._stag").html("Variation Selected: <b class='inherit'>" + _sel_ + "</b>");
			$("._qtag").html("Shipping Fee Is: <b class='inherit'>" + dtaq + "</b>");

			if (_type == 1) {
				
				_sel_Z.css({"border-radius": "0px", "background": "#FFF", "color": "unset"});
				_sel_this.css({"background": color, "color": "#FFF"});
				_sel_this.animate({"border-radius": "100px"});

				var new_in_text = dta;

			} else {

				var _sel_selected = _sel_this.attr("slt");

				var in_text = _inp_txt.val().trim();

				if (_sel_selected == "1") {
					_sel_this.css({"background": color, "color": "#FFF"});
					_sel_this.animate({"border-radius": "100px"});
					_sel_this.attr("slt","2");
					var new_in_text = in_text + " " + _sel_;
				} else {
					_sel_this.animate({"border-radius": "0px"}, function () {
						_sel_this.css({"background": "#FFF", "color": "unset"});
					});
					
					_sel_this.attr("slt","1");
					var new_in_text = in_text.replace(_sel_, "").replace("  ", " ");
				}

			}							

			_inp_txt.val(new_in_text.trim());
			
		});
	});

}

function callClickLay() {

	$("._adtcart__").each(function () {

		var _this_p_img = $(this).attr("id");
		var _this_p_img_src = $(this).attr("src");

		$(this).click(function () {

			$("._thisS_p_img").attr("src", _this_p_img_src);

			$("._ld_detail_aa").html("<center><img style='height: 50px;' src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiIgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiBmaWxsPSIjMjIyMjIyIj4KICA8cGF0aCBvcGFjaXR5PSIuMjUiIGQ9Ik0xNiAwIEExNiAxNiAwIDAgMCAxNiAzMiBBMTYgMTYgMCAwIDAgMTYgMCBNMTYgNCBBMTIgMTIgMCAwIDEgMTYgMjggQTEyIDEyIDAgMCAxIDE2IDQiLz4KICA8cGF0aCBkPSJNMTYgMCBBMTYgMTYgMCAwIDEgMzIgMTYgTDI4IDE2IEExMiAxMiAwIDAgMCAxNiA0eiI+CiAgICA8YW5pbWF0ZVRyYW5zZm9ybSBhdHRyaWJ1dGVOYW1lPSJ0cmFuc2Zvcm0iIHR5cGU9InJvdGF0ZSIgZnJvbT0iMCAxNiAxNiIgdG89IjM2MCAxNiAxNiIgZHVyPSIwLjhzIiByZXBlYXRDb3VudD0iaW5kZWZpbml0ZSIgLz4KICA8L3BhdGg+Cjwvc3ZnPgo='></center>");

			$.post("./php/include/product_option.php", {_this_p_img:_this_p_img}, function (data) {
				$("._ld_detail_aa").html(data);
				SelectorZ($("._c_capacity_"), $("._inp__p_c"), "#ff6600", 1);

				$(".comp_pro").click(function () {
					_load_s();
					Buy_();
				})

				$("._num_add_c").change(function () {
					var this_ = $(this).val();
					if (this_ < 1) {
						$("._num_add_c").val("1");
					}
				});

				$(".by_now").click(function () {
					window.location = "./?product_v="+$(this).attr('id')+"&th_i="+$(this).attr('th_i')+"&bn="+$("._inp__p_c").val()+"&qt="+$("._inp__q_c").val()+"&th_col="+$(this).attr('th_col');
				})

				$("._add_cRT").submit(function (e) { 

					e.preventDefault();
					var formdata = new FormData(this);

					DisableQ($("._addImg"), 1);
					var p_id = $(this).attr("p_id");

					$("._no_PP").show(0).html("<center>Uploading Image... <img style='height: 10px;' src='./asset/91.gif'></center>");

					$.ajax({
					    url: "./php/worker/worker.cart.transact.php?p_id="+p_id,
					    type: "POST",
					    data: formdata,
					    mimeTypes:"multipart/form-data",
					    contentType: false,
					    cache: false,
					    processData: false,

					    success: function(data){

					    	DisableQ($("._addImg"), 2);

					    	_float_n(data);
					    	
					    },error: function(){ DisableQ($("._addImg"), 1); _float_n("Internet connection is bad!"); }

					 });
				 
				});

			});

			/*if (_thisS_p_img_oVV_pos == $("._thisS_p_img_oVV").length || _thisS_p_img_oVV_pos > 1) {
				$("._next_Arrow").hide(0);
				$("._prev_Arrow").show(0);
			}

			$("._next_Arrow").click(function () {

				var _next_po = 1+_thisS_p_img_oVV_pos++;
				if (_next_po > $("._thisS_p_img_oVV").length) {
					$(this).hide(0);
				} else {
					if (_next_po == $("._thisS_p_img_oVV").length){
						$(this).hide(0);
					} else {
						$(this).show(0);
					}

					if (_thisS_p_img_oVV_pos < $("._thisS_p_img_oVV").length) {
						$("._prev_Arrow").show(0);
					}
					
					var _thisS_p_img_oVV_Click = $("#pV" + _next_po).attr("src");
					$("._in_ovPane").html("<center><img style='width: 100%;' src='" + _thisS_p_img_oVV_Click + "'></center>");
				}
				
			});

			if (_thisS_p_img_oVV_pos == 1 || _thisS_p_img_oVV_pos < $("._thisS_p_img_oVV").length) {
				$("._prev_Arrow").hide(0);
				$("._next_Arrow").show(0);
			}

			if (_thisS_p_img_oVV_pos > 1 && _thisS_p_img_oVV_pos < $("._thisS_p_img_oVV").length) {
				$("._prev_Arrow").show(0);
				$("._next_Arrow").show(0);
			}

			$("._prev_Arrow").click(function () {
				var _prev_po = (_thisS_p_img_oVV_pos--)-1;

				if (_prev_po < 1) {
					$(this).hide(0);
				} else {
					if (_prev_po == 1){
						$(this).hide(0);
					} else {
						$(this).show(0);
					}

					if (_thisS_p_img_oVV_pos > 0 && _thisS_p_img_oVV_pos < $("._thisS_p_img_oVV").length) {
						$("._next_Arrow").show(0);
					}

					var _thisS_p_img_oVV_Click = $("#pV" + _prev_po).attr("src");
					$("._in_ovPane").html("<center><img style='width: 100%;' src='" + _thisS_p_img_oVV_Click + "'></center>");
				}
				
			});*/

		});
	});

}

function AddMorePCall(click_) {
	
	click_.each(function () {

		$(this).click(function () {

			_load_s();

			var add_m_pp = $(this).attr("id");

			$("._ovL_Pane").fadeIn(200);
			$("._in_ovPane").html("<center><img style='height: 25px;' src='./asset/91.gif'></center>");
			AddMorePCallLoader(add_m_pp);

		});

	});

}

function AddMorePCallLoader(add_m_pp) {
	
	$.post("./php/include/add_mo_p.php", {add_m_pp:add_m_pp}, function (data) {
		$("._in_ovPane").html(data);
		EscC();

		$("._in_file___p").change(function () {
		  var reader = new FileReader();
		  reader.onload = function (e) {
		  	
		  	$("._p_prev_p").animate({"opacity": 1}, 500);
		    $("._f_image_p").attr('src', e.target.result);
		    // $("#prev_a").fadeIn(200);
		  };
		  reader.readAsDataURL(this.files[0]);
		});

		var id_tracker = 1;
		$("._add_spec").click(function () {

			var id_tracker_ = "_q"+id_tracker++;
			$("<div class='_inp_seg_ "+id_tracker_+"'><input class='_inp__Spec spn"+id_tracker_+"' type='text' placeholder='Size /Capacity/ Inches'><input class='_inp__Spec xL__inp__Spec spc"+id_tracker_+"' type='text' placeholder='Price e.g 12000'><input class='_inp__Spec xxL__inp__Spec spq"+id_tracker_+"' type='number' placeholder='Shipping Fee e.g 1200'><div class='_inP_Q pa _ml_n' id='"+id_tracker_+"'>%</div></div>").insertBefore($(this));

			$("#"+id_tracker_).click(function () {
				var _inP_Q = $(this).attr("id");
				$("."+id_tracker_).remove();
			});

		});

		AddMoreP();

		$(".delImg").each(function () {

			$(this).click(function () {

				var this_s = $(this);
				var delImg = $(this).attr("id");
				var delImg_Src = $(this).attr("srr");
				DisableQ(this_s, 1);
				$.post("./php/worker/worker.del_img.php", {delImg:delImg, delImg_Src:delImg_Src}, function (data) {
					_float_n(data);
					DisableQ(this_s, 2);
				});

			});

		});

	});

}

function AddMoreP() {
	
	// Add Image
	$("._ed_Im_Form").submit(function (e) { 

		e.preventDefault();
		
		var thiss = this;

		$(".spec_col").val("");
		var _spec_array = [];
		var formdata = null;

		formdata = new FormData(thiss);	 

		$("._inP_Q").each(function () {

			var this__inP_Q = $(this);
			var this__inP_Q_id = this__inP_Q.attr("id"); 

			var this_text = $(".spn"+this__inP_Q_id).val() + "-" + $(".spc"+this__inP_Q_id).val() + "-" + $(".spq"+this__inP_Q_id).val();
			_spec_array.push(this_text);
			$(".spec_col").val(_spec_array.join("+").trim());

			formdata = new FormData(thiss);

		});

		DisableQ($("._addImg"), 1);
		var t_add = $(this).attr("t_add");

		$("._no_PP").show(0).html("<center>Uploading Image... <img style='height: 10px;' src='./asset/91.gif'></center>");

		$.ajax({
		    url: "./php/worker/worker.add_mo_p.php?t_add="+t_add,
		    type: "POST",
		    data: formdata,
		    mimeTypes:"multipart/form-data",
		    contentType: false,
		    cache: false,
		    processData: false,

		    success: function(data){

		    	DisableQ($("._addImg"), 2);

		    	_float_n(data);
		    	
		    },error: function(){ DisableQ($("._addImg"), 1); _float_n("Internet connection is bad!"); }

		 });
	 
	});

}

function Loader(call) {
	if (call == 1) {
		$("._top_load").show(0);
	} else {
		$("._top_load").hide(0);
	}
}

function Splash() {

	var _win_w = $(window).width();
	var _win_h = $(window).height();
	var _spl_ctr_h = 60;

	$("._spl_").show(0);

	var mid_point = (_win_h/2)-(_spl_ctr_h/2);
	var _spl_ctr = $("._spl_ctr").css({"margin-top": mid_point + "px"});

	setTimeout(function () {
		$("._spl_").animate({"opacity": "0", "top": "-100%"}, 600, function () {
			$(this).remove();
		})
	}, 2000, false);
}

function td(timie_mili_seconds, target_area, label) {
	
	// Set the date we're counting down to
	var countDownDate = new Date(timie_mili_seconds).getTime();

	// Update the count down every 1 second
	var x = setInterval(function() {

	    // Get todays date and time
	    var now = new Date().getTime();
	    
	    // Find the distance between now an the count down date
	    var distance = countDownDate - now;
	    
	    // Time calculations for days, hours, minutes and seconds
	    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
	    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
	    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
	    
	    // Output the result in an element with id="time_2"
	    target_area.innerHTML = "<b class='inherit'>" + label + "</b>" + hours + " hr " + minutes + " min " + seconds + " sec";
	    
	    // If the count down is over, write some text 
	    if (distance < 0) {
	        clearInterval(x);
	        target_area.innerHTML = "<b class='inherit'>" + label + "</b>" + " Expired!";
	        window.location = "";
	    }

	}, 1000, false);

}

function LoadTicket(typq) {

	$.post("./php/include/get_ticket.php",{typq:typq}, function (data) {
		
		if (typq == 2) {
			$("._in_ovPane").html(data);
		} else {
			$("._ctkk__").html(data);
		}
		
		$("._tr_tc").each(function () {
			$(this).click(function () {

				_load_s();
			
				var _tr_tc = $(this).attr("id");
				$.post("./php/include/ld_msg.php", {_tr_tc:_tr_tc}, function (data) {
					$("._flow_arena__OvL").html(data);

					$("._in_ovPane").html(data);
					EscC();
					
					$(".m_txt_area").submit(function (e) { 
	  
						e.preventDefault();
						var formdata = new FormData(this);

						DisableQ($("._bbY_d"), 1);
						var tc_id = $(".m_txt_area").attr("tc_id");

						$.ajax({
						    url: "./php/worker/worker.send_message.php?tc_idd="+tc_id,
						    type: "POST",
						    data: formdata,
						    mimeTypes:"multipart/form-data",
						    contentType: false,
						    cache: false,
						    processData: false,

						    success: function(data){

						    	DisableQ($("._bbY_d"), 2);
						    	_float_n(data);
						    	
						    },error: function(){ DisableQ($("._bbY_d"), 1); _float_n("Internet connection is bad!"); }

						 });
					 
					});
				})
			})
		})

	});
}

function CLOSE_() {
	$(".cl_ext_").click(function () {
		$("._flow_arena__OvL").animate({"right": "100%", "opacity": 0}, 500, function () {
			$("._flow_arena__OvL").remove();
		});
	})
}

function Call_INF_LOD() {

	var _win__d = $("body").width;
	alert(_win__d);
	
	$("._flow_arena_").append("<div class='_flow_arena__OvL'><center><img src='./asset/91.gif'></center></div>");
	$("._flow_arena__OvL").animate({"right": "-10%", "opacity": 1}, 500, function () {
		$("._flow_arena__OvL").animate({"right": "10%"}, 400, function () {
			$("._flow_arena__OvL").animate({"right": "0%"}, 500);
		});
	});
}

function GSLIDE(max_) {

	var init_p = -1;
	var in_x = 0;
	var x_dir = 0;

	var counter = 1;
	var cc;

	$("._dooot_a").each(function () {
		$(this).click(function () {
			$("._dooot_a").css({"background": "grey"});
			$(this).css({"background": "yellow"});

			var _id = $(this).attr("id");
			alert(_id);
			if (_id > 1) {
				$("._inP_TImg").animate({"margin-left": "-="+(370*_id)+"px"});
			}

		})
	})*

	$("._inP_TImg_").mousedown(function (e) {
		in_x = e.pageX;
	}).mousemove(function (e) {
		e.preventDefault();
	}).mouseup(function (e) {

		var dif = (e.pageX - in_x);
		$("._dooot_a").css({"background": "grey"});

		if (dif < 0) {
			cc = 1+counter++;

			if (cc > max_) {
				counter = max_;
				$(".d"+counter).css({"background": "yellow"});
			} else {
				$(".d"+cc).css({"background": "yellow"});
				$("._inP_TImg").animate({"margin-left": "-=370px"});
			}
				
		} else if (dif > 0) {
			// BACKWARD
			cc = counter--;
			if (cc == 1) {
				counter = 1;
				$(".d1").css({"background": "yellow"});
			} else {
				$("#d"+(cc-1)).css({"background": "yellow"});
				$("._inP_TImg").animate({"margin-left": "+=370px"});
			}

		}
	})
}

function _load_s(_tab_name) {
	$("._in_lay_b").removeAttr("id");
	$("._tab_name").html(_tab_name);
	$("._ovL_Pane").fadeIn(300);
	$("._in_ovPane").html("<center><img style='height: 50px; margin: 50px;' src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiIgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiBmaWxsPSIjMjIyMjIyIj4KICA8cGF0aCBvcGFjaXR5PSIuMjUiIGQ9Ik0xNiAwIEExNiAxNiAwIDAgMCAxNiAzMiBBMTYgMTYgMCAwIDAgMTYgMCBNMTYgNCBBMTIgMTIgMCAwIDEgMTYgMjggQTEyIDEyIDAgMCAxIDE2IDQiLz4KICA8cGF0aCBkPSJNMTYgMCBBMTYgMTYgMCAwIDEgMzIgMTYgTDI4IDE2IEExMiAxMiAwIDAgMCAxNiA0eiI+CiAgICA8YW5pbWF0ZVRyYW5zZm9ybSBhdHRyaWJ1dGVOYW1lPSJ0cmFuc2Zvcm0iIHR5cGU9InJvdGF0ZSIgZnJvbT0iMCAxNiAxNiIgdG89IjM2MCAxNiAxNiIgZHVyPSIwLjhzIiByZXBlYXRDb3VudD0iaW5kZWZpbml0ZSIgLz4KICA8L3BhdGg+Cjwvc3ZnPgo='></center>");
	$(".close_MM").click(function () {
		$("._ovL_Pane").fadeOut(200);
	})
}

function _float_n(data) {

	var _0_l = new Date().getTime();

	$("._no_PP").html(data);
	$("._n_Pane_").fadeIn(0).animate({"top": "0%"}, 800, function () {
		setTimeout(function () {
			$("._n_Pane_").animate({"top": "-100%"}, 1500, function () {
				$("._n_Pane_").fadeOut(0);
			});
		}, 4000);
	});

}

function CallEditSell() {
	
	// END PRODUCT
	$("._in_file___p").change(function () {
	  var reader = new FileReader();
	  reader.onload = function (e) {
	  	
	  	$("._p_prev_p").animate({"opacity": 1}, 500);
	    $("._f_image_p").attr('src', e.target.result);
	    // $("#prev_a").fadeIn(200);
	  };
	  reader.readAsDataURL(this.files[0]);
	});

	$("._in_file___c").change(function () {
	  var reader = new FileReader();
	  reader.onload = function (e) {
	  	
	  	$("._p_prev_c").animate({"opacity": 1}, 500);
	    $("._f_image_c").attr('src', e.target.result);
	    // $("#prev_a").fadeIn(200);
	  };
	  reader.readAsDataURL(this.files[0]);
	});

	$("._inp_m").click(function () {

		if ($(this).attr("seltd") == "on") {
			$("._inp_m").removeAttr("seltd").css({"background": "#EEE"});
			$("._t_c").val("");
			$("._in_tt_c").css({"color": "grey"});
		} else {
			$("._inp_m").attr("seltd", "on").css({"background": "#0400f6"});
			$("._t_c").val("1");
			$("._in_tt_c").css({"color": "#FFFFFF"});
		}

	});

	$("._inp_r").click(function () {

		if ($(this).attr("seltd") == "on") {
			$("._inp_r").removeAttr("seltd").css({"background": "#EEE"});
			$("._t_r").val("");
			$("._in_tt_r").css({"color": "grey"});
		} else {
			$("._inp_r").attr("seltd", "on").css({"background": "#0400f6"});
			$("._t_r").val("1");
			$("._in_tt_r").css({"color": "#FFFFFF"});
		}

	})

	// Sell Buy Form
	$("._sell__").submit(function (e) { 

		e.preventDefault();
		var formdata = new FormData(this);

		DisableQ($("._bbY_d"), 1);
		Loader(1);

		$.ajax({
		    url: "./php/worker/worker.sell.php?sub_=1",
		    type: "POST",
		    data: formdata,
		    mimeTypes:"multipart/form-data",
		    contentType: false,
		    cache: false,
		    processData: false,

		    success: function(data){

		    	DisableQ($("._bbY_d"), 2); Loader(2);

		    	_float_n(data);
		    	
		    },error: function(){ DisableQ($("._bbY_d"), 1); Loader(1); _float_n("Internet connection is bad!"); }

		 });
	 
	});

}

function EscC() {
	
	$("body").keyup(function (e) {
		var t_k_code = e.keyCode;
		if (t_k_code == 27) {
			$("._ovL_Pane").fadeOut(200);
		}
	});

}

function Sell_() {
	
	$.post("./php/include/profile.php", function (data) {
				
		$("._in_ovPane").html(data);

		$("._sel_inf").click(function () {
			_load_s("Edit Selling Profile");
			
			$.post("./php/include/sell.php?p=1", function (data) {
				$("._in_ovPane").html(data);
				CallEditSell();
			});

		})

		$("._buy_inf").click(function () {
			_load_s();
			Buy_();
		})

		$(".m_list_").click(function () {
			
			DisableQ($(".m_list_"), 1);
			$.post("./php/worker/worker.mail_list.php", function (data) {
				DisableQ($(".m_list_"), 2);
				_float_n(data);
			});

		})

		Loader(2); DisableQ(_call_module_, 2);
		EscC();
		$("._ovvvv_").fadeOut(200);

	});

}

function Ticket_() {
	
	$.post("./php/include/ticket.php", function (data) {
							
		$("._in_ovPane").html(data);

		$("._inA_Cal__").each(function function_name() {
			$(this).click(function () {
				var _inA_Cal__ = $(this).attr("id");
				$("._dim_1").fadeOut(0);
				$("._dim_09"+_inA_Cal__).fadeIn(0);
				if (_inA_Cal__ == 2) {
					$("._dim_09q1").fadeOut(0);
					$("._tab_name").html("Create Message");
				} else {
					$("._dim_09q1").fadeIn(0);
					$("._tab_name").html("My Message");
				}
			});
		});

		// Load Ticket
		LoadTicket(1);

		$("._c_ticket__").submit(function (e) { 
	  
			e.preventDefault();
			var formdata = new FormData(this);

			DisableQ($("._bbY_d"), 1);

			$.ajax({
			    url: "./php/worker/worker.create_ticket.php",
			    type: "POST",
			    data: formdata,
			    mimeTypes:"multipart/form-data",
			    contentType: false,
			    cache: false,
			    processData: false,

			    success: function(data){

			    	DisableQ($("._bbY_d"), 2);

			    	if (data.substring(0, 1) == 1) {
			    		LoadTicket(1);
			    		$("._c_ticket__").show(0).html("<div class='sux__'>Message created successfully <b style='font-size: inherit;'>#<?php echo $ticket_id; ?></b> <span class='pa' style='float: unset;'>U</span></div>");
			    	} else {
			    		_float_n(data);
			    	}
			    	
			    },error: function(){ DisableQ($("._bbY_d"), 1); _float_n("Internet connection is bad!"); }

			 });
		 
		});

		Loader(2); DisableQ(_call_module_, 2);
		EscC();
		$("._ovvvv_").fadeOut(200);

	});

}

function Buy_() {

	$.post("./php/include/buy.php", function (data) {
							
		$("._in_ovPane").html(data);
		$("._inp_c").click(function () {

			if ($(this).attr("seltd") == "on") {
				$("._inp_c").removeAttr("seltd").css({"background": "#EEE"});
				$("._t_c").val("");
				$("._in_tt_c").css({"color": "grey"});
			} else {
				$("._inp_c").attr("seltd", "on").css({"background": "#0400f6"});
				$("._t_c").val("1");
				$("._in_tt_c").css({"color": "#FFFFFF"});
			}

		});

		$("._inp_r").click(function () {

			if ($(this).attr("seltd") == "on") {
				$("._inp_r").removeAttr("seltd").css({"background": "#EEE"});
				$("._t_r").val("");
				$("._in_tt_r").css({"color": "grey"});
			} else {
				$("._inp_r").attr("seltd", "on").css({"background": "#0400f6"});
				$("._t_r").val("1");
				$("._in_tt_r").css({"color": "#FFFFFF"});
			}

		})

		// Process Buy Form
		$("._buy__").submit(function (e) { 

			e.preventDefault();
			var formdata = new FormData(this);

			DisableQ($("._bbY_d"), 1);
			Loader(1);

			$.ajax({
			    url: "./php/worker/worker.buy.php?sub_=1",
			    type: "POST",
			    data: formdata,
			    mimeTypes:"multipart/form-data",
			    contentType: false,
			    cache: false,
			    processData: false,

			    success: function(data){

			    	DisableQ($("._bbY_d"), 2); Loader(2);

			    	_float_n(data);
			    	
			    },error: function(){ DisableQ($("._bbY_d"), 1); Loader(1); _float_n("Internet connection is bad!"); }

			 });
		 
		});

	});

}

function Notification_() {
	$.post("./php/include/notification.php", function (data) {
				
		$("._in_ovPane").html(data);
		Loader(2); DisableQ(_call_module_, 2);
		EscC();

	});
}

function Wish_() {
	$.post("./php/include/wishlist.php", function (data) {
				
		$("._in_ovPane").html(data);

		$("._can_W").each(function () {
			var _WLST = $(this).attr("id");
			$(this).click(function () {
				var _this = $(this);
				_this.hide();
				$("#_l"+_WLST).show(0);
				var _sRc = "wDb";
				$.post("./php/worker/wish.php", {_WLST:_WLST, _sRc:_sRc}, function (data) {
					$("._hP").html(data);
					DisableQ(_this, 2);
				})
			})
		})

		Loader(2); DisableQ(_call_module_, 2);
		EscC();
		$("._ovvvv_").fadeOut(200);

	});
}

function MassiVModule() {
	$("._buy_inf").click(function () {
		_load_s();
		Buy_();
	})

	$("._sell_inf").click(function () {
		_load_s();
		Sell_();
	})

	$("._profile_inf").click(function () {
		_load_s();
		Sell_();
	})

	$("._order_inf").click(function () {
		_load_s();
		CallOrders();
	})
	$("._ticket_inf").click(function () {
		_load_s();
		Ticket_();
	})
	$("._wish_inf").click(function () {
		_load_s();
		Wish_();
	})
}

function CallOrders() {
	
	$.post("./php/include/orders.php", function (data) {
							
		$("._in_ovPane").html(data);
		EscC();

		$("._od_").each(function () {
			var _od_ = $(this).attr("id");

			$(this).click(function () {

				_load_s();
				$.post("./php/include/order_detail.php", {_od_:_od_}, function (data) {
					$("._flow_arena__OvL").html(data);
					
					$("._in_ovPane").html(data);
					EscC();

					$("._TrSt").each(function () {
						$(this).click(function (e) {

							var _TrSt = $(this).attr("id");
							// Review Product
							_load_s();
							$.post("./php/include/track_status.php", {_TrSt: _TrSt}, function (data) {
						
								$("._in_ovPane").html(data);
								EscC();

								// Claim - click
								$("._cf_pClmd").click(function () {

									// Claimed PRODO
									var _cf_pClmd = $(this).attr("id");
									_load_s();
									$.post("./php/include/review_product.php", {_cf_pClmd: _cf_pClmd}, function (data) {
								
										$("._in_ovPane").html(data);

										$("._radio_rate").each(function () {
											$(this).click(function () {
												var _radio_rate = $(this).attr("id");
												$("._RTT").val(_radio_rate);
											})
										})

										// Process Review Form
										$("._rTForm").submit(function (e) { 

											e.preventDefault();
											var formdata = new FormData(this);

											DisableQ($("._rvVw"), 1);
											$("._rvLoad").show(0);

											var urlLL = $("._rTForm").attr("action");

											$.ajax({
											    url: urlLL,
											    type: "POST",
											    data: formdata,
											    mimeTypes:"multipart/form-data",
											    contentType: false,
											    cache: false,
											    processData: false,

											    success: function(data){

											    	$("._rvLoad").hide(0);
											    	DisableQ($("._rvVw"), 2);
											    	_float_n(data);
											    	
											    },error: function(){ DisableQ($("._rvVw"), 1); $("._rvLoad").hide(0); _float_n("Internet connection is bad!"); }

											 });
										 
										});

										Loader(2); DisableQ(_call_module_, 2);
										EscC();
										$("._ovvvv_").fadeOut(200);

									});
									// ----------------- **
									
								});

								// Paid
								$("._mk_Pd").click(function () {
									var _mk_Pd = $(this).attr("id");
									$.post("./php/worker/worker.mkPd.php", {_mk_Pd: _mk_Pd}, function (data) {
										_float_n(data);
									});
								})

								$("._u_tr_detail").each(function () {
									$(this).click(function () {
										var _u_tr_detail = $(this).attr("id");
										$("._rvForm"+_u_tr_detail).slideToggle(200);
									})
								})

								$("._up_tr_form").each(function () {

									var this_ = $(this);
									this_.submit(function (e) { 

										e.preventDefault();
										var formdata = new FormData(this);

										// DisableQ($("._rvVw"), 1);

										var urlLL = this_.attr("data");

										$.ajax({
										  	url: "./php/worker/worker.update_track.php?od="+urlLL,
										    type: "POST",
										    data: formdata,
										    mimeTypes:"multipart/form-data",
										    contentType: false,
										    cache: false,
										    processData: false,
										    success: function(data){

												_float_n(data);
										    	DisableQ($("._bbY_d"), 2);
										    	
										    },error: function(){ DisableQ($("._rvVw"), 1); $("._rvLoad").hide(0); _float_n("Internet connection is bad!"); }

										 });
								 
									});
								})

								Loader(2); DisableQ(_call_module_, 2);
								$("._ovvvv_").fadeOut(200);

							});

						});

					});

				})

			})
		})

		DisableQ(_call_module_, 2);

	});

}