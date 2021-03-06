<?php

namespace App\Http\Controllers;

use App\Models\MGudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MGudangController extends Controller
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
        $data = DB::table('MGudang')
            ->select(
                'MGudang.*',
                'MPerusahaan.cname as perusahaanName',
                'MPerusahaan.cnames as perusahaanNames',
                'users.name as manager',
                'MKota.cname as kotaName',
                'MProvinsi.cname as provinsiName',
                'MPulau.cname as pulauName'
            )
            ->leftjoin('MPerusahaan', 'MGudang.cidp', '=', 'MPerusahaan.MPerusahaanID')
            ->leftjoin('users', 'MGudang.UserIDKepalaDivisi', '=', 'users.id')
            ->leftjoin('MKota', 'MGudang.cidkota', '=', 'MKota.cidkota')
            ->leftjoin('MPulau', 'MKota.cidpulau', '=', 'MPulau.cidpulau')
            ->leftjoin('MProvinsi', 'MKota.cidprov', '=', 'MProvinsi.cidprov')
            //->leftjoin('MGudangValues', 'MGudang.MGudangID', '=', 'MGudangValues.MGudangID')
            //->leftjoin('MGudangAreaSimpan', 'MGudangValues.MGudangAreaSimpanID', '=', 'MGudangAreaSimpan.MGudangAreaSimpanID')
            ->paginate(10);
        //->get();

        $dataTag = DB::table('MGudangValues')
            ->leftjoin('MGudangAreaSimpan', 'MGudangValues.MGudangAreaSimpanID', '=', 'MGudangAreaSimpan.MGudangAreaSimpanID')
            ->get();
        //dd($dataTag);

        $user = Auth::user();
        $check = $this->checkAccess('mGudang.index', $user->id, $user->idRole);
        if ($check) {
            return view('master.mGudang.index', [
                'data' => $data,
                'dataTag' => $dataTag,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Index Gudang');
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
        $dataMKota = DB::table('MKota')
            ->get();
        $dataMPerusahaan = DB::table('MPerusahaan')
            ->get();
        $dataMGudangAreaSimpan = DB::table('MGudangAreaSimpan')
            ->get();
        $users = DB::table('users')->get();


        $user = Auth::user();
        $check = $this->checkAccess('mGudang.create', $user->id, $user->idRole);
        if ($check) {
            return view('master.mGudang.tambah', [
                'dataMKota' => $dataMKota,
                'dataMPerusahaan' => $dataMPerusahaan,
                'dataMGudangAreaSimpan' => $dataMGudangAreaSimpan,
                'users' => $users,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Tambah Gudang');
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
        $user = Auth::user();

        $idGudang = DB::table('MGudang')
            ->insertGetId(
                array(
                    'ccode' => $data['code'],
                    'cname' => $data['name'],
                    'cidp' => $data['perusahaan'],
                    'cidkota' => $data['kota'],
                    'CreatedBy' => $user->id,
                    'CreatedOn' => date("Y-m-d h:i:s"),
                    'UpdatedBy' => $user->id,
                    'UpdatedOn' => date("Y-m-d h:i:s"),
                    'UserIDKepalaDivisi' => $data['kepala'],
                )
            );

        /*for($i = 0; $i < count($data['gudangAreaSimpanTotal']); $i++){
            DB::table('MGudangValues')->insert(array(
                'MGudangID' => $idGudang,
                'MGudangAreaSimpanID' => $data['gudangAreaSimpanID'][$i],
                )
            ); 
        }*/

        return redirect()->route('mGudang.index')->with('status', 'Berhasil menambahkan gudang');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MGudang  $mGudang
     * @return \Illuminate\Http\Response
     */
    public function show(MGudang $mGudang)
    {
        //
        /*$data = DB::table('MGudang')
            ->join('MPerusahaan', 'MGudang.cidp', '=', 'MPerusahaan.MPerusahaanID')
            ->join('MKota', 'MGudang.cidkota', '=', 'MKota.cidkota')
            ->get();*/
        $dataMKota = DB::table('MKota')
            ->get();
        $dataMPerusahaan = DB::table('MPerusahaan')
            ->get();
        $dataMGudangAreaSimpan = DB::table('MGudangAreaSimpan')
            ->get();
        $users = DB::table('users')->get();


        $user = Auth::user();
        $check = $this->checkAccess('mGudang.show', $user->id, $user->idRole);
        if ($check) {
            return view('master.mGudang.detail', [
                'mGudang' => $mGudang,
                'dataMKota' => $dataMKota,
                'dataMPerusahaan' => $dataMPerusahaan,
                'dataMGudangAreaSimpan' => $dataMGudangAreaSimpan,
                'users' => $users,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Detail Gudang');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MGudang  $mGudang
     * @return \Illuminate\Http\Response
     */
    public function edit(MGudang $mGudang)
    {
        //
        $dataMKota = DB::table('MKota')
            ->get();
        $dataMPerusahaan = DB::table('MPerusahaan')
            ->get();
        $dataMGudangAreaSimpan = DB::table('MGudangAreaSimpan')
            ->get();
        $users = DB::table('users')->get();


        $user = Auth::user();
        $check = $this->checkAccess('mGudang.edit', $user->id, $user->idRole);
        if ($check) {
            return view('master.mGudang.edit', [
                'mGudang' => $mGudang,
                'dataMKota' => $dataMKota,
                'dataMPerusahaan' => $dataMPerusahaan,
                'dataMGudangAreaSimpan' => $dataMGudangAreaSimpan,
                'users' => $users,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Ubah Gudang');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MGudang  $mGudang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MGudang $mGudang)
    {
        //
        $data = $request->collect();
        $user = Auth::user();
        DB::table('MGudang')
            ->where('MGudangID', $mGudang['MGudangID'])
            ->update(
                array(
                    'ccode' => $data['code'],
                    'cname' => $data['name'],
                    'cidp' => $data['perusahaan'],
                    'cidkota' => $data['kota'],
                    'UpdatedBy' => $user->id,
                    'UpdatedOn' => date("Y-m-d h:i:s"),
                    'UserIDKepalaDivisi' => $data['kepala'],
                )
            );

        /*$dataGudangValues = DB::table('MGudangValues')
            ->where('MGudangID', $mGudang->MGudangID)
            ->get();

        if(count($dataTagValues) > count($data['gudangAreaSimpanTotal'])){
            DB::table('MGudangValues')
                ->where('MGudangID','=',$mGudang->MGudangID)
                ->delete();

            for($i = 0; $i < count($data['gudangAreaSimpanTotal']); $i++){
            DB::table('MGudangValues')
                ->insert(array(
                    'MGudangID' => $mGudang->MGudangID,
                    'MGudangAreaSimpanID' => $data['mGudangAreaSimpanID'][$i],
                    )
                ); 
            }
        }
        else{
            for($i = 0; $i < count($data['gudangAreaSimpanTotal']); $i++){
                if($i < count($dataTagValues)){
                    DB::table('MGudangValues')
                        ->where('MGudangID', $mGudang->MGudangID)
                        ->update(array(
                            'MGudangAreaSimpanID' => $data['mGudangAreaSimpanID'][$i],
                        )
                    );
                }
                else{
                    DB::table('MGudangValues')
                        ->insert(array(
                            'MGudangID' => $mGudang->MGudangID,
                            'MGudangAreaSimpanID' => $data['mGudangAreaSimpanID'][$i],
                        )
                    ); 
                }
            }
        }*/
        return redirect()->route('mGudang.index')->with('status', 'Berhasil mengubah gudang');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MGudang  $mGudang
     * @return \Illuminate\Http\Response
     */
    public function destroy(MGudang $mGudang)
    {
        //

        $user = Auth::user();
        $check = $this->checkAccess('mGudang.edit', $user->id, $user->idRole);
        if ($check) {
            $mGudang->delete();
            /*DB::table('MGudangValues')
                ->where('MGudangID','=',$mGudang->MGudangID)
                ->delete();
            */
            return redirect()->route('mGudang.index')->with('status', 'Berhasil menghapus gudang');
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Hapus Gudang');
        }
    }

    public function searchGudangName(Request $request)
    {
        //
        $name = $request->input('searchname');
        $data = DB::table('MGudang')
            ->select(
                'MGudang.*',
                'MPerusahaan.cname as perusahaanName',
                'MPerusahaan.cnames as perusahaanNames',
                'users.name as manager',
                'MKota.cname as kotaName',
                'MProvinsi.cname as provinsiName',
                'MPulau.cname as pulauName',
                'MGudangAreaSimpan.MGudangAreaSimpanID as gudangAreaSimpanID',
                'MGudangAreaSimpan.cname as gudangAreaSimpanName'
            )
            ->leftjoin('MPerusahaan', 'MGudang.cidp', '=', 'MPerusahaan.MPerusahaanID')
            ->leftjoin('users', 'MGudang.UserIDKepalaDivisi', '=', 'users.id')
            ->leftjoin('MKota', 'MGudang.cidkota', '=', 'MKota.cidkota')
            ->leftjoin('MPulau', 'MKota.cidpulau', '=', 'MPulau.cidpulau')
            ->leftjoin('MProvinsi', 'MKota.cidprov', '=', 'MProvinsi.cidprov')
            ->leftjoin('MGudangValues', 'MGudang.MGudangID', '=', 'MGudangValues.MGudangID')
            ->leftjoin('MGudangAreaSimpan', 'MGudangValues.MGudangAreaSimpanID', '=', 'MGudangAreaSimpan.MGudangAreaSimpanID')
            ->where('MGudang.cname', 'like', '%' . $name . '%')
            ->paginate(10);
        //->get();

        $dataTag = DB::table('MGudangValues')
            ->leftjoin('MGudangAreaSimpan', 'MGudangValues.MGudangAreaSimpanID', '=', 'MGudangAreaSimpan.MGudangAreaSimpanID')
            ->get();
        //dd($dataTag);

        $user = Auth::user();
        $check = $this->checkAccess('mGudang.index', $user->id, $user->idRole);
        if ($check) {
            return view('master.mGudang.index', [
                'data' => $data,
                'dataTag' => $dataTag,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Index Gudang');
        }
    }

    public function searchGudangCode(Request $request)
    {
        //
        $code = $request->input('searchcode');

        $data = DB::table('MGudang')
            ->select(
                'MGudang.*',
                'MPerusahaan.cname as perusahaanName',
                'MPerusahaan.cnames as perusahaanNames',
                'users.name as manager',
                'MKota.cname as kotaName',
                'MProvinsi.cname as provinsiName',
                'MPulau.cname as pulauName',
                'MGudangAreaSimpan.MGudangAreaSimpanID as gudangAreaSimpanID',
                'MGudangAreaSimpan.cname as gudangAreaSimpanName'
            )
            ->leftjoin('MPerusahaan', 'MGudang.cidp', '=', 'MPerusahaan.MPerusahaanID')
            ->leftjoin('users', 'MGudang.UserIDKepalaDivisi', '=', 'users.id')
            ->leftjoin('MKota', 'MGudang.cidkota', '=', 'MKota.cidkota')
            ->leftjoin('MPulau', 'MKota.cidpulau', '=', 'MPulau.cidpulau')
            ->leftjoin('MProvinsi', 'MKota.cidprov', '=', 'MProvinsi.cidprov')
            ->leftjoin('MGudangValues', 'MGudang.MGudangID', '=', 'MGudangValues.MGudangID')
            ->leftjoin('MGudangAreaSimpan', 'MGudangValues.MGudangAreaSimpanID', '=', 'MGudangAreaSimpan.MGudangAreaSimpanID')
            ->where('MGudang.ccode', 'like', '%' . $code . '%')
            ->paginate(10);

        $dataTag = DB::table('MGudangValues')
            ->leftjoin('MGudangAreaSimpan', 'MGudangValues.MGudangAreaSimpanID', '=', 'MGudangAreaSimpan.MGudangAreaSimpanID')
            ->get();
        //dd($dataTag);
        $user = Auth::user();
        $check = $this->checkAccess('mGudang.index', $user->id, $user->idRole);
        if ($check) {
            return view('master.mGudang.index', [
                'data' => $data,
                'dataTag' => $dataTag,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Index Gudang');
        }
    }

    public function searchGudangKota(Request $request)
    {
        //
        $kota = $request->input('searchkota');
        $data = DB::table('MGudang')
            ->select(
                'MGudang.*',
                'MPerusahaan.cname as perusahaanName',
                'MPerusahaan.cnames as perusahaanNames',
                'users.name as manager',
                'MKota.cname as kotaName',
                'MProvinsi.cname as provinsiName',
                'MPulau.cname as pulauName',
                'MGudangAreaSimpan.MGudangAreaSimpanID as gudangAreaSimpanID',
                'MGudangAreaSimpan.cname as gudangAreaSimpanName'
            )
            ->leftjoin('MPerusahaan', 'MGudang.cidp', '=', 'MPerusahaan.MPerusahaanID')
            ->leftjoin('users', 'MGudang.UserIDKepalaDivisi', '=', 'users.id')
            ->leftjoin('MKota', 'MGudang.cidkota', '=', 'MKota.cidkota')
            ->leftjoin('MPulau', 'MKota.cidpulau', '=', 'MPulau.cidpulau')
            ->leftjoin('MProvinsi', 'MKota.cidprov', '=', 'MProvinsi.cidprov')
            ->leftjoin('MGudangValues', 'MGudang.MGudangID', '=', 'MGudangValues.MGudangID')
            ->leftjoin('MGudangAreaSimpan', 'MGudangValues.MGudangAreaSimpanID', '=', 'MGudangAreaSimpan.MGudangAreaSimpanID')
            ->where('MKota.cname', 'like', '%' . $kota . '%')
            ->paginate(10);

        $dataTag = DB::table('MGudangValues')
            ->leftjoin('MGudangAreaSimpan', 'MGudangValues.MGudangAreaSimpanID', '=', 'MGudangAreaSimpan.MGudangAreaSimpanID')
            ->get();
        //dd($dataTag);
        $user = Auth::user();
        $check = $this->checkAccess('mGudang.index', $user->id, $user->idRole);
        if ($check) {
            return view('master.mGudang.index', [
                'data' => $data,
                'dataTag' => $dataTag,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Index Gudang');
        }
    }
}
