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

    public function getAll() {
        return $this->repository->getAll();
    }

    public function get($id) {
        return $this->repository->get($id);
    }

    public function create(array $data) {
        $validator = Validator::make($data, UserTypes::RULE_TYPE_USER);

        if ($validator->fails()) {
            throw new CustomValidationException('Falha na validação dos dados', $validator->errors());
        }

        return $this->repository->create($data);
    }

    public function update(int $id, array $data) {
        $validator = Validator::make($data, UserTypes::RULE_TYPE_USER);
        if ($validator->fails()) {
            throw new CustomValidationException('Falha na validação dos dados', $validator->errors());
        }
        return $this->repository->update($id, $data);
    }

    public function delete($id) {
        return $this->repository->delete($id);
    }

}
