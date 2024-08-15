<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            @php
            $menus = \App\Helpers\Main::getMenus();
            @endphp
            @foreach($menus as $parent)
            @can('Show '.$parent->name)
            <li><a class="{{ (count($parent->children) > 0) ? 'has-arrow' : '' }}" href="{{ $parent->url }}">
                    {!!$parent->icon!!}
                    <span class="nav-text">{{ $parent->name }}</span>
                </a>
                @if($parent->children)
                <ul>
                    @foreach($parent->children as $child)
                    @if(count($child->children) > 0)
                    @can('Show '.$child->name)
                    <li>
                        <a class="{{ (count($child->children) > 0) ? 'has-arrow' : '' }}" href="{{ $child->url }}">{{
                            $child->name }}</a>
                        <ul>
                            @foreach($child->children as $children)
                            @can('Show '.$children->name)
                            <li><a href="{{ $children->url }}">{{ $children->name }}</a></li>
                            @endcan
                            @endforeach
                        </ul>
                    </li>
                    @endcan
                    @else
                    @can('Show '.$child->name)
                    <li><a href="{{ $child->url }}">{{ $child->name }}</a></li>
                    @endcan
                    @endif
                    @endforeach
                </ul>
                @endif
            </li>
            @endcan
            @endforeach
        </ul>

    </div>
</div>