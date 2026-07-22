<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class InvitationRulesTest extends TestCase
{
    use RefreshDatabase;

    private function makeCompany(int $id, string $name): void
    {
        DB::table('companies')->insert([
            'id' => $id,
            'name' => $name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function makeUser(int $companyId, string $name, string $email, string $role): User
    {
        return User::create([
            'company_id' => $companyId,
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('password'),
            'role' => $role,
        ]);
    }

    public function test_superadmin_can_invite_admin_in_new_company(): void
    {
        $superAdmin = $this->makeUser(1, 'Super Admin', 'superadmin@mail.com', 'SuperAdmin');

        $response = $this->actingAs($superAdmin)->post(route('invite.store'), [
            'company_name' => 'New Company',
            'email' => 'admin@newcompany.com',
            'role' => 'Admin',
        ]);

        $response->assertSessionHas('invite_link');

        $this->assertDatabaseHas('companies', [
            'name' => 'New Company',
        ]);

        $this->assertDatabaseHas('invitations', [
            'email' => 'admin@newcompany.com',
            'role' => 'Admin',
            'status' => 'Pending',
        ]);
    }

    public function test_admin_can_invite_member_in_own_company(): void
    {
        $this->makeCompany(1, 'Main Company');
        $admin = $this->makeUser(1, 'Admin User', 'admin@mail.com', 'Admin');

        $response = $this->actingAs($admin)->post(route('invite.store'), [
            'email' => 'member@company.com',
            'role' => 'Member',
        ]);

        $response->assertSessionHas('invite_link');

        $this->assertDatabaseHas('invitations', [
            'company_id' => 1,
            'email' => 'member@company.com',
            'role' => 'Member',
            'status' => 'Pending',
        ]);
    }
}
