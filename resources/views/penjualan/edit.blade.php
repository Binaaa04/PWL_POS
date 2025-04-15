@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">

        @empty($penjualan)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                The data you are looking for is not found.
            </div>
            <a href="{{ url('penjualan') }}" class="btn btn-sm btn-default mt-2">Back</a>
        @else
            <form method="POST" action="{{ url('/penjualan/'.$penjualan->penjualan_id) }}" class="form-horizontal">
                @csrf
                {!! method_field('PUT') !!} 

                <!-- user -->
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Employee name</label>
                    <div class="col-11">
                        <select class="form-control" id="user_id" name="user_id" required>
                            <option value="">- Select Employee -</option>
                            @foreach($user as $item)
                                <option value="{{ $item->user_id }}" 
                                    @if($item->user_id == $item->user_id) selected @endif>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Nama Pembeli/ customer name -->
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Customer</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="pembeli" name="pembeli" value="{{ old('pembeli', $penjualan->pembeli) }}" required>
                        @error('pembeli')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                
                <!-- penjualan code -->
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Transaction Code</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="penjualan_kode" name="penjualan_kode" value="{{ old('penjualan_kode', $penjualan->penjualan_kode) }}" required>
                        @error('penjualan_kode')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- transaction Date -->
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">transaction Date</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="penjualan_tanggal" name="penjualan_tanggal" value="{{ old('penjualan_tanggal', $penjualan->penjualan_tanggal) }}" required>
                        @error('penjualan_tanggal')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Submit -->
                <div class="form-group row">
                    <div class="col-11 offset-1">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <a href="{{ url('penjualan') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>

            </form>
        @endempty

    </div>
</div>
@endsection
