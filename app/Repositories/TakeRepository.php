<?php

namespace App\Repositories;

use App\Models\Take;

class TakeRepository extends BaseRepository
{
    protected $model;
    protected $allowedFields = [];
    protected $booleanFields = [];

    public function __construct(Take $Take) {
        $this->model = $Take;
    }

    protected function saveModel($model, $data) {
        foreach ($data as $k=>$d) {
            $model->{$k} = $d;
        }
        $model->save();
        return $model;
    }

    public function store($data) {
        $model = $this->saveModel(new $this->model, $data);
        return $model;
    }

    public function update($model, $data) {
        $model = $this->saveModel($model, $data);
        return $model;
    }

    public function getAllowedFields () {
        return $this->allowedFields;
    }

    public function getBooleanFields () {
        return $this->booleanFields;
    }

    public function findById ($id) {
        return $this->model->where('id', $id)->first();
    }

    public function checkUser ($member) {
        return $this->model->where('member_id', $member->id)->where('status', '!=', 'done')->first();
    }

    public function search ($datatables) {
        $user = \Sentinel::getUser();

        $permissions = $user->permissions;
        if (!isset($permissions['admin'])) {
            $member = $user->member;
            $query = $this->model->where('member_id', $member->id);
        } else {
            $query = $this->model->with('member')->select(['id', 'member_id', 'amount', 'status', 'type', 'created_at'])->latest();
        }

        return $datatables
            ->eloquent($query)
            ->editColumn('created_at', function ($model) {
                return $model->created_at->format('d F Y H:i:s A');
            })
            ->editColumn('amount', function ($model) {
                return number_format($model->amount, 0);
            })
            ->addColumn('action', function ($model) use ($permissions) {
                if (isset($permissions['admin'])) {
                    return view('back.withdraw.actions')->with('model', $model);
                } else {
                    return view('front.withdraw.actions')->with('model', $model);
                }
            })
            ->editColumn('status', function ($model) {
                if ($model->status == 'done') return '<span class="text-success">' . $model->status . '</span>';
                else return '<span class="text-danger">' . $model->status . '</span>';
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function getTotal ($field, $value) {
        return $this->model->where($field, $value)->count();
    }

}