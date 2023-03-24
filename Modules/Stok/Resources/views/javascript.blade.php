<script>
    var form = 'form_stok';
    var fields = [
        'stok_id',
        'stok_kategori',
        'stok_produk_id',
        'stok_jumlah',
        'stok_label',
        'stok_supplier_id',
        'stok_produk_beban',
        'stok_keterangan',
    ];

    $(() => {
        $('#stok_kategori, #stok_produk_id, #stok_supplier_id').select2();
        combobox();
    })

    showBeban = () => {
        var data = $('#stok_kategori').val();
        if (data == 2) {
            $('.col-beban').addClass('d-none');
        } else {
            $('.col-beban').removeClass('d-none');
        }
    }

    combobox = () => {
        loadBlock();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('produk/combobox') }}",
            method: 'post',
            success: function(data) {
                $.each(data, (i, v) => {
                    $('#stok_produk_id').append(`
                        <option value="${v['produk_id']}">${v['produk_nama']}</option>
                    `);
                })
                unblock();
            }
        })
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('supplier/combobox') }}",
            method: 'post',
            success: function(data) {
                $.each(data, (i, v) => {
                    $('#stok_supplier_id').append(`
                        <option value="${v['supplier_id']}">${v['supplier_nama']}</option>
                    `);
                })
                unblock();
            }
        })
    }

    onSave = () => {
        var formData = new FormData($(`[name="${form}"]`)[0]);
        var urlSave = "";

        var produk_id = $('#stok_produk_id').val();
        var produk_beban = $('#stok_produk_beban').val();

        var kategori = $('#stok_kategori').val();

        // get old data
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('stok/getOldData') }}",
            method: 'post',
            data: {
                produk_id: produk_id
            },
            success: function(data) {
                var infoProduk = '';

                if (kategori == 1) {
                    if (produk_beban > data['produk_beban']) {
                        marginBeban = Number(produk_beban) - Number(data['produk_beban']);
                        hargaBaru1 = Number(data['produk_harga']) * Number(produk_beban);
                        hargaBaru2 = Number(hargaBaru1) / 100;
                        hargaBaru = Number(hargaBaru2) + data['produk_harga'];

                        infoProduk += `
                        Beban sebelumnya sebesar ${data['produk_beban']} %.  \r\n
                        Mengalami kenaikan sebesar ${marginBeban} %.\r\nym8jj
                        Harga jual produk akan berubah dari Rp. ${toRp(data['produk_harga_jual'])} menjadi Rp. ${toRp(hargaBaru)}.\r\n
                        Apakah anda yakin untuk menyimpan data ? \r\n
                    `;
                    } else {
                        marginBeban = Number(data['produk_beban']) - Number(produk_beban);
                        hargaBaru1 = Number(data['produk_harga']) * Number(produk_beban);
                        hargaBaru2 = Number(hargaBaru1) / 100;
                        hargaBaru = Number(hargaBaru2) + data['produk_harga'];

                        infoProduk += `
                        Beban sebelumnya sebesar ${data['produk_beban']} %. \r\n
                        Mengalami penurunan sebesar ${marginBeban} %. \r\n
                        Harga jual produk akan berubah dari Rp. ${toRp(data['produk_harga_jual'])} menjadi Rp. ${toRp(hargaBaru)}. \r\n
                        Apakah anda yakin untuk menyimpan data ? \r\n
                    `;
                    }
                }else{
                    infoProduk += `Apakah anda yakin menyimpan data tersebut ?`;
                }


                saConfirm({
                    message: infoProduk,
                    callback: function(res) {
                        if (res) {
                            loadBlock();
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                        .attr('content')
                                },
                                url: "{{ route('stok/store') }}",
                                method: 'post',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(res) {
                                    unblock();
                                    onReset();
                                    saMessage({
                                        success: res['success'],
                                        title: res['title'],
                                        message: res['message']
                                    })
                                }
                            })
                        }

                    }
                })
            }
        })


        // saConfirm({
        //     message: infoProduk,
        //     callback: function(res) {
        //         if (res) {
        //             loadBlock();
        //             $.ajax({
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                 },
        //                 url: "{{ route('stok/store') }}",
        //                 method: 'post',
        //                 data: formData,
        //                 processData: false,
        //                 contentType: false,
        //                 success: function(res) {
        //                     unblock();
        //                     onReset();
        //                     saMessage({
        //                         success: res['success'],
        //                         title: res['title'],
        //                         message: res['message']
        //                     })
        //                 }
        //             })
        //         }

        //     }
        // })
    }

    onReset = () => {
        $.each(fields, function(i, v) {
            $('#' + v).val('').change()
        })
    }
</script>
