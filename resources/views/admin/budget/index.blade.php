@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.budget.actions.index'))

@section('body')

    <budget-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/budgets') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.budget.actions.index') }}
                        @can('admin.budget.create')
                            <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/budgets/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.budget.actions.create') }}</a>
                        @endcan
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('brackets/admin-ui::admin.btn.search') }}</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-auto form-group ">
                                        <select class="form-control" v-model="pagination.state.per_page">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>
                            </form>

                            <table class="table table-hover table-listing">
                                <thead>
                                    <tr>
                                        <th>{{ trans('admin.budget.columns.no') }}</th>
                                        <th is='sortable' :column="'divisi'">{{ trans('admin.budget.columns.divisi') }}</th>
                                        <th is='sortable' :column="'nama_periode'">{{ trans('admin.budget.columns.nama_periode') }}</th>
                                        <th is='sortable' :column="'periode'">{{ trans('admin.budget.columns.periode') }}</th>
                                        <th is='sortable' :column="'total_budget'">{{ trans('admin.budget.columns.total_budget') }}</th>
                                        <th>{{ trans('admin.budget.columns.total_reimburs') }}</th>
                                        <th>{{ trans('admin.budget.columns.sisa') }}</th>
                                        <th>{{ trans('admin.budget.columns.kelebihan') }}</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                        <td>@{{ pagination.state.from + index }}</td>
                                        <td>@{{ item.divisi }}</td>
                                        <td>@{{ item.nama_periode }}</td>
                                        <td>@{{ item.periode | date('MMMM YYYY') }}</td>
                                        <td>@{{ item.total_budget_awal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") }}</td>
                                        <td>@{{ item.total_reimburs.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") }}</td>
                                        <td>@{{ item.sisa.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") }}</td>
                                        <td>@{{ item.kelebihan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") }}</td>
                                        
                                        <td>
                                            <div class="row no-gutters">
                                                @can('admin.budget.download-bon-zip')
                                                    <div class="col-auto">
                                                        <a class="btn btn-sm btn-spinner btn-success" :href="'/admin/budgets/download-bon-zip/' + item.id" title="Download Bon" role="button"><i class="fa fa-download"></i></a>
                                                    </div>
                                                @endcan
                                                @can('admin.budget.export-excel')
                                                    <div class="col-auto">
                                                        <a class="btn btn-sm btn-spinner btn-success" :href="'/admin/budgets/export-excel/' + item.id" title="Export Excel" role="button"><i class="fa fa-file-excel-o"></i></a>
                                                    </div>
                                                @endcan
                                                @can('admin.budget.duplicate')
                                                    <form class="col" @submit.prevent="duplicateItem(item.resource_url + '/duplicate')">
                                                        <button type="submit" class="btn btn-sm  btn-info" title="Duplicate"><i class="fa fa-copy"></i></button>
                                                    </form>
                                                @endcan
                                                @can('admin.budget.edit')
                                                    <div class="col-auto">
                                                        <a class="btn btn-sm btn-spinner btn-info" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                    </div>
                                                @endcan
                                                @can('admin.budget.delete')
                                                    <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                        <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                                <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                                @can('admin.budget.create')
                                    <a class="btn btn-primary btn-spinner" href="{{ url('admin/budgets/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.budget.actions.create') }}</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </budget-listing>
@endsection