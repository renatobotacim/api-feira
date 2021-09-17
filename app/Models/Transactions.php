<?php

namespace App\Models;

/**
 * inf_transferencias data model
 *
 * @author Renato
 */
use Illuminate\Database\Eloquent\Model;

/**
 * Description of userTipes
 *
 * @author Renato
 */
class Transactions extends Model implements \JsonSerializable{

    /**
     * Bank table for this model
     * @var string
     */
    protected $table = 'inf_transferencias';

    /**
     * Primary key
     * @var string
     */
    protected $primaryKey = 'transferencia_id';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'transferencia_id',
        'transferencia_valor',
        'transferencia_pagador',
        'transferencia_beneficiado',
        'transferencia_data',
        'transferencia_status',
        'transferencia_mensagem'
    ];

    /**
     * active timestamps
     * timestamp is used in transferencia_data for execution registred
     * @var bool
     */
    public $timestamps = false;

    
    /**
     * Validation Rules for Table Fields
     * @var array
     */
    const RULE_TRANSACTION = [
        'transferencia_valor' => 'required|numeric',
        'transferencia_pagador' => 'required|numeric',
        'transferencia_beneficiado' => 'required|numeric',
        'transferencia_mensagem' => 'required|max:50'
    ];

}
