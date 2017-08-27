<?php
namespace App\Facades; 
use Illuminate\Support\Facades\Facade; 
class WorkerusersH  extends Facade 
{ 
    protected static function getFacadeAccessor() 
    { 
        return \App\Handler\WorkerusersH ::class;
    } 
}