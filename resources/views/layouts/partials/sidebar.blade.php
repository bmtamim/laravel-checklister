<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <ul class="m-0 p-0 list-unstyled">
        @if(auth()->user()->is_admin == true)
            <li class="c-sidebar-nav-title">{{ __('Groups') }}</li>
            @foreach($admin_menu as $key => $group)
                <li class="c-sidebar-nav-item c-sidebar-nav-dropdown c-show">
                    <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle"
                       href="{{ route('admin.checklist_groups.edit',$group->id) }}">
                        {{ $group->name ?? __('Default') }}
                    </a>
                    <ul class="c-sidebar-nav-dropdown-items">
                        @foreach( $group->checklists()->whereNull('user_id')->get() as $key => $checklist)
                            <li class="c-sidebar-nav-item">
                                <a class="c-sidebar-nav-link"
                                   href="{{ route('admin.checklist_groups.checklists.edit',[$group,$checklist]) }}">
                                    {{ $checklist->name ?? __('Default') }}
                                </a>
                            </li>
                        @endforeach
                        <li class="c-sidebar-nav-item">
                            <a class="c-sidebar-nav-link"
                               href="{{ route('admin.checklist_groups.checklists.create',$group) }}">
                                {{ __('Add Checklist') }}
                            </a>
                        </li>
                    </ul>
                </li>
            @endforeach
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-link"
                   href="{{ route('admin.checklist_groups.create') }}">{{ __('Add Groups') }}</a>
            </li>
            <li class="c-sidebar-nav-title">{{ __('Pages') }}</li>
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown c-show">
                <ul class="c-sidebar-nav-dropdown-items">
                    @foreach(\App\Models\Page::all() as $key => $page)
                        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link"
                                                          href="{{ route('admin.pages.edit',$page) }}">{{ $page->title ?? __('Default') }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
            <li class="c-sidebar-nav-title">{{ __('Management') }}</li>
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown c-show">
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('admin.users.index') }}">
                            {{ __('Users') }}
                        </a>
                    </li>
                </ul>
            </li>
        @else
            @foreach($user_tasks_menu as $type => $user_task_menu)
                <li class="c-sidebar-nav-item c-sidebar-nav-dropdown c-show">
                    <a class="c-sidebar-nav-link"
                       href="{{ route('users.checklist.tasklist',$type) }}">
                        {{--                        <span>{{ $user_task_menu['icon'] }}</span>--}}
                        {{ $user_task_menu['name'] }}
                        @livewire('user-task-counter',[
                        'task_count' => $user_task_menu['tasks_count'],
                        'task_type' => $type,
                        ])
                    </a>
                </li>
            @endforeach

            @foreach($user_menu as $key => $group)
                <li class="c-sidebar-nav-title">{{ __('Groups') }}</li>
                <li class="c-sidebar-nav-item c-sidebar-nav-dropdown c-show">
                    <span
                        class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle">{{ $group['name'] ?? __('Default') }}
                        @if($group['is_new'])
                            <span class="badge badge-info">{{ __('NEW') }}</span>
                        @elseif($group['is_updated'])
                            <span class="badge badge-info">{{ __('UPD') }}</span>
                        @endif
                    </span>
                    <ul class="c-sidebar-nav-dropdown-items">
                        @foreach( $group['checklists'] as $key => $checklist)
                            @if($checklist['tasks_count'] > 0)
                                <li class="c-sidebar-nav-item">
                                    <a class="c-sidebar-nav-link"
                                       href="{{ route('users.checklist.show',[$checklist['id']]) }}">
                                        {{ $checklist['name'] ?? __('Default') }}
                                        @livewire('complete-task-counter',[
                                        'task_count' => $checklist['tasks_count'],
                                        'completed_task_count' => $checklist['completed_tasks_count'],
                                        'checklist_id' => $checklist['id'],
                                        ])
                                        @if($checklist['is_new'])
                                            <span class="badge badge-info">{{ __('NEW') }}</span>
                                        @elseif($checklist['is_updated'])
                                            <span class="badge badge-info">{{ __('UPD') }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endforeach
            <li class="c-sidebar-nav-label">Options</li>
            @if(auth()->user()->subscribed('primary'))
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link"
                       href="{{ route('users.billing_portal') }}">{{ __('Billing Portal') }}</a>
                </li>
            @else
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link"
                       href="{{ route('users.packages') }}">{{ __('Packages') }}</a>
                </li>
            @endif
        @endif
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
            data-class="c-sidebar-minimized"></button>
</div>
