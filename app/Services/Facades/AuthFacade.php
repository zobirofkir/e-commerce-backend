<?php
namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

class AuthFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'AuthService';
    }
}