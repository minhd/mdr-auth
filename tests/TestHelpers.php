<?php

function create($class, array $attributes = [], int $count = 1)
{
    if ($count === 1) {
        return factory($class)->create($attributes);
    }

    for ($i = 0; $i < $count; $i++) {
        factory($class)->create($attributes);
    }

    return true;
}

function signIn($user = null)
{
    if ($user === null) {
        $user = factory(MinhD\User::class)->create();
    }
    Laravel\Passport\Passport::actingAs($user);
    return $user;
}

function signInAdmin()
{
    $user = factory(MinhD\User::class)->create();
    $user->addRole('admin');
    Laravel\Passport\Passport::actingAs($user);
}
