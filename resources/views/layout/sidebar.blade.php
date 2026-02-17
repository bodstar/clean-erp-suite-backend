<div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
	<div class="main-menu-content">

		<ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
			<li style="margin-top: 20px" class="nav-item @yield('dashboard_active')">
                <a  href="{{ route('home')}}"><i class="ft-monitor"></i><span data-i18n="" class="menu-title">@lang('sidebar.dashboard')</span></a>
            </li>

            {{--<li class="nav-item {{ isRouteActive('household.member.details', false, 'active open') }}{{ isRouteActive('household.details', false, 'active open') }} {{ isRouteActive('household.list', false, 'active open') }}"><a href="{{ route('household.list')}}"><i class="ft-list"></i><span data-i18n="" class="menu-title">Manage Household</span></a></li>--}}
            @if(Auth::user()->isAbleTo('access_household_mgt'))
            <li class="nav-item"><a href="#"><i class="{{--fa fa-cubes--}} {{--fa fa-briefcase--}} ft-box"></i><span class="menu-title" data-i18n="" data-toggle="tooltip" data-placement="right" title="{{__('Module 1: Registration')}}">{{__('Module 1: Registration')}}</span></a>
                <ul class="menu-content">
                @if(Auth::user()->isAbleTo('manage_active_households'))
                    <li class="menu-item {{--has-sub--}} @yield('household_mgt_active')"><a href="#" data-toggle="tooltip" data-placement="right" title="{{__('sidebar.household_mgt')}}"><i class="icon-home"></i>{{--<span data-i18n="" class="menu-title">--}}@lang('sidebar.household_mgt'){{--</span>--}}</a>
                        <ul class="menu-content">
                            @if(Auth::user()->isAbleTo('manage_active_households'))
                                <li class="menu-item @yield('all_households_list_active')"><a href="{{ route('household.list') }}"><i class="ft-list"></i>{{--<span data-i18n="" class="menu-title">--}}@lang('sidebar.household_mgt_options.all_households'){{--</span>--}}</a></li>
                            @endif
                            @if(Auth::user()->isAbleTo('manage_non_consent_households'))
                                <li class="menu-item @yield('non_consent_households_list_active')"><a href="{{ route('household.non_consent_household_list') }}" data-toggle="tooltip" data-placement="right" title="{{__('sidebar.household_mgt_options.non_consent_households')}}"><i class="ft-list"></i>{{--<span data-i18n="" class="menu-title">--}}@lang('sidebar.household_mgt_options.non_consent_households'){{--</span>--}}</a></li>
                            @endif
                            @if(Auth::user()->isAbleTo('household_upload_data'))
                            <li class="menu-item @yield('household_upload_active')"><a href="{{ route('household.upload.data') }}" data-toggle="tooltip" data-placement="right" title="{{__('sidebar.household_mgt_options.upload')}}"><i class="ft-upload"></i>{{--<span data-i18n="" class="menu-title">--}}@lang('sidebar.household_mgt_options.upload'){{--</span>--}}</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Auth::user()->isAbleTo('access_targeting'))
                    <li class="menu-item {{--has-sub--}} @yield('household_targeting_active')"><a href="#"><i class="{{--fa fa-bullseye--}} icon-target"></i>{{--<span data-i18n="" class="menu-title">--}}@lang('sidebar.household_mgt_options.targetting'){{--</span>--}}</a>
                        <ul class="menu-content" style="">
                            @if(Auth::user()->isAbleTo('manage_forms'))
                            <li class="menu-item @yield('cbt_forms_active')"><a href="{{ route('cbt-forms') }}"><i class="fa fa-file"></i>{{--<span data-i18n="" class="menu-title">--}}@lang('sidebar.form_mgt_options.cbt_forms'){{--</span>--}}</a></li>
                            @endif
                            @if(Auth::user()->isAbleTo('access_cbt_evidence'))
                                <li class="menu-item @yield('cbt_evidence_active')"><a href="{{ route('cbt_evidence.index') }}"><i class="ft-list"></i>{{--<span data-i18n="" class="menu-title">--}}@lang('sidebar.household_mgt_options.CBT_evidence'){{--</span>--}}</a></li>
                            @endif
                            @if(Auth::user()->isAbleTo('access_cbt_assessed_households'))
                                <li class="menu-item @yield('cbt_assessed_households_list_active')"><a href="{{ route('household.cbt') }}"><i class="ft-list"></i>{{--<span data-i18n="" class="menu-title">--}}@lang('sidebar.household_mgt_options.CBT_households'){{--</span>--}}</a></li>
                            @endif
                            @if(Auth::user()->isAbleTo('access_pmt_assessed_households'))
                                <li class="menu-item @yield('pmt_active')"><a href="{{ route('household.pmt') }}"><i class="ft-list"></i>{{--<span data-i18n="" class="menu-title">--}}@lang('sidebar.household_mgt_options.PMT_households'){{--</span>--}}</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                </ul>
            </li>
            @endif
            @if(Auth::user()->isAbleTo('access_program_management_module'))
            <li class="nav-item"><a href="#" data-toggle="tooltip" data-placement="right" title="{{__('Module 2: Program Mgt.')}}"><i class="{{--fa fa-cubes--}} {{--fa fa-briefcase--}} ft-box"></i><span data-i18n="" class="menu-title">{{__('Module 2: Program Mgt.')}}</span></a>
                <ul class="menu-content" style="">
                    <li class="@yield('all_programs_active')"><a href="{{ route('program.list') }}" class="menu-item" data-toggle="tooltip" data-placement="right" title="{{__('sidebar.program_mgt')}}"><i class="fa fa-money"></i>{{--<span data-i18n="" class="menu-title">--}}@lang('sidebar.program_mgt'){{--</span>--}}</a></li>
{{--                    <li class="@yield('active')"><a href="#" class="menu-item"><i class="ft-list"></i><span data-i18n="" class="menu-title">@lang('sidebar.user_program_roles')</span></a></li>--}}
                </ul>
            </li>
            @endif
            @if(Auth::user()->isAbleTo('manage_cases'))
                {{--@if(in_array('manage_cases',$admin_permissions))--}}
                <li class="nav-item"><a href="javascript:;" data-toggle="tooltip" data-placement="right" title="{{__('Module 3: Case Mgt.(Complaints & Grievances)')}}"><i class="{{--fa fa-cubes--}} {{--fa fa-briefcase--}} ft-box"></i><span data-i18n="" class="menu-title">{{__('Module 3: Case Mgt.(Complaints & Grievances)')}}</span></a>
                    <ul class="menu-content" style="">
                        <li class="menu-item {{ isRouteActive('case', true, 'open') }}"><a href=""><i class="ft-briefcase"></i>{{--<span data-i18n="" class="menu-title">--}}@lang('sidebar.case_mgt'){{--</span>--}}</a>
                            <ul class="menu-content" style="">
                                <li class="{{ isRouteActive('case.agent.category', false, 'active') }} {{ isRouteActive('case.agent.assign', false, 'active') }}"><a href="{{ route('case.agent.category') }}" class="menu-item"><i class="fa fa-users"></i>{{--<span data-i18n="" class="menu-title">--}}@lang('sidebar.case_mgt_options.agents'){{--</span>--}}</a></li>
                                <li class="{{ isRouteActive('manage.categories', false, 'active') }}"><a href="{{ route('manage.categories') }}" class="menu-item"><i class="fa fa-sitemap"></i>{{--<span data-i18n="" class="menu-title">--}}@lang('sidebar.case_mgt_options.categories'){{--</span>--}}</a></li>
                                
                                @if(Auth::user()->role->name != "case-agent")
                                    <li class="{{ isRouteActive('case.active', false, 'active') }}"><a href="{{ route('case.active') }}" class="menu-item"><i class="fa fa-list"></i>{{--<span data-i18n="" class="menu-title">--}}@lang('sidebar.case_mgt_options.history'){{--</span>--}}</a></li>
                                @endif

                                <li class="{{ isRouteActive('case.assigned', false, 'active') }}"><a href="{{ route('case.assigned') }}" class="menu-item"><i class="fa fa-list"></i>{{--<span data-i18n="" class="menu-title">--}}@lang('sidebar.case_mgt_options.assigned'){{--</span>--}}</a></li>
                                <li class="{{ isRouteActive('case.solved', false, 'active') }}"><a href="{{ route('case.solved') }}" class="menu-item"><i class="fa fa-check"></i>{{--<span data-i18n="" class="menu-title">--}}@lang('sidebar.case_mgt_options.solved'){{--</span>--}}</a></li>
                                <li class="{{ isRouteActive('case.closed', false, 'active') }}"><a href="{{ route('case.closed') }}" class="menu-item"><i class="fa fa-close"></i>{{--<span data-i18n="" class="menu-title">--}}@lang('sidebar.case_mgt_options.closed'){{--</span>--}}</a></li>
                                <li class="{{ isRouteActive('case.archive', false, 'active') }}"><a href="{{ route('case.archive') }}" class="menu-item"><i class="fa fa-archive"></i>{{--<span data-i18n="" class="menu-title">--}}@lang('sidebar.case_mgt_options.archive'){{--</span>--}}</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            @endif
            @if(Auth::user()->isAbleTo('manage_forms'))
            {{--<li class="nav-item has-sub @yield('form_mgt_active')"><a href="javascript:;"><i class="ft-file-text"></i><span data-i18n="" class="menu-title">@lang('sidebar.form_mgt')</span></a>
                <ul class="menu-content" style="">
                    <li class="@yield('all_forms_active')"><a href="{{ route('forms') }}" class="menu-item"><i class="fa fa-file"></i><span data-i18n="" class="menu-title">@lang('sidebar.form_mgt_options.all_forms')</span></a></li>
                </ul>
            </li>--}}
            @endif

            @if(Auth::user()->isAbleTo('manage_enumerator'))
                <li class="nav-item @yield('enumerator_mgt_active')">
                    <a href="{{ route('enumerator.list') }}"><i class="fa fa-podcast"></i><span data-i18n="" class="menu-title" data-toggle="tooltip" data-placement="right" title="{{__('sidebar.enumerator_mgt')}}">@lang('sidebar.enumerator_mgt')</span></a>
                </li>
            @endif

            {{--<li class="nav-item {{ isRouteActive('civil.registry', false, 'active open') }}"><a href="{{ route('civil.registry')}}"><i class="ft-search"></i><span data-i18n="" class="menu-title">Civil Registry</span></a></li>--}}
            @if(Auth::user()->isAbleTo('manage_users'))
            <li class="nav-item has-sub {{ isRouteActive('manage.users', true, 'open') }} @yield('user_mgt_active')" style=""><a href="javascript:;"><i class="fa fa-user-o"></i><span data-i18n="" class="menu-title">@lang('sidebar.user_mgt')</span></a>
                <ul class="menu-content" style="">
                    <li class="{{ isRouteActive('manage.users', false, 'active') }} @yield('users_active')"><a href="{{ route('manage.users') }}" class="menu-item"><i class="fa fa-user"></i><span data-i18n="" class="menu-title">@lang('sidebar.user_mgt_options.users')</span></a></li>
                    <li class="{{ isRouteActive('manage.roles.index', false, 'active') }} @yield('roles_active')"><a href="{{ route('manage.roles.index') }}" class="menu-item"><i class="fa fa-lock"></i><span data-i18n="" class="menu-title" data-toggle="tooltip" data-placement="right" title="{{__('sidebar.user_mgt_options.roles_and_permission')}}">@lang('sidebar.user_mgt_options.roles_and_permission')</span></a></li>
                </ul>
            </li>
            @endif
            @if(Auth::user()->isAbleTo('generate_report'))
            <li class="nav-item has-sub"><a href="javascript:;"><i class="ft-pie-chart"></i><span data-i18n="" class="menu-title">@lang('sidebar.report_generator')</span></a>
                <ul class="menu-content" style="">
                    <li class="@yield('household_report_active')"><a href="{{ route('generate.household.report')}}" class="menu-item" data-toggle="tooltip" data-placement="right" title="{{__('sidebar.report_generator_options.household_report')}}"><i class="fa fa-file"></i><span data-i18n="" class="menu-title">@lang('sidebar.report_generator_options.household_report')</span></a></li>
                    {{--<li class=""><a href="{{ route('generate.householdmember.report')}}" class="menu-item"><i class="fa fa-files-o"></i><span data-i18n="" class="menu-title">@lang('sidebar.report_generator_options.member_report')</span></a></li>--}}
                    <li class="@yield('saved_reports_active')"><a href="{{ route('generate.allsaved.report')}}" class="menu-item"><i class="fa fa-save"></i><span data-i18n="" class="menu-title">@lang('sidebar.report_generator_options.saved_report')</span></a></li>
                </ul>
            </li>
            @endif

            @if(Auth::user()->isAbleTo('settings'))
            <li class="nav-item has-sub"><a href="#"><i class="fa fa-gear"></i><span data-i18n="" class="menu-title">@lang('sidebar.settings')</span></a>
                <ul class="menu-content" style="">
                    <li class="@yield('lookup_options_active')"><a href="{{ route('settings.lookup_options')}}" class="menu-item"><i class="fa fa-list-ol"></i><span data-i18n="" class="menu-title">@lang('sidebar.manage_lookup_option')</span></a>
                    </li>
                </ul>

                <ul class="menu-content" style="">
                    <li class="@yield('options_active')"><a href="{{ route('settings.options')}}" class="menu-item"><i class="fa fa-list-ol"></i><span data-i18n="" class="menu-title">@lang('sidebar.manage_option')</span></a>
                    </li>
                </ul>

                <ul class="menu-content" style="">
                    <li class="@yield('pmt_settings_active')"><a href="{{ route('settings.pmt')}}" class="menu-item"><i class="fa fa-list-ol"></i><span data-i18n="" class="menu-title">{{__('PMT')}}</span></a>
                    </li>
                </ul>

                <ul class="menu-content" style="">
                    <li class="nav-item has-sub"><a href="javascript:;"><i class="fa fa-medkit"></i><span data-i18n="" class="{{--menu-title--}}">@lang('sidebar.health_details')</span></a>
                        <ul class="menu-content" style="">
                            <li class="@yield('health_zone_active')"><a href="{{ route('health_zone.index')}}" class="menu-item"><i class="ft-list"></i><span data-i18n="" class="{{--menu-title--}}">@lang('household_details.geography.health_zone')</span></a></li>

                            <li class="@yield('health_area_active')"><a href="{{ route('health_area.index')}}" class="menu-item"><i class="ft-list"></i><span data-i18n="" class="{{--menu-title--}}">@lang('household_details.geography.health_area')</span></a></li>

                        </ul>
                    </li>

                    <li class="@yield('executing_organisations_active')"><a href="{{ route('executing_organisations.index')}}" class="menu-item"><i class="fa fa-briefcase"></i><span data-i18n="" class="{{--menu-title--}}" data-toggle="tooltip" data-placement="right" title="{{__('Executing Organisations')}}">{{__('Executing Organisations')}}</span></a>
                    </li>

                    <li class="@yield('fsps_active')"><a href="{{ route('fsps.index')}}" class="menu-item"><i class="fa fa-usd"></i><span data-i18n="" class="{{--menu-title--}}">{{__('FSPs')}}</span></a>
                    </li>

                    <li class="@yield('provinces_active')"><a href="{{ route('provinces.index')}}" class="menu-item"><i class="fa fa-map-o"></i><span data-i18n="" class="{{--menu-title--}}">@lang('household_details.geography.provinces')</span></a>
                    </li>

                    <li class="@yield('territories_active')"><a href="{{ route('territories.index')}}" class="menu-item"><i class="fa fa-map-o"></i><span data-i18n="" class="{{--menu-title--}}">@lang('household_details.geography.territories')</span></a>
                    </li>

                    <li class="@yield('communities_active')"><a href="{{ route('communities.index')}}" class="menu-item"><i class="fa fa-map-o"></i><span data-i18n="" class="{{--menu-title--}}">@lang('household_details.geography.communities')</span></a>
                    </li>

                    <li class="@yield('groupments_active')"><a href="{{ route('groupments.index')}}" class="menu-item"><i class="fa fa-map-o"></i><span data-i18n="" class="{{--menu-title--}}">@lang('household_details.geography.groupements')</span></a>
                    </li>
                </ul>
            </li>


            @endif

            {{--@permission('manage_audit_logs')--}}
			{{--<li class="nav-item {{ isRouteActive('admin.logs', true, 'active open') }}"><a href="{{ route('admin.logs.index')}}"><i class="ft-activity"></i><span data-i18n="" class="menu-title">Audit Log Report</span></a></li>--}}
			{{--@endpermission--}}

		</ul>
	</div>
</div>