<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TaxController extends Controller
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

        $data = DB::table('Tax')
            ->paginate(10);
        //->get();
        $user = Auth::user();
        $check = $this->checkAccess('tax.index', $user->id, $user->idRole);
        if ($check) {
            return view('master.tax.index', [
                'data' => $data,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Master Pajak');
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
        $check = $this->checkAccess('tax.create', $user->id, $user->idRole);
        if ($check) {
            return view('master.tax.tambah');
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Master Pajak');
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

        DB::table('Tax')
            ->insert(
                array(
                    'Name' => $data['name'],
                    'Deskripsi' => $data['deskripsi'],
                    'TaxPercent' => $data['taxpercent'],
                    'CreatedBy' => $user->id,
                    'CreatedOn' => date("Y-m-d h:i:sa"),
                    'UpdatedBy' => $user->id,
                    'UpdatedOn' => date("Y-m-d h:i:sa"),
                )
            );
        return redirect()->route('tax.index')->with('status', 'Berhasil Menambah Data Pajak!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show(Tax $tax)
    {
        //

        $user = Auth::user();
        $check = $this->checkAccess('tax.show', $user->id, $user->idRole);
        if ($check) {
            return view('master.tax.detail', [
                'tax' => $tax,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Master Pajak');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit(Tax $tax)
    {
        //

        $user = Auth::user();
        $check = $this->checkAccess('tax.edit', $user->id, $user->idRole);
        if ($check) {
            return view('master.tax.edit', [
                'tax' => $tax,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Master Pajak');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tax $tax)
    {
        //
        $data = $request->collect();
        $user = Auth::user();

        DB::table('Tax')
            ->where('TaxID', $tax['TaxID'])
            ->update(
                array(
                    'Name' => $data['name'],
                    'Deskripsi' => $data['deskripsi'],
                    'TaxPercent' => $data['taxpercent'],
                    'UpdatedBy' => $user->id,
                    'UpdatedOn' => date("Y-m-d h:i:sa"),
                )
            );
        return redirect()->route('tax.index')->with('status', 'Berhasil Mengupdate Data Pajak!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tax $tax)
    {
        //
        $user = Auth::user();
        $check = $this->checkAccess('tax.edit', $user->id, $user->idRole);
        if ($check) {
            $tax->delete();
            return redirect()->route('tax.index')->with('status', 'Berhasil Menghapus Data Pajak!!');
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Master Pajak');
        }
    }

    public function searchTaxName(Request $request)
    {
        $name = $request->input('searchname');
        $data = DB::table('Tax')
            ->where('Name', 'like', '%' . $name . '%')
            ->paginate(10);
        //->get();

        $user = Auth::user();
        $check = $this->checkAccess('tax.index', $user->id, $user->idRole);
        if ($check) {
            return view('master.tax.index', [
                'data' => $data,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Master Pajak');
        }
    }

    public function searchTaxPercent(Request $request)
    {
        $taxPercent = $request->input('searchpercent');
        $data = DB::table('Tax')
            ->where('TaxPercent', 'like', '%' . $taxPercent . '%')
            ->get();

        $user = Auth::user();
        $check = $this->checkAccess('tax.index', $user->id, $user->idRole);
        if ($check) {
            return view('master.tax.index', [
                'data' => $data,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Master Pajak');
        }
    }
}
