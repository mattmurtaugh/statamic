<?php

namespace Statamic\Policies;

use Statamic\API\Form;

class FormPolicy
{
    public function before($user, $ability)
    {
        $user = User::fromUser($user);

        if ($user->hasPermission('configure forms')) {
            return true;
        }
    }

    public function index($user)
    {
        $user = User::fromUser($user);

        if ($this->create($user)) {
            return true;
        }

        return ! Form::all()->filter(function ($form) use ($user) {
            return $this->view($user, $form);
        })->isEmpty();
    }

    public function view($user, $form)
    {
        $user = User::fromUser($user);

        return $user->hasPermission("view {$form->handle()} form submissions");
    }

    public function edit($user, $form)
    {
        //
    }

    public function create($user)
    {
        //
    }

    public function delete($user, $form)
    {
        //
    }
}
