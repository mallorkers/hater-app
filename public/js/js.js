$(document).ready(function(){

//TODO: Clean this shit
//TODO: Create a simple framework for preventing default form's being sended the normal way
// and force sending them via ajax

	var opacity1 = { opacity: 1 };
	var opacity0 = { opacity: 0 };

	var options = {
		duration: 200,
		start: function(){ $('.login_screen').removeClass('hidden'); }
	};

	var options2 = {
		duration: 200,
		done: function(){ $('.login_screen').addClass('hidden'); }
	}

	$('.login_button').on('click', function(){
		$('.login_screen').animate(opacity1, options);
	});

	$('.login_screen').on('click', function(event){
		if(event.target.id === 'target')
		{
				$('.login_screen').animate(opacity0, options2);
		}
	});

	$(".submit_button").on('click', function(event){
		event.preventDefault();
		$.ajax("/login", {
			complete: function(data, status){ console.log(data); },
			data: { user_login_input: "asdasd", password_login_input: "passwordguapa" },
			type: 'POST'
		});
	});

	function show_data(data, status)
	{
		console.log(data);
	}

	$("#user_input").on('input', function(event){
		var input = $(this);
		var regex = /([A-Z]|[0-9]|_)+/i;
		var match = regex.exec( input.val() )[0];
		if( input.val().length >= 4 &&
			input.val().length <= 14 &&
			input.val().length == match.length )
		{
			input.removeClass("invalid_input");
			input.addClass("valid_input");
			$(".login_tip").hide(200);
		}
		else
		{
			input.addClass("invalid_input");
			input.removeClass("valid_input");
			$(".login_tip").show(200);
		}

	});

});