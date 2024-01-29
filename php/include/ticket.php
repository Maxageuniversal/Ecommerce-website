<script type="text/javascript">
	$("._side_l__").attr("style", "red");
	$(".dbh_tc").css({"color": "unset", "background": "#FFFFFF"});

	$("._tab_name").html("My Message");
	$("._in_lay_b").attr("id", "_in_lay_b_02");

</script>
<?php include "../db.php"; ?>

	<div class="rd_edge _p10">

		<div class="_ff">
			<a class="_in_Lk _inA_Cal__" id="1" href="#CT">My Message</a>
			<a class="_in_Lk _inA_Cal__" id="2" href="#CT">Create Message</a>
		</div>

		<div class="_ff _ctkk__ _dim_09q1" id="1"> </div>

		<form method="POST" class="_c_ticket__ _dim_1 _dim_092" enctype="multipart/form-data">

			<label class="_label__ mtop">Admin Office</label>
			<select class="_inp__" name="tc_dept">
				<option value="">Select department</option>
				<option value="sales">Sales</option>
				<option value="abuse">Abuse</option>
				<option value="inquiry">Inquiry</option>
				<option value="inquiry">Product Request</option>
				<option value="inquiry">Other</option>
			</select>

			<label class="_label__ mtop">Photo</label>
			<input class="_inp__" type="file" name="tc_image">

			<label class="_label__ mtop">Message Subject</label>
			<input class="_inp__" type="text" name="tc_sub" placeholder="e.g. How can I get paid?">

			<label class="_label__ mtop">Message Body</label>
			<textarea id="text_area" placeholder="Type Something Here" name="tc_body"></textarea>

			<input class="_inp__ button__ _bbY_d" type="submit" value="CREATE TICKET">

		</form>

	</div>

	<style >
		
#text_area{
  width: 255px;
  border-radius: 3px;
  resize : none;
  font-size: 15px;
  padding: 10px 40px 10px 10px;
  height: 40px;
}

textarea[id="text_area"]:focus{
  background : fff;
}
	</style>