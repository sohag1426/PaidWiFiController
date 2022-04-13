<?php

namespace App\Http\Controllers;

use App\Models\card_distributor;
use App\Models\package;
use App\Models\recharge_card;
use Illuminate\Http\Request;

class RechargeCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];

        $where[] = ['operator_id', '=', $request->user()->id];

        if ($request->filled('package_id')) {
            $where[] =  ['package_id', '=', $request->package_id];
        }

        if ($request->filled('status')) {
            $where[] = ['status', '=', $request->status];
        }

        if ($request->filled('distributor_id')) {
            $where[] = ['card_distributor_id', '=', $request->distributor_id];
        }

        if ($request->filled('pin')) {
            $where[] = ['pin', '=', $request->pin];
        }

        if ($request->filled('creation_date')) {
            $creation_date = date_format(date_create($request->creation_date), config('app.date_format'));
            $where[] = ['creation_date', '=', $creation_date];
        }

        $cards = recharge_card::with(['package', 'distributor'])->where($where)->paginate(10);

        $active_packages = recharge_card::where('operator_id', $request->user()->id)->select('package_id')->distinct()->get();

        $package_ids = [];

        foreach ($active_packages as $active_package) {
            $package_ids[] = $active_package->package_id;
        }

        if (count($package_ids)) {
            $packages = package::whereIn('id', $package_ids)->get();
        } else {
            $packages = $request->user()->packages;
        }

        $distributors = card_distributor::where('operator_id', $request->user()->id)->get();

        return view('admins.group_admin.recharge-cards', [
            'packages' => $packages,
            'distributors' => $distributors,
            'cards' => $cards,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $packages = $request->user()->packages;

        $distributors = card_distributor::where('operator_id', $request->user()->id)->get();

        return view('admins.group_admin.recharge-cards-create', [
            'packages' => $packages,
            'distributors' => $distributors,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'card_distributor_id' => 'required|numeric',
            'package_id' => 'required|numeric',
            'unit' => 'required|numeric',
            'commission' => 'required|numeric',
        ]);

        $active_cards_where = [
            ['package_id', '=', $request->package_id],
            ['card_distributor_id', '=', $request->card_distributor_id],
            ['status', '=', 'unused'],
        ];

        $active_cards = recharge_card::where($active_cards_where)->count();

        if ($active_cards > 1100) {
            return redirect()->route('recharge_cards.index')->with('success', 'Please use the previously generated card first!');
        }

        $unit = $request->unit > 1100 ? 1100 : $request->unit;

        for ($i = 0; $i < $unit; $i++) {
            $recharge_card = new recharge_card();
            $recharge_card->operator_id = $request->user()->id;
            $recharge_card->card_distributor_id = $request->card_distributor_id;
            $recharge_card->package_id = $request->package_id;
            $recharge_card->pin = rand(1012101030, 9999999999);
            $recharge_card->commission = $request->commission;
            $recharge_card->creation_date = date(config('app.date_format'));
            $recharge_card->creation_month = date(config('app.month_format'));
            $recharge_card->creation_year = date(config('app.year_format'));
            $recharge_card->save();
        }

        return redirect()->route('recharge_cards.index')->with('success', 'Cards are generated Successfully!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\recharge_card  $recharge_card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, recharge_card $recharge_card)
    {
        if ($request->user()->id !== $recharge_card->operator_id) {
            abort(403);
        }
        $recharge_card->delete();
        return redirect(url()->previous())->with('success', 'Card Deleted Successfully');
    }
}
