<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Exceptions\CustomValidationException;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;

class UserService extends AbstractService {

    private $repository;

    public function __construct(UserRepositoryInterface $Repository) {
        $this->repository = $Repository;
    }

    /**
     * function to list all user table records
     * @return type
     */
    public function getAll() {
        return $this->repository->getAll();
    }

    public function get($id) {
        return $this->repository->get($id);
    }

    public function create(array $data) {
        $validator = Validator::make($data, User::RULE_USER);
        if ($validator->fails()) {
            throw new CustomValidationException('Falha na validação dos dados', $validator->errors());
        }
        return $this->repository->create($data);
    }

    public function update(int $id, array $data) {
//        $validator = Validator::make($data, User::RULE_USER);
//        if ($validator->fails()) {
//            throw new CustomValidationException('Falha na validação dos dados', $validator->errors());
//        }
        return $this->repository->update($id, $data);
    }

    public function delete($id) {
        return $this->repository->delete($id);
    }

    function checkSendReceive(int $idUser) {
         return $this->repository->checkSendReceive($idUser);
    }

    /**
     * validates the issuer's balance
     * @param int $idUser
     * @param float $value
     * @return array[message, numberErro, statusErro]
     */
    function checkBalance(int $idUser) {
        return $this->repository->balanceToUser($idUser);
    }

}
