<?php

namespace App\Http\Controllers;

use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class InventoryTransactionController extends Controller
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
        $data = DB::table('ItemInventoryTransaction')
            ->select('ItemInventoryTransaction.*', 'ItemTransaction.Name as itemTransactionName','MSupplier.Name as supplierName','MGudang.cname as gudangName','MGudang.ccode as gudangCode')
            ->leftjoin('ItemTransaction','ItemInventoryTransaction.ItemTransactionID','=','ItemTransaction.ItemTransactionID')
            ->leftjoin('MSupplier','ItemInventoryTransaction.SupplierID','=','MSupplier.SupplierID')
            ->leftjoin('MGudang','ItemInventoryTransaction.MGudangID','=','MGudang.MGudangID')
            ->paginate(10);
        $dataDetail = DB::table('ItemInventoryTransactionLine')
            ->get();
        
        return view('report.itemInventoryTransaction.index',[
            'data' => $data,
            'dataDetail' => $dataDetail,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Tidak ada

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ////Tidak ada
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InventoryTransaction  $inventoryTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(InventoryTransaction $inventoryTransaction)
    {
        //
        $user = Auth::user();

        $dataSupplier = DB::table('MSupplier')
            ->get();

        $dataBarang = DB::table('Item')
            ->select('Item.*', 'Unit.Name as unitName')
            ->join('Unit','Item.UnitID', '=', 'Unit.UnitID')
            ->leftjoin('ItemTagValues', 'Item.ItemID', '=', 'ItemTagValues.ItemID')
            ->where('Item.Hapus',0)
            ->get();

        $dataBarangTag = DB::table('Item')
            ->select('Item.*', 'Unit.Name as unitName','ItemTagValues.ItemTagID')
            ->join('Unit','Item.UnitID', '=', 'Unit.UnitID')
            ->join('ItemTagValues', 'Item.ItemID', '=', 'ItemTagValues.ItemID')
            ->where('Item.Hapus',0)
            ->get();
        //dd($dataBarangTag);
        $dataTag = DB::table('ItemTag')
            ->get();

        $dataGudang =DB::table('MGudang')
            ->get();          

        $suratJalan = DB::table('surat_jalan')
            ->where('hapus', 0)
            ->get();
        $suratJalanDetail = DB::table('surat_jalan_detail')
            ->select('surat_jalan_detail.*')
            ->join('surat_jalan', 'surat_jalan_detail.suratJalanID','=','surat_jalan.id')
            ->where('surat_jalan.hapus', 0)
            ->get();

        $transaksiGudangBarang = DB::table('transaction_gudang_barang')
            ->get();
        $transaksiGudangBarangDetail = DB::table('transaction_gudang_barang_detail')
            ->get();

        $stokAwal = DB::table('StokAwal')
            ->get();
        

        return view('report.itemInventoryTransaction.detail',[
            'inventoryTransaction' => $inventoryTransaction,
            'dataSupplier' => $dataSupplier,
            'dataBarangTag' => $dataBarangTag,
            'dataTag' => $dataTag,
            'dataGudang' => $dataGudang,
            'suratJalan' => $suratJalan,
            'suratJalanDetail' => $suratJalanDetail,
            'transaksiGudangBarang' => $transaksiGudangBarang,
            'transaksiGudangBarangDetail' => $transaksiGudangBarangDetail,
            'stokAwal' => $stokAwal,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InventoryTransaction  $inventoryTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(InventoryTransaction $inventoryTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InventoryTransaction  $inventoryTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InventoryTransaction $inventoryTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InventoryTransaction  $inventoryTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(InventoryTransaction $inventoryTransaction)
    {
        //
    }
}
