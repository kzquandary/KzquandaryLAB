<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tokens extends Model
{
    use HasFactory;
    protected $primaryKey = 'username';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['username', 'access_token', 'expired_at'];

    public function admin()
    {
        return $this->belongsTo(Admins::class, 'username', 'username');
    }
    public static function generateToken(Admins $admin)
    {
        $token = new Tokens();
        $token->username = $admin->username;
        $token->access_token = Str::random(64);
        $token->expired_at = now()->addHours(720);
        $token->save();

        return $token->access_token;
    }
}
