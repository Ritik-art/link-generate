<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UrlPermissionsTest extends TestCase
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

    private function makeUrl(int $companyId, int $userId, string $url, string $code): void
    {
        DB::table('urls')->insert([
            'company_id' => $companyId,
            'user_id' => $userId,
            'original_url' => $url,
            'short_code' => $code,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function test_admin_can_create_short_url(): void
    {
        $this->makeCompany(1, 'Company One');
        $admin = $this->makeUser(1, 'Admin User', 'admin@mail.com', 'Admin');

        $response = $this->actingAs($admin)->post(route('url.store'), [
            'original_url' => 'https://example.com',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('urls', [
            'company_id' => 1,
            'user_id' => $admin->id,
            'original_url' => 'https://example.com',
        ]);
    }

    public function test_member_can_create_short_url(): void
    {
        $this->makeCompany(1, 'Company One');
        $member = $this->makeUser(1, 'Member User', 'member@mail.com', 'Member');

        $response = $this->actingAs($member)->post(route('url.store'), [
            'original_url' => 'https://member.com',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('urls', [
            'company_id' => 1,
            'user_id' => $member->id,
            'original_url' => 'https://member.com',
        ]);
    }

    public function test_superadmin_cannot_create_short_url(): void
    {
        $this->makeCompany(1, 'Company One');
        $superAdmin = $this->makeUser(1, 'Super Admin', 'superadmin@mail.com', 'SuperAdmin');

        $response = $this->actingAs($superAdmin)->post(route('url.store'), [
            'original_url' => 'https://blocked.com',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('urls', [
            'original_url' => 'https://blocked.com',
        ]);
    }

    public function test_superadmin_can_see_all_short_urls(): void
    {
        $this->makeCompany(1, 'Company One');
        $this->makeCompany(2, 'Company Two');

        $superAdmin = $this->makeUser(1, 'Super Admin', 'superadmin@mail.com', 'SuperAdmin');
        $ownerOne = $this->makeUser(1, 'Owner One', 'owner1@mail.com', 'Admin');
        $ownerTwo = $this->makeUser(2, 'Owner Two', 'owner2@mail.com', 'Admin');

        $this->makeUrl(1, $ownerOne->id, 'https://company-one.test', 'abc111');
        $this->makeUrl(2, $ownerTwo->id, 'https://company-two.test', 'abc222');

        $response = $this->actingAs($superAdmin)->get(route('url.create'));

        $response->assertOk();
        $response->assertSee('https://company-one.test');
        $response->assertSee('https://company-two.test');
        $response->assertDontSee('SuperAdmin can only view short URLs.');
    }

    public function test_admin_can_only_see_own_company_short_urls(): void
    {
        $this->makeCompany(1, 'Company One');
        $this->makeCompany(2, 'Company Two');

        $admin = $this->makeUser(1, 'Admin User', 'admin@mail.com', 'Admin');
        $otherUser = $this->makeUser(2, 'Other User', 'other@mail.com', 'Admin');

        $this->makeUrl(1, $admin->id, 'https://company-one.test', 'abc111');
        $this->makeUrl(2, $otherUser->id, 'https://company-two.test', 'abc222');

        $response = $this->actingAs($admin)->get(route('url.create'));

        $response->assertOk();
        $response->assertSee('https://company-one.test');
        $response->assertDontSee('https://company-two.test');
    }

    public function test_member_can_only_see_own_short_urls(): void
    {
        $this->makeCompany(1, 'Company One');

        $memberOne = $this->makeUser(1, 'Member One', 'member1@mail.com', 'Member');
        $memberTwo = $this->makeUser(1, 'Member Two', 'member2@mail.com', 'Member');

        $this->makeUrl(1, $memberOne->id, 'https://my-link.test', 'abc111');
        $this->makeUrl(1, $memberTwo->id, 'https://other-link.test', 'abc222');

        $response = $this->actingAs($memberOne)->get(route('url.create'));

        $response->assertOk();
        $response->assertSee('https://my-link.test');
        $response->assertDontSee('https://other-link.test');
    }

    public function test_short_url_redirects_publicly(): void
    {
        $this->makeCompany(1, 'Company One');
        $user = $this->makeUser(1, 'Admin User', 'admin@mail.com', 'Admin');
        $this->makeUrl(1, $user->id, 'https://redirect.test', 'xyz123');

        $response = $this->get('/u/xyz123');

        $response->assertRedirect('https://redirect.test');
    }
}
