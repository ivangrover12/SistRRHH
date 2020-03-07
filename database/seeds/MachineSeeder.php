<?php

use Illuminate\Database\Seeder;

class MachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attendance_devices = [
            ['MachineAlias' => 'Av. Arica', 'IP' => '192.168.1.201', 'Port' => '4370', 'MachineNumber' => '1', 'sn' => '1234567890']
          ];
      
          foreach ($attendance_devices as $attendance_device) {
            App\AttendanceDevice::create($attendance_device);
          } //
    }
}
