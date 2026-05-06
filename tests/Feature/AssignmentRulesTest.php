<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssignmentRulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_and_member_cannot_create_short_urls(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $member = User::factory()->create(['role' => User::ROLE_MEMBER]);

        $this->actingAs($admin)->post('/short-urls', ['original_url' => 'https://example.com'])->assertForbidden();
        $this->actingAs($member)->post('/short-urls', ['original_url' => 'https://example.com'])->assertForbidden();
    }

    public function test_super_admin_cannot_create_short_urls(): void
    {
        $superAdmin = User::factory()->create(['role' => User::ROLE_SUPER_ADMIN]);

        $this->actingAs($superAdmin)->post('/short-urls', ['original_url' => 'https://example.com'])->assertForbidden();
    }

    public function test_admin_only_sees_urls_not_from_own_company(): void
    {
        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $admin = User::factory()->create(['role' => User::ROLE_ADMIN, 'company_id' => $companyA->id]);
        $ownUser = User::factory()->create(['company_id' => $companyA->id]);
        $otherUser = User::factory()->create(['company_id' => $companyB->id]);

        $ownShort = ShortUrl::create(['user_id' => $ownUser->id, 'original_url' => 'https://own.com', 'code' => 'own11111']);
        $otherShort = ShortUrl::create(['user_id' => $otherUser->id, 'original_url' => 'https://other.com', 'code' => 'oth22222']);

        $response = $this->actingAs($admin)->get('/short-urls');

        $response->assertOk();
        $response->assertDontSee($ownShort->code);
        $response->assertSee($otherShort->code);
    }

    public function test_member_only_sees_urls_not_created_by_themselves(): void
    {
        $member = User::factory()->create(['role' => User::ROLE_MEMBER]);
        $other = User::factory()->create();

        $mine = ShortUrl::create(['user_id' => $member->id, 'original_url' => 'https://mine.com', 'code' => 'mine1111']);
        $others = ShortUrl::create(['user_id' => $other->id, 'original_url' => 'https://other.com', 'code' => 'other111']);

        $response = $this->actingAs($member)->get('/short-urls');

        $response->assertOk();
        $response->assertDontSee($mine->code);
        $response->assertSee($others->code);
    }

    public function test_short_urls_are_not_publicly_resolvable(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_MANAGER]);
        $shortUrl = ShortUrl::create([
            'user_id' => $user->id,
            'original_url' => 'https://example.com',
            'code' => 'abc12345',
        ]);

        $this->get('/s/'.$shortUrl->code)->assertRedirect('/login');
        $this->actingAs($user)->get('/s/'.$shortUrl->code)->assertRedirect('https://example.com');
    }
}
