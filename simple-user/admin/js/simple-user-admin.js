(function( $, ajax ) {
	'use strict';
	var CREATE_FORM = 'form#Simple-User--createuser';
	var SUBMIT_BUTTON = '#Simple-User--createuser-submit';

	function disableSubmitButton() {
		$(SUBMIT_BUTTON).prop('disabled', true);
	}

	function enableSubmitButton() {
		$(SUBMIT_BUTTON).prop('disabled', false);
	}

	function createUserHandler(event) {
		event.preventDefault();
		console.log('From submitted!');
		disableSubmitButton();

		// setTimeout(function () { enableSubmitButton(); }, 2000);
		$.post(ajax.ajax_url, {
			_ajax_nonce: ajax.nonce,
			action: 'simple_user_create_user',
			echo: 'It is working!',
		}, function (data) {
			enableSubmitButton();

			console.log('Data: ', data);
			$('#ajax-response').html('<pre>' + JSON.stringify(data, null, 2) + '</pre>');
		}).fail(function (err) {
			console.log('Failed:', err);
		});
	}

	$(CREATE_FORM).submit(createUserHandler);
})( jQuery, simple_user_ajax );
