@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">

        @empty($level)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                The data you are looking for is not found.
            </div>
            <a href="{{ url('level') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        @else
            <form method="POST" action="{{ url('/level/'.$level->level_id) }}" class="form-horizontal">
                @csrf
                @method('PUT')

                <!-- level code -->
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">level Code</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="level_kode" name="level_kode" value="{{ old('level_kode', $level->level_kode) }}" required>
                        @error('level_kode')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Nama -->
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Level Name</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="level_nama" name="level_nama" value="{{ old('level_nama', $level->level_nama) }}" required>
                        @error('level_nama')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Submit -->
                <div class="form-group row">
                    <div class="col-11 offset-1">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="{{ url('level') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>

            </form>
        @endempty

    </div>
</div>
@endsection
