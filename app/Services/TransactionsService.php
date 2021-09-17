<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomValidationException;
use App\Models\Transactions;
use App\Repositories\TransactionsRepositoryInterface;
use App\Services\UserService;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class TransactionsService extends AbstractService {

    private $repository;
    private $userService;

    public function __construct(TransactionsRepositoryInterface $Repository, UserService $userService) {
        $this->repository = $Repository;
        $this->userService = $userService;
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
     * NOTE: The method is commented out because, according to the current business rule, the method should not be used.
     * @param int $id
     * @return array
     */
    public function get($id) {
//        return $this->repository->get($id);
    }

    /**
     * method created to register records
     * @param array $data
     * @return type array
     * @throws CustomValidationException
     */
    public function create(array $data) {

        //Validation of user types to see if they can send / receive transfers
        $checkSendReceiveMoneyPayer = $this->userService->checkSendReceive($data['transferencia_pagador']);
        $checkSendReceiveMoneyPayee = $this->userService->checkSendReceive($data['transferencia_beneficiado']);

        if ($checkSendReceiveMoneyPayer['tipo_usuario_envia'] && $checkSendReceiveMoneyPayee['tipo_usuario_recebe']) {

            //verifica type para enviar e receber.
            $payerBalance = $this->userService->checkBalance($data['transferencia_pagador']);
            if (($data['transferencia_valor'] > 0) && ($payerBalance['usuario_saldo'] >= $data['transferencia_valor'])) {

                //starts the transfer process if the balance is greater than or equal to the amount it will execute.
                // validates the request data as specified in the model.
                $validator = Validator::make($data, Transactions::RULE_TRANSACTION);
                if ($validator->fails()) {
                    $this->messageResponse('Data validation failed', 401, true);
                }

                //external verification
                if ($this->authorizer()) {

                    //transfer validation block
                    DB::beginTransaction();

                    //register the transfer in the bank
                    $transaction = $this->repository->create($data);

                    //change payer balance
                    $payer = $this->userService->update($data['transferencia_pagador'], [
                        'usuario_saldo' => ($payerBalance['usuario_saldo'] - $data['transferencia_valor'])
                    ]);

                    //change payee balance
                    $payeeBalance = $this->userService->checkBalance($data['transferencia_beneficiado']);
                    $payee = $this->userService->update($data['transferencia_beneficiado'], [
                        'usuario_saldo' => $payeeBalance['usuario_saldo'] + $data['transferencia_valor']
                    ]);

                    //verification for validation
                    if ($transaction && $payer && $payee) {
                        DB::commit();
                        //sending the success notification
                        return $this->sendNotification(1);
                    } else {
                        DB::rollBack();
                        return $this->messageResponse('sorry, there was an error in your transfer. Try again!', 401, true);
                    }
                } else {
                    return $this->messageResponse('Sorry, your transfer was not authorized.', 401, true);
                }
            } else {
                return $this->messageResponse('insufficient balance to make payment', 401, true);
            }
        } else {
            return $this->messageResponse('sorry, it is not possible to carry out the transfer as the paying entity or the beneficiary is not allowed to carry out this action.', 401, true);
        }
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
//        $validator = Validator::make($data, Transactions::RULE_TRANSACTION);
//        if ($validator->fails()) {
//            throw new CustomValidationException('Falha na validação dos dados', $validator->errors());
//        }
//        return $this->repository->update($id, $data);
    }

    /**
     * Method created to delete the record with id passed as parameter.
     * NOTE: The method is commented out because according to the current business rule the method should not be used.
     * @param type $id
     * @return  bool
     */
    public function delete($id) {
//        return $this->repository->delete($id);
    }

    
    /**
     * @param int $idUser
     * @param string $message optional. Used when sending a specific message. NOTE: This rule still needs to be implemented.
     * @return object
     */
    public function sendNotification(int $idUser, string $message = null) {
        $notification = new Client([
            'base_uri' => 'http://o4d9z.mocklab.io',
            'verify' => false
        ]);
        $response = $notification->get('/notify');
        return ['message' => json_decode($response->getBody())->message];
    }

    
    /**
     * external authorizer method
     * @return object
     */
    public function authorizer() {
        $authorizer = new Client([
            'base_uri' => 'https://run.mocky.io',
            'verify' => false]
        );
        $response = $authorizer->get('/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
        return ['statysCode' => $response->getStatusCode(), 'message' => json_decode($response->getBody())->message];
    }

}
