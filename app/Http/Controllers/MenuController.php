<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
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
        $data = DB::Table('menu')
            ->paginate(10);
        //->get();

        $user = Auth::user();
        $check = $this->checkAccess('menu.index', $user->id, $user->idRole);
        if ($check) {
            return view('master.menu.index', [
                'data' => $data,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Index Menu');
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
        $check = $this->checkAccess('menu.create', $user->id, $user->idRole);
        if ($check) {
            return view('master.menu.tambah');
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Tambah Menu');
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

        DB::table('menu')
            ->insert(
                array(
                    'Name' => $data['Name'],
                    'Url' => $data['Url'],
                    'Deskripsi' => $data['Deskripsi'],
                    'CreatedBy' => $user->id,
                    'CreatedOn' => date("Y-m-d h:i:sa"),
                    'UpdatedBy' => $user->id,
                    'UpdatedOn' => date("Y-m-d h:i:sa"),
                )
            );
        return redirect()->route('menu.index')->with('status', 'Berhasil menambahkan menu');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //


        $user = Auth::user();
        $check = $this->checkAccess('menu.show', $user->id, $user->idRole);
        if ($check) {
            return view('master.menu.detail', [
                'menu' => $menu,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Detail Menu');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        //

        $user = Auth::user();
        $check = $this->checkAccess('menu.edit', $user->id, $user->idRole);
        if ($check) {
            return view('master.menu.edit', [
                'menu' => $menu,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Ubah Menu');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        //
        $data = $request->collect();
        $user = Auth::user();
        DB::table('menu')
            ->where('MenuID', $menu['MenuID'])
            ->update(
                array(
                    'Name' => $data['Name'],
                    'Url' => $data['Url'],
                    'Deskripsi' => $data['Deskripsi'],
                    'UpdatedBy' => $user->id,
                    'UpdatedOn' => date("Y-m-d h:i:sa"),
                )
            );
        return redirect()->route('menu.index')->with('status', 'Berhasil mengubah menu');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //
        $user = Auth::user();
        $check = $this->checkAccess('menu.edit', $user->id, $user->idRole);
        if ($check) {
            $menu->delete();
            return redirect()->route('menu.index')->with('status', 'Berhasil menghapus menu');
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Hapus Menu');
        }
    }

    public function searchMenuName(Request $request)
    {
        //
        $name = $request->input('searchname');
        $data = DB::Table('menu')
            ->where('Name', 'like', '%' . $name . '%')
            ->paginate(10);
        //->get();

        $user = Auth::user();
        $check = $this->checkAccess('menu.index', $user->id, $user->idRole);
        if ($check) {
            return view('master.menu.index', [
                'data' => $data,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Index Menu');
        }
    }

    public function searchMenuDeskripsi(Request $request)
    {
        //
        $desc = $request->input('searchdeskripsi');
        $data = DB::Table('menu')
            ->where('deskripsi', 'like', '%' . $desc . '%')
            ->paginate(10);
        //->get();
        $user = Auth::user();
        $check = $this->checkAccess('menu.index', $user->id, $user->idRole);
        if ($check) {
            return view('master.menu.index', [
                'data' => $data,
            ]);
        } else {
            return redirect()->route('home')->with('message', 'Anda tidak memiliki akses kedalam Index Menu');
        }
    }
}
