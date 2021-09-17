<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

/**
 * inf_usuarios data model
 *
 * @author Renato
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract {

    use Authenticatable,
        Authorizable;

    /**
     * Bank table for this model
     * @var string
     */
    protected $table = 'inf_usuarios';

    /**
     * Primary key
     * @var string
     */
    protected $primaryKey = 'usuario_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario_id',
        'usuario_nome',
        'usuario_cpf_cnpj',
        'usuario_email',
        'usuario_senha',
        'usuario_tipo_usuario_id',
        'usuario_registro',
        'usuario_saldo',
        'usuario_status'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'usuario_senha',
        'usuario_registro',
//        'usuario_saldo'
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
    const RULE_USER = [
        'usuario_id' => 'required',
        'usuario_nome' => 'required|max:100|alpha',
        'usuario_cpf_cnpj' => 'required|min:11|max:14',
        'usuario_email' => 'required|email|max:45|email:rfc,dns',
        'usuario_tipo_usuario_id' => 'required',
        'usuario_status' => 'required'
    ];

    /**
     * 1:N relationship definition
     */
    public function transactions() {
        return $this->hasMany(Transactions::class);
    }

    /**
     * method for autentication using jwt
     * @return string
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return '';
    }

}
