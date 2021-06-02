<?php

use App\MagicCard;
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
                $cardArr = MagicCard::formatJSONtextToInsert($cardArr);

                //Adds the expansion name to the array
                $cardArr['expansion'] = $expansionName;

                MagicCard::insertCardJsonToDB($cardArr , $cardDir);


            }
        }

    }




}
