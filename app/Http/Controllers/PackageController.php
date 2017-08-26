<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PackageRepository;
use App\Repositories\MemberRepository;

class PackageController extends Controller
{
    /**
     * The PackageRepository instance.
     *
     * @var \App\Repositories\PackageRepository
     */
    protected $PackageRepository;

    /**
     * The PackageRepository instance.
     *
     * @var \App\Repositories\PackageRepository
     */
    protected $MemberRepository;

    /**
     * Create a new PackageController instance.
     *
     * @param \App\Repositories\PackageRepository $PackageRepository
     * @return void
     */
    public function __construct(
        PackageRepository $PackageRepository,
        MemberRepository $MemberRepository
    ) {
        $this->PackageRepository = $PackageRepository;
        $this->MemberRepository = $MemberRepository;
        $this->middleware('admin');
    }

    public function update ($id) {
        if (!$model = $this->PackageRepository->findById(trim($id))) {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  'Package not found.'
            ]);
        }

        $data = \Input::get('data');
        if ($update = $this->PackageRepository->update($model, $data)) {
            $this->MemberRepository->updateMemberPackage($update);
        }

        return \Response::json([
            'type'  =>  'success',
            'message'   =>  'Package updated.'
        ]);
    }
}
