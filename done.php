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
          
          <h1>
			Donation Succeeded! 
		  </h1>

		  <h2>
				Thank you for your donation.
		  </h2>

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
