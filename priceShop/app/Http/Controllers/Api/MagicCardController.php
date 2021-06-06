<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MagicCardResource;
use App\MagicCard;
use Illuminate\Http\Request;

class MagicCardController extends Controller
{

    public function index(){

        $cards = MagicCard::with('cardKingdom')->paginate(10);
        return MagicCardResource::collection($cards);
    }
}
