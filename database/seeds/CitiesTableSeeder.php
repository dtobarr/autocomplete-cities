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
        $row = 1;
        if (($handle = fopen(storage_path('files/cities.csv'), "r")) !== false) {
            while (($data = fgetcsv($handle, 0, ",")) !== false) {
                if ($row === 1) {
                    $row++;
                    continue;
                }
                $row++;

                $dbData = [
                    'name' => '"'.$data[1].'"',
                    'asciiname' => '"'.$data[2].'"',
                    'latitude' => '"'.$data[4].'"',
                    'longitude' => '"'.$data[5].'"',
                    'feature_class' => '"'.$data[6].'"',
                    'feature_code' => '"'.$data[7].'"',
                    'country_code' => '"'.$data[8].'"',
                    'cc2' => '"'.$data[9].'"',
                    'admin1_code' => '"'.$data[10].'"',
                    'admin2_code' => '"'.$data[11].'"',
                    'admin3_code' => '"'.$data[12].'"',
                    'admin4_code' => '"'.$data[13].'"',
                    'population' => '"'.$data[14].'"',
                    'elevation' => '"'.$data[15].'"',
                    'dem' => '"'.$data[16].'"',
                    'timezone' => '"'.$data[17].'"'
                ];

                $colNames = array_keys($dbData);

                $createQuery = 'INSERT INTO cities ('.implode(',', $colNames).') VALUES ('.implode(',', $dbData).')';

                DB::statement($createQuery, $data);
                $this->command->info($row);
            }
            fclose($handle);
        }
    }
}