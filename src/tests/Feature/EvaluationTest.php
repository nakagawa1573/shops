<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;

class EvaluationTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function testEvaluationSuccess(): void
    {
        $user = User::find(1);
        $this->actingAs($user)
            ->post('/detail/1/evaluation', [
                'evaluation' => 5,
                'comment' => 'test',
            ]);
        $this->assertDatabaseHas('evaluations', [
            'user_id' => $user->id,
            'shop_id' => 1,
            'evaluation' => 5,
            'comment' => 'test',
        ]);
    }

    public function testEvaluationErrorNotLogin(): void
    {
        $user = User::find(1);
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

    public function testEvaluationErrorEvaluationNull()
    {
        $user = User::find(1);
        $request = $this->actingAs($user)
            ->post('/detail/1/evaluation', [
                'evaluation' => null,
                'comment' => 'test',
            ]);
        $request->assertSessionHasErrors('evaluation');
    }

    public function testEvaluationErrorEvaluationType()
    {
        $user = User::find(1);
        $request = $this->actingAs($user)
            ->post('/detail/1/evaluation', [
                'evaluation' => 'test',
                'comment' => 'test',
            ]);
        $request->assertSessionHasErrors('evaluation');
    }

    public function testEvaluationErrorEvaluationDifference()
    {
        $user = User::find(1);
        $request = $this->actingAs($user)
            ->post('/detail/1/evaluation', [
                'evaluation' => 0,
                'comment' => 'test',
            ]);
        $request->assertSessionHasErrors('evaluation');
    }

    public function testEvaluationErrorCommentNull()
    {
        $user = User::find(1);
        $request = $this->actingAs($user)
            ->post('/detail/1/evaluation', [
                'evaluation' => 5,
                'comment' => null,
            ]);
        $request->assertSessionHasErrors('comment');
    }

    public function testEvaluationErrorCommentType()
    {
        $user = User::find(1);
        $request = $this->actingAs($user)
            ->post('/detail/1/evaluation', [
                'evaluation' => 5,
                'comment' => ['comment' => 'test'],
            ]);
        $request->assertSessionHasErrors('comment');
    }

    public function testEvaluationErrorCommentMax()
    {
        $user = User::find(1);
        $request = $this->actingAs($user)
            ->post('/detail/1/evaluation', [
                'evaluation' => 5,
                'comment' => 'testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttest',
            ]);
        $request->assertSessionHasErrors('comment');
    }
}
