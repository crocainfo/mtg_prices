<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardKingdom extends Model
{
    //
    protected $table = "card_kingdom";

    protected $hidden = [ 'created_at', 'updated_at'];
}
