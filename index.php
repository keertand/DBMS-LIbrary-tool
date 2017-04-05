<html>



<head>

<title>Db Library Management system</title>


	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	

    <!-- Bootstrap Core JavaScript -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	
	<link rel="stylesheet" href="css/theme.css"/>


	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.2.0/jquery.rateyo.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.2.0/jquery.rateyo.min.js"></script>
	
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
	
</head>

<body>

<?php 
include "db.php";
?>

<div class="row">


<div class="row searchcontainer">
<div class="col-xs-10 col-sm-10 col-md-8 col-lg-8 col-xs-offset-1 col-sm-offset-1 col-md-offset-2 col-lg-offset-2 search">

<input type="text" id="searchbar" placeholder="Search for books / authors" />

<span class="glyphicon glyphicon-search"></span>
<span class="glyphicon glyphicon-th"></span>
<div class="row">
<div class="col-xs-10 col-sm-10 col-md-8 col-lg-8 col-xs-offset-1 col-sm-offset-1 col-md-offset-2 col-lg-offset-2 catcontainer">
<p>Advanced Book Search:</p>
<ul><form id="catform">
<li><input type="text" name="category" placeholder="ISBN"></input> 
	  </li>
  <?php
    
	   echo '<li><input type="text" name="category" placeholder="Title"></input></li>';
	   echo '<li><input type="text" name="category" placeholder="Author"></input></li>';
	  
	  echo '<li><button class="btn btn-primary">Search</button></li>';
  ?>
</form></ul>
</div>
</div>

</div>
</div>

<div class="hrefs">
<a href="#bookloans"><button class="btn btn-primary">Book Loans</button></a>
<a href="#borrow"><button class="btn btn-primary">Add Borrowers</button></a>
<a href="#fines"><button class="btn btn-primary">Fine and Dues</button></a>

</div>

</div>



<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 resultbox">
<div id="#res" class="row"></div>
</div>
</div>


<div class="row" id="bookloans">
<h3>Book Loans</h3>




<?php

if(isset($_GET['isbn']))
{
$isbn = $_GET['isbn'];
$isbn = rtrim($isbn,"/");
}
else
{
$isbn = "";
}
?>


<ul><li><h4>Book CheckOut</h4></li></ul>
<form>
<ul>
<li><span class="error"></span></li>
<li><input id="checkout_isbn" type="text" required="true" Placeholder="Book Isbn" <?php echo 'value="'.$isbn . '"';?>/></li>
<li><input id="checkout_cardno" type="text" required="true" Placeholder="Borrower Card No"/></li>
<li><input id="checkout" class="btn btn-primary" type="submit" value="Check out Book" /></li>

</ul>
</form>



<div id="check_output" class="row">
</div>
<?php

if(isset($_GET['checkin']))
{
$checkin_isbn = $_GET['checkin'];
$checkin_isbn = rtrim($checkin_isbn,"/");
}
else
{
$checkin_isbn = "";
}
?>

<ul><li><h4>Book CheckIN</h4></li></ul>
<form>
<ul>
<li><input id="checkin_isbn" type="text" required="true" Placeholder="Book Isbn" value="<?php echo $checkin_isbn;?>" /></li>
<li><input id="checkin" class="btn btn-primary" type="submit" value="Book checkIn" /></li>

</ul>
</form>

<form>
<ul>
<li><input id="checkin_cardid" type="text" Placeholder="Card ID"/> OR
<input id="checkin_name" type="text" Placeholder="Borrower Name"/></li>
<li><input id="find_checkin" class="btn btn-primary" type="submit" value="Find Book to Check In" /></li>
</ul>
</form>


</div>

<hr>

<div class="row" id="borrow">

<h3>Add a new Borrower</h3>
<form>
<ul>
<li><span class="error"></span></li>
<li><input id="borrow_fname" type="text" style="width:250px;" required="true" Placeholder="First name"/><input id="borrow_lname" style="width:250px;" type="text" required="true" Placeholder="Last name"/></li>
<li><input id="borrow_ssn" type="text" required="true" Placeholder="ssn"/></li>
<li><input id="borrow_addr" type="text" required="true" Placeholder="Address( Dont use /,-,:,#,$,&, etc. )"/></li>
<li><input id="borrow_phone" type="text" required="true" Placeholder="Phone number"/></li>
<li><input id="borrow_btn" class="btn btn-primary" type="submit" value="Add new Borrower" /></li>
<li><span id="borrow_output"></span></li>
</ul>
</form>

</div>

<hr>

<div class="row" id="fines">
<h3>Fines and Dues</h3>

<button id="fineupdate" class="btn btn-primary" >Update Fines</button>
<br><br>
<span>Enter Borrower card_id  to view fines</span>
<ul>
<li><span class="error"></span></li>
<li><input type="text" id="ctl_cardno" required="true" Placeholder="Card No"/></li>
<li><input type="radio" id="ctl_radio" value="0" name="ctl_radio">Paid</input>
<input type="radio" id="ctl_radio" value="1" name="ctl_radio">Unpaid</input>
</li>
<li><button id="fineborrower" class="btn btn-primary" type="submit" >Find Fines</button></li>

