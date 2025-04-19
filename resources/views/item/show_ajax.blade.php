@empty($barang)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    Item data not found.
                </div>
                <a href="{{ url('/barang') }}" class="btn btn-warning">Back</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Item Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="alert alert-info">
                    <h5><i class="icon fas fa-info-circle"></i> Information</h5>
                   This detail data is u choose.
                </div>

                <table class="table table-sm table-bordered table-striped">
                    <tr>
                        <th class="text-right col-4">Code:</th>
                        <td class="col-8">{{ $barang->barang_kode }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-4">Name:</th>
                        <td class="col-8">{{ $barang->barang_nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-4">Category:</th>
                        <td class="col-8">{{ $barang->kategori->kategori_nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-4">Purchase Price:</th>
                        <td class="col-8">Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-4">Selling Price:</th>
                        <td class="col-8">Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
@endempty