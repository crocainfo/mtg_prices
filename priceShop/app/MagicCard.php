<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MagicCard extends Model
{
    protected $table = "magic_card";


    //find, paginate, with, ->get, ->paginate

    static function formatJSONtextToInsert(array $cardArr){
        //Formats all the blank data to null or other default values

        foreach ($cardArr["price"] as $priceType => $value){

            ($value === "") ? $cardArr["price"][$priceType] = null : $cardArr["price"][$priceType] = trim($value) * 100;
        }

        if($cardArr['webLink']['foil'] === "") $cardArr['webLink']['foil'] = null;

        if($cardArr['lang'] === "") $cardArr['lang'] = 'english';



        return $cardArr;
    }

    static function insertCardJsonToDB(array $cardJSONArr, string $db_name){


        //Adds the card to the db where the files where extracted
        $cardID = DB::table($db_name)->insertGetId([
            'price_nm' => $cardJSONArr['price']['nm'],
            'price_ex' => $cardJSONArr['price']['ex'],
            'price_nm_foil' => $cardJSONArr['price']['foil_nm'],
            'price_ex_foil' => $cardJSONArr['price']['foil_ex'],
            'link_to_webpage' => $cardJSONArr['webLink']['normal'] ,
            'link_to_webpage_foil' => $cardJSONArr['webLink']['foil'] ,
            'link_to_image' => $cardJSONArr['img']['medium'],
            'link_to_image_little' => $cardJSONArr['img']['little'],
            'currency' => $cardJSONArr['currency'],
            'lang' => $cardJSONArr['lang'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        //If the card exists just updates, adding the new id from the other db to the card
        $existingCardinDB = DB::table('magic_card')->where('name', $cardJSONArr['name'])->where('expansion', $cardJSONArr['expansion'])->first();
        if( $existingCardinDB !== null){

            DB::table('magic_card')->where('id', $existingCardinDB->id)->update([
                $db_name.'_id' => $cardID,
                'updated_at' => now()
            ]);
        }else{
            //if not exists , just creates a new register
            DB::table('magic_card')->insert([
                'name' => $cardJSONArr['name'],
                $db_name.'_id' => $cardID,
                'expansion' => $cardJSONArr['expansion'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }




    }


    public function cardKingdom()
    {
        return $this->belongsTo(CardKingdom::class);
    }

}
