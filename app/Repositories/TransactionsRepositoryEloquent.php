<?php

namespace App\Repositories;

use App\Models\Transactions;

class TransactionsRepositoryEloquent implements TransactionsRepositoryInterface {

    private $model;

    public function __construct(Transactions $data) {
        $this->model = $data;
    }

    public function getAll() {
        return $this->model->all();
    }

    public function get($id) {
        return $this->model->find($id);
    }

    public function create(array $data) {
        return $this->model->create($data);
    }

    public function update(int $id, array $data) {
        return $this->model->find($id)->update($data);
    }

    public function delete(int $id) {
        return $this->model->find($id)->delete();
    }

}
