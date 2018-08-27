<section class="page_breadcrumbs ds parallax section_padding_top_40 section_padding_bottom_40">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h2>@yield('title')</h2>
                <ol class="breadcrumb greylinks color1">
                    <li><a href="/">Home</a></li>
                    <li><i class="fa fa-chevron-circle-right"></i></li>
                    @for($i = 1; $i <= count(Request::segments()); $i++)
                        @if($i == count(Request::segments()))
                            @if(Request::segment($i) == 'shop' && isset($_GET['cat']))
                                <li><a href="/{{Request::segment($i)}}">{{Request::segment($i)}}</a></li>
                            @endif
                            <li class="active">@yield('title')</li>
                        @elseif(Request::segment($i-1) == 'shop')
                            <li><a href="/shop/{{Request::segment($i)}}">{{Request::segment($i)}}</a></li>
                            <li><i class="fa fa-chevron-circle-right"></i></li>
                        @elseif(Request::segment($i) == 'password')
                        @else
                            <li><a href="/{{Request::segment($i)}}">{{Request::segment($i)}}</a></li>
                            <li><i class="fa fa-chevron-circle-right"></i></li>
                        @endif
                    @endfor
                </ol>
            </div>
        </div>
    </div>
</section>