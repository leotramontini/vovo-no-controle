<?php

namespace Vovo\Transformer;

use League\Fractal\TransformerAbstract;
use Vovo\Models\User;

class UserTransformer extends TransformerAbstract
{
    /**
     * @param \Vovo\Models\User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email
        ];
    }
}
