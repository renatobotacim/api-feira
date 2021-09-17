<?php

namespace App\Repositories;

use App\Models\User;

class UserRepositoryEloquent implements UserRepositoryInterface {

    private $model;

    public function __construct(User $data) {
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

    function checkSendReceive(int $id) {
        return $this->model
                        ->join('inf_tipos_usuarios', 'tipo_usuario_id', '=', 'usuario_tipo_usuario_id')
                        ->select('tipo_usuario_envia', 'tipo_usuario_recebe')
                        ->find($id);
    }

    function checkBalance(int $id) {
        return $this->model
                        ->select('usuario_saldo')
                        ->find($id);
    }

}
