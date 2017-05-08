<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserActivations extends Model
{

    protected $table = 'user_activations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'token',
    ];

    public function verified()
    {
        $this->token = null;
        $this->save();
    }

    public function user() {

        return $this->belongsTo('\App\User', 'user_id', 'id');
    }

}
