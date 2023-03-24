<script>
    var table = 'table_produk';
    var form = 'form_produk';
    var fields = [
        'produk_id',
        'produk_kode',
        'produk_nama',
        'produk_kategori_id',
        'produk_satuan_id',
        'produk_harga',
        'produk_beban',
        'produk_keterangan',
        // 'produk_photo',
        'produk_active',
    ];

    $(() => {
        $("#produk_photo").change(function() {
            readURL(this);
        });

        $('#produk_kategori_id, #produk_satuan_id').select2({
            dropdownParent: $('.viewForm')
        });

        loadBlock();
        initTable();
        onCombobox();
    })

    showForm = () => {
        onReset()
        $('.viewForm').modal('show')
    }
    
    showExcel = () => {
        $('#modalExcel').modal('show')
    }

    $('#produk_import_file').change(()=>{
        var filename = $('#produk_import_file').val().replace(/.*(\/|\\)/, '');
        if($('#produk_import_file').val()){
            $('#text_upload_file').html(filename);
        }else{
            $('#text_upload_file').html('Import Excel File');
        }
    })

    initTable = () => {
        var table = $('#table_produk').DataTable({
            processing: true,
            serverSide: true,
            searchAble: true,
            searching: true,
            paging: true,
            "bDestroy": true,
            ajax: "{{ route('produk/table') }}",
            columns: [{
                    "data": null,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                },
                {
                    data: 'produk_kode',
                    name: 'produk_kode',
                    render: function(data, type, full, meta) {
                        return `<span class="barcode39">${full.produk_kode?full.produk_kode:''}</span>`;
                    }
                },
                {
                    data: 'produk_nama',
                    name: 'produk_nama',
                    render: function(data, type, full, meta) {
                        var image = '';
                        if (full.produk_photo) {
                            image += `<?= asset('storage/uploads/produk/`+full.produk_photo+`') ?>`
                        } else {
                            image += `<?= asset('assets/noImage.jpg') ?>`
                        }

                        return `
                            <div>
                                <div class="col-12 mb-1">
                                    <img src="${image}" class="rounded-3" style="width: 60px; height: 60px; object-fit: cover" alt="Image Product" />
                                </div>
                                <div class="col-12">
                                    <span>${full.produk_nama?full.produk_nama:''}</span>
                                </div>
                            </div>
                            `;
                    }
                },
                
                {
                    data: 'produk_harga',
                    name: 'produk_harga',
                    render: function(data, type, full, meta) {
                        var harga =''; 
                        if(full.produk_harga){
                            harga += toRp(full.produk_harga);
                        }else{
                            harga += '-';
                        }
                        return `<span>${harga}</span>`;
                    }
                },
                {
                    data: 'produk_beban',
                    name: 'produk_beban',
                    render: function(data, type, full, meta) {
                        var harga =''; 
                        if(full.produk_beban){
                            harga += full.produk_beban+' %';
                        }else{
                            harga += '-';
                        }
                        return `<span>${harga}</span>`;
                    }
                },
                {
                    data: 'produk_harga_jual',
                    name: 'produk_harga_jual',
                    render: function(data, type, full, meta) {
                        var harga_jual =''; 
                        if(full.produk_harga_jual){
                            harga_jual += toRp(full.produk_harga_jual);
                        }else{
                            harga_jual += '-';
                        }
                        return `<span>${harga_jual}</span>`;
                    }
                },
                {
                    data: 'produk_stok',
                    name: 'produk_stok',
                    render: function(data, type, full, meta) {
                        return `<span>${full.produk_stok?full.produk_stok:''}</span>`;
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
                    data: 'satuan_nama',
                    name: 'satuan_nama',
                    render: function(data, type, full, meta) {
                        return `<span>${full.satuan_nama?full.satuan_nama:''}</span>`;
                    }
                },
                // {
                //     data: 'supplier_nama',
                //     name: 'supplier_nama',
                //     render: function(data, type, full, meta) {
                //         return `<span>${full.supplier_nama?full.supplier_nama:''}</span>`;
                //     }
                // },
                {
                    data: 'produk_keterangan',
                    name: 'produk_keterangan',
                    render: function(data, type, full, meta) {
                        return `<span>${full.produk_keterangan?full.produk_keterangan:''}</span>`;
                    }
                },
                {
                    data: 'produk_active',
                    name: 'produk_active',
                    render: function(data, type, full, meta) {
                        var status = '';
                        if (full.produk_active == 1) {
                            status += `<span class="badge bg-success">Active</span>`;
                        } else {
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

    onSave = () => {
        var formData = new FormData($(`[name="${form}"]`)[0]);

        var id_produk = $('#produk_id').val();
        var urlSave = "";

        if (id_produk == '' || id_produk == null) {
            urlSave += "{{ route('produk/store') }}";
        } else {
            urlSave += "{{ route('produk/update') }}";
        }

        saConfirm({
            message: 'Apakah anda yakin untuk mengubah data?',
            callback: function(res) {
                if (res) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: urlSave,
                        method: 'post',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            // JSON.parse(res);

                            $('.viewForm').modal('hide');
                            onReset();
                            saMessage({
                                success: res['success'],
                                title: res['title'],
                                message: res['message'],
                                callback:function(){
                                    initTable();
                                }
                            })
                        }
                    })
                }
            }
        })
    }

    onEdit = (el) => {
        var id = $(el).data('id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('produk/edit') }}",
            data: {
                produk_id: id
            },
            method: 'post',
            success: function(data) {
                showForm()

                var img = data[0]['produk_photo'];

                if (img) {
                    $('#produk_photoPreview').attr('src',`{{ Storage::disk('local')->url('public/uploads/produk/${img}') }}`);
                }

                $.each(fields, function(i, v) {
                    $('#' + v).val(data[0][v]).change()
                })

                $('#produk_password').val('').attr('placeholder',
                    'Kosongkan jika ingin mengubah password');

                if (data[0]['produk_active'] == 1) {
                    $('#produk_active').prop('checked', true)
                } else {
                    $('#produk_active').prop('checked', false)
                }
            }
        })
    }

    onDelete = (el) => {
        var id = $(el).data('id');
        saConfirm({
            message: 'Apakah anda yakin untuk menghapus data?',
            callback: function(res) {
                if (res) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('produk/destroy') }}",
                        data: {
                            produk_id: id
                        },
                        method: 'post',

                        success: function(res) {
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
        $.each(fields, function(i, v) {
            $('#' + v).val('').change()
        })
        $('#produk_keterangan').html('');
        $('#produk_active').prop('checked', false);
        removePP()
    }

    readURL = (input) => {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#produk_photoPreview').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    removePP = () => {
        $('#produk_photoPreview').attr('src', '').fadeIn('slow');
        $('#produk_photo').val('');
    }

    onCombobox = (el) => {
        loadBlock()
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('kategori/combobox') }}",
            method: 'post',
            success: function(data) {
                
                $.each(data, (i, v)=>{
                    $('#produk_kategori_id').append(`
                        <option value="${v['kategori_id']}">${v['kategori_nama']}</option>
                    `);
                })
                unblock()
            }
        })
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('satuan/combobox') }}",
            method: 'post',
            success: function(data) {
                
                $.each(data, (i, v)=>{
                    $('#produk_satuan_id').append(`
                        <option value="${v['satuan_id']}">${v['satuan_nama']}</option>
                    `);
                })
                unblock()
            }
        })
        // $.ajax({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     url: "{{ route('supplier/combobox') }}",
        //     method: 'post',
        //     success: function(data) {
                
        //         $.each(data, (i, v)=>{
        //             $('#produk_supplier_id').append(`
        //                 <option value="${v['supplier_id']}">${v['supplier_nama']}</option>
        //             `);
        //         })
        //         unblock()
        //     }
        // })

    }

    // onImport = (name) => {
    //     var formData = new FormData($(`[name="${name}"]`)[0]);
    //     saConfirm({
    //         message: 'Apakah anda yakin untuk import data?',
    //         callback:function(res){
    //             if(res){
    //                 $.ajax({
    //                     headers: {
    //                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                     },
    //                     url : "{{ route('produk/importExcel') }}",
    //                     method : 'post',
    //                     data : formData,
    //                     processData: false,
    //                     contentType: false,
    //                     success : function(res) {
    //                         saMessage({
    //                             success: res['success'],
    //                             title: res['title'],
    //                             message: res['message']
    //                         })
    //                         $('#modalExcel').modal('hide')
    //                     } 
    //                 })
    //             }

    //         }
    //     })
    // }
</script>
