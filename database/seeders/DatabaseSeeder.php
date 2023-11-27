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
use App\Models\Notification;
use App\Models\Rental;
use App\Models\ReportedUser;
use App\Models\Review;
use App\Models\Rule;
use App\Models\School;
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


        Facility::factory()->count(6)->sequence(
            ['name' => 'Comfort Room', 'icon' => 'facility_1692025831.svg', 'is_switch' => 0],
            ['name' => 'Kitchen Sink', 'icon' => 'facility_1700850916.svg', 'is_switch' =>  0],
            ['name' => 'Parking', 'icon' => 'facility_1692026270.svg', 'is_switch' => 1],
            ['name' => 'Dining Area', 'icon' => 'facility_1700851016.svg', 'is_switch' => 1],
            ['name' => 'Shower Room', 'icon' => 'facility_1700851083.svg', 'is_switch' => 1],
            ['name' => 'Bed', 'icon' => 'facility_1700851129.svg', 'is_switch' => 1],
        )->create();

        Amenity::factory()->count(9)->sequence(
            ['name' => 'CCTV', 'icon' => 'amenity_1700844363.svg'],
            ['name' => 'Air Condition', 'icon' => 'amenity_1700844377.svg'],
            ['name' => 'Washer', 'icon' => 'amenity_1700843433.svg'],
            ['name' => 'Refrigerator', 'icon' => 'amenity_1700844421.svg'],
            ['name' => 'Television', 'icon' => 'amenity_1700844435.svg'],
            ['name' => 'Stove', 'icon' => 'amenity_1700844481.svg'],
            ['name' => 'Wi-Fi', 'icon' => 'amenity_1700844531.svg'],
            ['name' => 'Electric Fan', 'icon' => 'amenity_1700853180.svg'],
            ['name' => 'Water Heater', 'icon' => 'amenity_1700858301.svg'],
        )->create();

        Inclusion::factory()->count(3)->sequence(
            ['name' => 'Water', 'icon' => 'inclusion_1692026406.svg'],
            ['name' => 'Electricity', 'icon' => 'inclusion_1692026414.svg'],
            ['name' => 'Wi-Fi', 'icon' => 'inclusion_1700851501.svg'],
        )->create();

        Rule::factory()->count(2)->sequence(
            ['name' => 'No Visitors', 'icon' => 'rule_1692027093.svg'],
            ['name' => 'No Smoking', 'icon' => 'rule_1700851306.svg'],
            ['name' => 'No Pets', 'icon' => 'rule_1700851326.svg'],
        )->create();

        Subscription::factory()->count(3)->sequence(
            ['name' => 'Bronze', 'price' => 0, 'details' => 'An example details of a subscription.', 'hex_color' => '#ffffff', 'features' => 'a feature; another feature', 'duration' => 500],
            ['name' => 'Silver', 'price' => 0, 'details' => 'An example details of a subscription.', 'hex_color' => '#ffffff', 'features' => 'a feature; another feature', 'duration' => 500],
            ['name' => 'Gold', 'price' => 0, 'details' => 'An example details of a subscription.', 'hex_color' => '#ffffff', 'features' => 'a feature; another feature', 'duration' => 500],
        )->create();


        Unit::factory()->count(3)->sequence(
            ['landlord_id' => 1, 'name' => 'Jano Boarding House', 'details' => fake()->paragraph(), 'price' => 3500, 'month_advance' => 1, 'month_deposit' => 1, 'location' => '13.144563, 123.727199', 'address' => 'EMs Barrio', 'target_gender' => 3, 'slots' => 4],
            ['landlord_id' => 1, 'name' => 'Cutie Boarding House', 'details' => fake()->paragraph(), 'price' => 3500, 'month_advance' => 1, 'month_deposit' => 1, 'location' => '13.1439, 123.727762', 'address' => 'EMs Barrio', 'target_gender' => 3, 'slots' => 4],
            ['landlord_id' => 1, 'name' => 'Pogi Boarding House', 'details' => fake()->paragraph(), 'price' => 3500, 'month_advance' => 1, 'month_deposit' => 1, 'location' => '13.14427, 123.719212', 'address' => 'EMs Barrio', 'target_gender' => 3, 'slots' => 4],
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


        Review::factory()->count(5)->create();
        Notification::factory()->count(5)->create();
        School::factory()->count(5)->sequence(
            ['name' => 'Bicol University Main Campus', 'location' => '13.144297,123.725128', 'icon' => 'BU_Main.png'],
            ['name' => 'Bicol University - East Campus', 'location' => '13.147322,123.729648', 'icon' => 'BU_Main.png'],
            ['name' => 'University of Santo Tomas Legazpi', 'location' => '13.1645849,123.7510655', 'icon' => 'ustl.png'],
            ['name' => 'Divine Word College Legazpi', 'location' => '13.138219,123.735674', 'icon' => 'DWCL.png'],
            ['name' => 'Computer Arts and Technological College', 'location' => '13.1641,123.751605', 'icon' => 'catc.png'],
            ['name' => 'Tanchuling College', 'location' => '13.143853,123.752583', 'icon' => 'tanchuling.png'],
        )->create();
    }
}
