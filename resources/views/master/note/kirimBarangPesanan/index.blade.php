@extends('layouts.home_master')

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

@section('judul')
Kirim pesanan
@endsection

@section('pathjudul')
<li class="breadcrumb-item"><a href="/home">Home</a></li>
<li class="breadcrumb-item">Nota</li>
<li class="breadcrumb-item active">Kirim pesanan</li>
@endsection

@section('content')
<div class="container-fluid">
        <h2 class="text-center display-4">Cari Nota</h2>
        <div class="row">
            <div class="col-md-8 offset-md-2">
            <form action="/kirimBarangPesanane/searchname/" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg" name="searchname" placeholder="Nama NPP">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-default">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</div>
<div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
            <form action="/kirimBarangPesanane/searchdate/" method="get">
                <label>Tanggal Pembuatan Awal - Akhir:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                        </span>
                    </div>
                    <input type="text" name="searchdate" class="form-control float-right" id="reservation" value="{{old('tanggalDibutuhkan','')}}" >
                    <button type="submit" class="btn btn-lg btn-default">
                    <i class="fa fa-search"></i>
                    </button>
                </div>                           
            </form>
        </div>
    </div>
</div>
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List-Kirim pesanan Barang</h3>
                    
                    <a href="{{route('kirimBarangPesanan.create')}}" class="btn btn-primary btn-responsive float-right">Tambah pesanan Barang
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                        </svg>
                    </a> 
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Tanggal Dibuat</th>
                                <th scope="col">Gudang Awal</th>
                                <th scope="col">Gudang Tujuan</th>
                                <th scope="col">keterangan Pengemudi</th>
                                <th scope="col">Handle</th>
                            </tr>
                          </thead>
                         <tbody>
                            @foreach($data as $d)
                            <tr >
                            <th scope="row" name='id'>{{$d->id}}</th>
                            <td>{{$d->name}}</td>
                            <td>{{$d->tanggalDibuat}}</td>
                            @foreach($dataGudang as $gudang)
                                @if($gudang->MGudangID == $d->MGudangIDAwal)
                                    <td>{{$gudang->cname}}</td>
                                @endif
                            @endforeach     
                            @foreach($dataGudang as $gudang)
                                @if($gudang->MGudangID == $d->MGudangIDTujuan)
                                    <td>{{$gudang->cname}}</td>
                                @endif
                            @endforeach 
                            <td>{{$d->keteranganPemudi}}</td>                 
                            <td>  
                                <a class="btn btn-default bg-info" href="{{route('kirimBarangPesanan.show',[$d->id])}}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-default bg-info" href="{{route('kirimBarangPesanan.edit',[$d->id])}}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{route('kirimBarangPesanan.destroy',[$d->id])}}" method="POST" class="btn btn-responsive">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-default bg-danger" action="{{route('kirimBarangPesanan.destroy',[$d->id])}}">
                                        <i class="fas fa-trash"></i> 
                                    </button>
                                </form>  
                            </td>
                              
                            </tr>
                            @endforeach
                           
                          </tbody>
                        <tfoot>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Tanggal Dibuat</th>
                                <th scope="col">Gudang Awal</th>
                                <th scope="col">Gudang Tujuan</th>
                                <th scope="col">keterangan Pengemudi</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
{{ $data->links('pagination::bootstrap-4') }}

@endsection