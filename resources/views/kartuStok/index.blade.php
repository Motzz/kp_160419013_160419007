@extends('layouts.home_master')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

@section('judul')
Kartu Stok
@endsection

@section('pathjudul')
<li class="breadcrumb-item"><a href="/home">Home</a></li>
<li class="breadcrumb-item active">Kartu Stok</li>
@endsection


@section('content')
<div class="container-fluid">
        <h2 class="text-center display-4">Search Gudang</h2>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <form action="/kartuStok/searchgudang/" method="get">
                    <div class="input-group">
                    <select class="form-control selectpicker col-md-8" data-live-search="true" data-show-subtext="true" style="width: 100%;" id="idGudangTujuan" name="searchgudangid">
                        <option value="">
                            --Pilih Gudang--
                        </option>
                        @foreach($dataGudang as $data)
                            <option name="idGudang" singkatan="{{$data->ccode}}" value="{{$data->MGudangID}}"{{$data->cname == $data->MGudangID? 'selected' :'' }}>{{$data->cname}}</option>
                        @endforeach
                
                    </select>
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
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kartu Stok</h3>
                    
           
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                             <tr>
                                <th scope="col">Gudang</th>
                                <th scope="col">Item</th>
                                <th scope="col">Satuan</th>
                                <th scope="col">Jumlah Barang</th>
                                <th scope="col">Handle</th>
                            </tr>
                          </thead>
                        <tbody>
                              @foreach($dataReport as $stok)            
                              <tr>  
                              
                                <td >{{$stok->gudangName}}</td>
                                <td >{{$stok->ItemName}}</td>
                                <td>
                                @foreach($dataItem as $item)
                                    @if($stok->ItemID == $item->ItemID)
                                        {{$item->Name}}
                                    @endif
                                @endforeach
                                </td>
                                <td>
                                    {{$stok->totalQuantity}}                                
                                </td>                 
                                 <a class="btn btn-default bg-info" href="{{route('inventoryTransaction.show',[$stok->ItemTransactionID])}}">
                                        <i class="fas fa-eye"></i> 
                                </a>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th scope="col">Gudang</th>
                                <th scope="col">Item</th>
                                <th scope="col">Satuan</th>
                                <th scope="col">Jumlah Barang</th>                  
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


