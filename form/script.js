/*
	Script for Simple Donation Form
	Handles validation and form processing
*/

$(function() {
	var $form        = $('.donation-form');
	var $otherAmount = $form.find('.other-amount');
	var $amount      = $form.find('.amount');
	var $segmented   = $form.find('.has-segmented-picker');
	var outputError = function(error) {
		$('.messages')
			.html('<p>' + error + '</p>')
			.addClass('active');
		$('.submit-button')
			.removeProp('disabled')
			.val('Submit Donation');
		$("html, body")
		  .animate({ scrollTop:102  },"slow");
	};
	var stripeResponseHandler = function(status, response) {
		if (response.error) {
			outputError(response.error.message);
		} else {
			var token = response['id'];
			$form.append('<input type="hidden" name="stripeToken" value="' + token + '">');
			$form.get(0).submit();
		}
	};
	var disableinput = function(amount) {
		$amount.val(amount).blur().prop('disabled');
		$amount.parent().addClass('hidden');
		$segmented.removeClass('stick-to-next');
	};
	var enableinput = function() {
		$amount.val('');
		$amount.parent().removeClass('hidden');
		$segmented.addClass('stick-to-next');
		$amount
			.removeProp('disabled')
			.focus();
	};

	$('.donation-form').on('submit', function(event) {
		// Disable processing button to prevent multiple submits
		$('.submit-button')
			.prop('disabled', true)
			.val('Processing...');

		// Very simple validation
		if ( $('.first-name').val() === '' ) {
			outputError('First name is required');
			$('.first-name').focus();
			return false;
		}

		if ( $('.email').val() === '' ) {
			outputError('Email is required');
			$('.email').focus();
			return false;
		}
		
		if ( $('.amount').val() === '' ) {
			outputError('Please make a donation amount');
			$('.other-amount').trigger('click');
			return false;
		}

		// Create Stripe token, check if CC information correct
		Stripe.createToken({
			name      : $('.first-name').val(),
			number    : $('.card-number').val(),
			cvc       : $('.card-cvc').val(),
			exp_month : $('.card-expiry-month').val(),
			exp_year  : $('.card-expiry-year').val()
		}, stripeResponseHandler);

		return false;
	});

	$('.form-amount label').on('click', function() {
		var $label = $(this);

		$label.addClass('active').parent().children('label').removeClass('active');

		if ( $label.parent().index() === 3 ) {
			enableinput();
		} else {
			disableinput($label.parent().find('input').val());
		}

	});

	$amount.on('change', function() {
		$otherAmount.val($(this).val());
	});

});
