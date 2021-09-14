<?php

namespace App\Repositories;

use App\Models\UserTypes;

interface UserTypeRepositoryInterface {

    public function __construct(UserTypes $data);

    public function getAll();

    public function get(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);
}
