<?php
namespace F3AppSetup\Model;

use DB\SQL\Mapper;
use \F3AppSetup\Model\UserGame;

class Game extends Mapper {
   public function __construct() {
        parent::__construct(\Base::instance()->get('DB'), 'games');
    }

    public function gameCreate($creator, $game_type, $game_state) {
        $this->reset();
        $this->creator = $creator->id;
        $this->uuid = date('YmdHis') . bin2hex( random_bytes(6) );
        $this->game_type = $game_type;
        $this->game_state = $game_state;
        $this->save();

        $users_games = new UserGame();
        $users_games->addUserToGame($creator->id, $this->id);
        
        return true;
    }
}