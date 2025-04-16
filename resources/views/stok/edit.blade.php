@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">

        @empty($stok)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                The data you are looking for is not found.
            </div>
            <a href="{{ url('stok') }}" class="btn btn-sm btn-default mt-2">Back</a>
        @else
            <form method="POST" action="{{ url('/stok/'.$stok->stok_id) }}" class="form-horizontal">
                @csrf
                @method('PUT')

                <!-- barang -->
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Item</label>
                    <div class="col-11">
                        <select class="form-control" id="barang_id" name="barang_id" required>
                            <option value="">- Select Item -</option>
                            @foreach($barang as $item)
                                <option value="{{ $item->barang_id }}" @if($item->barang_id == $stok->barang_id) selected @endif>
                                    {{ $item->barang_nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('barang_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- user -->
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Employee Name</label>
                    <div class="col-11">
                        <select class="form-control" id="user_id" name="user_id" required>
                            <option value="">- Select Employee -</option>
                            @foreach($user as $item)
                                <option value="{{ $item->user_id }}" @if($item->user_id == $stok->user_id) selected @endif>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <!-- stok date -->
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Stock Date</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="stok_tanggal" name="stok_tanggal" value="{{ old('stok_tanggal', $stok->stok_tanggal) }}" required>
                        @error('stok_tanggal')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Nama -->
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Quantity</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="stok_jumlah" name="stok_jumlah" value="{{ old('stok_jumlah', $stok->stok_jumlah) }}" required>
                        @error('stok_jumlah')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Submit -->
                <div class="form-group row">
                    <div class="col-11 offset-1">
                        <button type="submit" class="btn btn-primary">save changes</button>
                        <a href="{{ url('stok') }}" class="btn btn-secondary">cancel</a>
                    </div>
                </div>

            </form>
        @endempty

    </div>
</div>
@endsection
