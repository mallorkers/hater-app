$(document).ready(function(){

	$('.login_button').on('click', function(){
		$('.login_screen').removeClass('hidden');
	});

	$('.login_screen').on('click', function(event){
		if(event.target.id === 'target')
		{
				$('.login_screen').addClass('hidden');
		}
	});

});