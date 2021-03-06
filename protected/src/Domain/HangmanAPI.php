<?php

namespace F3AppSetup\Domain;

use F3AppSetup\Model\Game;
use F3AppSetup\Model\User;
use F3AppSetup\Model\UserGame;

class HangmanAPI {
    private $success = false;
    private $errors = array();
    private $game_state = null;
    private $game_uuid = null;
    private $game_id = null;

    public function createGame($user) {
        $game = new Game();
        $game_state = $this->getInitialStateJSON($user);
        if(!$game->gameCreate($user, 'hangman', $game_state)) {
            array_push($this->errors, _(
                'Game not created.'
            ));
            return $this->buildResponse();
        }
        $this->success = true;
        $this->game_state = $game_state;
        $this->game_uuid = $game->uuid;
        $this->game_id = $game->id;
        return $this->buildResponse();
    }

    public function getApiState($session_user, $uuid) {
        $game = new Game();
        $game->load(array('uuid = ?', $uuid));
        if($game->dry()) {
            array_push($this->errors, _(
                'Game does not exist.'
            ));
            return $this->buildResponse();
        }
        $user_game = new UserGame();
        $user_game->load(array(
            'user_id = ? AND game_id = ?',
            $session_user->id,
            $game->id
        ));
        if($user_game->dry()) {
            array_push($this->errors, _(
                'Access denied.'
            ));
            return $this->buildResponse();
        }
        $this->success = true;
        $this->game_state = json_decode($game->game_state);
        $this->game_uuid = $game->uuid;
        $this->game_id = $game->id;
        return $this->buildResponse();
    }

    public function addUserToGame($game_uuid, $username) {
        $game = new Game();
        $game_obj = $game->load(array('uuid = ?', $game_uuid));
        $user = new User();
        $user_obj = $user->load(array('username = ?', $username));
        if($game_obj->dry() || $user_obj->dry()) {
            array_push($this->errors, _(
                'Failed to send invite'
            ));
            return $this->buildResponse();
        }
        $user_game = new UserGame();
        $user_game->addUserToGame($user_obj->id, $game_obj->id);
        $this->success = true;
        $game_state = json_decode($game_obj->game_state);
        if(!in_array($username, $game_state->players))
            array_push($game_state->players, $username);
        $game_obj->game_state = json_encode($game_state);
        $game_obj->save();
        return $this->buildResponse();
    }

    private function getInitialStateJSON($user) {
        return json_encode(array(
            'creator' => $user->username,
            'players' => array($user->username),
            'whoseTurn' => '',
            'guessers' => array(),
            'writer' => '',
            'phrase' => '',
            'guesses' => array(),
            'winner' => '',
            'hangmanCount' => 0
        ));
    }

    private function buildResponse() {
        $response = array();
        $response['success'] = $this->success;
        $response['errors'] = $this->errors;
        $response['game_state'] = $this->game_state;
        $response['game_uuid'] = $this->game_uuid;
        $response['game_id'] = $this->game_id;
        return $response;
    }
}