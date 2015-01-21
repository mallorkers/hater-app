$(document).ready(function(){

//TODO: Clean this shit
//TODO: Create a simple framework for preventing default form's being sended the normal way
// and force sending them via ajax

	var opacity1 = { opacity: 1 };
	var opacity0 = { opacity: 0 };
	var send_container_down = { top: (16 * 4) - 1 };
	var send_container_up = { top: -(16*15) + 1}
	var container_down = false;

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

	$(".send_publication").on('click', function(){
		if(!container_down)
		{
			$('.send_container').animate(send_container_down, 300);
			container_down = true;
		}
		else
		{
			$('.send_container').animate(send_container_up, 300);
			container_down = false;
		}
	});

	$("#user_input").on('input', function(event){
		var input = $(this);
		var regex = /([A-Z]|[0-9]|_)+/i;
		if( input.val().length === 0 ) return;
		var match = regex.exec( input.val() )[0];
		if( input.val().length >= 4 &&
			input.val().length <= 10 &&
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

	$('#tag_selector').on('change', function(event){
		event.preventDefault();
		selectedOption = $(this).find(':selected');
		if( $(".tag_viewer .tag").length === 3 ) return;
		createTagElement( $(".tag_viewer"), selectedOption.text() );
		selectedOption.hide();
	});

	$('.multiple_button button').on('click', function(event){
		event.preventDefault();
		$(this).siblings().removeClass('active_button');
		$(this).addClass('active_button');
	});

	function createTagElement(parentElement, tagText)
	{
		var tag = $(document.createElement("span"));
		var tag_graphic = $(document.createElement("div"));
		tag.addClass("tag");
		tag_graphic.addClass("tag_graphic")
		tag.text(tagText);
		tag.prepend(tag_graphic);
		parentElement.append(tag);
	}

});