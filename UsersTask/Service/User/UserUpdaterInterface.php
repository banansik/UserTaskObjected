<?php
declare(strict_types=1);

namespace UsersTask\Service\User;

use UsersTask\Entity\User;

interface UserUpdaterInterface
{
    public function update(array $users): void;
}