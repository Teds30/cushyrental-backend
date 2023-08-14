<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AccountVerification;
use App\Models\Amenity;
use App\Models\BlacklistedUser;
use App\Models\Facility;
use App\Models\IdentificationCardType;
use App\Models\Image;
use App\Models\Inclusion;
use App\Models\Rental;
use App\Models\ReportedUser;
use App\Models\Rule;
use App\Models\Subscription;
use App\Models\Unit;
use App\Models\UnitAmenity;
use App\Models\UnitFacility;
use App\Models\UnitImage;
use App\Models\UnitInclusion;
use App\Models\UnitRule;
use App\Models\UnitSubscription;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\UserTypes;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        UserTypes::factory()->count(3)->sequence(
            ['name' => 'admin'],
            ['name' => 'landlord'],
            ['name' => 'tenant'],

        )->create();

        User::factory()->count(10)->create();
        BlacklistedUser::factory()->create();
        ReportedUser::factory()->count(10)->create();
        IdentificationCardType::factory()->count(2)->sequence(
            ['name' => 'National ID'],
            ['name' => "Driver's License"],
        )->create();
        AccountVerification::factory()->create();


        Facility::factory()->count(3)->sequence(
            ['name' => 'Comfort Room', 'icon' => 'facility_1692025831.svg', 'is_switch' => 0],
            ['name' => 'Kitchen Sink', 'icon' => 'facility_1692026078.svg', 'is_switch' =>  0],
            ['name' => 'Parking', 'icon' => 'facility_1692026270.svg', 'is_switch' => 1],
        )->create();

        Amenity::factory()->count(2)->sequence(
            ['name' => 'CCTV', 'icon' => 'amenity_1692025416.svg'],
            ['name' => 'Air Condition', 'icon' => 'amenity_1692025428.svg'],
        )->create();
        Inclusion::factory()->count(2)->sequence(
            ['name' => 'Water', 'icon' => 'inclusion_1692026406.svg'],
            ['name' => 'Electricity', 'icon' => 'inclusion_1692026414.svg'],
        )->create();
        Rule::factory()->count(2)->sequence(
            ['name' => 'No Visitors', 'icon' => 'rule_1692027093.svg'],
            ['name' => 'No Smoking', 'icon' => 'rule_1692026581.svg'],
        )->create();
        Subscription::factory()->count(3)->sequence(
            ['name' => 'Bronze', 'price' => 0, 'details' => 'An example details of a subscription.', 'hex_color' => '#ffffff', 'features' => 'a feature; another feature', 'duration' => 500],
            ['name' => 'Silver', 'price' => 0, 'details' => 'An example details of a subscription.', 'hex_color' => '#ffffff', 'features' => 'a feature; another feature', 'duration' => 500],
            ['name' => 'Gold', 'price' => 0, 'details' => 'An example details of a subscription.', 'hex_color' => '#ffffff', 'features' => 'a feature; another feature', 'duration' => 500],
        )->create();


        Unit::factory()->count(1)->sequence(
            ['landlord_id' => 1, 'name' => 'Jano Boarding House', 'details' => fake()->paragraph(), 'price' => 3500, 'month_advance' => 1, 'month_deposit' => 1, 'location' => '13.143972, 123.727927', 'address' => 'EMs Barrio', 'target_gender' => 3, 'slots' => 4],
        )->create();


        Image::factory()->create();
        UnitFacility::factory()->create();
        UnitAmenity::factory()->create();
        UnitAmenity::factory()->create();
        UnitInclusion::factory()->create();
        UnitRule::factory()->create();
        UnitImage::factory()->create();
        UnitSubscription::factory()->create();
        Rental::factory()->create();
    }
}
