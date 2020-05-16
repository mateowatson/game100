<?php require_once(dirname(__DIR__).'/partials/header.php'); ?>
<h1>Hangman</h1>
<div id="hangmanapp" data-csrf="<?php echo $SESSION['csrf']; ?>"></div>
<?php require_once(dirname(__DIR__).'/partials/footer.php');