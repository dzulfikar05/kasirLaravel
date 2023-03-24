<script>
    var table = 'table_kategori';
    var form = 'form_kategori';
    var fields = [
        'kategori_id',
        'kategori_nama',
        'kategori_kode',
        'kategori_active',
    ];

    $(() => {
        loadBlock()
        initTable();

    })

    initTable = () => {
        var table = $('#table_kategori').DataTable({
            processing: true,
            serverSide: true,
            searchAble: true,
            searching: true,
            paging: true,
            "bDestroy": true,
            ajax: "{{ route('kategori/table') }}",
            columns: [{
                    "data": null,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                },
                {
                    data: 'kategori_kode',
                    name: 'kategori_kode',
                    render: function(data, type, full, meta) {
                        return `<span>${full.kategori_kode?full.kategori_kode:''}</span>`;
                    }
                },
                {
                    data: 'kategori_nama',
                    name: 'kategori_nama',
                    render: function(data, type, full, meta) {
                        return `<span>${full.kategori_nama?full.kategori_nama:''}</span>`;
                    }
                },
                {
                    data: 'kategori_active',
                    name: 'kategori_active',
                    render: function(data, type, full, meta) {
                        var status = '';
                        if(full.kategori_active == 1){
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
            url : "{{ route('kategori/edit') }}",
            data:{
                kategori_id : id
            },
            method: 'post',
            success: function(data){
                unblock();
                $.each(fields, function(i,v){
                    $('#'+v).val(data[0][v]).change()
                })

                if(data[0].kategori_active == 1){
                    $('#kategori_active').prop('checked', true)
                }
            }
        })
    }

    onSave = () => {
        
        var formData = new FormData($(`[name="${form}"]`)[0]);
        
        var id_kategori = $('#kategori_id').val();
        var urlSave = "";

        if(id_kategori == '' || id_kategori == null){
            urlSave += "{{route('kategori/store')}}";
        }else{
            urlSave += "{{route('kategori/update')}}";
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
                        url : "{{ route('kategori/destroy') }}",
                        data:{
                            kategori_id : id
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
        $('#kategori_active').prop('checked', false)
    }
</script>