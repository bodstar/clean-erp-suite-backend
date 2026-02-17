<div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
    <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
                <li class="nav-item has-sub {{ isRouteActive('case', true, 'open') }}" style=""><a href=""><i class="ft-briefcase"></i><span data-i18n="" class="menu-title">Case Management</span></a>
                    <ul class="menu-content" style="">
                        <li class="{{ isRouteActive('case.agent.category', false, 'active') }} {{ isRouteActive('case.agent.assign', false, 'active') }}"><a href="{{ route('case.agent.category') }}" class="menu-item"><i class="fa fa-users"></i><span data-i18n="" class="menu-title">Case Agents</span></a></li>
                        <li class="{{ isRouteActive('manage.categories', false, 'active') }}"><a href="{{ route('manage.categories') }}" class="menu-item"><i class="fa fa-sitemap"></i><span data-i18n="" class="menu-title">Case Categories</span></a></li>
                        <li class="{{ isRouteActive('case.active', false, 'active') }}"><a href="{{ route('case.active') }}" class="menu-item"><i class="fa fa-list"></i><span data-i18n="" class="menu-title">Case History</span></a></li>
                        <li class="{{ isRouteActive('case.assigned', false, 'active') }}"><a href="{{ route('case.assigned') }}" class="menu-item"><i class="fa fa-list"></i><span data-i18n="" class="menu-title">Assigned Cases</span></a></li>
                        <li class="{{ isRouteActive('case.solved', false, 'active') }}"><a href="{{ route('case.solved') }}" class="menu-item"><i class="fa fa-check"></i><span data-i18n="" class="menu-title">Solved Cases</span></a></li>
                        <li class="{{ isRouteActive('case.closed', false, 'active') }}"><a href="{{ route('case.closed') }}" class="menu-item"><i class="fa fa-close"></i><span data-i18n="" class="menu-title">Closed Cases</span></a></li>
                    </ul>
                </li>
        </ul>
    </div>
</div>