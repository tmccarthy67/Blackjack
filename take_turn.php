<?
require ('blackjack.php');

load_game();

$rank = $_GET['rank'];
$opponent = $_GET['opponent'];

$num_cards_received = get_cards_from("cards/" . $rank, $opponent);

if ($num_cards_received == 0) {
	go_fish();
}

check_for_books();

save_game();
header('Location: ./index.php');

?>
