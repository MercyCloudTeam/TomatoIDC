<?php

namespace App\Models\Server;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Token extends Model
{

    protected $table = 'servers_tokens';

    protected $fillable = [
        'title','api','type','username','password'
    ];


    protected $hidden = [
        'password'
    ];

    /**
     * 加密存储密码
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute(string $value)
    {
//        $this->attributes['password'] =  Crypt::encryptString($value);;
        $this->attributes['password'] = encrypt($value);;
    }

    /**
     * 解密获取密码
     *
     * @param string $value
     * @return string
     */
    public function getPasswordAttribute(string $value)
    {
//       return Crypt::decryptString($value);
       return decrypt($value);
    }

}
