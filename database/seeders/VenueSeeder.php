<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as FakerFactory;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();
        $initialVenues = [
            'Hallway', 'Terrace', 'Garden', 'Beach'
        ];

        foreach ( $initialVenues as $venue ) {
            $newVenue = new Venue;
            $newVenue->name = $venue;
            $newVenue->description = $faker->words( rand( 15, 33 ), true );
            $newVenue->save();
        }
    }
}
