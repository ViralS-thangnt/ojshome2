<?php
namespace App\Lib\Prototype\Interfaces;

use App\Lib\Prototype\Interfaces\BaseIntreface;

interface UserInterface extends BaseInterface
{
    public function getPermission();
}
