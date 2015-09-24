<!DOCTYPE html>
<!--[if lt IE 7]> <html lang="en-us" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>  <html lang="en-us" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>  <html lang="en-us" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en-us" class="no-js"> <!--<![endif]-->
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>BelCham - Donate now</title>
  <link rel="stylesheet" type="text/css" href="assets/css/style.css" media="all">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <script>
      jQuery(document).ready(function($) {

      if (window.history && window.history.pushState) {

        $(window).on('popstate', function() {
          var hashLocation = location.hash;
          var hashSplit = hashLocation.split("#!/");
          var hashName = hashSplit[1];

          if (hashName !== '') {
            var hash = window.location.hash;
            if (hash === '') {
              alert('Thank you! Come again.');
                window.location='http://belcham.org/donate';
                return false;
            }
          }
        });

        window.history.pushState('forward', null, './#forward');
      }

    });
    </script> 
</head>
<body>
  <div class="app">
    <form action="#" method="POST" class="donation-form">
      <div class="modal">
        
        <header>
          <div class="logo">
            <img src="assets/img/logo.svg" />
          </div>
          <h2>BelCham</h2>
          <h3>Support Belcham and win fantastic prizes!</h3>
        </header>
    
        <div class="messages">
          <!-- Error messages go here go here -->
        </div>
        
        <section>
          <div class="large-icon"><em class="icon">v</em></div>
          <h1> Thank you for your donation. </h1>
          <p class="center"> We have sent you a receipt-email from this donation.</p>
        </section>
        
        <footer>
    		  <a href="http://belcham.org/donate" class="btn btn-m btn-action"> Back To Form </a>
        </footer>
        
        
      </div>
    </form>
  </div>

  <script>if (window.Stripe) $('.donation-form').show()</script>
  <noscript><p>JavaScript is required for the donation form.</p></noscript>

</body>
</html>
