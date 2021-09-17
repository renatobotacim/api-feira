<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Exceptions\CustomValidationException;
//use Illuminate\Support\Facades\DB;
use App\Models\UserTypes;
use App\Repositories\UserTypeRepositoryInterface;

class UserTypeService {

    private $repository;

    public function __construct(UserTypeRepositoryInterface $Repository) {
        $this->repository = $Repository;
    }

    /**
     * Method created to list all records in this table.
     * @return array
     */
    public function getAll() {
        return $this->repository->getAll();
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
        $validator = Validator::make($data, UserTypes::RULE_TYPE_USER);
        if ($validator->fails()) {
            throw new CustomValidationException('Falha na validação dos dados', $validator->errors());
        }
        return $this->repository->create($data);
    }

    /**
     * Method created to change the record with id passed as parameter. 
     * @param int $id
     * @param array $data
     * @return bool
     * @throws CustomValidationException
     */
    public function update(int $id, array $data) {
        $validator = Validator::make($data, UserTypes::RULE_TYPE_USER);
        if ($validator->fails()) {
            throw new CustomValidationException('Falha na validação dos dados', $validator->errors());
        }
        return $this->repository->update($id, $data);
    }

    /**
     * Method created to delete the record with id passed as parameter.
     * @param type $id
     * @return 
     */
    public function delete($id) {
        return $this->repository->delete($id);
    }

}
