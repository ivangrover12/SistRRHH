<?php

use Illuminate\Database\Seeder;

class ChargeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    factory(App\Charge::class, 20)->create();
  }
}
