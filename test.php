<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>TEST</title>

  <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script src="blackjack.js"></script>

	<link rel="stylesheet" href="styles.css">
</head>
<body>
<?php

session_start();
// load game from session
$GAME_STATE = $_SESSION['state'];

function render_hand($hand) {
	// echo $hand;
	echo "<div class='hand'>";
	foreach ($hand as $card) {
		echo "<img src='$card'>";
	}
	echo "</div>";
}

function dealer_hand($hand) {
	echo "<div class='hand'>";
	foreach ($hand as $card) {
		if ($card == $hand[0]) {
			$card = "Cards/cards_back.png";
			echo "<img src='$card'>";
		} else {
			echo "<img src='$card'>";
		}
	}
	echo "</div>";
}

function render_game() {
	global $NUM_PLAYERS, $GAME_STATE;

	$hands = $GAME_STATE['hands'];

	$deck           = $GAME_STATE['deck'];
	$NUM_PLAYERS    = $GAME_STATE['number_of_players'];
	$player_counter = $GAME_STATE['counter'];
	$hand           = $hands[0];

	// cover one of dealers cards
	//can use counter compared to numplayers to make switch

	//generate HTML to show cards
	// generate_html ();
	echo "<div class='player-section' data-playerid=0>";
	$playername = "Dealer";
	echo "<h2> $playername </h2>";
	render_hand($hand);
	echo "</div>";

	echo "<br>";

	// echo $player_counter;
	// echo "<br>";
	// echo $NUM_PLAYERS;
	// echo "<br>";

	if ($player_counter < $NUM_PLAYERS-1) {
		echo "<div class='player-section' data-playerid=0>";
		dealer_hand($hand);
		echo "</div>";
	}

}

render_game();
?>