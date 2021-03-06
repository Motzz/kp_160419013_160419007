<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
        $datas = DB::table('bank')
            ->paginate(10);
        //->get();


        $user = Auth::user();

        $check = $this->checkAccess('bank.index', $user->id, $user->idRole);
        if ($check) {
            return view('master.Bank.index', [
                'datas' => $datas,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Bank');
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
        return view('master.Bank.tambah');
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

        DB::table('bank')->insert(
            array(
                'name' => $data['name'],
                'alias' => $data['alias'],
                'CreatedBy' => $user->id,
                'CreatedOn' => date("Y-m-d h:i:sa"),
                'UpdatedBy' => $user->id,
                'UpdatedOn' => date("Y-m-d h:i:sa"),
            )
        );
        return redirect()->route('bank.index')->with('status', 'Success!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        //


        $user = Auth::user();

        $check = $this->checkAccess('bank.edit', $user->id, $user->idRole);
        if ($check) {
            return view('master.Bank.edit', [
                'bank' => $bank
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Bank');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
        //
        $data = $request->collect(); //la teros iki
        $user = Auth::user();

        DB::table('bank')
            ->where('id', $bank['id'])
            ->update(array(
                'name' => $data['name'],
                'alias' => $data['alias'],
                'UpdatedBy' => $user->id,
                'UpdatedOn' => date("Y-m-d h:i:sa"),
            ));

        return redirect()->route('bank.index')->with('status', 'Success!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        //
        $user = Auth::user();
        $check = $this->checkAccess('bank.edit', $user->id, $user->idRole);
        if ($check) {
            $bank->delete();
            return redirect()->route('bank.index')->with('status', 'Success!!');
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Bank');
        }
    }

    public function searchName(Request $request)
    {
        $name = $request->input('searchname');
        $datas = DB::table('bank')
            ->where('name', 'like', '%' . $name . '%')
            ->paginate(10);
        //->get();



        $user = Auth::user();

        $check = $this->checkAccess('bank.index', $user->id, $user->idRole);
        if ($check) {
            return view('master.Bank.index', [
                'datas' => $datas,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Bank');
        }
    }
}
