<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BranchAPITest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_branch_api_call_create_with_auto_code_expect_successful()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $branch = Branch::factory()->make(['code' => 'AUTO'])->toArray();

        $branchImages = [];
        for ($i = 0; $i < 3; $i++) {
            array_push($branchImages, ProductImage::factory()->make()->image);
        }
        $branch['images'] = $branchImages;

        $api = $this->json('POST', 'api/v1/branches', $branch);

        $api->assertSuccessful();

        $branch['code'] = $api->json('data')['code'];

        $this->assertDatabaseHas(
            'branches', Arr::except($branch, ['images'])
        );

        foreach ($api['data']['images'] as $image) {
            $this->assertTrue(Storage::disk('public')->exists($image));
        }
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

        $updatedBranch = Branch::factory()->make(['code' => 'AUTO'])->toArray();

        $branchImages = [];
        for ($i = 0; $i < 3; $i++) {
            array_push($branchImages, ProductImage::factory()->make()->image);
        }
        $updatedBranch['images'] = $branchImages;

        $api = $this->json('POST', 'api/v1/branches/'.$branch->id, $updatedBranch);

        $api->assertSuccessful();

        $updatedBranch['code'] = $api->json('data')['code'];

        // $this->assertDatabaseHas('branches', $updatedBranch);
        $this->assertDatabaseHas(
            'branches', Arr::except($updatedBranch, ['images'])
        );

        foreach ($api['data']['images'] as $image) {
            $this->assertTrue(Storage::disk('public')->exists($image));
        }
    }

    public function test_branch_api_call_update_with_random_code_and_main_branch_is_true_expect_successful()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $branch = Branch::factory()->create();

        $api = $this->json('POST', 'api/v1/branches/'.$branch->id.'/main', ['is_main' => true]);

        $api->assertSuccessful();

        $this->assertDatabaseHas('branches', [
            'id' => $branch->id,
            'is_main' => true,
        ]);

        $count = Branch::where([
            ['id', '!=', $branch->id],
            ['is_main', '=', true],
        ])->count();

        $this->assertTrue($count == 0);
    }

    public function test_branch_api_call_update_with_random_code_and_main_branch_is_false_expect_successful()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $branch = Branch::factory()->create(['is_main' => true]);

        $api = $this->json('POST', 'api/v1/branches/'.$branch->id.'/main', ['is_main' => false]);

        $api->assertSuccessful();

        $this->assertDatabaseHas('branches', ['id' => $branch->id, 'is_main' => false]);
    }

    public function test_branch_api_call_update_with_random_code_and_active_branch_is_true_expect_successful()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $branch = Branch::factory()->create();

        $api = $this->json('POST', 'api/v1/branches/'.$branch->id.'/active', ['is_active' => true]);

        $api->assertSuccessful();

        $this->assertDatabaseHas('branches', ['id' => $branch->id, 'is_active' => true]);
    }

    public function test_branch_api_call_update_with_random_code_and_active_branch_is_false_expect_successful()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $branch = Branch::factory()->create(['is_active' => true]);

        $api = $this->json('POST', 'api/v1/branches/'.$branch->id.'/active', ['is_active' => false]);

        $api->assertSuccessful();

        $this->assertDatabaseHas('branches', ['id' => $branch->id, 'is_active' => false]);
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

        $existingBranch = Branch::factory()->create();

        $branch = Branch::factory()->create();

        $updatedBranch = $branch->toArray();
        $updatedBranch['code'] = $existingBranch->code;

        $api = $this->json('POST', 'api/v1/branches/'.$branch->id, $updatedBranch);

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
