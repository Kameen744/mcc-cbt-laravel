<div id="wrapper"> 
    {{-- side navbar --}}
        @include('layouts.side-nav')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
        <div id="content">
            {{-- top nav bar --}}
            @include('layouts.top-nav')
            <!-- Begin Page Content -->
            <div class="container-fluid m-0 p-1">
                @yield('main-page-content')
            </div>
            <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; MCCHST 2019</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
    <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
</div>