<?php
namespace F3AppSetup\Model;

use DB\SQL\Mapper;

class Game extends Mapper {
   public function __construct() {
        parent::__construct(\Base::instance()->get('DB'), 'games');
    }

    public function gameCreate($creator_id) {
        $this->reset();
        $this->creator = $creator_id;
        $this->uuid = date('YmdHis') . bin2hex( random_bytes(6) );
        $this->save();
        return true;
    }
}