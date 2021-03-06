
@extends('layouts.home_master')
<style>
            p {
                font-family: 'Nunito', sans-serif;
            }
 </style>

@section('judul')
Edit Supplier
@endsection

@section('pathjudul')
<li class="breadcrumb-item"><a href="/home">Home</a></li>
<li class="breadcrumb-item">Master</li>
<li class="breadcrumb-item"><a href="{{route('msupplier.index')}}">Supplier</a></li>
<li class="breadcrumb-item active">Edit</li>
@endsection
@section('content')
<div class="container-fluid">

<!-- Page Heading -->
<div class="card card-primary">
    <!-- form start -->
      <form action="{{route('msupplier.update',[$msupplier->SupplierID])}}" method="POST" >
        @csrf
        @method('PUT')
        <div class="card-body">
              <div class="form-group">
                        <div class="form-group">
                             <div class="form-group">
                             <label for="title">Info supplier</label>
                            <select name="infoSupplierID" class="form-control select2">
                                    <option value="">--Pilih supplier--</option>
                                    @foreach($infoSupplier as $key => $data)
                                    @if($data->InfoSupplierID==$msupplier->InfoSupplierID)
                                    <option selected value="{{$data->InfoSupplierID}}"{{$data->name == $data->InfoSupplierID? 'selected' :'' }}>{{$data->name}}</option>
                                    @else
                                    <option  value="{{$data->InfoSupplierID}}"{{$data->name == $data->InfoSupplierID? 'selected' :'' }}>{{$data->name}}</option>
                                    @endif
                                    @endforeach
                            </select>
                        </div>

                    

                        <div class="form-group">
                            <label for="title">Nama Supplier</label>
                           <input require type="text" name="name" maxlength="50" class="form-control" 
                           value="{{old('Name',$msupplier->Name)}}" >
                        </div>

                        <div class="form-group">
                            <label for="title">Alamat Supplier</label>
                           <input require type="text" name="alamat" maxlength="100" class="form-control" 
                           value="{{old('Alamat',$msupplier->Alamat)}}" >
                        </div>

                         <div class="form-group">
                            <label for="title">Kota</label>
                            <input require type="text" name="kota" maxlength="50" class="form-control" 
                           value="{{old('Kota',$msupplier->Kota)}}" >
                        </div>
                     
                        
                        <div class="form-group">
                            <label for="title">Kode Pos</label>
                            <input require type="number" name="kodePos" maxlength="50" class="form-control" 
                           value="{{old('KodePos',$msupplier->KodePos)}}" >
                        </div>


                        <div class="form-group">
                            <label for="title">Phone 1</label>
                            <input require type="number" name="phone1" maxlength="50" class="form-control" 
                           value="{{old('Phone1',$msupplier->Phone1)}}" >
                        </div>

                        <div class="form-group">
                            <label for="title">Phone 2</label>
                            <input require type="number" name="phone2" maxlength="50" class="form-control" 
                           value="{{old('Phone2',$msupplier->Phone2)}}" >
                        </div>

                        
                        <div class="form-group">
                            <label for="title">Fax 1</label>
                            <input require type="text" name="fax1" maxlength="50" class="form-control" 
                           value="{{old('Fax1',$msupplier->Fax1)}}" >
                        </div>

                        <div class="form-group">
                            <label for="title">Fax 2</label>
                            <input require type="text" name="fax2" maxlength="50" class="form-control" 
                           value="{{old('Fax2',$msupplier->Fax2)}}" >
                        </div>

                         <div class="form-group">
                            <label for="title">Contact Person</label>
                            <input require type="text" name="contactPerson" maxlength="50" class="form-control" 
                           value="{{old('ContactPerson',$msupplier->ContactPerson)}}" >
                        </div>

                         <div class="form-group">
                            <label for="title">email</label>
                            <input require type="text" name="email" maxlength="50" class="form-control" 
                           value="{{old('Email',$msupplier->Email)}}" >
                        </div>

                         <div class="form-group">
                            <label for="title">NPWP</label>
                            <input require type="number" name="NPWP" maxlength="20" class="form-control" 
                           value="{{old('NPWP',$msupplier->NPWP)}}" >
                        </div>

                        <div class="form-group">
                            <label for="title">Bank</label>
                            <input require type="text" name="bank" maxlength="50" class="form-control" 
                           value="{{old('bank',$msupplier->bank)}}" >
                        </div>
                       
                        
                         <div class="form-group">
                            <label for="title">No Rekening</label>
                            <input require type="number" name="noRekening" maxlength="50" class="form-control" 
                           value="{{old('NoRekening',$msupplier->NoRekening)}}" >
                        </div>

                        <div class="form-group">
                            <label for="title">note</label>
                            <input require type="text" name="note" maxlength="2000" class="form-control" 
                           value="{{old('Note',$msupplier->Note)}}" >
                        </div>

                           <div class="form-group">
                            <label for="title">Atas Nama</label>
                            <input require type="text" name="atasNama" maxlength="50" class="form-control" 
                           value="{{old('AtasNama',$msupplier->AtasNama)}}" >
                        </div>

                           <div class="form-group">
                            <label for="title">Lokasi</label>
                            <input require type="text" name="lokasi" maxlength="50" class="form-control" 
                           value="{{old('Lokasi',$msupplier->Lokasi)}}" >
                        </div>

                           <div class="form-group">
                            <label for="title">Kode</label>
                            <input require type="text" name="kode" maxlength="100" class="form-control" 
                           value="{{old('Kode',$msupplier->Kode)}}" >
                        </div>

                          <div class="form-group">
                            <label for="title">Keterangan</label>
                            <input require type="text" name="keterangan" maxlength="2000" class="form-control" 
                           value="{{old('Keterangan',$msupplier->Keterangan)}}" >
                        </div>


                          <div class="form-group">
                            <label for="title">Nama NPWP</label>
                            <input require type="text" name="namaNPWP" maxlength="128" class="form-control" 
                           value="{{old('NamaNPWP',$msupplier->NamaNPWP)}}" >
                        </div>

                     

                        <div class="form-group">
                            <label for="title">KTP</label>
                            <input require type="text" name="KTP" maxlength="128" class="form-control" 
                           value="{{old('KTP',$msupplier->KTP)}}" >
                        </div>

                       
        <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
        </div>
        
    </form>
</div>
@endsection

