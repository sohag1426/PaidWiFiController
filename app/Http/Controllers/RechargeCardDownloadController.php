<?php

namespace App\Http\Controllers;

use App\Models\card_distributor;
use App\Models\package;
use App\Models\recharge_card;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Spatie\SimpleExcel\SimpleExcelWriter;

class RechargeCardDownloadController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // distributors
        $distributors = card_distributor::where('operator_id', $request->user()->id)->get();

        // packages
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

        return view('admins.group_admin.recharge-card-download-create', [
            'distributors' => $distributors,
            'packages' => $packages,
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
            'file_format' => 'required|in:PDF,excel',
            'package_id' => 'nullable|numeric',
            'status' => 'nullable|in:used,unused',
        ]);

        $filter = [];

        $filter[] = ['operator_id', '=', $request->user()->id];

        // card_distributor_id
        $filter[] = ['card_distributor_id', '=', $request->card_distributor_id];

        // file_format && status
        if ($request->file_format == 'PDF') {
            $filter[] = ['status', '=', 'unused'];
        } else {
            if ($request->filled('status')) {
                $filter[] = ['status', '=', $request->status];
            }
        }

        // package_id
        if ($request->filled('package_id')) {
            $filter[] = ['package_id', '=', $request->package_id];
        }

        $cards = recharge_card::with(['package', 'distributor'])->where($filter)->get();

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $from_date = date_format(date_create($request->from_date), config('app.date_format'));
            $to_date = date_format(date_create($request->to_date), config('app.date_format'));
            $from = Carbon::createFromFormat(config('app.date_format'), $from_date)->startOfDay();
            $to = Carbon::createFromFormat(config('app.date_format'), $to_date)->endOfDay();
            $cards = $cards->whereBetween('updated_at', [$from, $to]);
        }

        if (count($cards) == 0) {
            return redirect()->route('recharge_cards.index')->with('success', 'Nothing to download');
        }

        // PDF
        if ($request->file_format == 'PDF') {

            $mpdf = new Mpdf();

            $mpdf->SetColumns(4);

            $column_count = 1;

            $page_count = 1;

            foreach ($cards as $card) {

                $body = view('admins.group_admin.recharge-card-pdf-column', [
                    'card' => $card,
                    'package' => $card->package,
                    'master_package' => $card->package->master_package,
                    'user' => $request->user(),
                ]);

                $mpdf->WriteHTML($body, \Mpdf\HTMLParserMode::HTML_BODY);

                if ($column_count === 4) {
                    $mpdf->SetColumns(4);
                    $column_count = 0;
                } else {
                    $mpdf->AddColumn();
                }

                if ($page_count == 28) {
                    $mpdf->AddPage();
                    $page_count = 0;
                }

                $column_count++;

                $page_count++;
            }

            $mpdf->Output();
        }

        // Excel
        if ($request->file_format == 'excel') {

            $writer = SimpleExcelWriter::streamDownload('recharge_cards.xlsx');

            foreach ($cards as $card) {

                $writer->addRow([
                    'Distributor' => $card->distributor->name,
                    'package' => $card->package->name,
                    'Price' => $card->package->price,
                    'Commission' => $card->commission,
                    'customer ID' => $card->customer_id,
                    'customer Mobile' => $card->mobile,
                    'status' => $card->status,
                    'pin' => $card->pin,
                    'date' => $card->used_date,
                    'month' => $card->used_month,
                    'year' => $card->used_year,
                ]);
            }

            $writer->toBrowser();
        }
    }
}
