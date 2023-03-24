<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">SiKato</span>
        </a>

        <ul class="sidebar-nav">
            <li class="menu-dashboard d-none sidebar-item  {{ set_active('dashboard') }}">
                <a class="sidebar-link  " href="/">
                    <i class="align-middle " data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            {{-- <li class="sidebar-header">
                Master Data
            </li> --}}

            <li
                class=" sidebar-item {{ set_active('kategori') }} {{ set_active('satuan') }} {{ set_active('produk') }} {{ set_active('supplier') }}">
                <a data-bs-target="#masters" data-bs-toggle="collapse" class="sidebar-link collapsed  ">
                    <i class="align-middle " data-feather="layers"></i> <span class="align-middle">Master Data</span>
                </a>
                <ul id="masters"
                    class="sidebar-dropdown list-unstyled collapse {{ set_show('kategori') }} {{ set_show('satuan') }} {{ set_show('produk') }}  {{ set_show('supplier') }}"
                    data-bs-parent="#sidebar">
                    <li class="menu-kategori d-none sidebar-item {{ set_active('kategori') }}"><a class="sidebar-link"
                            href="kategori">Kategori</a></li>
                    <li class="menu-satuan d-none sidebar-item {{ set_active('satuan') }}"><a class="sidebar-link"
                            href="satuan">Satuan</a></li>
                    <li class="menu-supplier d-none sidebar-item {{ set_active('supplier') }}"><a class="sidebar-link"
                            href="supplier">Supplier</a></li>
                    <li class="menu-produk d-none sidebar-item {{ set_active('produk') }}"><a class="sidebar-link"
                            href="produk">Produk</a></li>
                </ul>
            </li>
            <li class="menu-stok d-none sidebar-item  {{ set_active('stok') }}">
                <a class="sidebar-link  " href="stok">
                    <i class="align-middle " data-feather="inbox"></i> <span class="align-middle">Stok</span>
                </a>
            </li>
            <li class="menu-transaksi d-none sidebar-item  {{ set_active('transaksi') }}">
                <a class="sidebar-link  " href="transaksi">
                    <i class="align-middle " data-feather="shopping-cart"></i> <span
                        class="align-middle">Transaksi</span>
                </a>
            </li>
            <li class=" sidebar-item {{ set_show('laporanstok') }} {{ set_show('laporantransaksi') }}">
                <a data-bs-target="#reports" data-bs-toggle="collapse" class="sidebar-link collapsed  ">
                    <i class="align-middle " data-feather="file-text"></i> <span class="align-middle">Laporan</span>
                </a>
                <ul id="reports"
                    class="sidebar-dropdown list-unstyled collapse {{ set_show('laporanstok') }} {{ set_show('laporantransaksi') }}"
                    data-bs-parent="#sidebar">
                    <li class="menu-laporanstok d-none sidebar-item {{ set_active('laporanstok') }}"><a class="sidebar-link"
                            href="laporanstok">Laporan Stok</a></li>
                    
                    <li class="menu-laporantransaksi d-none sidebar-item {{ set_active('laporantransaksi') }}"><a class="sidebar-link"
                            href="laporantransaksi">Laporan Transaksi</a></li>
                </ul>
            </li>

        </ul>

        {{-- <div class="sidebar-cta">
            <div class="sidebar-cta-content">
                <strong class="d-inline-block mb-2">Upgrade to Pro</strong>
                <div class="mb-3 text-sm">
                    Are you looking for more components? Check out our premium version.
                </div>
                <div class="d-grid">
                    <a href="upgrade-to-pro.html" class="btn btn-primary">Upgrade to Pro</a>
                </div>
            </div>
        </div> --}}
    </div>
</nav>
