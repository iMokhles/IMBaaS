<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($user)
    {
        return [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'emailVerified' => (bool)$user->emailVerified,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];
    }
}
