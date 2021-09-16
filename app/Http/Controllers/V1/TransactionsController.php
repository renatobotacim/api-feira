<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\TransactionsService;
use App\Http\Controllers\Controller;

class TransactionsController extends Controller {

    private $service;

    public function __construct(TransactionsService $Service) {
        $this->service = $Service;
    }

    public function getAll() {
        try {
            return response()->json($this->service->getAll(), Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function get(int $id) {
        $data = $this->service->get($id);
        try {
            return response()->json($data, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error();
        }
    }

    public function create(Request $request) {
        
        
            return response()->json(
                            $this->service->create($request->all()),
                            Response::HTTP_CREATED
            );
    //        try {
//            return response()->json(
//                            $this->service->create($request->all()),
//                            Response::HTTP_CREATED
//            );
//        } catch (\Exception $e) {
//            return $this->error($e->getMessage());
//        }
    }

    public function update(int $id, Request $request) {
        try {
            return response()->json(
                            $this->service->update($id, $request->all()),
                            Response::HTTP_OK
            );
        } catch (CustomValidationException $e) {
            return $this->error($e->getMessage(), $e->getDetails());
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function delete(int $id) {
        try {
            return response()->json(
                            $this->service->delete($id),
                            Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }

//
}