<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Blackjack</title>

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

function dealer_hand($hand) {
	echo "<div class='hand'>";
	foreach ($hand as $card) {
		if ($card == $hand[0]) {
			$card = "cards_back.png";
			echo "<img src='$card'>";
		} else {
			echo "<img src='$card'>";
		}
	}
	echo "</div>";
}

function render_hand($hand) {
	// genereate html to show hands
	echo "<div class='hand'>";
	foreach ($hand as $card) {
		echo "<img src='$card'>";
	}
	echo "</div>";
}

function render_game() {
	global $NUM_PLAYERS, $GAME_STATE;

	$hands          = $GAME_STATE['hands'];
	$deck           = $GAME_STATE['deck'];
	$NUM_PLAYERS    = $GAME_STATE['number_of_players'];
	$player_counter = $GAME_STATE['counter'];

	if ($NUM_PLAYERS == $player_counter) {
		dealer_vs_player();
	}

	//generate HTML to show cards
	for ($i = 0; $i < $NUM_PLAYERS; $i++) {
		echo "<div class='player-section' data-playerid='$i'>";
		if ($i == 0) {
			$playername = "Dealer";
			$hand       = $hands[$i];
			echo "<h2> $playername </h2>";
			if ($player_counter < $NUM_PLAYERS-1) {
				echo "<div class='player-section' data-playerid=0>";
				dealer_hand($hand);
				echo "</div>";
			} else {
				render_hand($hand);
				echo "</div>";
			}
		} else {
			$playername        = "Player $i";
			$hand              = $hands[$i];
			$player_hand_score = card_count($hand);
			$number_cards      = count($hand);
			if ($i == $player_counter+1) {
				if ($number_cards == 2 && $player_hand_score == "Blackjack") {
					header("Location: ./stand.php");
				}
				echo "<h2> $playername <a href='hit.php?player=$i'><button type='button'>Hit</button></a><a href='stand.php?player=$i'><button type='button'>Stand</button></a> - $player_hand_score </h2>";
				render_hand($GAME_STATE['hands'][$i]);
				echo "</div>";
			} else {
				echo "<h2> $playername - $player_hand_score </h2>";
				render_hand($GAME_STATE['hands'][$i]);
				echo "</div>";
			}
		}
	}
}

function score_card($card) {
	// card values from image name
	$card_name = substr($card, 6);
	$rank      = explode("_", $card_name)[0];
	if ($rank == 'ace') {
		return 11;
	}
	if ($rank == 'king') {
		return 10;
	}
	if ($rank == 'queen') {
		return 10;
	}
	if ($rank == 'jack') {
		return 10;
	} else {
		return $rank;
	}
}

function card_count($hand) {
	global $NUM_PLAYERS, $GAME_STATE;
	// calculate scores
	$score_total  = 0;
	$aces         = 0;
	$number_cards = count($hand);
	foreach ($hand as $card) {
		$current_card = score_card($card);
		if ($current_card == 11) {
			$aces = $aces+1;
		}
		$score_total = $score_total+$current_card;
		if ($score_total > 21 && $aces > 0) {
			$score_total = $score_total-10;
			$aces        = $aces-1;
		}
	}
	if ($number_cards == 2 && $score_total == 21) {
		//set score to blackjack
		$score_total = "Blackjack";
	}
	return $score_total;
}

function dealer_vs_player() {
	//compare dealers hand to player hand
	global $NUM_PLAYERS, $GAME_STATE;
	$hands         = $GAME_STATE['hands'];
	$dealers_hand  = $hands[0];
	$dealers_score = card_count($dealers_hand);
	for ($i = 1; $i < $NUM_PLAYERS; $i++) {
		$players_score = card_count($hands[$i]);
		if ($players_score == "Blackjack") {
			$players_score = 21;
		}
		if ($players_score > 21) {
			echo "Player $i - Bust";
			echo "<br>";
		} else {
			if ($dealers_score > 21) {
				echo "Player $i - wins";
				echo "<br>";
			} else {
				if ($dealers_score > $players_score) {
					echo "Player $i - loses";
					echo "<br>";
				}
				if ($dealers_score < $players_score) {
					echo "Player $i - wins";
					echo "<br>";
				}
				if ($dealers_score == $players_score) {
					echo "Player $i - push";
					echo "<br>";
				}
			}
		}
	}
}

if (isset($_SESSION['state'])) {
	//load game state from session
	$GAME_STATE = $_SESSION['state'];
	render_game();
} else {
	echo "error - GAME_STATE".var_dump($GAME_STATE);
}

for ($i = 0; $i < $NUM_PLAYERS; $i++) {
	global $NUM_PLAYERS, $GAME_STATE;
	$hands = $GAME_STATE['hands'][$i];
}

$_SESSION['state'] = $GAME_STATE;
?>
