<script>
    $(() => {
        $('#nama_kasir').html(": <?= Session::get('userdata.user_nama') ?>");
        initTable();
        getDataTransaksi();
    })

    getDataTransaksi = () => {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('transaksi/countTransaksi') }}",
            method: 'post',
            success: function(data) {
                $('#no_nota').html(" " + data['kode_transaksi']);

                if(data['grandtotal'] == 0){
                    $('#grandTotal').html("Rp. " + 0);
                }else{
                    $('#grandTotal').html("Rp. " + toRp(data['grandtotal']));
                }

                $('#bayar').val(data['grandtotal']);
                $('#totalBayar').val(data['grandtotal']);
            }
        })
    }

    getKembalian = () => {
        var totalBayar = $('#totalBayar').val();
        var bayar = $('#bayar').val();

        kembalian = Number(bayar) - Number(totalBayar);
        $('#kembalian').val(kembalian);
    }

    initTable = () => {
        var table = $('#table_keranjang').DataTable({
            processing: true,
            serverSide: true,
            searchAble: true,
            searching: true,
            paging: true,
            "bDestroy": true,
            ajax: "{{ route('transaksi/table') }}",
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
                        return `<span>${full.produk_nama?full.produk_nama:''}</span>`;
                    }
                },
                {
                    data: 'keranjang_qty',
                    name: 'keranjang_qty',
                    render: function(data, type, full, meta) {
                        return `<span>${full.keranjang_qty?full.keranjang_qty:''}</span>`;
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
                    data: 'produk_harga_jual',
                    name: 'produk_harga_jual',
                    render: function(data, type, full, meta) {
                        return `<span>${full.produk_harga_jual?toRp(full.produk_harga_jual):''}</span>`;
                    }
                },
                {
                    data: 'produk_harga_jual',
                    name: 'produk_harga_jual',
                    render: function(data, type, full, meta) {
                        subTotal = Number(full.produk_harga_jual) * Number(full.keranjang_qty);
                        return `<span>${subTotal?toRp(subTotal):''}</span>`;
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

    onShowBarang = () => {
        $('.viewForm').modal('show');
        $('#search_produk').val('');
        $('.result').html('');
    }

    searchProduk = () => {
        loadBlock();
        var data = $('#search_produk').val();

        if (data != '') {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('transaksi/search') }}",
                data: {
                    produk_kode: data
                },
                method: 'post',
                success: function(data) {
                    unblock();
                    var html = '';
                    if (data.length != 0) {

                        $.each(data, function(i, v) {
                            var img = '';
                            if (v.produk_photo) {
                                img +=
                                    `{{ Storage::disk('local')->url('public/uploads/produk/${v.produk_photo}') }}`
                            } else {
                                img += `assets/noImage.jpg`
                            }

                            html += `
                                <div class="card bg-light mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-2 d-none d-md-block">

                                                <img src="${img}" class="rounded-3" height="75px" width="75px" style="object-fit: cover" alt="product image">
                                            </div>
                                            <div class="col-8 col-md-6">

                                                <span class="">Kode : ${v.produk_kode}</span></br>
                                                <span class="">Nama : ${v.produk_nama}</span></br>
                                                <span class="">Stok : ${v.produk_stok}</span>
                                            </div>
                                            <div class="col-4 d-flex justify-content-end">
                                                <div class="row">
                                                    <div class="d-flex flex-row">
                                                        <button data-produk_id="${v.produk_id}" onclick="onPlus(this)" class="btn btn-primary w-40px  d-none d-md-block">+</button>
                                                        <input type="text" id="qty-${v.produk_id}" class="form-control mx-1 w-75px" value="1">
                                                        <button data-produk_id="${v.produk_id}" onclick="onMinus(this)" class="btn btn-primary w-40px  d-none d-md-block">-</button>
                                                    </div>
                                                    <div class="d-flex align-items-end justify-content-end mt-2 mt-md-0">
                                                        <button id="btn-${v.produk_id}" onclick="onAdd(this)" class="btn btn-primary" data-produk_id="${v.produk_id}">Tambahkan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        })
                        $('.result').html(html);
                    } else {
                        $('.result').html(
                            `<span class="text-muted mx-auto my-5 fs-4">Tidak Ditemukan...</span>`);
                    }

                }
            })
        } else {
            unblock();
            $('.result').html('');
        }
    }

    onPlus = (el) => {
        var id = $(el).data('produk_id');
        var qtyOld = $('#qty-' + id).val();

        // new qty
        var qtyNew = Number(qtyOld) + 1;
        $('#qty-' + id).val(qtyNew);
    }

    onMinus = (el) => {
        var id = $(el).data('produk_id');
        var qtyOld = $('#qty-' + id).val();

        // new qty
        var qtyNew = Number(qtyOld) - 1;
        if (qtyNew < 1) {
            saMessage({
                success: false,
                message: 'Jumlah tidak boleh kurang dari 1 !'
            })
        } else {
            $('#qty-' + id).val(qtyNew);
        }
    }

    onAdd = (el) => {
        var id = $(el).data('produk_id');
        var qty = $('#qty-' + id).val();
        var transaksi_no = $('#no_nota').html();


        if (Number(qty) < 1) {
            saMessage({
                success: false,
                message: 'Jumlah tidak boleh kurang dari 1 !'
            })
        } else {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('transaksi/addCart') }}",
                data: {
                    keranjang_produk_id: id,
                    keranjang_qty: qty,
                    keranjang_transaksi_no: transaksi_no,
                },
                method: 'post',
                success: function(res) {
                    $('.viewForm').modal('hide');
                    saMessage({
                        success: res['success'],
                        title: res['title'],
                        message: res['message'],
                        callback: function() {
                            initTable();
                            getDataTransaksi();

                        }
                    })

                }
            })

        }
    }

    onPlusQty = (el) => {
        var produk_id = $(el).data('produk_id');
        var keranjang_id = $(el).data('id');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('transaksi/plusQty') }}",
            data: {
                produk_id: produk_id,
                keranjang_id: keranjang_id
            },
            method: 'post',
            success: function(res) {
                console.log(res)
                if(res){
                    saMessage({
                        success: res['success'],
                        title: res['title'],
                        message: res['message'],
                    })
                }
                initTable();
                getDataTransaksi();
            }
        })
    }
    onMinusQty = (el) => {
        var produk_id = $(el).data('produk_id');
        var keranjang_id = $(el).data('id');
        var qty = Number($(el).data('qty')) - 1;

        if (Number(qty) < 1) {
            saMessage({
                success: false,
                message: 'Jumlah tidak boleh kurang dari 1 !'
            })
        } else {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('transaksi/minusQty') }}",
                data: {
                    produk_id: produk_id,
                    keranjang_id: keranjang_id
                },
                method: 'post',
                success: function(res) {
                    initTable();
                    getDataTransaksi();
                }
            })
        }

    }

    onDelete = (el) => {
        var produk_id = $(el).data('produk_id');
        var keranjang_id = $(el).data('id');
        var qty = $(el).data('qty');

        saConfirm({
            message: 'Apakah anda yakin untuk menghapus data?',
            callback: function(res) {
                if (res) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('transaksi/destroy') }}",
                        data: {
                            produk_id: produk_id,
                            keranjang_id: keranjang_id,
                            keranjang_qty: qty
                        },
                        method: 'post',
                        success: function(res) {
                            saMessage({
                                success: res['success'],
                                title: res['title'],
                                message: res['message'],
                            })
                            initTable();
                            getDataTransaksi();
                        }
                    })
                }
            }
        });
    }

    bayar = (el) => {
        var transaksi_no = $('#no_nota').html();
        var totalBayar = $('#totalBayar').val();
        var bayar = $('#bayar').val();

        if (Number(bayar) < Number(totalBayar)) {
            saMessage({
                success: false,
                message: 'Uang anda tidak mencukupi untuk melakukan pembayaran !',
            })
        } else {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('transaksi/bayar') }}",
                data: {
                    transaksi_no: transaksi_no,
                    transaksi_total_bayar: totalBayar,
                    transaksi_jumlah_uang: bayar,
                    transaksi_kembalian: Number(bayar) - Number(totalBayar),
                },
                method: 'post',
                success: function(res) {
                    saMessage({
                        success: res['success'],
                        title: res['title'],
                        message: res['message'],
                    })
                    initTable();

                    $('#grandTotal').html("Rp. ");
                    $('#bayar').val('');
                    $('#totalBayar').val('');
                    $('#kembalian').val('');

                    if (el == 'bayar') {
                        truncateCart();
                        getDataTransaksi();
                    } else {
                        setNota();
                        
                        
                        // $('#btn-cetak')[0].click();
                        // $(()=> {
                        //     initTable();
                        //     // $('#btn-cetak').click(function(){
                        //         // alert(el)
                        //     // });
                        // })
                    }
                }
            })
        }
    }

    setNota = () => {
        var transaksi_no = $('#no_nota').html();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : {
                transaksi_no : transaksi_no
            },
            url: "{{ route('transaksi/cetak') }}",
            method: 'post',
            success: function(data) {
                $('.struk').html(data)

                var divToPrint = $('.struk').html();

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

                setTimeout(function(){newWin.close();},10)
                truncateCart();
                getDataTransaksi();

            }
        })
    }

    truncateCart = () => {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ route('transaksi/truncateCart') }}",

            method: 'post',
            success: function(res) {
                initTable();
            }
        })
    }
</script>
