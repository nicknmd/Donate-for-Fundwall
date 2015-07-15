<?php

// Load Stripe
require('lib/Stripe.php');

// Load configuration settings
$config = require('config.php');

// Force https
// if ($config['test-mode'] && $_SERVER['HTTPS'] != 'on') {
//     header('HTTP/1.1 301 Moved Permanently');
//     header('Location: https://' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
//     exit;
// }

if ($_POST) {
    Stripe::setApiKey($config['secret-key']);

    // POSTed Variables
    $token      = $_POST['stripeToken'];
    $name = $_POST['first-name'];
    //$last_name  = $_POST['last-name'];
    $email      = $_POST['email'];
    $message     = $_POST['message'];
    $amount     = (float) $_POST['amount'];

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
        $headers = 'From: nick@digiti.be' . "\r\n" .
    'Reply-To: nick@digiti.be' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

        // Find and replace values
        $find    = array('%name%', '%amount%');
        $replace = array($name, '$' . $amount);

        $body = str_replace($find, $replace , $config['email-message']) . "\n\n";
        $body .= 'Amount: $' . $amount . "\n";
        $body .= 'Email: ' . $email . "\n";
        $body .= 'Date: ' . date('M j, Y, g:ia', $donation['created']) . "\n";
        $body .= 'Transaction ID: ' . $donation['id'] . "\n\n\n";

        $subject = $config['email-subject'];

        // Send it
        if ( !$config['test-mode'] ) {
            mail($email,$subject,$body,$headers);
        }

        // Forward to "Thank You" page
        header("Location: http://nickvw.be/fundwall/thankyou.php?name=$name&email=$email&amount=$amount&message=$message");
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
    <title>Stripe Donation Form</title>
    <link rel="stylesheet" type="text/css" href="style.css" media="all">
    <script type="text/javascript" src="https://js.stripe.com/v2"></script>
    <script type="text/javascript">
        Stripe.setPublishableKey('<?php echo $config['publishable-key'] ?>');
    </script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
</head>
<body>
    <div class="wrapper">
        <h1>
            FundWall
        </h1>

        <div class="messages">
            <!-- Error messages go here go here -->
        </div>

        <form action="#" method="POST" class="donation-form">
            <fieldset>
                <div class="form-row form-first-name">
                    <label>Name</label>
                    <input type="text" name="first-name" class="first-name text">
                </div>
                
                <div class="form-row form-email">
                    <label>Email</label>
                    <input type="text" name="email" class="email text">
                </div>

                <div class="form-row form-message">
                    <label><i>Optional Message</i></label>
                    <input type="text" row="3" name="message" class="message text">
                </div>

                <div class="form-row form-amount">
                    <label><input type="radio" name="amount" class="set-amount" value="25"> $25</label>
                    <label><input type="radio" name="amount" class="set-amount" value="50"> $50</label>
                    <label><input type="radio" name="amount" class="set-amount" value="100"> $100</label>
                    <label><input type="radio" name="amount" class="other-amount" value="0"> Other:</label> <input type="text" class="amount text" disabled>
                </div>
                <div class="form-row form-number">
                    <label>Card Number</label>
                    <input type="text" autocomplete="off" class="card-number text" value="4242424242424242">
                </div>
                <div class="form-row form-cvc">
                    <label>CVC</label>
                    <input type="text" autocomplete="off" class="card-cvc text" value="123">
                </div>
                <div class="form-row form-expiry">
                    <label>Expiration Date</label>
                    <select class="card-expiry-month text">
                        <option value="01" selected>January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                    <select class="card-expiry-year text">
                        <option value="2015" selected>2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                    </select>
                </div>
                <div class="form-row form-submit">
                    <input type="submit" class="submit-button" value="Submit Donation">
                </div>
            </fieldset>
        </form>
    </div>

    <script>if (window.Stripe) $('.donation-form').show()</script>
    <noscript><p>JavaScript is required for the donation form.</p></noscript>

</body>
</html>
