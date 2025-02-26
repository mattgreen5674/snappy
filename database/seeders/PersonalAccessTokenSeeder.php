<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class PersonalAccessTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name'     => 'Matt Test',
            'email'    => 'matt@test.co.uk',
            'password' => Hash::make('qX@szVEATghZW83JWF7X'),
        ]);

        PersonalAccessToken::create([
            'tokenable_type' => 'App\Models\User',
            'tokenable_id'   => $user->id,
            'name'           => 'Snappy API',
            'token'          => hash('sha256', 'Lf7t1DOKuZExrctnsKB4gzjIcBwv1c7VX8m2HRpb266cb071'), // Hash the token for storage
            'abilities'      => json_encode(['*']), // You can define specific abilities here
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        // Personal Access Token = user_id + | + token (Check DB to ensure user_id = 1)
        // Example = 1|Lf7t1DOKuZExrctnsKB4gzjIcBwv1c7VX8m2HRpb266cb071
    }
}
