<?php

use Illuminate\Database\Seeder;

class cardDataInjectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pathToCardDir = storage_path() . "/cardDataTest";

        $cardStrorageDirectories = scandir($pathToCardDir);
        //scandir() also scans the "." ".." files. So remove them with array_splice
        array_splice($cardStrorageDirectories, 0, 2);

        foreach ($cardStrorageDirectories as $cardDir){

            $cardJsonFiles = scandir($pathToCardDir."/".$cardDir);
            array_splice($cardJsonFiles, 0, 2);


            foreach ($cardJsonFiles as $cardFile){

                $cardArr = json_decode(file_get_contents($pathToCardDir . "/" . $cardDir . "/" . $cardFile), true);

                $expansionName = explode('.',explode("-", $cardFile)[1])[0];

                $cardArr = $this->formatJSONtextToInsert($cardArr);

                $cardArr['expansion'] = $expansionName;

                $this->insertCardJsonToDB($cardArr , $cardDir);


            }
        }

    }

    private function insertCardJsonToDB(array $cardJSONArr, string $db_name){


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

        $existingCardinDB = DB::table('magic_card')->where('name', $cardJSONArr['name'])->where('expansion', $cardJSONArr['expansion'])->first();
        if( $existingCardinDB !== null){

            DB::table('magic_card')->where('id', $existingCardinDB->id)->update([
                $db_name.'_id' => $cardID,
                'updated_at' => now()
            ]);
        }else{

            DB::table('magic_card')->insert([
                'name' => $cardJSONArr['name'],
                $db_name.'_id' => $cardID,
                'expansion' => $cardJSONArr['expansion'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }


    }

    private function formatJSONtextToInsert(array $cardArr){
        foreach ($cardArr["price"] as $priceType => $value){

            ($value === "") ? $cardArr["price"][$priceType] = null : $cardArr["price"][$priceType] = trim($value) * 100;
        }

        if($cardArr['webLink']['foil'] === "") $cardArr['webLink']['foil'] = null;

        if($cardArr['lang'] === "") $cardArr['lang'] = 'english';



        return $cardArr;
    }

}
