<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Exceptions\CustomValidationException;
//use Illuminate\Support\Facades\DB;
use App\Models\Transactions;
use App\Repositories\TransactionsRepositoryInterface;
use App\Services\UserService;

class TransactionsService extends AbstractService {

    private $repository;
    private $userService;

    public function __construct(TransactionsRepositoryInterface $Repository, UserService $userService) {
        $this->repository = $Repository;
        $this->userService = $userService;
    }

    public function getAll() {
        return $this->repository->getAll();
    }

    public function get($id) {
        return $this->repository->get($id);
    }

    /**
     * "transferencia_valor" -> deciamal(10,2)
     * "transferencia_pagador" -> (int) usuario_id
     * "transferencia_beneficiado" -> (int) usuario_id
     * "transferencia_data" -> timestamp
     * "transferencia_status" -> bool -> Transfencia ok 1- 
     * "transferencia_mensagem" -> string
     */
    public function create(array $data) {


        $checkSendMoneyPayer = $this->userService->checkSendReceive($data['transferencia_pagador']);
        $checkSendMoneyPayee = $this->userService->checkSendReceive($data['transferencia_beneficiado']);

        /**
         * Validação dos tipos de usuário para verficar se eles podem enviar e podem receber
         */
        if (!$checkSendMoneyPayer['tipo_usuario_envia'] && $checkSendMoneyPayee['tipo_usuario_recebe']) {

            //verifica type para enviar e receber.
            $payerBalance = $this->userService->checkBalance($data['transferencia_pagador']);

            /**
             * inicia o processo de tranferência caso o saldo seja maior ou igual ao valor que ela vai executar.
             */
            if (($data['transferencia_valor'] > 0) && ($payerBalance['usuario_saldo'] >= $data['transferencia_valor'])) {

                /**
                 * valida os dados da requisição de acordo com o especificado no modelo.
                 */
                $validator = Validator::make($data, Transactions::RULE_TRANSACTION);
                if ($validator->fails()) {
                    $this->messageResponse('Data validation failed', 401, true);
                }

                /*
                 * Regitra no banco de dados a transição.
                 */
                $trasaction = $this->repository->create($data);

                if (!empty($trasaction)) {

                    //update saldo pagador
                    $this->userService->update($data['transferencia_pagador'], ['usuario_saldo' => ($payerBalance['usuario_saldo'] - $data['transferencia_valor'])]);

                    //update saldo beneficado
                    $payeeBalance = $this->userService->checkBalance($data['transferencia_beneficiado']);
                    $this->userService->update($data['transferencia_beneficiado'], ['usuario_saldo' => ($payeeBalance['usuario_saldo'] + $data['transferencia_valor'])]);
                } else {
                    throw new CustomValidationException('Falha na validação dos dados', $validator->errors());
                }
            } else {
                return $this->messageResponse('insufficient balance to make payment', 401, true);
            }
        } else {
            return $this->messageResponse('sorry, it is not possible to carry out the transfer as the paying entity or the beneficiary is not allowed to carry out this action.', 401, true);
        }
    }

    public function update(int $id, array $data) {
        $validator = Validator::make($data, Transactions::RULE_TRANSACTION);
        if ($validator->fails()) {
            throw new CustomValidationException('Falha na validação dos dados', $validator->errors());
        }
        return $this->repository->update($id, $data);
    }

    public function delete($id) {
        return $this->repository->delete($id);
    }

}
