<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Insert repositories
        DB::table('users')->insert([
            'name' =>  'Hospital Clínic de Barcelona',
            'email' => 'hb@mail.com ',
            'password' => bcrypt('secret'),
            'created_at' => Carbon::now()
        ]);

        //Insert projects
        DB::table('projects')->insert([
            'name' =>  'Digestive Diseases',
            'description' => 'Description of the project',
            'repository_id' => 1,
            'created_at' => Carbon::now()
        ]);
        DB::table('projects')->insert([
            'name' =>  'Musculoskeletal Diseases',
            'description' => 'Description of the project',
            'repository_id' => 1,
            'created_at' => Carbon::now()
        ]);

        //Insert subjects
        DB::table('subjects')->insert([
            'name' =>  'Paolo Costa',
            'email' => 'pc@mail.com ',
            'repository_id' => 1,
            'created_at' => Carbon::now()
        ]);
        DB::table('subjects')->insert([
            'name' =>  'Marta Cases',
            'email' => 'mc@mail.com ',
            'repository_id' => 1,
            'created_at' => Carbon::now()
        ]);

        //Attach project to subject
        DB::table('project_subject')->insert([
            'project_id' =>  1,
            'subject_id' =>  1,
            'created_at' => Carbon::now()
        ]);
        DB::table('project_subject')->insert([
            'project_id' =>  1,
            'subject_id' =>  2,
            'created_at' => Carbon::now()
        ]);
        DB::table('project_subject')->insert([
            'project_id' =>  2,
            'subject_id' =>  1,
            'created_at' => Carbon::now()
        ]);

    }
}
