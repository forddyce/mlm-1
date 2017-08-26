<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\GiveRepository;

class GiveController extends Controller
{
    /**
     * The GiveRepository instance.
     *
     * @var \App\Repositories\GiveRepository
     */
    protected $GiveRepository;

    /**
     * Create a new GiveController instance.
     *
     * @param \App\Repositories\GiveRepository $GiveRepository
     * @return void
     */
    public function __construct(GiveRepository $GiveRepository) {
        $this->GiveRepository = $GiveRepository;
        // $this->middleware('');
    }
}
