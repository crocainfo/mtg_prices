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

        //Gets all the directories inside
        $cardStrorageDirectories = scandir($pathToCardDir);

        //scandir() also scans the "." ".." files. So remove them with array_splice
        array_splice($cardStrorageDirectories, 0, 2);

        //Loops through the directories to get all the json files inside of them
        foreach ($cardStrorageDirectories as $cardDir){

            //Gets the json files on an array
            $cardJsonFiles = scandir($pathToCardDir."/".$cardDir);
            array_splice($cardJsonFiles, 0, 2);

            //loop through the files to add them to de DB
            foreach ($cardJsonFiles as $cardFile){

                $cardArr = json_decode(file_get_contents($pathToCardDir . "/" . $cardDir . "/" . $cardFile), true);

                //The expansion Name is in the name file, so its parsed through delimiters
                $expansionName = explode('.',explode("-", $cardFile)[1])[0];

                //Formats de data so its easier to work with
                $cardArr = $this->formatJSONtextToInsert($cardArr);

                //Adds the expansion name to the array
                $cardArr['expansion'] = $expansionName;

                $this->insertCardJsonToDB($cardArr , $cardDir);


            }
        }

    }

    private function insertCardJsonToDB(array $cardJSONArr, string $db_name){


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

    private function formatJSONtextToInsert(array $cardArr){
        //Formats all the blank data to null or other default values

        foreach ($cardArr["price"] as $priceType => $value){

            ($value === "") ? $cardArr["price"][$priceType] = null : $cardArr["price"][$priceType] = trim($value) * 100;
        }

        if($cardArr['webLink']['foil'] === "") $cardArr['webLink']['foil'] = null;

        if($cardArr['lang'] === "") $cardArr['lang'] = 'english';



        return $cardArr;
    }

}
