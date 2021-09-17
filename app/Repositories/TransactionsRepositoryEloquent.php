<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Transactions;
use App\Repositories\UserRepositoryEloquent;

class TransactionsRepositoryEloquent implements TransactionsRepositoryInterface {

    private $model;
    private $modelUser;

    public function __construct(Transactions $data, UserRepositoryEloquent $user) {
        $this->model = $data;
        $this->modelUser = $user;
    }

    public function getAll() {
        return $this->model->all();
    }

    public function get($id) {
        return $this->model->find($id);
    }

    public function create(array $data) {




//        \DB::transaction(function () {
//            DB::update('update users set votes = 1');
//
//            DB::delete('delete from posts');
//        });


        DB::beginTransaction();
        $transaction = $this->model->create($data);
        $a = ['usuario_saldo' => 1];
        $b = ['usuario_saldo' => 2];
        $payer = $this->modelUser->update(1, $a);
        $payee = $this->modelUser->update(2, $b);

        if ($transaction && $payer && $payee) {
            DB::commit();
        } else {
            DB::rollBack();
        }
        
//        return $this->model->create($data);
        return ['fiquei','verde'];
    }

    public function update(int $id, array $data) {
        return $this->model->find($id)->update($data);
    }

    public function delete(int $id) {
        return $this->model->find($id)->delete();
    }

}
