<?

session_start();

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

function check_aces($score_total, $aces) {
	//checks for aces value 1 or 11
	if ($score_total > 21 && $aces > 0) {
		$score_total = $score_total-10;
		$aces        = $aces-1;
		return $score_total;
	} else {
		return $score_total;
	}
}

function card_count($hand) {
	global $NUM_PLAYERS, $GAME_STATE;
	$score_total = "";
	$aces        = 0;
	foreach ($hand as $card) {
		$current_card = score_card($card);
		if ($current_card == 11) {
			$aces++;
		}
		$score_total = $score_total+$current_card;
		if ($score_total > 21 && $aces > 0) {
			$score_total = $score_total-10;
			$aces        = $aces-1;
		}
	}
	check_bust($score_total);
}

function check_bust($score_total) {
	//check card total for bust
	if ($score_total > 21) {
		header("Location: ./stand.php");
	} else {
		header("Location: ./index.php");
	}
}

// load game from session
$GAME_STATE = $_SESSION['state'];

$deck = $GAME_STATE['deck'];

$hands  = $GAME_STATE['hands'];
$player = $_GET['player'];
$hand   = $hands[$player];

$card = array_pop($deck);// remove card from deck
array_push($hand, $card);// add that card to the players hand
$hands[$player] = $hand;// update all hands

$GAME_STATE['deck']  = $deck;
$GAME_STATE['hands'] = $hands;

$_SESSION['state'] = $GAME_STATE;

card_count($hand);

?>