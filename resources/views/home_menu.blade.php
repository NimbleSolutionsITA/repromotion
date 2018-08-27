<ul class="mainmenu nav sf-menu">
    @foreach($items as $menu_item)
        <li><a href="{{ $menu_item->link() }}">{{ $menu_item->title }}@if($menu_item->children->count())<b class="caret"></b>@endif</a>

                @if($menu_item->children->count())
                        <ul class="submenu">
                                @foreach($menu_item->children as $item)
                                        <li><a href="{{$item->url}}">{{$item->title}} </a></li>
                                @endforeach
                        </ul>

                @endif
        </li>
    @endforeach
</ul>