<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\UserService;
use App\Http\Controllers\Controller;

class UserController extends Controller {

    private $service;

    /**
     * @param UserService $Service
     */
    public function __construct(UserService $Service) {
        $this->service = $Service;
    }

    /**
     * NOTE: The method is commented out because according to the current business rule the method should not be used.
     * @return array
     */
    public function getAll() {
        try {
//            return response()->json($this->service->getAll(), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * @return array
     */
    public function get(int $id) {
        try {
            return response()->json($this->service->get($id), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error();
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    public function create(Request $request) {
        try {
            return response()->json($this->service->create($request->all()), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @param Request $request
     * @return bool
     */
    public function update(int $id, Request $request) {
        try {
            return response()->json($this->service->update($id, $request->all()), Response::HTTP_OK);
        } catch (CustomValidationException $e) {
            return $this->error($e->getMessage(), $e->getDetails());
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id) {
        try {
            return response()->json($this->service->delete($id), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

//
}
