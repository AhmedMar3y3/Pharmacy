<!DOCTYPE html>
<html lang="ar">
    @include('partials.head')
    <body>
        <div class="container-scroller">
           
            <div class="container-fluid page-body-wrapper">
                @include('partials.navbar')
                <div class="main-panel" >
                    <div class="content-wrapper" style="background-color: #F6D2D4">
                        <main id="main" class="main" >
                            @yield('main')
                        </main>
                    </div>
                    @include('partials.footer')
                </div>
            </div>
            @include('partials.sidebar')
        </div>
        @include('partials.scripts')
    </body>
</html>