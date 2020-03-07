<?php

use Illuminate\Database\Seeder;

class UserinfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attendance_users = [
            ['BADGENUMBER' => '1', 'NAME' => 'ROKCY MARLEY'],
            ['BADGENUMBER' => '2', 'NAME' => 'MILAN TATYANA'],
            ['BADGENUMBER' => '3', 'NAME' => 'OLE'],
            ['BADGENUMBER' => '4', 'NAME' => 'ANGEL TELLY'],
            ['BADGENUMBER' => '5', 'NAME' => 'CYDNEY'],
            ['BADGENUMBER' => '6', 'NAME' => 'FOREST ANSLEY'],
            ['BADGENUMBER' => '7', 'NAME' => 'KRYSTEL'],
            ['BADGENUMBER' => '8', 'NAME' => 'CORTNEY'],
            ['BADGENUMBER' => '9', 'NAME' => 'JESSE'],
            ['BADGENUMBER' => '10', 'NAME' => 'UNIQUE HOUSTON'],
            ['BADGENUMBER' => '11', 'NAME' => 'ALEXZANDER']
          ];
      
          foreach ($attendance_users as $attendance_user) {
            App\AttendanceUser::create($attendance_user);
          } // //
    }
}
