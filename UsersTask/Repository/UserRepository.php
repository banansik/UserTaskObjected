<?php
declare(strict_types=1);

namespace UserTask\Repository;

use UsersTask\Entity\User;

class UserRepository implements UserRepositoryInterface
{
    private const USER_TABLE_NAME = 'users';

    public function saveUser(User $user): void
    {
        DB::table(self::USER_TABLE_NAME)->insert([
            'name' => $user->getName(),
            'login' => $user->getLogin(),
            'email' => $user->getEmail(),
            'password' =>$user->getPassword()
        ]);
    }

    /**
     * @param array $users
     *
     * array of @param User
     *
     */
    public function saveUsers(array $users): void
    {
        DB::table(self::USER_TABLE_NAME)->insert($users);
    }

    public function countUserLogin(string $login): int
    {
        $users = DB::table('users')->where('login', $login)->count();

        return (int) $users;
    }

    public function updateUser(User $user): void
    {
        DB::table(self::USER_TABLE_NAME)->where('id', $user->getId())->update([
            'name' => $user->getName(),
            'login' => $user->getLogin(),
            'email' => $user->getEmail(),
            'password' =>$user->getPassword()
        ]);
    }

    public function updateUsers(array $users): void
    {
        $unstructuredUsers = [];

        /**
         * @param User $user
         */
        foreach ($users as $user) {
            $unstructuredUsers[] = $user->toArray;
        }

        DB::table(self::USER_TABLE_NAME)->update($unstructuredUsers);
    }
}