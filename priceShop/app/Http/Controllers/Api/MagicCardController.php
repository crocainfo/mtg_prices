<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MagicCardResource;
use App\MagicCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MagicCardController extends Controller
{

    public function index(){

        $search_term = request('q', '');
        $expansion = request('expansion');
        $foil = request('foil');


//        $foilIds = DB::table('cardKingdom')->when($foil == 'true', function ($query){$query->whereNotNull('price_foil_nm');})->get('id');
        $foilIds = DB::table('card_kingdom')->whereNotNull('price_nm_foil')->get('id');


        $cards = MagicCard::with('cardKingdom')
            ->when($expansion, function ($query) use ($expansion){ $query->where('expansion', $expansion);})
            ->when($foil == 'true', function ($query) use ($foilIds){ $query->whereIn('cardkingdom', $foilIds)->orWhere('name','like','%foil%');})
            ->search(trim($search_term))
            ->paginate(12);
        return MagicCardResource::collection($cards);
    }

    public function getExpansions(){

        $expansions = file_get_contents(storage_path() . "/expansionLibraryNames.json", true);
        return $expansions;
    }


}
