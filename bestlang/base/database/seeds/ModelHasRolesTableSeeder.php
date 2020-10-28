<?php

use Illuminate\Database\Seeder;

class ModelHasRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('model_has_roles')->delete();
        
        \DB::table('model_has_roles')->insert(array (
            0 => 
            array (
                'model_id' => 156,
                'model_type' => 'Bestlang\\Base\\Models\\User',
                'role_id' => 4,
            ),
            1 => 
            array (
                'model_id' => 157,
                'model_type' => 'Bestlang\\Base\\Models\\User',
                'role_id' => 4,
            ),
            2 => 
            array (
                'model_id' => 160,
                'model_type' => 'Bestlang\\Base\\Models\\User',
                'role_id' => 7,
            ),
            3 => 
            array (
                'model_id' => 166,
                'model_type' => 'Bestlang\\Base\\Models\\User',
                'role_id' => 4,
            ),
            4 => 
            array (
                'model_id' => 195,
                'model_type' => 'Bestlang\\Base\\Models\\User',
                'role_id' => 7,
            ),
            5 => 
            array (
                'model_id' => 195,
                'model_type' => 'Bestlang\\Base\\Models\\User',
                'role_id' => 8,
            ),
            6 => 
            array (
                'model_id' => 222,
                'model_type' => 'Bestlang\\Base\\Models\\User',
                'role_id' => 4,
            ),
        ));
        
        
    }
}