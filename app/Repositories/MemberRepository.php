<?php

namespace App\Repositories;

use App\Models\Member;
use App\Models\CoinHistory;

class MemberRepository extends BaseRepository
{
    protected $model;
    protected $allowedFields = [
        'parent_id',
        'phone',
        'identification_number',
        'bank_name',
        'bank_account_holder',
        'bank_account_number',
        'package_amount',
        'cash_wallet',
        'roi_wallet',
        'register_wallet',
        'direct',
        'roi',
        'max_profit',
        'date_of_birth',
        'nationality',
        'gender'
    ];
    
    protected $booleanFields = [
        'is_active'
    ];

    public function __construct(Member $Member) {
        $this->model = $Member;
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

    public function findByUsername ($username) {
        return $this->model->where('username', $username)->first();
    }

    public function findChildren ($target) {
        return $this->model->where('parent_id', $target->id)->get();
    }

    public function search ($datatables) {
        return $datatables
            ->eloquent($this->model->query())
            ->editColumn('created_at', function ($model) {
                return $model->created_at->format('d F Y H:i:s A');
            })
            ->editColumn('package_amount', function ($model) {
                return number_format($model->package_amount, 0);
            })
            ->addColumn('action', function ($model) {
                return view('back.member.actions')->with('model', $model);
            })
            ->make(true);
    }

    public function searchTerm ($term) {
        return $this->model->where('username', 'like', '%' . $term . '%')->orderBy('username', 'asc')->take(30)->get();
    }

    public function createCoinHistory ($from, $to, $amount) {
        $model = new CoinHistory;
        $model->from_id = $from->id;
        $model->to_id = $to->id;
        $model->amount = $amount;
        $model->save();
        return $model;
    }

    public function updateMemberPackage ($package) {
        $members = $package->members()->get();
        if (count($members) > 0) {
            foreach ($members as $member) {
                $member->package_amount = $package->package_amount;
                $member->direct = $package->direct;
                $member->roi = $package->roi;
                $member->max_profit = $package->max_profit;
                $member->save();
            }
        }
        return true;
    }

    public function getTotal () {
        return $this->model->count();
    }

}