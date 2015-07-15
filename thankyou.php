<!DOCTYPE html>
<!--[if lt IE 7]> <html lang="en-us" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>  <html lang="en-us" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>  <html lang="en-us" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en-us" class="no-js"> <!--<![endif]-->
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>Stripe Donation Form</title>
	<link rel="stylesheet" type="text/css" href="style.css" media="all">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

	<script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>
  <script>
      $( document ).ready(function() {
			     function getUrlParameter(sParam)
					{
					  var sPageURL = window.location.search.substring(1);
					  var sURLVariables = sPageURL.split('&');
					  for (var i = 0; i < sURLVariables.length; i++) 
					  {
					    var sParameterName = sURLVariables[i].split('=');
					    if (sParameterName[0] == sParam) 
					    {
					      return sParameterName[1];
					    }
					  }
					}   
				
		      var myDataRef = new Firebase('https://fundwall.firebaseio.com/donations');
		      var name = getUrlParameter('name');
		      var email = getUrlParameter('email');
		      var amount = getUrlParameter('amount'); ;
		      var message = getUrlParameter('message'); ;
		      myDataRef.push({name: name, email: email, amount: amount, message: message});

		      	window.setTimeout(function(){

				        // Move to a new location or you can do something else
				        window.location.href = "http://nickvw.be/fundwall/done.php";

				  }, 2500);
		   
		   });  
  </script>
</head>
<body>

	<div class="wrapper">

		<h1>
			FundWall
		</h1>

		<h2>
			Thank you for your donation!
		</h2>

		<a href="http://localhost:9999/donate/">
			Back to form
		</a>

	</div>

</body>
</html>
