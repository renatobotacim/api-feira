<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of userTipes
 *
 * @author Renato
 */
class UserTypes extends Model {

    /**
     * Bank table for this model
     * @var string
     */
    protected $table = 'inf_tipos_usuarios';

    /**
     * Primary key
     * @var string
     */
    protected $primaryKey = 'tipo_usuario_id';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'tipo_usuario_id',
        'tipo_usuario_nome',
        'tipo_usuario_envia',
        'tipo_usuario_recebe'
    ];

    /**
     * Disable timestamps
     * @var bool
     */
    public $timestamps = false;

    
    /**
     * Validation Rules for Table Fields
     * @var array
     */
    const RULE_TYPE_USER = [
        'tipo_usuario_nome' => 'required|max:45',
        'tipo_usuario_envia' => 'required|boolean',
        'tipo_usuario_recebe' => 'required|boolean'
    ];

}
