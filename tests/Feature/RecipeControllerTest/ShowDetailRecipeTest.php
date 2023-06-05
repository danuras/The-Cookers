<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\GroupIngredient;
use App\Models\Ingredient;
use App\Models\Ratting;
use App\Models\Recipe;
use App\Models\Step;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowDetailRecipeTest extends TestCase
{
    /**
     * @test
     */
    public function test_show_detail(): void
    {
        // Membuat user baru untuk dihapus
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Membuat sebuah resep
        $recipe = Recipe::factory()->create();

        // Membuat kelompok bahan untuk resep
        $groupIngredients = GroupIngredient::factory()->count(3)->create([
            'recipe_id' => $recipe->id,
        ]);

        // Membuat bahan untuk setiap kelompok bahan
        foreach ($groupIngredients as $groupIngredient) {
            Ingredient::factory()->count(2)->create([
                'group_ingredient_id' => $groupIngredient->id,
            ]);
        }

        // Membuat langkah-langkah untuk resep
        $steps = Step::factory()->count(5)->create([
            'images' => json_encode([]),
            'recipe_id' => $recipe->id,
        ]);

        // Membuat ratting dan komentar untuk resep
        $i = 0;
        for ($i = 0; $i < 5; $i++) {
            // Membuat user yang memberikan ratting
            $user = User::factory()->create();
            Ratting::factory()->create([
                'value' => 3,
                'user_id' => $user->id,
                'recipe_id' => $recipe->id,
            ]);
            Comment::factory()->create([
                'images' => json_encode([]),
                'user_id' => $user->id,
                'recipe_id' => $recipe->id,
            ]);
        }

        // Melakukan permintaan GET ke endpoint showDetail
        $response = $this->get('/recipes/' . $recipe->id);

        // Memastikan bahwa respons berhasil (successful)
        $response->assertStatus(200);

        // Memastikan bahwa view yang dipanggil adalah view detail_resep
        $response->assertViewIs('recipes.detail_recipe');

        // Memastikan bahwa data resep diteruskan ke tampilan (view)
        $response->assertViewHas('recipe', $recipe);

        // Memastikan bahwa data kelompok bahan diteruskan ke tampilan (view)
        $response->assertViewHas('groupIngredients');

        // Memastikan bahwa data langkah-langkah diteruskan ke tampilan (view)
        $response->assertViewHas('steps', $recipe->steps);

        // Memastikan bahwa data komentar-komentar diteruskan ke tampilan (view)
        $response->assertViewHas('comments', $recipe->comments);

        // Memastikan bahwa data rata-rata ratting diteruskan ke tampilan (view)
        $response->assertViewHas('avg_ratting', $recipe->averageRatting());
    }
}