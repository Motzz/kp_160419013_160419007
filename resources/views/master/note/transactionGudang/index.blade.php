@extends('layouts.home_master')

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

@section('judul')
Transaksi Gudang Barang
@endsection

@section('pathjudul')
<li class="breadcrumb-item"><a href="/home">Home</a></li>
<li class="breadcrumb-item">Nota</li>
<li class="breadcrumb-item active">Transaksi Gudang Barang</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List-Transaksi Gudang Barang</h3>
                    
                    <a href="{{route('transactionGudang.create')}}" class="btn btn-primary btn-responsive float-right">Tambah Transaksi Gudang Barang
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
                                <th scope="col">Tanggal Keluar/Masuk Barang</th>
                                <th scope="col">Jenis Transaksi</th>
                                <th scope="col">Jenis Proses</th>
                                <th scope="col">Gudang</th><!-- Gudang Awal-->
                                <th scope="col">Handle</th>
                            </tr>
                          </thead>
                         <tbody>
                            @foreach($data as $data)
                            <tr >
                            <th scope="row" name='id'>{{$data->id}}</th>
                            <td>{{$data->tanggalDibuat}}</td>
                            <td>{{$data->tanggalDatang}}</td>
                            <td>{{$data->itemTransactionName}}</td>
                            @if($data->isMenerima == "0")
                                <td>Mengirim</td>
                            @else
                                <td>Menerima</td>
                            @endif
                            @foreach($dataGudang as $gudang)
                                @if($gudang->MGudangID == $data->MGudangIDAwal)
                                    <td>{{$gudang->cname}}</td>
                                @endif
                            @endforeach                        
                            <td>  
                                <a class="btn btn-default bg-info" href="{{route('transactionGudang.show',[$data->id])}}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-default bg-info" href="{{route('transactionGudang.edit',[$data->id])}}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{route('transactionGudang.destroy',[$data->id])}}" method="POST" class="btn btn-responsive">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-default bg-danger" action="{{route('transactionGudang.destroy',[$data->id])}}">
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
                                <th scope="col">Tanggal Keluar/Masuk Barang</th>
                                <th scope="col">Jenis Transaksi</th>
                                <th scope="col">Jenis Proses</th>
                                <th scope="col">Gudang</th><!-- Gudang Awal-->
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

@endsection