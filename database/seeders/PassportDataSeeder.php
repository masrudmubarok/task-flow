<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PassportDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // cache table
        DB::table('cache')->insert([
            'key' => 'dummy_cache_key',
            'value' => 'dummy_cache_value',
            'expiration' => now()->addMinutes(10)->timestamp,
        ]);

        // jobs table
        DB::table('jobs')->insert([
            'queue' => 'default',
            'payload' => 'dummy_payload',
            'attempts' => 0,
            'reserved_at' => null,
            'available_at' => now()->format('Y-m-d H:i:s'),
            'created_at' => now()->format('Y-m-d H:i:s'),
        ]);

        // oauth_clients table (Personal Access Client)
        DB::table('oauth_clients')->insert([
            'user_id' => null,
            'name' => 'Personal Access Client',
            'secret' => Str::random(40),
            'provider' => null,
            'redirect' => 'http://localhost',
            'personal_access_client' => true,
            'password_client' => false,
            'revoked' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // oauth_access_tokens table (Dummy Token - not recommended for production)
        $client = DB::table('oauth_clients')->where('personal_access_client', true)->first();
        if ($client) {
            DB::table('oauth_access_tokens')->insert([
                'user_id' => null,
                'client_id' => $client->id,
                'name' => 'Dummy Access Token',
                'scopes' => '[]',
                'revoked' => false,
                'expires_at' => now()->addDays(1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // oauth_refresh_tokens table (Dummy Refresh Token - not recommended for production)
        $token = DB::table('oauth_access_tokens')->first();
        if ($token) {
            DB::table('oauth_refresh_tokens')->insert([
                'access_token_id' => $token->id,
                'revoked' => false,
                'expires_at' => now()->addDays(30),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}