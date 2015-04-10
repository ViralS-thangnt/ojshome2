<?php
namespace App\Lib\Prototype\Interfaces;

use App\Lib\Prototype\Interfaces\BaseIntreface;

interface UserInterface extends BaseInterface
{
    public function getListIds($actor); //return an array of user_id => user_name by user actor
    public function getByIds($ids);
}
