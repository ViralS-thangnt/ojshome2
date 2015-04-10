<?php
namespace App\Lib\Prototype\Interfaces;

use App\Lib\Prototype\Interfaces\BaseIntreface;

interface ManuscriptInterface extends BaseInterface
{
    public function getByStatus($status);
    
}
