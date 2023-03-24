<script>
    var table = 'table_laporantransaksi';
   
    $(() => {
        loadBlock();
        initTable();
        totalPendapatan();
        
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
        var table = $('#table_laporantransaksi').DataTable({
            processing: true,
            serverSide: true,
            searchAble: true,
            searching: true,
            paging: true,
            "bDestroy": true,
            "ajax": {
                'type': 'GET',
                'url': "{{ route('laporantransaksi/table') }}",
                'data': filter,
            },
            // ajax: "{{ route('laporantransaksi/table') }}",
            columns: [{
                    "data": null,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                },
                {
                    data: 'transaksi_tanggal',
                    name: 'transaksi_tanggal',
                    render: function(data, type, full, meta) {
                        return `<span>${full.transaksi_tanggal?dateFormat(full.transaksi_tanggal):''}</span>`;
                    }
                },
                {
                    data: 'transaksi_total_bayar',
                    name: 'transaksi_total_bayar',
                    render: function(data, type, full, meta) {
                        return `<span>${full.income?'Rp. '+toRp(full.income):''}</span>`;
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
            // cetakLaporan(true);

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
        initTable(filter);
        totalPendapatan(filter);
        // onCetakLaporan(filter);
    }

    totalPendapatan = (filter) => {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : filter,
            url: "{{ route('laporantransaksi/totalPendapatan') }}",
            method: 'post',
            success: function(data) {
                $('.sum_income').html(data?'Rp. '+toRp(data[0]['income']):'-');
            }
        })
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

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : filter,
            url: "{{ route('laporantransaksi/cetakLaporan') }}",
            method: 'post',
            success: function(data) {
                // console.log(data);return;
                $('.laporan').html(data);

                var divToPrint = $('.laporan').html();

                newWin = window.open("");
                newWin.document.write('<!DOCTYPE html>'
                                        +'<html lang="en">'
                                        +'<head>'
                                            +'<meta charset="UTF-8">'
                                            +'<meta http-equiv="X-UA-Compatible" content="IE=edge">'
                                            +'<meta name="viewport" content="width=device-width, initial-scale=1.0">'
                                            +'<title>Laporan Penjualan</title>'

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

    onDetail = (el) => {
        var date = $(el).data('date');
        loadBlock()
        var table = $('#table_detailtransaksi').DataTable({
            processing: true,
            serverSide: true,
            searchAble: true,
            searching: true,
            paging: true,
            "bDestroy": true,
            "ajax": {
                'type': 'GET',
                'url': "{{ route('laporantransaksi/detail') }}",
                'data': {
                    date : date
                },
            },
            columns: [{
                    "data": null,
                    "sortable": false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1
                    }
                },
                {
                    data: 'transaksi_no',
                    name: 'transaksi_no',
                    render: function(data, type, full, meta) {
                        return `<span>${full.transaksi_no?full.transaksi_no:''}</span>`;
                    }
                },
                {
                    data: 'transaksi_total_bayar',
                    name: 'transaksi_total_bayar',
                    render: function(data, type, full, meta) {
                        return `<span>${full.transaksi_total_bayar?'Rp. '+toRp(full.transaksi_total_bayar):''}</span>`;
                    }
                },
                {
                    data: 'user_nama',
                    name: 'user_nama',
                    render: function(data, type, full, meta) {
                        return `<span>${full.user_nama?full.user_nama:''}</span>`;
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

        $('.viewDetail').modal('show');
    }

    onCetak = (el) => {
        var transaksi_no = $(el).data('no');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : {
                transaksi_no : transaksi_no
            },
            url: "{{ route('laporantransaksi/cetak') }}",
            method: 'post',
            success: function(data) {
                $('.nota').html(data)

                var divToPrint = $('.nota').html();

                newWin = window.open("");

                // newWin.document.write('<html><body onload="window.print()">'+divToPrint+'</body></html>');
                newWin.document.write('<!DOCTYPE html>'
                                        +'<html lang="en">'
                                        +'<head>'
                                            +'<meta charset="UTF-8">'
                                            +'<meta http-equiv="X-UA-Compatible" content="IE=edge">'
                                            +'<meta name="viewport" content="width=device-width, initial-scale=1.0">'
                                            +'<title>cetak nota</title>'

                                            +'<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">'
                                            +'<style>'
                                                +'@page {'
                                                    +'margin: 0;'
                                                    +'width: 100%;'

                                                +'}'
                                                +'@media print {'
                                                    +'html,body {'
                                                        +'margin: 0;'
                                                        +'width: 100%;'
                                                    +'}'
                                                +'}'
                                            +'</style>'
                                        +'</head>'
                                        +'<body style="width: 219.2126 px; line-height: 1;" onload="window.print()">'
                                            +divToPrint
                                        +'</body>'
                                        +'</html>');

                newWin.print();
                newWin.close();

                setTimeout(function(){newWin.close();},10);

            }
        })
    }
</script>