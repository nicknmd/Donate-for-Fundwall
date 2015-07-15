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
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>
<body>
  <div class="app">
    <form action="#" method="POST" class="donation-form">
      <div class="modal">
        
        <header>
          <div class="logo">
            <img src="assets/logo.svg" />
          </div>
          <h2>Belcham</h2>
          <h3>Help us to raise funds to support Belgian students in the USA.</h3>
        </header>
    
        <div class="messages">
          <!-- Error messages go here go here -->
        </div>
        
        <section>
          
          <h1 style="font-weight: 700">
			Donation Succeeded! 
		  </h1>
		  <br>
		  <h2>
				Thank you for your donation.
		  </h2>
		  <br>
		   <a href="http://nickvw.be/fundwall">
				Back to form
		   </a>
          
        </section>
        
        
      </div>
    </form>
  </div>

  <script>if (window.Stripe) $('.donation-form').show()</script>
  <noscript><p>JavaScript is required for the donation form.</p></noscript>

</body>
</html>
