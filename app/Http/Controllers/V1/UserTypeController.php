<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\UserTypeService;
use App\Http\Controllers\Controller;

class UserTypeController extends Controller {

    private $service;

    /**
     * 
     * @param UserTypeService $Service
     */
    public function __construct(\App\Services\UserTypeService $Service) {
        $this->service = $Service;
    }

    /**
     * 
     * @return array
     */
    public function getAll() {
        try {
            return response()->json($this->service->getAll(), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 
     * @param int $id
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
     * 
     * @param Request $request
     * @return array
     */
    public function create(Request $request): array {
        try {
            return response()->json($this->service->create($request->all()), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * 
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
