<script>
    var table = 'table_satuan';
    var form = 'form_satuan';
    var fields = [
        'satuan_id',
        'satuan_nama',
        'satuan_kode',
        'satuan_active',
    ];

    $(() => {
        loadBlock()
        initTable();

    })

    initTable = () => {
        var table = $('#table_satuan').DataTable({
            processing: true,
            serverSide: true,
            searchAble: true,
            searching: true,
            paging: true,
            "bDestroy": true,
            ajax: "{{ route('satuan/table') }}",
            columns: [{
                    "data": null,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                },
                {
                    data: 'satuan_kode',
                    name: 'satuan_kode',
                    render: function(data, type, full, meta) {
                        return `<span>${full.satuan_kode?full.satuan_kode:''}</span>`;
                    }
                },
                {
                    data: 'satuan_nama',
                    name: 'satuan_nama',
                    render: function(data, type, full, meta) {
                        return `<span>${full.satuan_nama?full.satuan_nama:''}</span>`;
                    }
                },
                {
                    data: 'satuan_active',
                    name: 'satuan_active',
                    render: function(data, type, full, meta) {
                        var status = '';
                        if(full.satuan_active == 1){
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
            url : "{{ route('satuan/edit') }}",
            data:{
                satuan_id : id
            },
            method: 'post',
            success: function(data){
                unblock();
                $.each(fields, function(i,v){
                    $('#'+v).val(data[0][v]).change()
                })

                if(data[0].satuan_active == 1){
                    $('#satuan_active').prop('checked', true)
                }
            }
        })
    }

    onSave = () => {
        
        var formData = new FormData($(`[name="${form}"]`)[0]);
        
        var id_satuan = $('#satuan_id').val();
        var urlSave = "";

        if(id_satuan == '' || id_satuan == null){
            urlSave += "{{route('satuan/store')}}";
        }else{
            urlSave += "{{route('satuan/update')}}";
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
                        url : "{{ route('satuan/destroy') }}",
                        data:{
                            satuan_id : id
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
        $('#satuan_active').prop('checked', false)
    }
</script>