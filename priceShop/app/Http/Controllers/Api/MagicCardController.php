<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MagicCardResource;
use App\MagicCard;
use Illuminate\Http\Request;

class MagicCardController extends Controller
{

    public function index(){

        $search_term = request('q', '');
        $expansion = request('expansion');


        $cards = MagicCard::with('cardKingdom')
            ->when($expansion, function ($query) use ($expansion){ $query->where('expansion', $expansion);})
            ->search(trim($search_term))
            ->paginate(12);
        return MagicCardResource::collection($cards);
    }

    public function getExpansions(){

        $expansions = file_get_contents(storage_path() . "/expansionLibraryNames.json", true);
        return $expansions;
    }
}
