<script>
    $(() => {
        $('#stok_kategori').select2();

        $(".datepicker").inputmask("99/99/9999", {
            "placeholder": "dd/mm/yyyy",
            autoUnmask: true
        });

        $('.datepicker').datepicker({
            value: new Date(),
            orientation: 'bottom left',
            clearBtn: true,
            format: 'dd-mm-yyyy',
            todayHighlight: true,
        });
    })

    initTable = (filter) => {
        loadBlock();
        var stok_kategori = $('#stok_kategori').val();
        filter['stok_kategori'] = stok_kategori;

        var table = $('#table_masuk').DataTable({
            processing: true,
            serverSide: true,
            searchAble: true,
            searching: true,
            paging: true,
            "bDestroy": true,
            "ajax": {
                'type': 'GET',
                'url': "{{ route('laporanstok/table') }}",
                'data': filter,
            },
            columns: [{
                    "data": null,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                },
                {
                    data: 'stok_tanggal',
                    name: 'stok_tanggal',
                    render: function(data, type, full, meta) {
                        return `<span>${full.stok_tanggal?dateFormat(full.stok_tanggal):''}</span>`;
                    }
                },
                {
                    data: 'produk_nama',
                    name: 'produk_nama',
                    render: function(data, type, full, meta) {
                        return `<span>${full.produk_nama?full.produk_nama:'-'}</span>`;
                    }
                },
                {
                    data: 'stok_label',
                    name: 'stok_label',
                    render: function(data, type, full, meta) {
                        return `<span>${full.stok_label?full.stok_label:'-'}</span>`;
                    }
                },
                {
                    data: 'stok_jumlah',
                    name: 'stok_jumlah',
                    render: function(data, type, full, meta) {
                        return `<span>${full.stok_jumlah?full.stok_jumlah:'-'}</span>`;
                    }
                },
                {
                    data: 'stok_produk_beban',
                    name: 'stok_produk_beban',
                    render: function(data, type, full, meta) {
                        return `<span>${full.stok_produk_beban?full.stok_produk_beban:'0'} %</span>`;
                    }
                },
                {
                    data: 'stok_keterangan',
                    name: 'stok_keterangan',
                    render: function(data, type, full, meta) {
                        return `<span>${full.stok_keterangan?full.stok_keterangan:'-'}</span>`;
                    }
                },
                {
                    data: 'supplier_nama',
                    name: 'supplier_nama',
                    render: function(data, type, full, meta) {
                        return `<span>${full.supplier_nama?full.supplier_nama:'-'}</span>`;
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

    function onFilter(is_reset = false) {
        var filter = {};
        if (is_reset == true) {
            $('#startDate, #endDate').val('').trigger('change');

        } else {
            if ($('#startDate').val()) {
                d = $('#startDate').val().slice(0, 2);
                m = $('#startDate').val().slice(2, 4);
                y = $('#startDate').val().slice(4);
                filter['startDate'] = d + '-' + m + '-' + y;
            }
            if ($('#endDate').val()) {
                d = $('#endDate').val().slice(0, 2);
                m = $('#endDate').val().slice(2, 4);
                y = $('#endDate').val().slice(4);
                filter['endDate'] = d + '-' + m + '-' + y;
            }
        }

        if($('#stok_kategori').val() == null){
            saMessage({
                success: false,
                message: "Pilih Kategori Terlebih Dahulu !"
            }); 
        }else{
            initTable(filter);
        }
    }

    cetakLaporan = () => {
        var filter = {};

        if ($('#startDate').val()) {
            d = $('#startDate').val().slice(0, 2);
            m = $('#startDate').val().slice(2, 4);
            y = $('#startDate').val().slice(4);
            filter['startDate'] = d + '-' + m + '-' + y;
        }
        if ($('#endDate').val()) {
            d = $('#endDate').val().slice(0, 2);
            m = $('#endDate').val().slice(2, 4);
            y = $('#endDate').val().slice(4);
            filter['endDate'] = d + '-' + m + '-' + y;
        }

        if($('#stok_kategori').val() == null){
            saMessage({
                success: false,
                message: "Pilih Kategori Terlebih Dahulu !"
            });  return;
        }
        var stok_kategori = $('#stok_kategori').val();
        filter['stok_kategori'] = stok_kategori;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : filter,
            url: "{{ route('laporanstok/cetakLaporan') }}",
            method: 'post',
            success: function(data) {
                $('.laporan').html(data);

                var divToPrint = $('.laporan').html();

                newWin = window.open("");
                newWin.document.write('<!DOCTYPE html>'
                                        +'<html lang="en">'
                                        +'<head>'
                                            +'<meta charset="UTF-8">'
                                            +'<meta http-equiv="X-UA-Compatible" content="IE=edge">'
                                            +'<meta name="viewport" content="width=device-width, initial-scale=1.0">'
                                            +'<title>Laporan Stok</title>'

                                            +'<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">'

                                        +'</head>'
                                        +'<style>'
                                            +'@page {'
                                                +'size: A4;'
                                            +'}'
                                            
                                        +'</style>'
                                        +'<body onload="window.print()">'
                                            +divToPrint
                                        +'</body>'
                                        +'</html>');
                newWin.print();
                newWin.close();
            }
        })
    }

    onCetak = (el) => {
        var stok_id = $(el).data('no');
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : {
                stok_id : stok_id
            },
            url: "{{ route('laporanstok/cetakInvoice') }}",
            method: 'post',
            success: function(data) {
                $('.invoice').html(data)

                var divToPrint = $('.invoice').html();

                newWin = window.open("");

                // newWin.document.write('<html><body onload="window.print()">'+divToPrint+'</body></html>');
                newWin.document.write('<!DOCTYPE html>'
                                        +'<html lang="en">'
                                        +'<head>'
                                            +'<meta charset="UTF-8">'
                                            +'<meta http-equiv="X-UA-Compatible" content="IE=edge">'
                                            +'<meta name="viewport" content="width=device-width, initial-scale=1.0">'
                                            +'<title>cetak invoice</title>'

                                            +'<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">'
                                            +'<style>'
                                                +'@page {'
                                                    +'margin: 0;'
                                                    +'width: 100%;'

                                                +'}'
                                                +' @media print{@page {size: landscape}}'
                                                +'@media print {'
                                                    +'html,body {'
                                                        +'margin: 0;'
                                                        +'width: 100%;'
                                                    +'}'
                                                +'}'
                                            +'</style>'
                                        +'</head>'
                                        +'<body style="width: 219.2126 px; line-height: 1;" onload="window.print()">'
                                            +'</br>'
                                            +divToPrint
                                        +'</body>'
                                        +'</html>');

                newWin.print();
                newWin.close();

                setTimeout(function(){newWin.close();},10)

            }
        })
    }
</script>