<?php
namespace F3AppSetup\Controller\Games;

use F3AppSetup\Domain\HangmanAPI;

class Hangman extends \F3AppSetup\Controller\Middleware\User {
    public function show() {
        echo \View::instance()->render('games/hangman.php');
    }
}