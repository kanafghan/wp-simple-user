(function( $, ajax ) {
	'use strict';
	var CREATE_FORM = 'form#Simple-User--createuser';
	var SUBMIT_BUTTON = '#Simple-User--createuser-submit';
	var ERRORS = {
		invalidForm: '#Simple-User--error-invalid-form',
		notCreated: '#Simple-User--error-not-created'
	};
	var SUCCESS = '#Simple-User--success';
	var RESPONSE = '#Simple-User--ajax-response';

	function disableSubmitButton() {
		$(SUBMIT_BUTTON).prop('disabled', true);
	}

	function enableSubmitButton() {
		$(SUBMIT_BUTTON).prop('disabled', false);
	}

	function clearForm(form) {
		$(form).find('input').val('');
	}

	function displayError(errorSelector) {
		var $error = $(errorSelector).clone();
		$(RESPONSE).html($error.addClass('error'));
	}

	function displaySuccess() {
		var $error = $(SUCCESS).clone();
		$(RESPONSE).html($error.addClass('notice notice-success'));
	}

	function createUserHandler(event) {
		event.preventDefault();
		var form = event.target;
		var firstName, lastName, role;

		try {
			firstName = $(form).find('#first_name').val();
			lastName = $(form).find('#last_name').val();
			role = $(form).find('#role').val();
		} catch (error) {
			console.log(error);
			displayError(ERRORS.invalidForm);

			return;
		}

		if (!firstName || !lastName || !role) {
			console.log('Please fill the form correctly!');
			displayError(ERRORS.invalidForm);
			return;
		}

		console.log('Form submitted!', form, firstName + ' ' + lastName, role);
		disableSubmitButton();

		// setTimeout(function () { enableSubmitButton(); }, 2000);
		$.post(ajax.ajax_url, {
			_ajax_nonce: ajax.nonce,
			action: 'simple_user_create_user',
			first_name: firstName,
			last_name: lastName,
			role: role
		}, function (data) {
			enableSubmitButton();

			console.log('Data: ', data);
			displaySuccess();

			clearForm(form);
		}).fail(function (err) {
			enableSubmitButton();
			displayError(ERRORS.notCreated);
			console.log('Failed:', err);
		});
	}

	$(CREATE_FORM).submit(createUserHandler);
})( jQuery, simple_user_ajax );
