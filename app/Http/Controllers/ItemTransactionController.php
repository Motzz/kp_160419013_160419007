<?php

namespace App\Http\Controllers;

use App\Models\ItemTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ItemTransactionController extends Controller
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
        $data = DB::table('ItemTransaction')
            ->paginate(10);
        //->get();


        $user = Auth::user();
        $check = $this->checkAccess('itemTransaction.index', $user->id, $user->idRole);
        if ($check) {
            return view('master.itemTransaction.index', [
                'data' => $data,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Index Transaksi Barang');
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
        $check = $this->checkAccess('itemTransaction.create', $user->id, $user->idRole);
        if ($check) {
            return view('master.itemTransaction.tambah');
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Tambah Transaksi Barang');
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

        DB::table('ItemTransaction')
            ->insert(
                array(
                    'Name' => $data['Name'],
                    'Description' => $data['Description'],
                    'Code' => $data['Code'],
                    'CreatedBy' => $user->id,
                    'CreatedOn' => date("Y-m-d h:i:sa"),
                    'UpdatedBy' => $user->id,
                    'UpdatedOn' => date("Y-m-d h:i:sa"),
                )
            );
        return redirect()->route('itemTransaction.index')->with('status', 'Berhasil menambahkan transaksi barang');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemTransaction  $itemTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(ItemTransaction $itemTransaction)
    {
        //


        $user = Auth::user();
        $check = $this->checkAccess('itemTransaction.show', $user->id, $user->idRole);
        if ($check) {
            return view('master.itemTransaction.detail', [
                'itemTransaction' => $itemTransaction
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Detail Transaksi Barang');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemTransaction  $itemTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemTransaction $itemTransaction)
    {
        //

        $user = Auth::user();
        $check = $this->checkAccess('itemTransaction.edit', $user->id, $user->idRole);
        if ($check) {
            return view('master.itemTransaction.edit', [
                'itemTransaction' => $itemTransaction
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Ubah Transaksi Barang');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemTransaction  $itemTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemTransaction $itemTransaction)
    {
        //
        $data = $request->collect();
        $user = Auth::user();
        DB::table('ItemTransaction')
            ->where('ItemTransactionID', $itemTransaction['ItemTransactionID'])
            ->update(
                array(
                    'Name' => $data['Name'],
                    'Description' => $data['Description'],
                    'Code' => $data['Code'],
                    'UpdatedBy' => $user->id,
                    'UpdatedOn' => date("Y-m-d h:i:sa"),
                )
            );
        return redirect()->route('itemTransaction.index')->with('status', 'Berhasil mengubah transaksi barang');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemTransaction  $itemTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemTransaction $itemTransaction)
    {
        //

        $user = Auth::user();
        $check = $this->checkAccess('itemTransaction.edit', $user->id, $user->idRole);
        if ($check) {
            $itemTransaction->delete();
            DB::table('ItemTransaction')->where('ItemTransactionID', $itemTransaction['ItemTransactionID'])->delete();
            return redirect()->route('itemTransaction.index')->with('status', 'Berhasil menghapus transaksi barang');
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Hapus Transaksi Barang');
        }
    }

    public function searchItemTransactionName(Request $request)
    {
        //
        $name = $request->input('searchname');

        $data = DB::table('ItemTransaction')
            ->where('Name', 'like', '%' . $name . '%')
            ->paginate(10);
        //->get();

        $user = Auth::user();
        $check = $this->checkAccess('itemTransaction.index', $user->id, $user->idRole);
        if ($check) {
            return view('master.itemTransaction.index', [
                'data' => $data,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Index Transaksi Barang');
        }
    }
}
