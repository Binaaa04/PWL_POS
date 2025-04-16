@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">

        @empty($barang)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                The data you are looking for is not found.
            </div>
            <a href="{{ url('barang') }}" class="btn btn-sm btn-default mt-2">Back</a>
        @else
            <form method="POST" action="{{ url('/barang/'.$barang->barang_id) }}" class="form-horizontal">
                @csrf
                @method('PUT')

                <!-- Category -->
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Category</label>
                    <div class="col-11">
                        <select class="form-control" id="kategori_id" name="kategori_id" required>
                            <option value="">- Select Category -</option>
                            @foreach($kategori as $item)
                                <option value="{{ $item->kategori_id }}" @if($item->kategori_id == $item->kategori_id) selected @endif>
                                    {{ $item->kategori_nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- kategori code -->
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Item Code</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="barang_kode" name="barang_kode" value="{{ old('barang_kode', $barang->barang_kode) }}" required>
                        @error('barang_kode')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Nama -->
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Item Name</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="barang_nama" name="barang_nama" value="{{ old('barang_nama', $barang->barang_nama) }}" required>
                        @error('barang_nama')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                    <!-- Harga Beli -->
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Purchase Price</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="harga_jual" name="harga_jual" value="{{ old('harga_jual', $barang->harga_jual) }}" required>
                        @error('harga_jual')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Harga Jual -->
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Selling Price</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="harga_beli" name="harga_beli" value="{{ old('harga_beli', $barang->harga_beli) }}" required>
                        @error('harga_beli')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Submit -->
                <div class="form-group row">
                    <div class="col-11 offset-1">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="{{ url('barang') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>

            </form>
        @endempty

    </div>
</div>
@endsection
