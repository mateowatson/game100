<?php
namespace F3AppSetup\Controller;

use F3AppSetup\Domain\HangmanAPI;
use F3AppSetup\Model\Game as GameModel;
use F3AppSetup\Model\UserGame;
use F3AppSetup\Model\User;

class Game extends Middleware\User {
    public function __construct($f3, $params, $csrf_fail_redirect = '/') {
        parent::__construct($f3, $params, $csrf_fail_redirect);
        $this->csrf_fail_redirect = '/dashboard';
    }

    public function createGame() {
        $game_type = isset($this->request['game-type']) ? $this->request['game-type'] : null;
        if($game_type === 'hangman') {
            $hangman = new HangmanAPI();
            $response = $hangman->createGame($this->session_user);
            if(!$response['success']) {
                $this->f3->merge('session_errors', $response['errors'], true);
                $this->reroute('/dashboard');
            }
            $this->f3->merge('session_confirmations', array(
                _('Game created.')
            ), true);
            $this->reroute('/hangman/game/'.urlencode($response['game_uuid']));
        }
    }

    public function sendGameInvite() {
        $game_uuid = $this->params['uuid'];
        $invitee = $this->params['invitee'];
        $game = new GameModel();
        $game_obj = $game->load(array('uuid = ?', $game_uuid));
        if($game_obj->game_type === 'hangman') {
            $hangman = new HangmanAPI();
            $hangman->addUserToGame($game_obj);
        }
        // $game = new GameModel();
        // $game_obj = $game->load(array('uuid = ?', $game_uuid));
        // $user = new User();
        // $invitee_obj = $user->load(array('username = ?', $invitee));
        // if($game_obj->dry() || $invitee_obj->dry()) {
        //     echo 'Failed to send invite';
        //     return false;
        // }
        // $user_game = new UserGame();
        // $user_game->addUserToGame($invitee_obj->id, $game_obj->id);
        // if($game_obj->game_type === 'hangman') {
        //     $hangman = new HangmanAPI();
        //     $hangman->addUserToGame($game_obj);
        // }
        // echo 'Sent invite';
        // return true;
    }
}