<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = [
        	[
        		'package_amount' => 100,
        		'direct' => 5,
        		'roi' => 28,
        		'max_profit' => 200
        	],
        	[
        		'package_amount' => 300,
        		'direct' => 6,
        		'roi' => 28,
        		'max_profit' => 700
        	],
        	[
        		'package_amount' => 500,
        		'direct' => 7,
        		'roi' => 30,
        		'max_profit' => 1250
        	],
        	[
        		'package_amount' => 1000,
        		'direct' => 8,
        		'roi' => 30,
        		'max_profit' => 2750
        	],
        	[
        		'package_amount' => 3000,
        		'direct' => 9,
        		'roi' => 33,
        		'max_profit' => 9000
        	],
        	[
        		'package_amount' => 5000,
        		'direct' => 10,
        		'roi' => 33,
        		'max_profit' => 15000
        	]
        ];

        foreach ($packages as $package) {
        	$package['created_at'] = Carbon::now();
        	$package['updated_at'] = Carbon::now();
        	\DB::table('Package')->insert($package);
        }
    }
}
