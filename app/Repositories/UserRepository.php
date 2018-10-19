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
            ->whereHas('sticks')
            // ->take(self::$perPage)
            ->get();
    }

    /**
     * @return mixed
     */
    public function latest()
    {
        return User::take(self::$perPage)->get();
    }

    /**
     * @param  string $email
     * @return mixed
     */
    public function findByEmail(string $email)
    {
        return User::whereEmail($email)->firstOrFail();
    }

    /**
     * @param  int $id
     * @return mixed
     */
    public function findById(int $id)
    {
        return User::whereId($id)->get();
    }
}
