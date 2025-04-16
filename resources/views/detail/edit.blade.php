@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">

        @empty($detail)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                The data you are looking for is not found.
            </div>
            <a href="{{ url('detail') }}" class="btn btn-sm btn-default mt-2">Back</a>
        @else
            <form method="POST" action="{{ url('/detail/'.$detail->detail_id) }}" class="form-horizontal">
                @csrf
                {!! method_field('PUT') !!} 

                <!-- customer -->
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Customer</label>
                    <div class="col-11">
                        <select class="form-control" id="penjualan_id" name="penjualan_id" required>
                            <option value="">- Select Customer -</option>
                            @foreach($penjualan as $item)
                                <option value="{{ $item->penjualan_id }}" @if($item->penjualan_id == $detail->penjualan_id) selected @endif>
                                    {{ $item->pembeli }}
                                </option>
                            @endforeach
                        </select>
                        @error('penjualan_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- barang -->
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Item</label>
                    <div class="col-11">
                        <select class="form-control" id="barang_id" name="barang_id" required>
                            <option value="">- Select Item -</option>
                            @foreach($barang as $item)
                                <option value="{{ $item->barang_id }}" @if($item->barang_id == $detail->barang_id) selected @endif>
                                    {{ $item->barang_nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('barang_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- detail date -->
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Total</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="harga" name="harga" value="{{ old('harga', $detail->harga) }}" required>
                        @error('harga')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Nama -->
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Quantity</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="jumlah" name="jumlah" value="{{ old('jumlah', $detail->jumlah) }}" required>
                        @error('jumlah')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- user -->
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">transaction date</label>
                    <div class="col-11">
                        <select class="form-control" id="penjualan_id" name="penjualan_id" required>
                            <option value="">- Select Transaction Date -</option>
                            @foreach($penjualan as $item)
                                <option value="{{ $item->penjualan_id }}" @if($item->penjualan_id == $detail->penjualan_id) selected @endif>
                                    {{ $item->penjualan_tanggal }}
                                </option>
                            @endforeach
                        </select>
                        @error('penjualan_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Submit -->
                <div class="form-group row">
                    <div class="col-11 offset-1">
                        <button type="submit" class="btn btn-primary">save changes</button>
                        <a href="{{ url('detail') }}" class="btn btn-secondary">cancel</a>
                    </div>
                </div>

            </form>
        @endempty

    </div>
</div>
@endsection
