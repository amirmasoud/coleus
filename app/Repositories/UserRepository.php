<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends Repository
{
    /**
     * @return mixed
     */
    public function featuredAuthors()
    {
        return User::role('writer')
            ->whereHas('sticks');
            // ->take(self::$perPage)
            // ->get();
    }

    /**
     * @return mixed
     */
    public function latest()
    {
        return User::take(self::$perPage);
    }

    /**
     * @param  string $email
     * @return mixed
     */
    public function findByEmail(string $email)
    {
        return User::whereEmail($email);
    }

    /**
     * @param  int $id
     * @return mixed
     */
    public function findById(int $id)
    {
        return User::whereId($id);
    }

    /**
     * @param  string $username
     * @return mixed
     */
    public function findByUsername(string $username)
    {
        return User::whereUsername($username);
    }
}
