<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Exceptions\CustomValidationException;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;

class AbstractService {

    /**
     * default method for success messages from performed http requests
     * @param array $data
     * @param int $statusCode
     * @return array
     */
    protected function successResponse(array $data, int $statusCode = Response::HTTP_OK): array {
        return [
            'status' => $statusCode,
            'data' => $data
        ];
    }

    /**
     *  default method for error messages from performed http requests
     * @param \Exception $e
     * @param int $statusCode
     * @return array
     */
    protected function errorResponse(Exception $e, int $statusCode = Response::HTTP_BAD_REQUEST): array {
        return [
        'status' => $statusCode,
        'erro' => true,
        'message' => $e->getMessage()
        ];
    }
    
    /**
     *  default method for error messages from performed http requests
     * @param \Exception $e
     * @param int $statusCode
     * @return array
     */
    protected function messageResponse(string $message, int $statusCode = Response::HTTP_BAD_REQUEST, bool $error): array {
        return [
        'message' => $message,
        'status' => $statusCode,
        'erro' => $error
        ];
    }

}
