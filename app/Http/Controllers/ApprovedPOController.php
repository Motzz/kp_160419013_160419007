<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrder;
use Auth;

class ApprovedPOController extends Controller
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

        $managerPerusahaan2 = DB::table('MPerusahaan')
            ->where('UserIDManager2', $user->id)
            ->get();

        $poKeluar = null;
        //belum
        $arrPerusahaan = array();
        foreach($managerPerusahaan2 as $val){
            array_push($arrPerusahaan, $val->MPerusahaanID);
        }
        //dd($arrPerusahaan);
        if(count($managerPerusahaan2)>0){
            $poKeluar= DB::table('purchase_order')
                ->where('approved',0)
                ->where('hapus',0)
                ->whereIn('MPerusahaanID', $arrPerusahaan)
                ->paginate(10);
        }
        //dd($poKeluar);
        $pod = DB::table('purchase_order_detail')
            ->select("purchase_order_detail.*",'Item.ItemName as namaItem','Tax.Name as namaTax','Unit.Name as namaUnit')
            ->join('Item','purchase_order_detail.idItem','=','Item.ItemID')
            ->join('Unit','Item.UnitID','=','Unit.UnitID')
            ->join('Tax','purchase_order_detail.idTax','=','Tax.TaxID')
            //->paginate(10);
            ->get();
        
        return view('master.approved.PurchaseOrder.index',[
            'poKeluar' => $poKeluar,
            'pod' => $pod,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseOrder $approvedPurchaseOrder)
    {
        //
        $dataPerusahaan = DB::table('MPerusahaan')
            ->get();
        $dataBarang = DB::table('Item')
        ->select('Item.*', 'Unit.Name as unitName')
        ->join('Unit','Item.UnitID', '=', 'Unit.UnitID')
        ->where('Item.Hapus',0)
        ->get();
        $pod = DB::table('purchase_order_detail')
            ->select("purchase_order_detail.*",'Item.ItemName as namaItem','Tax.Name as namaTax','Unit.Name as namaUnit')
            ->join('Item','purchase_order_detail.idItem','=','Item.ItemID')
            ->join('Unit','Item.UnitID','=','Unit.UnitID')
            ->join('Tax','purchase_order_detail.idTax','=','Tax.TaxID')
            ->get();
        //dd($approvedPurchaseRequest['id']);
        if($approvedPurchaseOrder->approved == 0){
            return view('master.approved.PurchaseOrder.approve',[
                'purchaseOrder'=>$approvedPurchaseOrder,
                'dataPerusahaan'=>$dataPerusahaan,
                'dataBarang'=>$dataBarang,
                'pod'=>$pod,
            ]);
        }
        else{
            return redirect()->route('approvedPurchaseOrder.index')->with('status','Failed');
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseOrder $approvedPurchaseOrder)
    {
        //
        $data = $request->collect();
        $user = Auth::user();
        //dd($approvedPurchaseRequest['id']);
        if($approvedPurchaseOrder['approve'] == 0){
            DB::table('purchase_order')
            ->where('id', $approvedPurchaseOrder['id'])
            ->update(array(
                'approved' => $data['approve'],
                'approved_by' => $user->id,
            ));

            if($data['approve'] == 1){
                DB::table('purchase_order')
                ->where('id', $approvedPurchaseOrder['id'])
                ->update(array(
                    'proses' => 1,
                ));
            }
            else{
                DB::table('purchase_order')
                ->where('id', $approvedPurchaseOrder['id'])
                ->update(array(
                    'proses' => 0,
                ));


                $podet = DB::table('purchase_order_detail')->where('idPurchaseOrder',$approvedPurchaseOrder['id'])->get();
                foreach ($podet as $data) {

                    /*DB::table('purchase_request_detail')    masih salaa
                        ->where('id', $data['idPurchaseRequestDetail'])
                        ->update(array(
                            'jumlahProses' => $data['jumlah'],
                        ));
                    DB::table('purchase_request_detail')->decrement('jumlahProses', $data['jumlah'], [
                        'id' => $data['idPurchaseRequestDetail'],
                    ]);*/
                    DB::table('purchase_request_detail')
                        ->where('id', $data->idPurchaseRequestDetail)
                        ->decrement('jumlahProses', $data->jumlah);
                }
                
            }

        }

        return redirect()->route('approvedPurchaseOrder.index')->with('status','Success!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function searchNamePO(Request $request)
    {
        $name=$request->input('searchname');
        $user = Auth::user();

        $managerPerusahaan2 = DB::table('MPerusahaan')
            ->where('UserIDManager2', $user->id)
            ->get();

        $poKeluar = null;
        $arrPerusahaan = array();
        foreach($managerPerusahaan2 as $val){
            array_push($arrPerusahaan, $val->MPerusahaanID);
        }
        //belum
        if(count($managerPerusahaan2)>0){
            $poKeluar= DB::table('purchase_order')
                ->where('approved',0)
                ->where('hapus',0)
                ->whereIn('MPerusahaanID', $arrPerusahaan)
                ->where('name','like', '%'.$name.'%')
                ->paginate(10);
            //->get();
        }
        $pod = DB::table('purchase_order_detail')
            ->select("purchase_order_detail.*",'Item.ItemName as namaItem','Tax.Name as namaTax','Unit.Name as namaUnit')
            ->leftjoin('Item','purchase_order_detail.idItem','=','Item.ItemID')
            ->leftjoin('Unit','Item.UnitID','=','Unit.UnitID')
            ->leftjoin('Tax','purchase_order_detail.idTax','=','Tax.TaxID')
            ->get();
        
        return view('master.approved.PurchaseOrder.index',[
            'poKeluar' => $poKeluar,
            'pod' => $pod,
        ]);

    }

    public function searchDatePO(Request $request)
    {
        $date=$request->input('dateRangeSearch');
        $user = Auth::user();

        $managerPerusahaan2 = DB::table('MPerusahaan')
            ->where('UserIDManager2', $user->id)
            ->get();

        $poKeluar = null;
        $arrPerusahaan = array();
        foreach($managerPerusahaan2 as $val){
            array_push($arrPerusahaan, $val->MPerusahaanID);
        }
        //belum
        if(count($managerPerusahaan2)>0){
            $poKeluar= DB::table('purchase_order')
                ->where('approved',0)
                ->where('hapus',0)
                ->whereIn('MPerusahaanID', $arrPerusahaan)
                ->whereBetween('tanggalDibuat', [$date[0], $date[1]])
                ->paginate(10);
            //->get();
        }
        $pod = DB::table('purchase_order_detail')
            ->select("purchase_order_detail.*",'Item.ItemName as namaItem','Tax.Name as namaTax','Unit.Name as namaUnit')
            ->join('Item','purchase_order_detail.idItem','=','Item.ItemID')
            ->join('Unit','Item.UnitID','=','Unit.UnitID')
            ->join('Tax','purchase_order_detail.idTax','=','Tax.TaxID')
            ->get();
        
        return view('master.approved.PurchaseOrder.index',[
            'poKeluar' => $poKeluar,
            'pod' => $pod,
        ]);
    }
}
