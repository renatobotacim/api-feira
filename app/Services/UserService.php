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
     * Method created to list all records in this table.
     * NOTE: The method is commented out because, according to the current business rule, the method should not be used.
     * @return array
     */
    public function getAll() {
//        return $this->repository->getAll();
    }

    /**
     * Method created to list the record with id passed as parameter.
     * @param int $id
     * @return array
     */
    public function get($id) {
        return $this->repository->get($id);
    }

    /**
     * method created to register records
     * @param array $data
     * @return type array
     * @throws CustomValidationException
     */
    public function create(array $data) {
        $validator = Validator::make($data, User::RULE_USER);
        if ($validator->fails()) {
            throw new CustomValidationException('Falha na validação dos dados', $validator->errors());
        }
        return $this->repository->create($data);
    }

    /**
     * Method created to change the record with id passed as parameter. 
     * NOTE: The method is commented out because, according to the current business rule, the method should not be used.
     * @param int $id
     * @param array $data
     * @return bool
     * @throws CustomValidationException
     */
    public function update(int $id, array $data) {
//        $validator = Validator::make($data, User::RULE_USER);
//        if ($validator->fails()) {
//            throw new CustomValidationException('Falha na validação dos dados', $validator->errors());
//        }
        return $this->repository->update($id, $data);
    }

    /**
     * Method created to delete the record with id passed as parameter.
     * @param type $id
     * @return bool
     */
    public function delete($id) {
        return $this->repository->delete($id);
    }

    /**
     * Method verifies that the beneficiary and the payer are authorized to carry out the transfer
     * @param int $idUser
     * @return array
     */
    function checkSendReceive(int $idUser) {
        return $this->repository->checkSendReceive($idUser);
    }

    /**
     * Method returns payer balance 
     * @param int $idUser
     * @return float
     */
    function checkBalance(int $idUser) {
        return $this->repository->checkBalance($idUser);
    }

}
