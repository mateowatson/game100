<?php
namespace F3AppSetup\Model;

use DB\SQL\Mapper;

class Game extends Mapper {
   public function __construct() {
        parent::__construct(\Base::instance()->get('DB'), 'games');
    }

    public function gameCreate($creator_id, $game_type) {
        $this->reset();
        $this->creator = $creator_id;
        $this->uuid = date('YmdHis') . bin2hex( random_bytes(6) );
        $this->game_type = $game_type;
        $this->save();
        return true;
    }
}