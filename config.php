<?php

return array(

    // Enable test mode (not require HTTPS)
    'test-mode'       => false,

    // Secret Key from Stripe.com Dashboard
    'secret-key'      => 'sk_test_0YjH63C2adnn9sksyHeAKsVp',

    // Publishable Key from Stripe.com Dashboard
    'publishable-key' => 'pk_test_zpURMKzDvRiFGEEBAonz8Ru2',

    // Where to send upon successful donation (must include http://)
    'thank-you'       => 'http://localhost:9999/donate/thankyou.html',

    // Who the email will be from.
    'email-from'      => 'test@test.com',

    // Who should be BCC'd on this email. Probably an administrative email.
    'email-bcc'       => 'nick@digiti.be',

    // Subject of email receipt
    'email-subject'   => 'Thank you for your donation!',

    // Email message. %name% is the donor's name. %amount% is the donation amount
    'email-message'   => "Dear %name%,\n\nThank you for your donation of %amount%. We rely on the financial support from people like you to keep our cause alive. Below is your donation receipt to keep for your records."

);
