<?php namespace App\Lib\Prototype\DBClasses\Eloquent;

use Illuminate\Contracts\Auth\Guard;
use App\Lib\Prototype\Interfaces\UserInterface;
use App\Lib\Prototype\BaseClasses\AbstractEloquentRepository;
use App\User;
use Session;
use Constant;


class EloquentUserRepository extends AbstractEloquentRepository implements UserInterface
{
    public function __construct(User $model, Guard $auth)
    {
        $this->model = $model;
        $this->auth = $auth;
        $this->user = $this->auth->user();
    }

    public function formModify($data, $id = null)
    {
        if ($id) {
            $user = $this->model->find($id);
        } else {
            $user = $this->model;
        }

        if ($data['actor_no']) {
            $data['actor_no'] = implode(',', $data['actor_no']);
        }

        $data['password'] = bcrypt($data['password']);

        $user->fill($data);
        $user->save();
    }
}
