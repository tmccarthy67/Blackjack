<?
session_start();
// load game from session
$GAME_STATE = $_SESSION['state'];

$deck = $GAME_STATE['deck'];

$hands = $GAME_STATE['hands'];

$hand = $hands[0];

$player_counter = $GAME_STATE['counter'];

function score_card($card) {
	$card_name = substr($card, 6);

	$rank = explode("_", $card_name)[0];
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

function dealer_draw() {
	global $GAME_STATE;
	$deck  = $GAME_STATE['deck'];
	$hands = $GAME_STATE['hands'];
	$hand  = $hands[0];

	$card = array_pop($deck);// remove card from deck
	array_push($hand, $card);// add that card to the players hand

	$hands[0]            = $hand;// update all hands
	$GAME_STATE['deck']  = $deck;
	$GAME_STATE['hands'] = $hands;
	$_SESSION['state']   = $GAME_STATE;

	card_count($hand);
}

function card_count($hand) {
	global $NUM_PLAYERS, $GAME_STATE;
	$score_total = 0;
	$aces        = 0;
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
	check_bust($score_total, $hand);
	return;
}

function check_bust($score_total, $hand) {
	global $NUM_PLAYERS, $GAME_STATE;
	$GAME_STATE     = $_SESSION['state'];
	$player_counter = $GAME_STATE['counter'];
	if ($score_total > 21) {
		echo $player_counter;
		echo "<br>";
		$player_counter++;
		echo $player_counter;
		$GAME_STATE['counter'] = $player_counter;
		$_SESSION['state']     = $GAME_STATE;
		header("Location: ./index.php");
		return;
	}
	if ($score_total > 16) {
		echo $player_counter;
		echo "<br>";
		$player_counter++;
		echo $player_counter;
		$GAME_STATE['counter'] = $player_counter;
		$_SESSION['state']     = $GAME_STATE;
		header("Location: ./index.php");
		return;
	} else {
		dealer_draw();
	}
}

$hand = $GAME_STATE['hands'][0];
card_count($hand);

?>