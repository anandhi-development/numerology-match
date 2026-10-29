<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\User;
use App\Services\NumerologyService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin account
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'first_name' => 'Admin',
                'last_name' => '',
                'name' => 'Admin',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
            ]
        );

        // 2. Demo User Anandhi V (from wireframe)
        $user = User::firstOrCreate(
            ['email' => 'anandhi@gmail.com'],
            [
                'first_name' => 'Anandhi',
                'last_name' => '',
                'name' => 'Anandhi',
                'role' => 'user',
                'password' => Hash::make('anandhi123'),
            ]
        );

        // 3. Additional demo user
        $user2 = User::firstOrCreate(
            ['email' => 'abe@gmail.com'],
            [
                'first_name' => 'Abe',
                'last_name' => '',
                'name' => 'Abe',
                'role' => 'user',
                'password' => Hash::make('abe123'),
            ]
        );

        $numerology = new NumerologyService();

        // Sample 1: Arun Kumar & Priya Raman (Pending - as in wireframe)
        $res1 = $numerology->compareProfiles(
            ['first_name' => 'Arun', 'last_name' => 'Kumar', 'dob' => '1992-06-12'],
            ['first_name' => 'Priya', 'last_name' => 'Raman', 'dob' => '1995-11-18']
        );
        Report::create([
            'user_id' => $user->id,
            'p1_first_name' => 'Arun',
            'p1_last_name' => 'Kumar',
            'p1_dob' => '1992-06-12',
            'p1_life_path' => $res1['person1']['life_path'],
            'p1_destiny' => $res1['person1']['destiny'],
            'p1_soul' => $res1['person1']['soul'],
            'p1_personality' => $res1['person1']['personality'],
            'p2_first_name' => 'Priya',
            'p2_last_name' => 'Raman',
            'p2_dob' => '1995-11-18',
            'p2_life_path' => $res1['person2']['life_path'],
            'p2_destiny' => $res1['person2']['destiny'],
            'p2_soul' => $res1['person2']['soul'],
            'p2_personality' => $res1['person2']['personality'],
            'compatibility_score' => $res1['compatibility_score'],
            'summary_en' => $res1['summary_en'],
            'summary_ta' => $res1['summary_ta'],
            'status' => 'pending',
            'created_at' => now()->subDay(),
        ]);

        // Sample 2: Karthik & Divya (Approved - as in wireframe)
        $res2 = $numerology->compareProfiles(
            ['first_name' => 'Karthik', 'last_name' => 'Subramanian', 'dob' => '1991-04-15'],
            ['first_name' => 'Divya', 'last_name' => 'Balaji', 'dob' => '1993-09-22']
        );
        Report::create([
            'user_id' => $user->id,
            'p1_first_name' => 'Karthik',
            'p1_last_name' => 'Subramanian',
            'p1_dob' => '1991-04-15',
            'p1_life_path' => $res2['person1']['life_path'],
            'p1_destiny' => $res2['person1']['destiny'],
            'p1_soul' => $res2['person1']['soul'],
            'p1_personality' => $res2['person1']['personality'],
            'p2_first_name' => 'Divya',
            'p2_last_name' => 'Balaji',
            'p2_dob' => '1993-09-22',
            'p2_life_path' => $res2['person2']['life_path'],
            'p2_destiny' => $res2['person2']['destiny'],
            'p2_soul' => $res2['person2']['soul'],
            'p2_personality' => $res2['person2']['personality'],
            'compatibility_score' => $res2['compatibility_score'],
            'summary_en' => $res2['summary_en'],
            'summary_ta' => $res2['summary_ta'],
            'status' => 'approved',
            'created_at' => now()->subDays(4),
        ]);

        // Sample 3: Suresh & Meena (Emailed - as in wireframe)
        $res3 = $numerology->compareProfiles(
            ['first_name' => 'Suresh', 'last_name' => 'Chandran', 'dob' => '1988-08-05'],
            ['first_name' => 'Meena', 'last_name' => 'Srinivasan', 'dob' => '1990-02-14']
        );
        Report::create([
            'user_id' => $user->id,
            'p1_first_name' => 'Suresh',
            'p1_last_name' => 'Chandran',
            'p1_dob' => '1988-08-05',
            'p1_life_path' => $res3['person1']['life_path'],
            'p1_destiny' => $res3['person1']['destiny'],
            'p1_soul' => $res3['person1']['soul'],
            'p1_personality' => $res3['person1']['personality'],
            'p2_first_name' => 'Meena',
            'p2_last_name' => 'Srinivasan',
            'p2_dob' => '1990-02-14',
            'p2_life_path' => $res3['person2']['life_path'],
            'p2_destiny' => $res3['person2']['destiny'],
            'p2_soul' => $res3['person2']['soul'],
            'p2_personality' => $res3['person2']['personality'],
            'compatibility_score' => $res3['compatibility_score'],
            'summary_en' => $res3['summary_en'],
            'summary_ta' => $res3['summary_ta'],
            'status' => 'emailed',
            'emailed_at' => now()->subDays(2),
            'created_at' => now()->subDays(8),
        ]);

        // Sample 4: Manoj & Swathi (Rejected)
        $res4 = $numerology->compareProfiles(
            ['first_name' => 'Manoj', 'last_name' => 'Sundaram', 'dob' => '1990-10-10'],
            ['first_name' => 'Swathi', 'last_name' => 'Natarajan', 'dob' => '1994-12-25']
        );
        Report::create([
            'user_id' => $user2->id,
            'p1_first_name' => 'Manoj',
            'p1_last_name' => 'Sundaram',
            'p1_dob' => '1990-10-10',
            'p1_life_path' => $res4['person1']['life_path'],
            'p1_destiny' => $res4['person1']['destiny'],
            'p1_soul' => $res4['person1']['soul'],
            'p1_personality' => $res4['person1']['personality'],
            'p2_first_name' => 'Swathi',
            'p2_last_name' => 'Natarajan',
            'p2_dob' => '1994-12-25',
            'p2_life_path' => $res4['person2']['life_path'],
            'p2_destiny' => $res4['person2']['destiny'],
            'p2_soul' => $res4['person2']['soul'],
            'p2_personality' => $res4['person2']['personality'],
            'compatibility_score' => $res4['compatibility_score'],
            'summary_en' => $res4['summary_en'],
            'summary_ta' => $res4['summary_ta'],
            'status' => 'rejected',
            'admin_notes' => 'Incomplete or inconsistent DOB details.',
            'created_at' => now()->subDays(3),
        ]);
    }
}
