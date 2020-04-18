<?php
namespace F3AppSetup\Controller;

use F3AppSetup\Domain\HangmanAPI;

class Game extends Middleware\User {
    public function __construct($f3, $params, $csrf_fail_redirect = '/') {
        parent::__construct($f3, $params, $csrf_fail_redirect);
        $this->csrf_fail_redirect = '/dashboard';
    }

    public function createGame() {
        $game_type = isset($this->request['game-type']) ? $this->request['game-type'] : null;
        if($game_type === 'hangman') {
            $hangman = new HangmanAPI();
            $response = $hangman->createGame($this->session_user->id);
            if(!$response['success']) {
                $this->f3->merge('session_errors', $response['errors'], true);
                $this->reroute('/dashboard');
            }
            $this->f3->merge('session_confirmations', array(
                _('Game created.')
            ), true);
            $this->reroute('/hangman/'.urlencode($response['game_uuid']));
        }
    }
}