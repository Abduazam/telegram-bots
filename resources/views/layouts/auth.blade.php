<x-sections.header />
    <div id="page-container" class="main-content-boxed">
        <!-- Main Container -->
        <main id="main-container">
            <!-- Page Content -->
            <div class="bg-body-dark">
                <div class="row mx-0 justify-content-center">
                    <div class="hero-static col-sm-8 col-md-7 col-xl-5">
                        <div class="content content-full overflow-hidden">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
<x-sections.footer />
