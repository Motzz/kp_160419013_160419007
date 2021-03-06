<?php

namespace App\Http\Controllers;

use App\Models\PaymentTerms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaymentTermsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = DB::table('PaymentTerms')
            ->select('PaymentTerms.*', 'Payment.Name as paymentName', 'Payment.Deskripsi as paymentDeskripsi')
            ->leftjoin('Payment', 'PaymentTerms.PaymentID', '=', 'Payment.PaymentID')
            ->where('PaymentTerms.Hapus', '=', 0)
            ->paginate(10);
        //->get();


        $user = Auth::user();
        $check = $this->checkAccess('paymentTerms.index', $user->id, $user->idRole);
        if ($check) {
            return view('master.paymentTerms.index', [
                'data' => $data,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Ketentuan Pembayaran');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $dataPayment = DB::table('Payment')
            ->get();


        $user = Auth::user();
        $check = $this->checkAccess('paymentTerms.create', $user->id, $user->idRole);
        if ($check) {
            return view('master.paymentTerms.tambah', [
                'dataPayment' => $dataPayment,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Ketentuan Pembayaran');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = $request->collect();

        //dd($data);
        $user = Auth::user();
        $isPenjualan = 0;
        if ($data['isPembelian'] == "0") $isPenjualan = 1;
        DB::table('PaymentTerms')
            ->insert(
                array(
                    'Name' => $data['name'],
                    'Deskripsi' => $data['deskripsi'],
                    'Days' => $data['days'],
                    'IsPembelian' => $data['isPembelian'],
                    'IsPenjualan' => $isPenjualan,
                    'PaymentID' => $data['paymentID'],
                    'CreatedBy' => $user->id,
                    'CreatedOn' => date("Y-m-d h:i:sa"),
                    'UpdatedBy' => $user->id,
                    'UpdatedOn' => date("Y-m-d h:i:sa"),
                    'Hapus' => 0,
                )
            );
        return redirect()->route('paymentTerms.index')->with('status', 'Berhasil Menambah Data Ketentuan Pembayaran!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentTerms  $paymentTerms
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentTerms $paymentTerm)
    {
        //
$dataPayment = DB::table('Payment')
            ->get();
        $user = Auth::user();
        $check = $this->checkAccess('paymentTerms.show', $user->id, $user->idRole);
        if ($check) {
            return view('master.paymentTerms.detail', [
                'paymentTerms' => $paymentTerm,
                 'dataPayment' => $dataPayment,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Ketentuan Pembayaran');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentTerms  $paymentTerms
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentTerms $paymentTerm)
    {
        //
        $dataPayment = DB::table('Payment')
            ->get();


        $user = Auth::user();
        $check = $this->checkAccess('paymentTerms.edit', $user->id, $user->idRole);
        if ($check) {
            return view('master.paymentTerms.edit', [
                'paymentTerms' => $paymentTerm,
                'dataPayment' => $dataPayment,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Ketentuan Pembayaran');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentTerms  $paymentTerms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentTerms $paymentTerm)
    {
        //
        $data = $request->collect();
        //dd($data);
        $isPenjualan = 0;
        if ($data['isPembelian'] == "0") $isPenjualan = 1;
        $user = Auth::user();
        DB::table('PaymentTerms')
            ->where('PaymentTermsID', $paymentTerm['PaymentTermsID'])
            ->update(
                array(
                    'Name' => $data['name'],
                    'Deskripsi' => $data['deskripsi'],
                    'Days' => $data['days'],
                    'IsPembelian' => $data['isPembelian'],
                    'IsPenjualan' => $isPenjualan,
                    'PaymentID' => $data['paymentID'],
                    'UpdatedBy' => $user->id,
                    'UpdatedOn' => date("Y-m-d h:i:sa"),
                )
            );
        return redirect()->route('paymentTerms.index')->with('status', 'Berhasil Mengupdate Data Ketentuan Pembayaran!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentTerms  $paymentTerms
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentTerms $paymentTerm)
    {
        //
        //dd($paymentTerm);
        $user = Auth::user();
        $check = $this->checkAccess('paymentTerms.edit', $user->id, $user->idRole);
        if ($check) {
            DB::table('PaymentTerms')
                ->where('PaymentTermsID', $paymentTerm['PaymentTermsID'])
                ->update(
                    array(
                        'Hapus' => 1,
                    )
                );
            return redirect()->route('paymentTerms.index')->with('status', 'Berhasil Menghapus Data Ketentuan Pembayaran!!');
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Ketentuan Pembayaran');
        }
    }

    public function searchPaymentTermsName(Request $request)
    {
        //
        $name = $request->input('searchname');
        $data = DB::table('PaymentTerms')
            ->select('PaymentTerms.*', 'Payment.Name as paymentName', 'Payment.Deskripsi as paymentDeskripsi')
            ->leftjoin('Payment', 'PaymentTerms.PaymentID', '=', 'Payment.PaymentID')
            ->where('PaymentTerms.Hapus', '=', 0)
            ->where('PaymentTerms.Name', 'like', '%' . $name . '%')
            ->paginate(10);
        //->get();


        $user = Auth::user();
        $check = $this->checkAccess('paymentTerms.index', $user->id, $user->idRole);
        if ($check) {
            return view('master.paymentTerms.index', [
                'data' => $data,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Ketentuan Pembayaran');
        }
    }

    public function searchPaymentTermsDay(Request $request)
    {
        //
        $day = $request->input('searchday');
        $data = DB::table('PaymentTerms')
            ->select('PaymentTerms.*', 'Payment.Name as paymentName', 'Payment.Deskripsi as paymentDeskripsi')
            ->leftjoin('Payment', 'PaymentTerms.PaymentID', '=', 'Payment.PaymentID')
            ->where('PaymentTerms.Hapus', '=', 0)
            ->where('PaymentTerms.Days', 'like', '%' . $day . '%')
            ->paginate(10);
        //->get();
        $user = Auth::user();
        $check = $this->checkAccess('paymentTerms.index', $user->id, $user->idRole);
        if ($check) {
            return view('master.paymentTerms.index', [
                'data' => $data,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Ketentuan Pembayaran');
        }
    }
}
