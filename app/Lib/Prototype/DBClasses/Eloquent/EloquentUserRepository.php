<?php namespace App\Lib\Prototype\DBClasses\Eloquent;

use Illuminate\Contracts\Auth\Guard;
use App\Lib\Prototype\Interfaces\UserInterface;
use App\Lib\Prototype\BaseClasses\AbstractEloquentRepository;
//use Illuminate\Database\Query\Builder as QueryBuilder;
use App\User;
use Session;
use Constant;


class EloquentUserRepository extends AbstractEloquentRepository implements UserInterface
{
    public function __construct(User $model)
    {
        $this->model = $model;
        $this->user = \Auth::user();
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

        return $user;
    }

    public function getListIds($actor, $none_value = false)
    {
        $users = $this->model->actor($actor)->select('id', 'first_name', 'last_name', 'middle_name')->get();

        $list = $none_value ? array(null => '-') : array();
        foreach ($users as $user) {
            $list[$user->id] = $user->full_name;
        }

        return $list;
    }

    public function getByIds($ids)
    {
        if ($ids) {
            $ids = explode(',', $ids);

            $data = $this->model->select('id', 'first_name', 'middle_name', 'last_name')
                    ->whereIn('id', $ids)->get();

            if (!is_object($data)) {
                return null;
            }

            $result = [];
            foreach ($data as $value) {
                $result[] = $value->full_name;
            }

            return $result;
        }

        return null;
    }

}
