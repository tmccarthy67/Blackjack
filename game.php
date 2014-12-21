<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Blackjack</title>

	<link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
require ('gofish.php');

load_game();
render_game();
?>


<form action="take_turn.php" method="GET">
	<h4>Player <?=$GAME_STATE['current_player']+1?>'s turn</h4>


	<label for="rank">Rank:</label>
	<input type="text" name="rank" >

	<br/>

	<label for="opponent">From:</label>
	<select name="opponent">
		<option value="0">Player 1</option>
		<option value="1">Player 2</option>
		<option value="2">Player 3</option>
		<option value="3">Player 4</option>
	</select>

	<input type="submit" >
	<h3>Scores:</h3>
	<p>Player 1: <?=get_player_score(0)?></p>
	<p>Player 2: <?=get_player_score(1)?></p>
	<p>Player 3: <?=get_player_score(2)?></p>
	<p>Player 4: <?=get_player_score(3)?></p>

</form>

</body>
</html>
