<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Contracts;

interface DeleteUser
{
    /**
     * Delete the given user.
     *
     * @param mixed $user
     *
     * @return void
     */
    public function delete($user);
}