</ul>

<div id="fineresults">

</div>



</div>

<hr>

</body>

<script>
$('.search .glyphicon-th').on('click',function(){
			
			$('.catcontainer').slideToggle("fast");
		});
		/*
	document.querySelector('#txtSearch').addEventListener('keypress', function (e) {
    var key = e.which || e.keyCode;
    if (key === 13) { // 13 is enter
      search(0);
    }
	});'
	
	*/
	
	
	
	
	
	
	
		function search(z)
			{
				var x = $("#searchbar").val();
				document.getElementById('#res').innerHTML = "Searching.......";
				
				y = 0;
				$.ajax({
				type:'POST',
				url: "search.php",
					data: {flag1: x,flag2: y, flag3: z},
					success: function(result){
						result = $.trim(result);	
					  document.getElementById('#res').innerHTML = result;
					 
					  },
					error: function(err,e1,e2){alert(err.status+e1+e2);},
					complete: function(obj){setimages();}
				 });
					
			}
			
			$(".glyphicon-search").on('click',function(){
				
				search(0);
				
			});
			
			
			
			$("#bookloans #checkout").on('click',function(){
				
				var x = $("#bookloans #checkout_isbn").val();
				var y = $("#bookloans #checkout_cardno").val();
				
				
				$.ajax({
				type:'POST',
				url: "bookcheckout.php",
					data: {flag1: x, flag2: y},
					success: function(result){
						result = $.trim(result);	
						alert(result);
					  document.getElementById('check_output').innerHTML = result;
					 }
					
				 });
				
				
			});
			
			
			$("#bookloans #checkin").on('click',function(){
				
				var x = $("#bookloans #checkin_isbn").val();
				
				
				$.ajax({
				type:'POST',
				url: "bookcheckin.php",
					data: {flag1: x},
					success: function(result){
						result = $.trim(result);	
						document.getElementById('check_output').innerHTML = result;
					 }
					 
					 });
				
			});
			
			
			$("#bookloans #find_checkin").on('click',function(){
				
				var x = $("#bookloans #checkin_cardid").val();
				var y = $("#bookloans #checkin_name").val();
				
				
				$.ajax({
				type:'POST',
				url: "find_bookcheckin.php",
					data: {flag1: x, flag2: y},
					success: function(result){
						result = $.trim(result);	
						document.getElementById('check_output').innerHTML = result;
					 }
				});
				
			});
			
			$("#borrow #borrow_btn").on('click',function(){
				
				var x = $("#borrow #borrow_fname").val();
				var a = $("#borrow #borrow_lname").val();
				var y = $("#borrow #borrow_ssn").val();
				var z = $("#borrow #borrow_addr").val();
				var b = $("#borrow #borrow_phone").val();
				 
				alert(x+a+y+z+b);
				
				$.ajax({
				type:'POST',
				url: "borrower.php",
					data: {flag1: x, flag2: y, flag3: z, flag4: a, flag5: b},
					success: function(result){
						result = $.trim(result);	
						alert(result);
					  document.getElementById('borrow_output').innerHTML = result;
					 }
					 });
				
				
			});
			
			$("#fineupdate").on('click',function(){
				document.getElementById('fineresults').innerHTML = "Updating...";
					 
				var x = 0;
				$.ajax({
				type:'POST',
				url: "updatefines.php",
					data: {flag1: x},
					success: function(result){
						result = $.trim(result);	
						
						document.getElementById('fineresults').innerHTML = result;
					 },
					error: function(err,e1,e2){alert(err.status+e1+e2);},
					complete: function(obj){setimages();}
				 });
			});
			
			
			$("#fineborrower").on('click',function(){
				
				var x = 0;
				$.ajax({
				type:'POST',
				url: "updatefines.php",
					data: {flag1: x},
					success: function(result){
						result = $.trim(result);	
						//document.getElementById('fineresults').innerHTML = result;
					 },
					error: function(err,e1,e2){alert(err.status+e1+e2);},
					complete: function(obj){setimages();}
				 });
				
				x = $("#ctl_cardno").val();
				
				y = $('input[name="ctl_radio"]:checked').val();
				if(y==undefined) y = 1;
				
				$.ajax({
				type:'POST',
				url: "fineholders.php",
					data: {flag1: x, flag2: y},
					success: function(result){
						result = $.trim(result);	
							
					 document.getElementById('fineresults').innerHTML = result;
					  },
					error: function(err,e1,e2){alert(err.status+e1+e2);},
					complete: function(obj){setimages();}
				 });
				
				
			});
			
			

		function pay()
		{
			var x = $('#finepaymentbutton').attr('data-id');
				
				$.ajax({
				type:'POST',
				url: "payfine.php",
					data: {flag1: x},
					success: function(result){
						result = $.trim(result);	
						
					  document.getElementById('fineresults').innerHTML = result;
					  },
					error: function(err,e1,e2){alert(err.status+e1+e2);},
					complete: function(obj){setimages();}
				 });
		}
		
</script>

</html>