<?php

namespace F3AppSetup\Domain;

use F3AppSetup\Model\Game;

class HangmanAPI {
    private $success = false;
    private $errors = array();
    private $game_state = null;
    private $game_uuid = null;
    private $game_id = null;

    public function createGame($userid) {
        $game = new Game();
        if(!$game->gameCreate($userid)) {
            array_push($this->errors, _(
                'Game not created.'
            ));
            return $this->buildResponse();
        }
        $this->success = true;
        $this->game_state = $game->state;
        $this->game_uuid = $game->uuid;
        $this->game_id = $game->id;
        return $this->buildResponse();
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