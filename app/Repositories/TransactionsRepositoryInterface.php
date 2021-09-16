<?php

namespace App\Repositories;

use App\Models\Transactions;

interface TransactionsRepositoryInterface {

    public function __construct(Transactions $data);

    public function getAll();

    public function get(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);
}
