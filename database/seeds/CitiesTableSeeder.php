<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $columns = [
            'geonameid',
            'name',
            'asciiname',
            'alternatenames',
            'latitude',
            'longitude',
            'feature_class',
            'feature_code',
            'country_code',
            'cc2',
            'admin1_code',
            'admin2_code',
            'admin3_code',
            'admin4_code',
            'population',
            'elevation',
            'dem',
            'timezone',
            'modification_date'
        ];

        $cities_file = storage_path('RU\RU.txt');
        //get .txt file data
        $lines = file($cities_file, FILE_IGNORE_NEW_LINES);
        foreach ($lines as $line){
            $values = preg_split('[\t]', $line);
            // get each city data
            $item = array_combine($columns, $values);
            \DB::table('cities')->insert(array_filter($item));
        }
    }
}
