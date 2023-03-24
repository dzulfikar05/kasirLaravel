<script>
    var table = 'table_supplier';
    var form = 'form_supplier';
    var fields = [
        'supplier_id',
        'supplier_nama',
        'supplier_kode',
        'supplier_telepon',
        'supplier_active',
    ];

    $(() => {
        loadBlock()
        initTable();

    })

    initTable = () => {
        var table = $('#table_supplier').DataTable({
            processing: true,
            serverSide: true,
            searchAble: true,
            searching: true,
            paging: true,
            "bDestroy": true,
            ajax: "{{ route('supplier/table') }}",
            columns: [{
                    "data": null,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                },
                {
                    data: 'supplier_kode',
                    name: 'supplier_kode',
                    render: function(data, type, full, meta) {
                        return `<span>${full.supplier_kode?full.supplier_kode:''}</span>`;
                    }
                },
                {
                    data: 'supplier_nama',
                    name: 'supplier_nama',
                    render: function(data, type, full, meta) {
                        return `<span>${full.supplier_nama?full.supplier_nama:''}</span>`;
                    }
                },
                {
                    data: 'supplier_telepon',
                    name: 'supplier_telepon',
                    render: function(data, type, full, meta) {
                        var html = '';
                        html += `<div class="row">
                                <a href="https://wa.me/${full.supplier_telepon?full.supplier_telepon:''}" target="blank" title="Klik untuk membuka WhatsApp" class="text-dark">${full.supplier_telepon?full.supplier_telepon:''}</a>
                                <span class="text-muted">${full.supplier_alamat?full.supplier_alamat:''}</span>
                            </div>`
                        return html;
                    }
                },
                {
                    data: 'supplier_keterangan',
                    name: 'supplier_keterangan',
                    render: function(data, type, full, meta) {
                        return `<span>${full.supplier_keterangan?full.supplier_keterangan:''}</span>`;
                    }
                },
                {
                    data: 'supplier_active',
                    name: 'supplier_active',
                    render: function(data, type, full, meta) {
                        var status = '';
                        if(full.supplier_active == 1){
                            status += `<span class="badge bg-success">Active</span>`;
                        }else{
                            status += `<span class="badge bg-danger">Non Active</span>`;
                        }
                        return status;
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        unblock()
    }

    onEdit = (el) => {
        loadBlock();
        var id = $(el).data('id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : "{{ route('supplier/edit') }}",
            data:{
                supplier_id : id
            },
            method: 'post',
            success: function(data){
                unblock();
                $.each(fields, function(i,v){
                    $('#'+v).val(data[0][v]).change()
                })

                $('#supplier_alamat').html(data[0]['supplier_alamat']);
                $('#supplier_keterangan').html(data[0]['supplier_keterangan']);

                if(data[0].supplier_active == 1){
                    $('#supplier_active').prop('checked', true)
                }
            }
        })
    }

    onSave = () => {
        
        var formData = new FormData($(`[name="${form}"]`)[0]);
        
        var id_supplier = $('#supplier_id').val();
        var urlSave = "";

        if(id_supplier == '' || id_supplier == null){
            urlSave += "{{route('supplier/store')}}";
        }else{
            urlSave += "{{route('supplier/update')}}";
        }

        saConfirm({
            message: 'Apakah anda yakin untuk mengubah data?',
            callback:function(res){
                if(res){
                    loadBlock();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url : urlSave,
                        method : 'post',
                        data : formData,
                        processData: false,
                        contentType: false,
                        success : function(res) {
                            unblock();
                            onReset();
                            saMessage({
                                success: res['success'],
                                title: res['title'],
                                message: res['message']
                            })
                            initTable();
                        } 
                    })
                }

            }
        })
    }

    onDelete = (el) => {
        var id = $(el).data('id');
        saConfirm({
            message: 'Apakah anda yakin untuk menghapus data?',
            callback:function(res){
                if(res){
                    loadBlock();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url : "{{ route('supplier/destroy') }}",
                        data:{
                            supplier_id : id
                        },
                        method: 'post',
                        
                        success: function(res){
                            unblock();
                            saMessage({
                                success: res['success'],
                                title: res['title'],
                                message: res['message']
                            })
                            initTable();

                        }
                    })
                }
            }
        }); 
        
    }

    onReset = () => {
        $.each(fields , function(i, v){
            $('#'+v).val('').change()
        })
        $('#supplier_active').prop('checked', false)
    }
</script>