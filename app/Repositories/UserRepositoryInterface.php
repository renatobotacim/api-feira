<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepositoryInterface {

    public function __construct(User $data);

    public function getAll();

    public function get(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);
    
    function checkSendReceive(int $id);
    
    function checkBalance(int $id);
    
}
