$(document).ready(function(){

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

});