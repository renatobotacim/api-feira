<?php

namespace App\Repositories;

use App\Models\Transactions;
use App\Repositories\UserRepositoryEloquent;

interface TransactionsRepositoryInterface {

    public function __construct(Transactions $data, UserRepositoryEloquent $user);

    public function getAll();

    public function get(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);
}
