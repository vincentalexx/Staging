<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">Jemaat</li>
            @can('admin.congregation.index')
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/congregations') }}"><i class="nav-icon icon-globe"></i> {{ trans('admin.congregation.title') }}</a></li>
            @endcan
            @can('admin.congregation-attendance.index')
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/congregation-attendances') }}"><i class="nav-icon icon-note"></i> {{ trans('admin.congregation-attendance.title') }}</a></li>
            @endcan
                
            <li class="nav-title">Budgeting</li>
            @can('admin.budget.index')
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/budgets') }}"><i class="nav-icon icon-bag"></i> {{ trans('admin.budget.title') }}</a></li>
            @endcan
            @can('admin.budget-usage.index-smp')
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/budget-usages/SMP') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.budget-usage.title-smp') }}</a></li>
            @endcan
            @can('admin.budget-usage.index-sma')
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/budget-usages/SMA') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.budget-usage.title-sma') }}</a></li>
            @endcan
            @can('admin.budget-usage.index-pemuda')
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/budget-usages/Pemuda') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.budget-usage.title-pemuda') }}</a></li>
            @endcan

            <li class="nav-title">Pembinaan</li>
            @can('admin.discipleship.index')
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/discipleships') }}"><i class="nav-icon icon-clock"></i> {{ trans('admin.discipleship.title') }}</a></li>
            @endcan
            @can('admin.discipleship-detail.index-smp')
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/discipleship-details/SMP') }}"><i class="nav-icon icon-drop"></i> {{ trans('admin.discipleship-detail.title-smp') }}</a></li>
            @endcan
            @can('admin.discipleship-detail.index-sma')
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/discipleship-details/SMA') }}"><i class="nav-icon icon-drop"></i> {{ trans('admin.discipleship-detail.title-sma') }}</a></li>
            @endcan
            @can('admin.discipleship-detail.index-pemuda')
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/discipleship-details/Pemuda') }}"><i class="nav-icon icon-drop"></i> {{ trans('admin.discipleship-detail.title-pemuda') }}</a></li>
            @endcan
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            @can('admin.user.index')
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/users') }}"><i class="nav-icon icon-user"></i> {{ __('User') }}</a></li>
            @endcan
            @can('admin.role.index')
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/roles') }}"><i class="nav-icon icon-eye"></i> {{ __('Role') }}</a></li>
            @endcan
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
