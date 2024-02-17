<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\User;
use Tests\TestCase;

class BranchAPITest extends TestCase
{
    public function test_branch_api_call_create_with_auto_code_expect_successful()
    {
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

    public function test_branch_api_call_create_with_random_code_expect_successful()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $branch = Branch::factory()->make()->toArray();

        $api = $this->json('POST', 'api/v1/branches', $branch);

        $api->assertSuccessful();

        $this->assertDatabaseHas('branches', $branch);
    }

    public function test_branch_api_call_create_with_existing_code_expect_failure()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $branch = Branch::factory()->create();

        $api = $this->json('POST', 'api/v1/branches', $branch->toArray());

        $api->assertStatus(422);
    }

    public function test_branch_api_call_read_expect_collection()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $api = $this->json('GET', 'api/v1/branches');

        $api->assertSuccessful();
    }

    public function test_branch_api_call_update_with_auto_code_expect_successful()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $branch = Branch::factory()->create();

        $branch->name = 'Updated Name';

        $api = $this->json('POST', 'api/v1/branches/'.$branch->id, $branch->toArray());

        $api->assertSuccessful();

        $this->assertDatabaseHas('branches', $branch->toArray());
    }

    public function test_branch_api_call_update_with_random_code_expect_successful()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $branch = Branch::factory()->create();

        $updatedBranch = Branch::factory()->make()->toArray();

        $api = $this->json('POST', 'api/v1/branches/'.$branch->id, $updatedBranch);

        $api->assertSuccessful();

        $this->assertDatabaseHas('branches', $updatedBranch);
    }

    public function test_branch_api_call_update_with_existing_code_expect_failure()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $branch = Branch::factory()->create();
        $branch2 = Branch::factory()->create();

        $branch->code = $branch2->code;

        $api = $this->json('POST', 'api/v1/branches/'.$branch->id, $branch->toArray());

        $api->assertStatus(422);
    }

    public function test_branch_api_call_delete_expect_successful()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $branch = Branch::factory()->create();

        $api = $this->json('DELETE', 'api/v1/branches/'.$branch->id);

        $api->assertSuccessful();

        $this->assertSoftDeleted('branches', $branch->toArray());
    }
}
