<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\User;
use Tests\TestCase;

class BranchAPITest extends TestCase
{
    public function test_branch_api_call_create_with_auto_code_expect_successful()
    {
        $this->markTestSkipped('This test is skipped because it is not implemented yet.');
        
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $branch = Branch::factory()->make(['code' => 'AUTO'])->toArray();

        $api = $this->json('POST', 'api/v1/branches', $branch);

        $api->assertSuccessful();

        $branch['code'] = $api->json('data')['code'];

        $this->assertDatabaseHas('branches', $branch);
    }
}
