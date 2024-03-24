<?php

namespace Tests\Feature\Livewire\Survey;

use App\Livewire\Survey\DimensionsList;
use App\Models\Dimension;
use Livewire\Livewire;
use Tests\TestCase;
use Faker\Factory;

class DimensionsListTest extends TestCase
{
    /** @test */
    public function viewPage()
    {
        Livewire::test(DimensionsList::class)
            ->assertStatus(200);
    }

    /** @test */
    public function createDimension(): void
    {
        $faker = Factory::create();
        $name = $faker->name;
        $description = $faker->sentence;
        Livewire::test(DimensionsList::class)
            ->set('name', $name)
            ->set('description', $description)
            ->call('create');

        $this->assertDatabaseHas('dimensions', [
            'name' => $name,
            'description' => $description,
        ]);
    }

    /** @test */
    public function createSubdimension(): void
    {
        $faker = Factory::create();
        $name = $faker->name;
        $description = $faker->sentence;
        $dimension = Dimension::inRandomOrder()->first();
        Livewire::test(DimensionsList::class)
            ->set('dimension_id', $dimension->id)
            ->set('name', $name)
            ->set('description', $description)
            ->call('createSubdimension');

        $this->assertDatabaseHas('dimensions', [
            'name' => $name,
            'description' => $description,
            'dimension_id' => $dimension->id,
        ]);
    }
}
