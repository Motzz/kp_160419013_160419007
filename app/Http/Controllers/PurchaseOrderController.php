<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderController extends Controller
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
        $user = Auth::user();

        $getPerusahaan = DB::table('MPerusahaan')
            ->join('MGudang', 'MPerusahaan.MPerusahaanID', '=', 'MPerusahaan.MPerusahaanID')
            ->where('MGudangID', $user->MGudangID)
            ->get();

        $data = DB::table('purchase_order')
            ->select('purchase_order.*','MSupplier.Name as supplierName')
            ->join('users', 'purchase_order.created_by', '=', 'users.id')
            ->join('MGudang', 'users.MGudangID', '=', 'MGudang.MGudangID')
            ->join('MKota', 'MGudang.cidkota', '=', 'MKota.cidkota')
            ->join('MPerusahaan', 'MGudang.cidp', '=', 'MPerusahaan.MPerusahaanID')
            ->leftjoin('MSupplier', 'purchase_order.idSupplier', '=', 'MSupplier.SupplierID')
            ->where('purchase_order.hapus', '=', 0)
            //->where('MPerusahaan.MPerusahaanID', $getPerusahaan[0]->MPerusahaanID)  
            ->orderByDesc('purchase_order.tanggalDibuat', 'purchase_order.id')
            ->paginate(10);
        //->get();

        //dd($data);


        $user = Auth::user();
        $check = $this->checkAccess('purchaseOrder.index', $user->id, $user->idRole);
        if ($check) {
            return view('master.PurchaseOrder.index', [
                'data' => $data,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Purchase Order');
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
        $user = Auth::user();

        $dataSupplier = DB::table('MSupplier')
            ->get();

        $dataPayment = DB::table('PaymentTerms')
            ->select('PaymentTerms.*', 'Payment.Name as PaymentName', 'Payment.Deskripsi as PaymentDeskripsi')
            ->leftjoin('Payment', 'PaymentTerms.PaymentID', '=', 'Payment.PaymentID')
            ->where('PaymentTerms.IsPembelian', 1)
            ->where('PaymentTerms.IsPenjualan', 0)
            ->get();

        $dataBarang = DB::table('Item')
            ->select('Item.*', 'Unit.Name as unitName')
            ->join('Unit', 'Item.UnitID', '=', 'Unit.UnitID')
            ->leftjoin('ItemTagValues', 'Item.ItemID', '=', 'ItemTagValues.ItemID')
            ->where('Item.Hapus', 0)
            ->get();

        $dataBarangTag = DB::table('Item')
            ->select('Item.*', 'Unit.Name as unitName', 'ItemTagValues.ItemTagID')
            ->join('Unit', 'Item.UnitID', '=', 'Unit.UnitID')
            ->join('ItemTagValues', 'Item.ItemID', '=', 'ItemTagValues.ItemID')
            ->where('Item.Hapus', 0)
            ->get();
        //dd($dataBarangTag);
        $dataTag = DB::table('ItemTag')
            ->get();
        $dataTax = DB::table('Tax')
            ->get();

        $dataPerusahaan = DB::table('MPerusahaan')
            ->get();


        //data Purchase Request yang disetujui
        $dataPurchaseRequestDetail = DB::table('purchase_request_detail')
            ->select('purchase_request_detail.*', 'purchase_request.name as prName', 'Item.ItemName as ItemName', 'Unit.Name as UnitName') //
            ->join('purchase_request', 'purchase_request_detail.idPurchaseRequest', '=', 'purchase_request.id')
            ->join('Item', 'purchase_request_detail.ItemID', '=', 'Item.ItemID')
            ->join('Unit', 'Item.UnitID', '=', 'Unit.UnitID')
            ->where('purchase_request.approved', 1)
            ->where('purchase_request.approvedAkhir', 1)
            ->where('purchase_request.hapus', 0)
            ->where('purchase_request.proses', 1)
            ->where('purchase_request_detail.jumlahProses', '<', DB::raw('purchase_request_detail.jumlah')) //errorr disini
            ->get();
        //dd($dataPurchaseRequestDetail);

        $dataPurchaseRequest = DB::table('purchase_request')
            ->select('purchase_request.*', 'MPerusahaan.MPerusahaanID as cidp')
            ->join('MGudang', 'purchase_request.MGudangID', '=', 'MGudang.MGudangID')
            ->join('MPerusahaan', 'MGudang.cidp', '=', 'MPerusahaan.MPerusahaanID')
            ->where('purchase_request.approved', 1)
            ->where('purchase_request.approvedAkhir', 1)
            ->where('purchase_request.hapus', 0)
            ->where('purchase_request.proses', 1)
            ->get();
        //dd($dataPurchaseRequest);
        //dd($dataPurchaseRequestDetail);
        //nama npp create
        $dataLokasi = DB::table('MGudang')
            ->select('MKota.*', 'MPerusahaan.cnames as perusahaanCode')
            ->join('MKota', 'MGudang.cidkota', '=', 'MKota.cidkota')
            ->join('MPerusahaan', 'MGudang.cidp', '=', 'MPerusahaan.MPerusahaanID')
            ->where('MGudang.MGudangID', '=', $user->MGudangID)
            ->get();
        $date = date("Y-m-d");
        $year = date("Y");
        $month = date("m");
        $dataOrder = DB::table('purchase_order')
            ->where('name', 'like', 'PO/' . $dataLokasi[0]->perusahaanCode . '/' . $dataLokasi[0]->ckode . '/' . $year . '/' . $month . "/%")
            ->get();
        $totalIndex = str_pad(strval(count($dataOrder) + 1), 4, '0', STR_PAD_LEFT);
        $namaPo = 'PO/' . $dataLokasi[0]->perusahaanCode . '/' . $dataLokasi[0]->ckode . '/' . $year . '/' . $month . "/" . $totalIndex;




        $user = Auth::user();
        $check = $this->checkAccess('purchaseOrder.create', $user->id, $user->idRole);
        if ($check) {
            return view('master.PurchaseOrder.tambah', [
                'dataSupplier' => $dataSupplier,
                'dataPayment' => $dataPayment,
                'dataBarangTag' => $dataBarangTag,
                'dataBarang' => $dataBarang,
                'namaPo' => $namaPo,
                'date' => $date,
                'dataTag' => $dataTag,
                'dataTax' => $dataTax,
                'dataPurchaseRequestDetail' => $dataPurchaseRequestDetail,
                'dataPurchaseRequest' => $dataPurchaseRequest,
                'dataPerusahaan' => $dataPerusahaan,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Purchase Order');
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
        $year = date("Y");
        $month = date("m");

        $dataLokasi = DB::table('MGudang')
            ->select('MKota.*', 'MPerusahaan.cnames as perusahaanCode')
            ->join('MKota', 'MGudang.cidkota', '=', 'MKota.cidkota')
            ->join('MPerusahaan', 'MGudang.cidp', '=', 'MPerusahaan.MPerusahaanID')
            ->where('MGudang.MGudangID', '=', $user->MGudangID)
            ->get();
        $dataLokasiPerusahaan = DB::table('MPerusahaan')
            ->where("MPerusahaanID", $data['perusahaan'])
            ->get();

        $dataPo = DB::table('purchase_order')
            ->where('name', 'like', 'PO/' . $dataLokasiPerusahaan[0]->cnames . '/' . $dataLokasi[0]->ckode . '/' . $year . '/' . $month . "/%")
            ->get();


        $totalIndex = str_pad(strval(count($dataPo) + 1), 4, '0', STR_PAD_LEFT);

        $idpo = DB::table('purchase_order')->insertGetId(
            array(
                'name' => 'PO/' . $dataLokasiPerusahaan[0]->cnames . '/' . $dataLokasi[0]->ckode . '/' . $year . '/' . $month . "/" . $totalIndex,
                'idSupplier' => $data['supplier'],
                'idPaymentTerms' => $data['paymentTerms'],
                'tanggalDibuat' => $data['tanggalDibuat'],
                'tanggal_akhir' => $data['tanggal_akhir'],
                'approved' => 0,
                'hapus' => 0,
                'proses' => 0,
                'keteranganLokasi' => $data['keteranganLokasi'],
                'keteranganPenagihan' => $data['keteranganPenagihan'],
                'keteranganPembayaran' => $data['keteranganPembayaran'],
                'created_by' => $user->id,
                'created_on' => date("Y-m-d h:i:s"),
                'updated_by' => $user->id,
                'updated_on' => date("Y-m-d h:i:s"),
                'MPerusahaanID' => $data['perusahaan'],
            )
        );

        $totalHarga = 0;
        $subtotalHarga = 0;

        for ($i = 0; $i < count($data['itemId']); $i++) {
            DB::table('purchase_order_detail')->insert(
                array(
                    'idPurchaseOrder' => $idpo,
                    'idPurchaseRequestDetail' => $data['prdID'][$i],
                    'idItem' => $data['itemId'][$i],
                    'jumlah' => $data['itemTotal'][$i],
                    'harga' => $data['itemHarga'][$i],
                    'diskon' => $data['itemDiskon'][$i],
                    'idTax' => $data['itemTax'][$i],
                    'keterangan' => $data['itemKeterangan'][$i],
                )
            );

            $totalNow = DB::table('purchase_request_detail')->select('jumlah', 'jumlahProses')->where('id', $data['prdID'][$i])->get();
            DB::table('purchase_request_detail')
                ->where('id', $data['prdID'][$i])
                ->update([
                    'jumlahProses' => $totalNow[0]->jumlahProses + $data['itemTotal'][$i],
                ]);

            $totalHarga += (($data['itemHarga'][$i] - $data['itemDiskon'][$i]) * $data['itemTotal'][$i]) * (100.0 + $data['itemTaxValue'][$i]) / 100.0;
            $subtotalHarga += (($data['itemHarga'][$i] - $data['itemDiskon'][$i]) * $data['itemTotal'][$i]);
        }

        DB::table('purchase_order')
            ->where('id', $idpo)
            ->update([
                'totalHarga' =>  $totalHarga,
                'subtotalHarga' =>  $subtotalHarga,
            ]);

        return redirect()->route('purchaseOrder.index')->with('status', 'Pembuatan PO/' . $dataLokasi[0]->perusahaanCode . '/' . $dataLokasi[0]->ckode . '/' . $year . '/' . $month . "/" . $totalIndex . ' Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        //
        $user = Auth::user();

        $dataSupplier = DB::table('MSupplier') //
            ->get();

        $dataPayment = DB::table('PaymentTerms') //
            ->select('PaymentTerms.*', 'Payment.Name as PaymentName', 'Payment.Deskripsi as PaymentDeskripsi')
            ->leftjoin('Payment', 'PaymentTerms.PaymentID', '=', 'Payment.PaymentID')
            ->get();

        $dataBarang = DB::table('Item')
            ->select('Item.*', 'Unit.Name as unitName')
            ->join('Unit', 'Item.UnitID', '=', 'Unit.UnitID')
            ->where('Item.Hapus', 0)
            ->get();

        //data Purchase Request yang disetujui
        $dataPurchaseRequestDetail = DB::table('purchase_request_detail')
            ->select('purchase_request_detail.*', 'purchase_request.name as prName', 'Item.ItemName as ItemName', 'Unit.Name as UnitName') //'purchase_order_detail.jumlah as podJumlah')//
            ->join('purchase_request', 'purchase_request_detail.idPurchaseRequest', '=', 'purchase_request.id')
            ->join('Item', 'purchase_request_detail.ItemID', '=', 'Item.ItemID')
            ->join('Unit', 'Item.UnitID', '=', 'Unit.UnitID')
            //->leftjoin('purchase_order_detail','purchase_request_detail.id','=','purchase_order_detail.idPurchaseRequestDetail')
            ->where('purchase_request.approved', 1)
            ->where('purchase_request.approvedAkhir', 1)
            ->where('purchase_request.hapus', 0)
            ->where('purchase_request.proses', 1)
            ->where('purchase_request_detail.jumlahProses', '<', DB::raw('purchase_request_detail.jumlah')) //errorr disini
            ->get();
        //dd($dataPurchaseRequestDetail);
        $dataDetail = DB::table('purchase_order_detail')
            ->select('purchase_order_detail.*', 'Item.ItemName as itemName', 'Tax.TaxPercent')
            //->leftjoin('purchase_request_detail', 'purchase_order_detail.idPurchaseRequestDetail','=','purchase_request_detail.id')
            ->leftjoin('Tax', 'purchase_order_detail.idTax', '=', 'Tax.TaxID')
            ->leftjoin('Item', 'purchase_order_detail.idItem', '=', 'Item.ItemID')
            ->where('purchase_order_detail.idPurchaseOrder', '=', $purchaseOrder->id)
            ->get();
        //dd($dataDetail);

        $dataDetailBarang = DB::table('purchase_order_detail')
            ->select('purchase_order_detail.*', 'Item.ItemName as itemName', 'Tax.TaxPercent')
            //->leftjoin('purchase_request_detail', 'purchase_order_detail.idPurchaseRequestDetail','=','purchase_request_detail.id')
            ->leftjoin('Tax', 'purchase_order_detail.idTax', '=', 'Tax.TaxID')
            ->leftjoin('Item', 'purchase_order_detail.idItem', '=', 'Item.ItemID')
            ->where('purchase_order_detail.idPurchaseOrder', '!=', $purchaseOrder->id)
            ->get();
        $dataTax = DB::table('Tax')
            ->select('Tax.*')
            ->get();

        $dataPerusahaan = DB::table('MPerusahaan') //
            ->get();

        $dataPurchaseRequest = DB::table('purchase_request')
            ->select('purchase_request.*', 'MPerusahaan.MPerusahaanID as cidp')
            ->join('MGudang', 'purchase_request.MGudangID', '=', 'MGudang.MGudangID')
            ->join('MPerusahaan', 'MGudang.cidp', '=', 'MPerusahaan.MPerusahaanID')
            ->where('purchase_request.approved', 1)
            ->where('purchase_request.approvedAkhir', 1)
            ->where('purchase_request.hapus', 0)
            ->where('purchase_request.proses', 1)
            ->get();





        $user = Auth::user();
        $check = $this->checkAccess('purchaseOrder.show', $user->id, $user->idRole);
        if ($check) {
            return view('master.PurchaseOrder.detail', [
                'purchaseOrder' => $purchaseOrder,
                'dataDetail' => $dataDetail,
                'dataSupplier' => $dataSupplier,
                'dataPayment' => $dataPayment,
                'dataBarang' => $dataBarang,
                'dataTax' => $dataTax,
                'dataPurchaseRequestDetail' => $dataPurchaseRequestDetail,
                'dataPurchaseRequest' => $dataPurchaseRequest,
                'dataPerusahaan' => $dataPerusahaan,
                'dataDetailBarang' => $dataDetailBarang,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Purchase Order');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        //
        $user = Auth::user();

        $dataSupplier = DB::table('MSupplier') //
            ->get();

        $dataPayment = DB::table('PaymentTerms') //
            ->select('PaymentTerms.*', 'Payment.Name as PaymentName', 'Payment.Deskripsi as PaymentDeskripsi')
            ->leftjoin('Payment', 'PaymentTerms.PaymentID', '=', 'Payment.PaymentID')
            ->get();

        $dataBarang = DB::table('Item')
            ->select('Item.*', 'Unit.Name as unitName')
            ->join('Unit', 'Item.UnitID', '=', 'Unit.UnitID')
            ->where('Item.Hapus', 0)
            ->get();

        //data Purchase Request yang disetujui
        $dataPurchaseRequestDetail = DB::table('purchase_request_detail')
            ->select('purchase_request_detail.*', 'purchase_request.name as prName', 'Item.ItemName as ItemName', 'Unit.Name as UnitName', 'purchase_order_detail.jumlah as podJumlah')//
            ->join('purchase_request', 'purchase_request_detail.idPurchaseRequest', '=', 'purchase_request.id')
            ->join('Item', 'purchase_request_detail.ItemID', '=', 'Item.ItemID')
            ->join('Unit', 'Item.UnitID', '=', 'Unit.UnitID')
            ->leftjoin('purchase_order_detail','purchase_request_detail.id','=','purchase_order_detail.idPurchaseRequestDetail')
            ->where('purchase_request.approved', 1)
            ->where('purchase_request.approvedAkhir', 1)
            ->where('purchase_request.hapus', 0)
            ->where('purchase_request.proses', 1)
            ->where('purchase_request_detail.jumlahProses', '<', DB::raw('purchase_request_detail.jumlah')) //error disini
            ->orWhere('purchase_request_detail.jumlahProses', '<', DB::raw('purchase_request_detail.jumlah + purchase_order_detail.jumlah')) //error disini
            ->get();
        //dd($dataPurchaseRequestDetail);
        $dataDetail = DB::table('purchase_order_detail')
            ->select('purchase_order_detail.*', 'Item.ItemName as itemName', 'Tax.TaxPercent', 'purchase_request.name as namaNPPCheck')
            ->leftjoin('purchase_request_detail', 'purchase_order_detail.idPurchaseRequestDetail', '=', 'purchase_request_detail.id')
            ->leftjoin('purchase_request', 'purchase_request_detail.idPurchaseRequest', '=', 'purchase_request.id')
            ->leftjoin('Tax', 'purchase_order_detail.idTax', '=', 'Tax.TaxID')
            ->leftjoin('Item', 'purchase_order_detail.idItem', '=', 'Item.ItemID')
            ->where('purchase_order_detail.idPurchaseOrder', '=', $purchaseOrder->id)
            ->get();
        //dd($dataDetail);

        $dataDetailBarang = DB::table('purchase_order_detail')
            ->select('purchase_order_detail.*', 'Item.ItemName as itemName', 'Tax.TaxPercent')
            //->leftjoin('purchase_request_detail', 'purchase_order_detail.idPurchaseRequestDetail','=','purchase_request_detail.id')
            ->leftjoin('Tax', 'purchase_order_detail.idTax', '=', 'Tax.TaxID')
            ->leftjoin('Item', 'purchase_order_detail.idItem', '=', 'Item.ItemID')
            ->where('purchase_order_detail.idPurchaseOrder', '!=', $purchaseOrder->id)
            ->get();
        $dataTax = DB::table('Tax')
            ->select('Tax.*')
            ->get();

        $dataPerusahaan = DB::table('MPerusahaan') //
            ->get();

        $dataPurchaseRequest = DB::table('purchase_request')
            ->select('purchase_request.*', 'MPerusahaan.MPerusahaanID as cidp')
            ->join('MGudang', 'purchase_request.MGudangID', '=', 'MGudang.MGudangID')
            ->join('MPerusahaan', 'MGudang.cidp', '=', 'MPerusahaan.MPerusahaanID')
            ->where('purchase_request.approved', 1)
            ->where('purchase_request.approvedAkhir', 1)
            ->where('purchase_request.hapus', 0)
            ->where('purchase_request.proses', 1)
            ->get();




        $user = Auth::user();
        $check = $this->checkAccess('purchaseOrder.edit', $user->id, $user->idRole);
        if ($check) {
            if ($purchaseOrder->approved == 1 || $purchaseOrder->approved == 2) {
                return redirect()->route('purchaseOrder.index')->with('status', 'Tidak dapat mengubah data');
            } else {
                return view('master.PurchaseOrder.edit', [
                    'purchaseOrder' => $purchaseOrder,
                    'dataDetail' => $dataDetail,
                    'dataSupplier' => $dataSupplier,
                    'dataPayment' => $dataPayment,
                    'dataBarang' => $dataBarang,
                    'dataTax' => $dataTax,
                    'dataPurchaseRequestDetail' => $dataPurchaseRequestDetail,
                    'dataPurchaseRequest' => $dataPurchaseRequest,
                    'dataPerusahaan' => $dataPerusahaan,
                    'dataDetailBarang' => $dataDetailBarang,
                ]);
            }
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Purchase Order');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        //
        $data = $request->collect();
        $user = Auth::user();
        $year = date("Y");
        $month = date("m");
        //dd(gettype($data['itemId']));
        DB::table('purchase_order')
            ->where('id', $purchaseOrder->id)
            ->update([
                'idSupplier' => $data['supplier'],
                'idPaymentTerms' => $data['paymentTerms'],
                'tanggal_akhir' => $data['tanggal_akhir'],
                'tanggalDibuat' => $data['tanggalDibuat'],
                'keteranganLokasi' => $data['keteranganLokasi'],
                'keteranganPenagihan' => $data['keteranganPenagihan'],
                'keteranganPembayaran' => $data['keteranganPembayaran'],
                'updated_by' => $user->id,
                'updated_on' => date("Y-m-d h:i:s"),
            ]);

        $dataDetailTotal = DB::table('purchase_order_detail')
            ->where('idPurchaseOrder', $purchaseOrder->id)
            ->get();


        $totalHarga = 0;

        foreach ($dataDetailTotal as $data) {
            DB::table('purchase_request_detail')
                ->where('id', $data->idPurchaseRequestDetail)
                ->decrement('jumlahProses', $data->jumlah);
        }
        DB::table('purchase_order_detail')
            ->where('idPurchaseOrder', $purchaseOrder->id)
            ->delete();

        $totalHarga = 0;
        $subtotalHarga = 0;

        //$itemIDArray= (array) json_decode($data['prdID']);

        $totalBarangDiCount = count(request()->get('itemId'));
        //dd(request()->get('itemId')[2]);
        for ($i = 0; $i < $totalBarangDiCount; $i++) {
            /*DB::table('purchase_order_detail')->insert(
                array(
                    'idPurchaseOrder' => $purchaseOrder->id,
                    'idPurchaseRequestDetail' => $data['prdID'][$i],
                    'idItem' => $data['itemId'][$i],
                    'jumlah' => $data['itemTotal'][$i],
                    'harga' => $data['itemHarga'][$i],
                    'diskon' => $data['itemDiskon'][$i],
                    'idTax' => $data['itemTax'][$i],
                    'keterangan' => $data['itemKeterangan'][$i],
                )
            );*/
            DB::table('purchase_order_detail')->insert(
                array(
                    'idPurchaseOrder' => $purchaseOrder->id,
                    'idPurchaseRequestDetail' => request()->get('prdID')[$i],
                    'idItem' => request()->get('itemId')[$i],
                    'jumlah' => request()->get('itemTotal')[$i],
                    'harga' => request()->get('itemHarga')[$i],
                    'diskon' => request()->get('itemDiskon')[$i],
                    'idTax' => request()->get('itemTax')[$i],
                    'keterangan' => request()->get('itemKeterangan')[$i],
                )
            );

            /*$totalNow = DB::table('purchase_request_detail')->select('jumlah', 'jumlahProses')->where('id', $data['prdID'][$i])->get();
            DB::table('purchase_request_detail')
                ->where('id', $data['prdID'][$i])
                ->update([
                    'jumlahProses' => $totalNow[0]->jumlahProses + $data['itemTotal'][$i],
                ]);

            $totalHarga += (((float)$data['itemHarga'][$i] - (float)$data['itemDiskon'][$i]) * (float)$data['itemTotal'][$i]) * (100.0 + (float)$data['itemTaxValue'][$i]) / 100.0;
            $subtotalHarga += (((float)$data['itemHarga'][$i] - (float)$data['itemDiskon'][$i]) * (float)$data['itemTotal'][$i]);
            */
            $totalNow = DB::table('purchase_request_detail')->select('jumlah', 'jumlahProses')->where('id', request()->get('prdID')[$i])->get();
            DB::table('purchase_request_detail')
                ->where('id', request()->get('prdID')[$i])
                ->update([
                    'jumlahProses' => $totalNow[0]->jumlahProses + request()->get('itemTotal')[$i],
                ]);

            $totalHarga += (((float)request()->get('itemHarga')[$i] - (float)request()->get('itemDiskon')[$i]) * (float)request()->get('itemTotal')[$i]) * (100.0 + (float)request()->get('itemTaxValue')[$i]) / 100.0;
            $subtotalHarga += (((float)request()->get('itemHarga')[$i] - (float)request()->get('itemDiskon')[$i]) * (float)request()->get('itemTotal')[$i]);
        }

        DB::table('purchase_order')
            ->where('id', $purchaseOrder->id)
            ->update([
                'totalHarga' =>  $totalHarga,
                'subtotalHarga' =>  $subtotalHarga,
            ]);

        return redirect()->route('purchaseOrder.index')->with('status', 'Berhasil Mengupdate Data Purchase Order!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        //

        $user = Auth::user();
        $check = $this->checkAccess('purchaseOrder.edit', $user->id, $user->idRole);
        if ($check) {
            if ($purchaseOrder->approved == 1 || $purchaseOrder->approved == 2) {
                return redirect()->route('purchaseOrder.index')->with('status', 'Tidak dapat mengubah data');
            } else {
                DB::table('purchase_order')
                    ->where('id', $purchaseOrder->id)
                    ->update([
                        'hapus' =>  1,
                    ]);

                $podet = DB::table('purchase_order_detail')->where('idPurchaseOrder', $purchaseOrder['id'])->get();
                foreach ($podet as $data) {
                    DB::table('purchase_request_detail')
                        ->where('id', $data->idPurchaseRequestDetail)
                        ->decrement('jumlahProses', $data->jumlah);
                }

                return redirect()->route('purchaseOrder.index')->with('status', 'Success!!');
            }
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Purchase Order');
        }
    }

    public function print(PurchaseOrder $purchaseOrder)
    {
        //
        $user = Auth::user();

        $dataSupplier = DB::table('MSupplier') //
            ->get();

        $dataPayment = DB::table('PaymentTerms') //
            ->select('PaymentTerms.*', 'Payment.Name as PaymentName', 'Payment.Deskripsi as PaymentDeskripsi')
            ->leftjoin('Payment', 'PaymentTerms.PaymentID', '=', 'Payment.PaymentID')
            ->get();

        $dataBarang = DB::table('Item')
            ->select('Item.*', 'Unit.Name as unitName')
            ->join('Unit', 'Item.UnitID', '=', 'Unit.UnitID')
            ->where('Item.Hapus', 0)
            ->get();

        //data Purchase Request yang disetujui
        $dataPurchaseRequestDetail = DB::table('purchase_request_detail')
            ->select('purchase_request_detail.*', 'purchase_request.name as prName', 'Item.ItemName as ItemName', 'Unit.Name as UnitName') //
            ->join('purchase_request', 'purchase_request_detail.idPurchaseRequest', '=', 'purchase_request.id')
            ->join('Item', 'purchase_request_detail.ItemID', '=', 'Item.ItemID')
            ->join('Unit', 'Item.UnitID', '=', 'Unit.UnitID')
            ->where('purchase_request.approved', 1)
            ->where('purchase_request.approvedAkhir', 1)
            ->where('purchase_request.hapus', 0)
            ->where('purchase_request.proses', 1)
            ->where('purchase_request_detail.jumlahProses', '<', DB::raw('purchase_request_detail.jumlah')) //errorr disini
            ->get();

        $dataDetail = DB::table('purchase_order_detail')
            ->select('purchase_order_detail.*', 'Item.ItemName as itemName', 'Tax.TaxPercent as TaxPercent')
            //->leftjoin('purchase_request_detail', 'purchase_order_detail.idPurchaseRequestDetail','=','purchase_request_detail.id')
            ->leftjoin('Tax', 'purchase_order_detail.idTax', '=', 'Tax.TaxID')
            ->leftjoin('Item', 'purchase_order_detail.idItem', '=', 'Item.ItemID')
            ->where('purchase_order_detail.idPurchaseOrder', '=', $purchaseOrder->id)
            ->get();
        $dataTax = DB::table('Tax')
            ->get();

        $dataPerusahaan = DB::table('MPerusahaan') //
            ->get();

        $dataPurchaseRequest = DB::table('purchase_request')
            ->select('purchase_request.*', 'MPerusahaan.MPerusahaanID as cidp')
            ->join('MGudang', 'purchase_request.MGudangID', '=', 'MGudang.MGudangID')
            ->join('MPerusahaan', 'MGudang.cidp', '=', 'MPerusahaan.MPerusahaanID')
            ->where('purchase_request.approved', 1)
            ->where('purchase_request.approvedAkhir', 1)
            ->where('purchase_request.hapus', 0)
            ->where('purchase_request.proses', 1)
            ->get();
        $dataUser = DB::table('users')
            ->get();

        return view('master.PurchaseOrder.print', [
            'purchaseOrder' => $purchaseOrder,
            'dataDetail' => $dataDetail,
            'dataSupplier' => $dataSupplier,
            'dataPayment' => $dataPayment,
            'dataBarang' => $dataBarang,
            'dataTax' => $dataTax,
            'dataPurchaseRequestDetail' => $dataPurchaseRequestDetail,
            'dataPurchaseRequest' => $dataPurchaseRequest,
            'dataPerusahaan' => $dataPerusahaan,
            'dataUser' => $dataUser,
        ]);
    }

    public function searchNamePO(Request $request)
    {
        $name = $request->input('searchname');
        $user = Auth::user();

        $getPerusahaan = DB::table('MPerusahaan')
            ->join('MGudang', 'MPerusahaan.MPerusahaanID', '=', 'MPerusahaan.MPerusahaanID')
            ->where('MGudangID', $user->MGudangID)
            ->get();

        $data = DB::table('purchase_order')
            ->select('purchase_order.*')
            ->join('users', 'purchase_order.created_by', '=', 'users.id')
            ->join('MGudang', 'users.MGudangID', '=', 'MGudang.MGudangID')
            ->join('MKota', 'MGudang.cidkota', '=', 'MKota.cidkota')
            ->join('MPerusahaan', 'MGudang.cidp', '=', 'MPerusahaan.MPerusahaanID')
            ->where('purchase_order.hapus', '=', 0)
            ->where('purchase_order.name', 'like', '%' . $name . '%')
            ->orderByDesc('purchase_order.tanggalDibuat', 'purchase_order.id')
            ->paginate(10);
        //->get();

        //dd($data);

        $user = Auth::user();
        $check = $this->checkAccess('purchaseOrder.index', $user->id, $user->idRole);
        if ($check) {
            return view('master.PurchaseOrder.index', [
                'data' => $data,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Purchase Order');
        }
    }

    public function searchDatePO(Request $request)
    {
        $date = $request->input('dateRangeSearch');
        $date = explode("-", $date);
        $user = Auth::user();

        $getPerusahaan = DB::table('MPerusahaan')
            ->join('MGudang', 'MPerusahaan.MPerusahaanID', '=', 'MPerusahaan.MPerusahaanID')
            ->where('MGudangID', $user->MGudangID)
            ->get();

        $data = DB::table('purchase_order')
            ->select('purchase_order.*')
            ->join('users', 'purchase_order.created_by', '=', 'users.id')
            ->join('MGudang', 'users.MGudangID', '=', 'MGudang.MGudangID')
            ->join('MKota', 'MGudang.cidkota', '=', 'MKota.cidkota')
            ->join('MPerusahaan', 'MGudang.cidp', '=', 'MPerusahaan.MPerusahaanID')
            ->where('purchase_order.hapus', '=', 0)
            ->whereBetween('tanggalDibuat', [$date[0], $date[1]])
            ->orderByDesc('purchase_order.tanggalDibuat', 'purchase_order.id')
            ->paginate(10);
        //->get();

        //dd($data);
        $user = Auth::user();
        $check = $this->checkAccess('purchaseOrder.index', $user->id, $user->idRole);
        if ($check) {
            return view('master.PurchaseOrder.index', [
                'data' => $data,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Purchase Order');
        }
    }

    public function searchNameDatePO(Request $request)
    {
        $name = $request->input('searchname');
        $date = $request->input('dateRangeSearch');
        $date = explode("-", $date);
        $user = Auth::user();

        $getPerusahaan = DB::table('MPerusahaan')
            ->join('MGudang', 'MPerusahaan.MPerusahaanID', '=', 'MPerusahaan.MPerusahaanID')
            ->where('MGudangID', $user->MGudangID)
            ->get();

        $data = DB::table('purchase_order')
            ->select('purchase_order.*')
            ->join('users', 'purchase_order.created_by', '=', 'users.id')
            ->join('MGudang', 'users.MGudangID', '=', 'MGudang.MGudangID')
            ->join('MKota', 'MGudang.cidkota', '=', 'MKota.cidkota')
            ->join('MPerusahaan', 'MGudang.cidp', '=', 'MPerusahaan.MPerusahaanID')
            ->where('purchase_order.hapus', '=', 0)
            ->where('purchase_order.name', 'like', '%' . $name . '%')
            ->whereBetween('tanggalDibuat', [$date[0], $date[1]])
            ->orderByDesc('purchase_order.tanggalDibuat', 'purchase_order.id')
            ->paginate(10);
        //->get();

        //dd($data);
        $user = Auth::user();
        $check = $this->checkAccess('purchaseOrder.index', $user->id, $user->idRole);
        if ($check) {
            return view('master.PurchaseOrder.index', [
                'data' => $data,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Purchase Order');
        }
    }
}
