<?php

namespace Tests\Feature;

use App\Models\GreenScorMetric;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class GreenScorCalculationTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
        ]);

        $this->user = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@batikmadura.id',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'is_active' => true,
        ]);
    }

    public function test_green_scor_metric_can_be_updated_and_normalized(): void
    {
        $metric = GreenScorMetric::create([
            'code' => 'TEST-01',
            'dimension' => 'PLAN',
            'metric_name' => 'Uji Metrik Perencanaan',
            'unit' => '%',
            'target_value' => 100,
            'actual_value' => 80,
            'weight' => 0.1000,
            'normalized_score' => 80,
            'final_score' => 8,
        ]);

        $response = $this->actingAs($this->user)->patch(route('green-supply-chain.update', $metric), [
            'actual_value' => 90,
            'weight' => 0.1500,
        ]);

        $response->assertRedirect(route('green-supply-chain.index'));

        $this->assertDatabaseHas('green_scor_metrics', [
            'id' => $metric->id,
            'actual_value' => 90,
            'weight' => 0.1500,
            'normalized_score' => 90.00,
            'final_score' => 13.50, // 90 * 0.15 = 13.50
        ]);
    }

    public function test_recalculate_generates_new_evaluation_result(): void
    {
        GreenScorMetric::create([
            'code' => 'PL-01',
            'dimension' => 'PLAN',
            'metric_name' => 'Akurasi Rencana',
            'unit' => '%',
            'target_value' => 100,
            'actual_value' => 80,
            'weight' => 1.0000,
            'normalized_score' => 80,
            'final_score' => 80,
        ]);

        $response = $this->actingAs($this->user)->post(route('green-supply-chain.recalculate'));

        $response->assertRedirect(route('green-supply-chain.index'));
        $this->assertDatabaseHas('green_scor_results', [
            'total_index' => 80,
            'category' => 'Good',
        ]);
    }
}

