<?php

namespace App\Policies;

use App\Models\Owner;
use App\Models\Shop;

class ShopPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(Owner $owner, Shop $shop)
    {
        return $owner->id === $shop->owner_id;
    }

}
