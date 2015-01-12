window.webdev_ajax = ( function( window, document, $ ){
	var app = {};

	app.cache = function(){
		app.$ajax_form = $( '.ajax_tut_form' );
	};

	app.init = function(){
		app.cache();
		app.$ajax_form.on( 'submit', app.form_handler );

	};

	app.post_ajax = function( serial_data ){
		var post_data = { 
			action     : 'webdev',
			nonce      : webdev.nonce,
			serialized : serial_data,
		};

		$.post( webdev.ajax_url, post_data, app.ajax_response, 'json' )
	};

	app.ajax_response = function( response_data ){
		if( response_data.success ){
			webdev.nonce = response_data.data.nonce;
			alert( response_data.data.script_response );
		} else {
			alert( 'ERROR' );
		}
	};

	app.form_handler = function( evt ){
		evt.preventDefault();
		var serialized_data = app.$ajax_form.serialize();
		app.post_ajax( serialized_data );
	};

	$(document).ready( app.init );

	return app;

})( window, document, jQuery );