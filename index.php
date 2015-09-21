<?php

// Load Stripe
require('lib/Stripe.php');

// Load configuration settings
$config = require('config.php');

/*
Force https
if ($config['test-mode'] && $_SERVER['HTTPS'] != 'on') {
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: https://' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
  exit;
}
*/

if ($_POST) {
    Stripe::setApiKey($config['secret-key']);

    // POSTed Variables
    $token      = $_POST['stripeToken'];
    $name = $_POST['first-name'];
    //$last_name  = $_POST['last-name'];
    $email      = $_POST['email'];
    $message     = $_POST['message'];
    $amount     = (float) $_POST['amount'];
    $chance = $amount/25;
    $chances = round($chance, 1); 

    try {
        if ( ! isset($_POST['stripeToken']) ) {
            throw new Exception("The Stripe Token was not generated correctly");
        }

        // Charge the card
        $donation = Stripe_Charge::create(array(
            'card'        => $token,
            'description' => 'Donation by ' . $name . ' (' . $email . ') - ' . $message,
            'amount'      => $amount * 100,
            'currency'    => 'usd'
        ));


        // Build and send the email
        $headers = 'From: info@belcham.org' . "\r\n" .
		'Reply-To: info@belcham.org' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
     	$headers .= "MIME-Version: 1.0" . "\r\n";
	 	$headers .= "Content-Type: text/html; charset=ISO-8859-1" . "\r\n";

        // Find and replace values
        $find    = array('%name%', '%amount%', '%chances%');
        $replace = array($name, '$' . $amount, $chances);

        $body = str_replace($find, $replace , $config['email-message']) . "\n\n";
        $body .= '<br>Amount: $' . $amount . "\n";
        $body .= '<br>Email: ' . $email . "\n";
        $body .= '<br>Date: ' . date('M j, Y, g:ia', $donation['created']) . "\n";
        $body .= '<br>Transaction ID: ' . $donation['id'] . "\n\n\n";

        $subject = $config['email-subject'];

        // Send it
        if ( !$config['test-mode'] ) {
            mail($email,$subject,$body,$headers);
        }

        // Forward to "Thank You" page
        header("Location: http://client.digiti.be/donate/thankyou.php?name=$name&email=$email&amount=$amount&message=$message");
        exit;

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
   
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Belcham - Donate now</title>
  <link rel="stylesheet" type="text/css" href="assets/css/style.css" media="all">
  <script type="text/javascript" src="https://js.stripe.com/v2"></script>
  <script type="text/javascript">
    Stripe.setPublishableKey('<?php echo $config['publishable-key'] ?>');
  </script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script type="text/javascript" src="script.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>
<body>
  <div class="app">
    <form action="#" method="POST" class="donation-form">
      <div class="modal">
        
        <header>
          <div class="logo">
            <img src="assets/img/logo.svg" />
          </div>
          <h2>Belcham</h2>
          <h3>Help us to raise funds to support Belgian students in the USA.</h3>
        </header>
    
        <div class="messages">
          <!-- Error messages go here go here -->
        </div>
        
        <section>
          
          <div class="form-row has-icon form-first-name">
            <input type="text" name="first-name" class="first-name text" placeholder="Your name">
            <em class="icon">u</em>
          </div>
          
          <div class="form-row has-icon form-email">
            <input type="text" name="email" class="email text" placeholder="Your email">
            <em class="icon">e</em>
          </div>
  
          <div class="form-row has-icon form-message">
            <input type="text" row="3" name="message" class="message text" placeholder="Optional Message">
            <em class="icon">m</em>
          </div>
          
        </section>
        
        <section>
  
          <div class="form-row form-amount has-segmented-picker">
            <ul class="segemented-picker">
              <li class="set-amount">
                <input type="radio" name="amount-picker" value="25" id="amount-25" checked="checked">
                <label for="amount-25">$25</label>
              </li>
              <li class="set-amount">
                <input type="radio" name="amount-picker" value="50" id="amount-50">
                <label for="amount-50"> $50</label>
              </li>
              <li class="set-amount">
                <input type="radio" name="amount-picker" value="100" id="amount-100">
                <label for="amount-100"> $100</label>
              </li>
              <li class="other-amount">
                <input type="radio" name="amount-picker" value="0" id="amount-other">
                <label for="amount-other" class="other"> Other</label> 
              </li>
            </ul>
          </div>
          
          <div class="form-row has-icon stick-to-previous form-amount hidden">
            <input type="text" class="amount text" placeholder="Amount" name="amount" disabled>
            <em class="icon">$</em>
          </div>
          
          <div class="form-row has-icon form-number">
            <input type="text" autocomplete="off" class="card-number text" placeholder="0000 0000 0000 0000">
            <em class="icon">c</em>
          </div>
          
          <div class="form-row">
            <div class="pull-left">
              <select class="compact card-expiry-month" dir="rtl">
                <option value="" selected>Month</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>
              /
              <select class="compact card-expiry-year ">
                <option value="" selected>Year</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
            </select>
            </div>
            <div class="pull-right">
              <input type="text" autocomplete="off" class="card-cvc text compact" placeholder="CVC" size="10" maxlength="3">
            </div>
          </div>
        
        </section>
        
        <footer>
          <div class="form-row form-submit">
            <input type="submit" class="submit-button btn btn-action btn-full" value="Submit Donation">
          </div>
        </footer>
        
      </div>
    </form>
  </div>

  <script>if (window.Stripe) $('.donation-form').show()</script>
  <noscript><p>JavaScript is required for the donation form.</p></noscript>

</body>
</html>
