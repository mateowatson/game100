<?php
namespace F3AppSetup\Model;

use DB\SQL\Mapper;

class UserGame extends Mapper {
    public function __construct() {
        parent::__construct(\Base::instance()->get('DB'), 'users_games');
    }

    public function addUserToGame($user_id, $game_id) {
        $this->load('user_id = ? AND game_id = ?', $user_id, $game_id);
        if($this->dry()) {
            $this->user_id = $user_id;
            $this->game_id = $game_id;
            $this->save();
        }
        return true;
    }
}