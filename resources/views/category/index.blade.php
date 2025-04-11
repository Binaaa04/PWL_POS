@extends('layouts.template') 
 
@section('content') 
  <div class="card card-outline card-primary"> 
      <div class="card-header"> 
        <h3 class="card-title">{{ $page->title }}</h3> 
        <div class="card-tools"> 
          <a class="btn btn-sm btn-primary mt-1" href="{{ url('kategori/create') }}">Add Category Data</a> 
        </div> 
      </div> 
      <div class="card-body">  
          @if (session('success'))
          <div class="alert alert-success">{{session('success')}}</div>
        @endif
          @if (session('error'))
          <div class="alert alert-danger">{{session('error')}}</div>
        @endif
        <div class="row">
          <div class="col-md-12">
          <div class="form-group row">
            <label class="col-1 control-label col-form-label">Filter:</label>
            <div class="col-3">
            <select class="form-control" id="kategori_kode" name="kategori_kode" required>
              <option value="">- all -</option>
              @foreach ($kategori as $item)
            <option value="{{$item->kategori_kode}}">{{$item->kategori_nama}}</option>
          @endforeach
            </select>
            <small class="form-text text-muted">kategori Data</small>
            </div>
          </div>
          </div>
        </div>
        <table class="table table-bordered table-striped table-hover table-sm" 
id="table_kategori"> 
          <thead> 
            <tr><th>ID</th><th>Category Code</th><th>Category Name</th><th>Action</th></tr> 
          </thead> 
      </table> 
    </div> 
  </div> 
@endsection 
 
@push('css') 
@endpush 
 
@push('js') 
  <script> 
    $(document).ready(function() { 
      var dataKategori = $('#table_kategori'). DataTable({ 
         // serverSide: true, if you want to use server side processing 
          serverSide: true,      
ajax: { 
              "url": "{{ url('kategori/list') }}", 
              "dataType": "json", 
              "type": "POST" ,
              "data":function(d){
                d.kategori_kode = $('#kategori_kode').val();
              }
}, 
columns: [ 
{ 
             // sequence number of laravel datatable addIndexColumn() 
              data: "DT_RowIndex",     
              className: "text-center", 
              orderable: false, 
              searchable: false     
},{ 
              data: "kategori_kode",                
 className: "", 
             // orderable: true, if you want this column to be sortable  
              orderable: true,     
              //searchable: true, if you want this field to be searchable 
              searchable: true     
},{ 
 data: "kategori_nama",  
 className: "", 
              orderable: true,     
              searchable: true     
},{ 
              data: "action",  
              className: "", 
              orderable: false,     
              searchable: false     
}] 
}); 
$('#kategori_kode').on('change', function () {
      datakategori.ajax.reload();
    });
}); 
  </script> 
@endpush 