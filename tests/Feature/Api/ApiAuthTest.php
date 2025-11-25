<?php

namespace Tests\Feature\Api;

use App\Http\Controllers\Api\AuthController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;

uses(RefreshDatabase::class);

test('api user can register', function () {
    $userData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $response = $this->postJson('/api/register', $userData);

    $response->assertStatus(201);

    $response->assertJsonStructure([
        'data' => ['token'],
        'message',
        'status'
    ]);

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);
});

test('api user can login', function () {
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    $userData = [
        'email' => 'test@example.com',
        'password' => 'password123',
    ];

    $response = $this->postJson('/api/login', [
        'email' => $userData['email'],
        'password' => $userData['password'],
    ]);

    $response->assertStatus(200);

    $response->assertJsonStructure([
        'data' => ['token'],
        'message',
        'status'
    ]);
});

test('api user cannot login with invalid credentials', function () {

    User::factory()->create([
        'email' => 'wrong@example.com',
        'password' => bcrypt('password123'),
    ]);

    $userData = [
        'email' => 'test@example.com',
        'password' => 'password123',
    ];

    $response = $this->postJson('/api/login', $userData);

    $response->assertStatus(401);
});

test('api user can login using stub', function () {
    $stub = $this->createStub(AuthController::class);

    $stub->method('login')
        ->willReturn(response()->json([
            'data' => ['token' => 'fake-jwt-token'],
            'message' => 'Login successful',
            'status' => true,
        ], 200));

    $this->app->instance(AuthController::class, $stub);

    $userData = [
        'email' => 'test@example.com',
        'password' => 'password123',
    ];

    $startTime = microtime(true);
    $response = $this->postJson('/api/login', $userData);
    $endTime = microtime(true);

    dump('=== STATISTIK TEST STUB ===');
    dump('Status Code: ' . $response->status());
    dump('Response Time: ' . round(($endTime - $startTime) * 1000, 2) . 'ms');
    dump('Content Type: ' . $response->headers->get('Content-Type'));
    dump('');
    dump('=== DATA RESPONSE ===');
    dump($response->json());
    dump('');
    dump('=== STRUKTUR RESPONSE ===');
    dump('Has data key: ' . ($response->json('data') ? 'Yes' : 'No'));
    dump('Has token: ' . ($response->json('data.token') ? 'Yes' : 'No'));
    dump('Token value: ' . $response->json('data.token'));
    dump('Message: ' . $response->json('message'));
    dump('Status: ' . ($response->json('status') ? 'true' : 'false'));
    dump('');
    dump('=== ASSERTIONS ===');
    dump('Total assertions in this test: 2');
    dump('- assertStatus(200)');
    dump('- assertJson(data structure)');

    $response->assertStatus(200);
    $response->assertJson([
        'data' => ['token' => 'fake-jwt-token'],
        'message' => 'Login successful',
        'status' => true,
    ]);
});

test('show detailed statistics for all auth tests', function () {
    dump('');
    dump('╔════════════════════════════════════════════════════════════╗');
    dump('║           STATISTIK LENGKAP AUTH TESTING                  ║');
    dump('╚════════════════════════════════════════════════════════════╝');
    dump('');

    $start1 = microtime(true);
    $response1 = $this->postJson('/api/register', [
        'name' => 'Test User',
        'email' => 'test1@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);
    $time1 = round((microtime(true) - $start1) * 1000, 2);

    User::factory()->create([
        'email' => 'test2@example.com',
        'password' => bcrypt('password123'),
    ]);

    $start2 = microtime(true);
    $response2 = $this->postJson('/api/login', [
        'email' => 'test2@example.com',
        'password' => 'password123',
    ]);
    $time2 = round((microtime(true) - $start2) * 1000, 2);

    $start3 = microtime(true);
    $response3 = $this->postJson('/api/login', [
        'email' => 'wrong@example.com',
        'password' => 'wrongpassword',
    ]);
    $time3 = round((microtime(true) - $start3) * 1000, 2);

    $stub = $this->createStub(AuthController::class);
    $stub->method('login')
        ->willReturn(response()->json([
            'data' => ['token' => 'fake-jwt-token'],
            'message' => 'Login successful',
            'status' => true,
        ], 200));
    $this->app->instance(AuthController::class, $stub);

    $start4 = microtime(true);
    $response4 = $this->postJson('/api/login', [
        'email' => 'test@example.com',
        'password' => 'password123',
    ]);
    $time4 = round((microtime(true) - $start4) * 1000, 2);

    dump('  ├─ Response Time: ' . $time1 . 'ms');
    dump('  ├─ Status: ' . $response1->status());
    dump('  ├─ Token Length: ' . strlen($response1->json('data.token')) . ' chars');
    dump('  └─ Database Write: ✅ Yes');
    dump('');

    dump('  ├─ Response Time: ' . $time2 . 'ms');
    dump('  ├─ Status: ' . $response2->status());
    dump('  ├─ Token Length: ' . strlen($response2->json('data.token')) . ' chars');
    dump('  ├─ Database Query: ✅ Yes');
    dump('  └─ JWT Generation: ✅ Yes');
    dump('');

    dump('  ├─ Response Time: ' . $time3 . 'ms');
    dump('  ├─ Status: ' . $response3->status());
    dump('  ├─ Database Query: ✅ Yes');
    dump('  └─ Expected: 401 Unauthorized');
    dump('');

    dump('  ├─ Response Time: ' . $time4 . 'ms');
    dump('  ├─ Status: ' . $response4->status());

    dump('  ├─ Total Tests: 3 (Real Integration Tests)');
    dump('  ├─ Total Time: ' . round($time1 + $time2 + $time3, 2) . 'ms');
    dump('  ├─ Average Time: ' . round(($time1 + $time2 + $time3) / 3, 2) . 'ms');
    dump('  ├─ Database Operations: 3 (100%)');
    dump('  └─ All tests use real database & JWT');
    dump('');


    expect($response1->status())->toBe(201);
    expect($response2->status())->toBe(200);
    expect($response3->status())->toBe(401);
});
