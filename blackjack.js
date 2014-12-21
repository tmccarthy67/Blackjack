
function main(){
	$('img').on('click', function(){
		$('img').removeClass('selected');
		$(this).addClass('selected');
	});


	// $('.player-section').on('click', function(){
	// 	var player_id = $(this).data('playerid');
	// 	alert(player_id);
	// })
}


$(document).ready(main);
