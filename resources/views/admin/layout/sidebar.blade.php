<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">Jemaat</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/congregations') }}"><i class="nav-icon icon-globe"></i> {{ trans('admin.congregation.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/congregation-attendances') }}"><i class="nav-icon icon-note"></i> {{ trans('admin.congregation-attendance.title') }}</a></li>

            <li class="nav-title">Budgeting</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/budgets') }}"><i class="nav-icon icon-bag"></i> {{ trans('admin.budget.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/budget-usages/SMP') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.budget-usage.title-smp') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/budget-usages/SMA') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.budget-usage.title-sma') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/budget-usages/Pemuda') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.budget-usage.title-pemuda') }}</a></li>
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/users') }}"><i class="nav-icon icon-user"></i> {{ __('User') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/roles') }}"><i class="nav-icon icon-eye"></i> {{ __('Role') }}</a></li>
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
