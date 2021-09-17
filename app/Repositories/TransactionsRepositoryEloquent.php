<?php

namespace App\Repositories;


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

//        DB::beginTransaction();
//        $transaction = $this->model->create($data);
//       
//        
//        $payer = $this->modelUser->update($data['transferencia_pagador'], $a);
//        $payee = $this->modelUser->update($data['transferencia_beneficiado'], $b);
//
//        if ($transaction && $payer && $payee) {
//            DB::commit();
//        } else {
//            DB::rollBack();
//        }
        
        return $this->model->create($data);
//        return ['fiquei','verde'];
    }

    public function update(int $id, array $data) {
        return $this->model->find($id)->update($data);
    }

    public function delete(int $id) {
        return $this->model->find($id)->delete();
    }

}
