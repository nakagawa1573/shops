<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Evaluation;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class EvaluationPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Evaluation $evaluation)
    {
        return $user->id === $evaluation->user_id;
    }

    public function destroy(User $user, Evaluation $evaluation)
    {
        return $user->id === $evaluation->user_id;
    }
}
