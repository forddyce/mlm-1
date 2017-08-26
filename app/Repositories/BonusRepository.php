<?php

namespace App\Repositories;

use App\Models\Bonus;

class BonusRepository extends BaseRepository
{
    protected $model;
    protected $allowedFields = [];
    protected $booleanFields = [];

    public function __construct(Bonus $Bonus) {
        $this->model = $Bonus;
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

    public function addSponsor ($parent, $child) {
        $amount = ($parent->direct / 100) * $child->package_amount;
        $parent->cash_wallet += $amount;
        $parent->save();
        $model = $this->store([
            'member_id' =>  $parent->id,
            'amount'    =>  $amount,
            'type'      =>  'sponsor'
        ]);
        \Cache::forget('member.' . $parent->id);
        return $model;
    }

    public function search ($datatables) {
        $user = \Sentinel::getUser();

        $permissions = $user->permissions;
        if (!isset($permissions['admin'])) {
            $member = $user->member;
            $query = $this->model->where('member_id', $member->id);
        } else {
            $query = $this->model->query();
        }

        return $datatables
            ->eloquent($query)
            ->editColumn('created_at', function ($model) {
                return $model->created_at->format('d F Y H:i:s A');
            })
            ->editColumn('amount', function ($model) {
                return number_format($model->amount, 0);
            })
            ->addColumn('action', function ($model) {
                return view('front.bonus.actions')->with('model', $model);
            })
            ->make(true);
    }

}