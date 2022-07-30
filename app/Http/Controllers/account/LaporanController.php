<?php

namespace App\Http\Controllers\account;

use App\Debit;
use App\Credit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;

class LaporanController extends Controller
{
    /**
     * LaporanController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('account.laporan.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function check(Request $request)
    {
        //set validasi required
        $this->validate(
            $request,
            [
                'tanggal_awal'     => 'required',
                'tanggal_akhir'    => 'required',
            ],
            //set message validation
            [
                'tanggal_awal.required'  => 'Silahkan Pilih Tanggal Awal!',
                'tanggal_akhir.required' => 'Silahkan Pilih Tanggal Akhir!',
            ]
        );

        $pemasukan  = $request->input('pemasukan');
        $pengeluaran = $request->input('pengeluaran');
        $tanggal_awal  = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');
        $data = collect();

        if (isset($pemasukan)) {
            $data = $data->merge($this->debit($tanggal_awal, $tanggal_akhir));
        }
        if (isset($pengeluaran)) {
            $data = $data->merge($this->credit($tanggal_awal, $tanggal_akhir));
        }

        $data = $data->paginate(10)
            ->appends(request()->except('page'));
        session()->flashInput($request->input());

        return view('account.laporan.index', compact('data', 'tanggal_awal', 'tanggal_akhir'));
    }

    public function credit($tanggal_awal, $tanggal_akhir)
    {
        return Credit::select('credit.id', 'credit.category_id', 'credit.user_id', 'credit.nominal', 'credit.credit_date as date', 'credit.description', 'categories_credit.id as id_category', 'categories_credit.name')
            ->join('categories_credit', 'credit.category_id', '=', 'categories_credit.id', 'LEFT')
            ->whereDate('credit.credit_date', '>=', $tanggal_awal)
            ->whereDate('credit.credit_date', '<=', $tanggal_akhir)
            ->get();
    }

    public function debit($tanggal_awal, $tanggal_akhir)
    {
        return Debit::select('debit.id', 'debit.category_id', 'debit.user_id', 'debit.nominal', 'debit.debit_date as date', 'debit.description', 'categories_debit.id as id_category', 'categories_debit.name')
            ->join('categories_debit', 'debit.category_id', '=', 'categories_debit.id', 'LEFT')
            ->whereDate('debit.debit_date', '>=', $tanggal_awal)
            ->whereDate('debit.debit_date', '<=', $tanggal_akhir)->get();
    }

    public function exportexcel()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}