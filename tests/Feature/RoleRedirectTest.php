<?php

use App\Models\User;

dataset('roles', [
    ['admin', '/admin/dashboard'],
    ['lecturer', '/lecturer/dashboard'],
    ['member', '/student/dashboard'],
]);

it('redirects authenticated users to the correct dashboard based on role', function (string $role, string $expected): void {
    $user = User::factory()->create([
        'role' => $role,
        'status' => 'active',
    ]);

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertRedirect($expected);
})->with('roles');
