<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admins extends Model
{
    use HasFactory;
    protected $primaryKey = 'username';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['username', 'password'];

    public function token()
    {
        return $this->hasOne(Token::class, 'username', 'username');
    }
}
