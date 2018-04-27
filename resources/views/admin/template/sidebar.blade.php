<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <div class="user-profile">
            <div class="dropdown user-pro-body">
                <div><img src="{{ asset($currentUserData['avatar']) }}" alt="user-img"
                          class="img-circle"></div>
                <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button"
                   aria-haspopup="true" aria-expanded="false">{{ $currentUserData['name'] }} <span class="caret"></span></a>
                <ul class="dropdown-menu animated flipInY">
                    <li><a href="{{ route('admin_profile') }}"><i class="ti-user"></i> Мой профиль</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit()"><i class="fa fa-power-off"></i> Выход</a></li>
                </ul>
            </div>
        </div>
        <ul class="nav" id="side-menu">
            <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                <!-- Search input-group this is only view in mobile -->
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Поиск...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
                        </span>
                </div>
                <!-- /Search input-group this is only view in mobile -->
            </li>


            @foreach( $sidebar_items as $sidebar_item )

                @if( $sidebar_item['type'] == 'parent' )

                    <li>

                        <a href="javascript:void(0)" class="waves-effect active" onclick="{{ !empty($sub_item['js']) ? $sub_item['js'] : '' }}">
                            <i class="{{ $sidebar_item['icon'] }}"> </i>
                            <span class="hide-menu">
                            {{ $sidebar_item['title'] }}
                                <span class="fa arrow"></span>
                            </span>
                        </a>

                        <ul class="nav nav-second-level">
                            @foreach( $sidebar_item['children'] as $sub_item )
                                <li>
                                    <a href="{{ $sub_item['url'] }}" onclick="{{ !empty($sub_item['js']) ? $sub_item['js'] : '' }}">
                                        {{ $sub_item['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                    </li>

                @else

                    <li>
                        <a href="{{ $sidebar_item['url'] }}"
                           class="waves-effect"
                           onclick="{{ !empty($sidebar_item['js']) ? $sidebar_item['js'] : '' }}">
                            <i class="fa fa-sign-out"></i> <span class="hide-menu">{{ $sidebar_item['title'] }} </span>
                        </a>
                    </li>

                @endif

            @endforeach


        </ul>
    </div>
</div>