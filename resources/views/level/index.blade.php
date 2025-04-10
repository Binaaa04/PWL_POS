@extends('layouts.template') 
 
@section('content') 
  <div class="card card-outline card-primary"> 
      <div class="card-header"> 
        <h3 class="card-title">{{ $page->title }}</h3> 
        <div class="card-tools"> 
          <a class="btn btn-sm btn-primary mt-1" href="{{ url('level/create') }}">Add Level Data</a> 
        </div> 
      </div> 
      <div class="card-body"> 
        <table class="table table-bordered table-striped table-hover table-sm" 
id="table_level"> 
          <thead> 
            <tr><th>ID</th><th>Level_Code</th><th>Level_Name</th><th>Action</th></tr> 
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
      var datalevel = $('#table_level'). DataTable({ 
          //serverSide: true, if you want to use server side processing 
          serverSide: true,      
ajax: { 
              "url": "{{ url('level/list') }}", 
              "dataType": "json", 
              "type": "POST" 
}, 
columns: [ 
    { 
              //sequence number of laravel datatable addIndexColumn() 
              data: "DT_RowIndex",  
              className: "text-center", 
              orderable: false, 
              searchable: false     
},{ 
              data: "level_kode",                
 className: "", 
              //orderable: true, if you want this column to be sortable  
              orderable: true,     
              //searchable: true, if you want this field to be searchable 
              searchable: true     
},{ 
 data: "level_nama",  
 className: "", 
              orderable: true,     
              searchable: true     
},{ 
 data: "action",  
 className: "", 
              orderable: false,     
              searchable: false     
} 
] 
}); 
}); 
  </script> 
@endpush 