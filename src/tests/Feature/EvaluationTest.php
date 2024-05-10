<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Evaluation;
use App\Models\Owner;
use App\Models\Shop;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class EvaluationTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function testEvaluationSuccess(): void
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $evaluation = rand(1, 5);
        $comment = fake()->realText(400);
        $response = $this->followingRedirects()
            ->actingAs($user)
            ->post('/detail/evaluation/' . $shop->id, [
                'evaluation' => $evaluation,
                'comment' => $comment,
            ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('evaluations', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'evaluation' => $evaluation,
            'comment' => $comment,
        ]);
    }

    public function testEvaluationErrorNotLogin(): void
    {
        $this->post('/detail/1/evaluation', [
            'evaluation' => 5,
            'comment' => 'test',
        ]);
        $this->assertDatabaseMissing('evaluations', [
            'shop_id' => 1,
            'evaluation' => 5,
            'comment' => 'test',
        ]);
    }

    public function testEvaluationErrorAccountOwner()
    {
        $user = Owner::inRandomOrder()->first();
        $shop = Shop::inRandomOrder()->first();
        $evaluation = rand(1, 5);
        $comment = fake()->realText(50);
        $response = $this->followingRedirects()->actingAs($user, 'owners')
            ->post('/detail/evaluation/' . $shop->id, [
                'evaluation' => $evaluation,
                'comment' => $comment,
            ]);
        $response->assertViewIs('index');
        $this->assertDatabaseMissing('evaluations', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'evaluation' => $evaluation,
            'comment' => $comment,
        ]);
    }

    public function testEvaluationErrorAccountAdmin()
    {
        $user = Admin::inRandomOrder()->first();
        $shop = Shop::inRandomOrder()->first();
        $evaluation = rand(1, 5);
        $comment = fake()->realText(50);
        $response = $this->followingRedirects()->actingAs($user, 'admins')
            ->post('/detail/evaluation/' . $shop->id, [
                'evaluation' => $evaluation,
                'comment' => $comment,
            ]);
        $response->assertViewIs('index');
        $this->assertDatabaseMissing('evaluations', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'evaluation' => $evaluation,
            'comment' => $comment,
        ]);
    }

    public function testEvaluationErrorAgain()
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $evaluation = rand(1, 5);
        $comment = fake()->realText(400);
        $this->followingRedirects()
            ->actingAs($user)
            ->post('/detail/evaluation/' . $shop->id, [
                'evaluation' => $evaluation,
                'comment' => $comment,
            ]);
        $evaluation = rand(1, 5);
        $comment = fake()->realText(400);
        $response = $this->actingAs($user)
            ->post('/detail/evaluation/' . $shop->id, [
                'evaluation' => $evaluation,
                'comment' => $comment,
            ]);
        $response->assertStatus(302)->assertSessionHas('message', '既に口コミが投稿されています');
        $this->assertDatabaseMissing('evaluations', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'evaluation' => $evaluation,
            'comment' => $comment,
        ]);
    }

    public function testEvaluationErrorCommentMax()
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $evaluation = rand(1, 5);
        $comment = fake()->realText(450);
        $response = $this->actingAs($user)
            ->post('/detail/evaluation/' . $shop->id, [
                'evaluation' => $evaluation,
                'comment' => $comment,
            ]);
        $response->assertStatus(302)->assertSessionHasErrors('comment');
        $this->assertDatabaseMissing('evaluations', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'evaluation' => $evaluation,
        ]);
    }

    public function testEvaluationErrorEvaluationNull()
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $evaluation = rand(1, 5);
        $comment = fake()->realText(50);
        $response = $this->actingAs($user)
            ->post('/detail/evaluation/' . $shop->id, [
                'evaluation' => null,
                'comment' => $comment,
            ]);
        $response->assertStatus(302)->assertSessionHasErrors('evaluation');
        $this->assertDatabaseMissing('evaluations', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'evaluation' => null,
            'comment' => $comment,
        ]);
    }

    public function testEvaluationErrorEvaluationBetween()
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $evaluation = rand();
        $comment = fake()->realText(50);
        $response = $this->actingAs($user)
            ->post('/detail/evaluation/' . $shop->id, [
                'evaluation' => $evaluation,
                'comment' => $comment,
            ]);
        $response->assertStatus(302)->assertSessionHasErrors('evaluation');
        $this->assertDatabaseMissing('evaluations', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'evaluation' => $evaluation,
            'comment' => $comment,
        ]);
    }

    public function testEvaluationErrorImgFormat()
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $evaluation = rand(1, 5);
        $comment = fake()->realText(50);
        $img = UploadedFile::fake()->image('evaluation.svg');
        $response = $this->actingAs($user)
            ->post('/detail/evaluation/' . $shop->id, [
                'evaluation' => $evaluation,
                'comment' => $comment,
                'img' => $img,
            ]);
        $response->assertStatus(302)->assertSessionHasErrors('img');
        $this->assertDatabaseMissing('evaluations', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'evaluation' => $evaluation,
            'comment' => $comment,
        ]);
    }

    public function testEvaluationSuccessUpdate()
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $data = [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'evaluation' => 5,
            'comment' => 'うまいよ',
        ];
        $evaluationId = Evaluation::create($data)->id;
        $this->assertDatabaseHas('evaluations', $data);
        $evaluation = rand(1, 5);
        $comment = fake()->realText(50);
        $response = $this->followingRedirects()
            ->actingAs($user)
            ->patch('/detail/evaluation/' . $shop->id . '/' . $evaluationId, [
                'evaluation' => $evaluation,
                'comment' => $comment,
            ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('evaluations', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'evaluation' => $evaluation,
            'comment' => $comment,
        ]);
        $this->assertDatabaseMissing('evaluations', $data);
    }

    public function testEvaluationErrorUpdateOtherUserId()
    {
        $user = User::factory()->create();
        $evaluationData = Evaluation::inRandomOrder()->first();
        $evaluation = rand(1, 5);
        $comment = fake()->realText(50);
        $response = $this->followingRedirects()
            ->actingAs($user)
            ->patch('/detail/evaluation/' . $evaluationData->shop_id . '/' . $evaluationData->id, [
                'evaluation' => $evaluation,
                'comment' => $comment,
            ]);
        $response->assertStatus(403);
        $this->assertDatabaseHas('evaluations', [
            'user_id' => $evaluationData->user_id,
            'shop_id' => $evaluationData->shop_id,
            'evaluation' => $evaluationData->evaluation,
            'comment' => $evaluationData->comment,
        ]);
        $this->assertDatabaseMissing('evaluations', [
            'user_id' => $user->id,
            'shop_id' => $evaluationData->shop_id,
            'evaluation' => $evaluation,
            'comment' => $comment,
        ]);
    }

    public function testEvaluationSuccessMovePage()
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $data = [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'evaluation' => 5,
            'comment' => 'うまいよ',
        ];
        $evaluationId = Evaluation::create($data)->id;
        $this->assertDatabaseHas('evaluations', $data);
        $response = $this
            ->actingAs($user)
            ->get('/detail/evaluation/' . $shop->id);
        $response->assertStatus(200)
            ->assertSeeText($data['comment'], $data['evaluation']);
    }

    public function testEvaluationSuccessDelete()
    {
        $evaluation = Evaluation::inRandomOrder()->first();
        $user = User::find($evaluation->user_id);
        $response = $this->actingAs($user)
            ->delete('/detail/evaluation/delete/' . $evaluation->id);
        $response->assertStatus(302)
                ->assertSessionHas('message', '削除に成功しました');
        $this->assertDatabaseMissing('evaluations', [
            'id' => $evaluation->id,
        ]);
    }

    public function testEvaluationSuccessDeleteFromAdmin()
    {
        $evaluation = Evaluation::inRandomOrder()->first();
        $user = Admin::inRandomOrder()->first();
        $response = $this->actingAs($user, 'admins')
            ->delete('/detail/evaluation/delete/' . $evaluation->id);
        $response->assertStatus(302)
            ->assertSessionHas('message', '削除に成功しました');
        $this->assertDatabaseMissing('evaluations', [
            'id' => $evaluation->id,
        ]);
    }

    public function testEvaluationErrorDeleteFromOwner()
    {
        $evaluation = Evaluation::inRandomOrder()->first();
        $user = Owner::inRandomOrder()->first();
        $this->actingAs($user, 'owners')
        ->delete('/detail/evaluation/delete/' . $evaluation->id);
        $this->assertDatabaseHas('evaluations', [
            'id' => $evaluation->id,
        ]);
    }
}
