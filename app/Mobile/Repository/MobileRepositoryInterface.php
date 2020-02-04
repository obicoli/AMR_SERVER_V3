<?php

namespace App\Mobile\Repository;

use App\Models\Users\User;

interface MobileRepositoryInterface {
    public function transformUser(User $user);
}