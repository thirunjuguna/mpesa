<?php
/**
 * Created by IntelliJ IDEA.
 * User: thread
 * Date: 10/28/17
 * Time: 12:16 AM
 */
namespace Thiru\Mpesa\Facade;
use Illuminate\Support\Facades\Facade;

class Mpesa extends Facade
{
    protected static function getFacadeAccessor() { return 'mpesa'; }

}