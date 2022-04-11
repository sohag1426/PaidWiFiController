<?php

namespace App\Http\Controllers;

use App\Models\radacct;
use Illuminate\Http\Request;

class OnlineCustomerWidgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $operator = $request->user();

        $where = [
            ['operator_id', '=', $operator->id],
        ];

        return radacct::where($where)
            ->whereNull('acctstoptime')
            ->count();
    }
}
