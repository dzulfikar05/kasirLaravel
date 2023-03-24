<script>
    $(() => {
        loadBlock();
        index();
    })

    async function index(){
        await getDataCard();
        await getChartTerlaris();
        await unblock();
    }

    getDataCard = () => {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('dashboard/getDataCard')}}",
            method: 'post',
            processData: false,
            contentType: false,
            success: function(data) {
                $('.text-transaksi').html(toRp(data['countTransaksi']));
                $('.text-produk').html(toRp(data['countProduk']));
                $('.text-pengadaan').html(toRp(data['countPengadaan']));
                $('.text-income').html('Rp. '+toRp(data['countIncome']));
            }
        })
    }

    getChartTerlaris = () => {
        // Create chart instance
        var chart = am4core.create("chartTerlaris", am4charts.PieChart);

        // Create pie series
        var series = chart.series.push(new am4charts.PieSeries());
        series.dataFields.value = "jumlah";
        series.dataFields.category = "produk";
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('dashboard/getChartTerlaris')}}",
            method: 'post',
            processData: false,
            contentType: false,
            success: function(data) {
                var dataChart = [];

                for (let i = 0; i < data.length; i++) {
                    dataChart.push({
                        "produk": data[i].produk_nama,
                        "jumlah": data[i].produk_terjual
                    })
                }
                chart.data = dataChart;
            }
        })
        chart.legend = new am4charts.Legend();
    }
</script>
