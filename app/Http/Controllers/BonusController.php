<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BonusRepository;
use Yajra\Datatables\Datatables;

class BonusController extends Controller
{
    /**
     * The BonusRepository instance.
     *
     * @var \App\Repositories\BonusRepository
     */
    protected $BonusRepository;

    /**
     * Create a new BonusController instance.
     *
     * @param \App\Repositories\BonusRepository $BonusRepository
     * @return void
     */
    public function __construct(BonusRepository $BonusRepository) {
        $this->BonusRepository = $BonusRepository;
        // $this->middleware('');
    }

    public function index (Datatables $datatables) {
        return $this->BonusRepository->search($datatables);
    }
}
