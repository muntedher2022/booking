<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailListSeeder extends Seeder
{
    public function run(): void
    {
        $emails = [
            ['department' => '1', 'email' => 'dg@gcpi.gov.iq'],
            ['department' => '2', 'email' => 'deputy-ta@gcpi.gov.iq'],
            ['department' => '3', 'email' => 'deputya@gcpi.gov.iq'],
            ['department' => '4', 'email' => 'planning@gcpi.gov.iq'],
            ['department' => '5', 'email' => 'isps@gcpi.gov.iq'],
            ['department' => '6', 'email' => 'contracts@gcpi.gov.iq'],
            ['department' => '7', 'email' => 'joint-operation@gcpi.gov.iq'],
            ['department' => '8', 'email' => 'em-dept@gcpi.gov.iq'],
            ['department' => '9', 'email' => 'financial@gcpi.gov.iq'],
            ['department' => '10', 'email' => 'hr@gcpi.gov.iq'],
            ['department' => '11', 'email' => 'audeting@gcpi.gov.iq'],
            ['department' => '12', 'email' => 'legale-dep@gcpi.gov.iq'],
            ['department' => '13', 'email' => 'commercial@gcpi.gov.iq'],
            ['department' => '14', 'email' => 'engineering@gcpi.gov.iq'],
            ['department' => '15', 'email' => 'firefighting@gcpi.gov.iq'],
            ['department' => '16', 'email' => 'ma-inspection@gcpi.gov.iq'],
            ['department' => '17', 'email' => 'ma-industries@gcpi.gov.iq'],
            ['department' => '18', 'email' => 'salvage-dep@gcpi.gov.iq'],
            ['department' => '19', 'email' => 'pilotage-dep@gcpi.gov.iq'],
            ['department' => '21', 'email' => 'dredging-dep@gcpi.gov.iq'],
            ['department' => '22', 'email' => 'maritime-dep@gcpi.gov.iq'],
            ['department' => '23', 'email' => 'communicatior@gcpi.gov.iq'],
            ['department' => '24', 'email' => 'media@gcpi.gov.iq'],
            ['department' => '25', 'email' => 'cadiv-of@gcpi.gov.iq'],
            ['department' => '26', 'email' => 'iso@gcpi.gov.iq'],
            ['department' => '27', 'email' => 'tariff@gcpi.gov.iq'],
            ['department' => '28', 'email' => 'port-institute@gcpi.gov.iq'],
            ['department' => '29', 'email' => 'nuq-port@gcpi.gov.iq'],
            ['department' => '30', 'email' => 'ssu-port@gcpi.gov.iq'],
            ['department' => '31', 'email' => 'khz-67port@gcpi.gov.iq'],
            ['department' => '32', 'email' => 'maqil-port@gcpi.gov.iq'],
            ['department' => '33', 'email' => 'abf-port@gcpi.gov.iq'],
        ];

        foreach ($emails as $email) {
            DB::table('emaillists')->insert([
                'user_id' => 4,
                'department' => $email['department'],
                'email' => $email['email'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
