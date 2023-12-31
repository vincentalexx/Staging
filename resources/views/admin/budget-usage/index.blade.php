@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.budget-usage.actions.index'))

@section('body')
    <budget-usage-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/budget-usages', $divisi) }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.budget-usage.actions.index') }}
                        @can('admin.budget-usage.create')
                            <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/budget-usages/create', $divisi) }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.budget-usage.actions.create') }}</a>
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
                                        <th>{{ trans('admin.budget-usage.columns.no') }}</th>
                                        <th is='sortable' :column="'tanggal'">{{ trans('admin.budget-usage.columns.tanggal') }}</th>
                                        <th is='sortable' :column="'jenis_budget'">{{ trans('admin.budget-usage.columns.jenis_budget') }}</th>
                                        <th is='sortable' :column="'deskripsi'">{{ trans('admin.budget-usage.columns.deskripsi') }}</th>
                                        <th is='sortable' :column="'jumlah_orang'">{{ trans('admin.budget-usage.columns.jumlah_orang') }}</th>
                                        <th is='sortable' :column="'total'">{{ trans('admin.budget-usage.columns.total') }}</th>
                                        <th is='sortable' :column="'reimburs'">{{ trans('admin.budget-usage.columns.reimburs') }}</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                        <td>@{{ pagination.state.from + index }}</td>
                                        <td>@{{ item.tanggal | date }}</td>
                                        <td>@{{ item.jenis_budget }}</td>
                                        <td>@{{ item.deskripsi }}</td>
                                        <td>@{{ item.jumlah_orang }}</td>
                                        <td>@{{ item.total }}</td>
                                        <td>@{{ item.reimburs }}</td>
                                        
                                        <td>
                                            <div class="row no-gutters">
                                                @can('admin.budget-usage.edit')
                                                    <div class="col-auto">
                                                        <a class="btn btn-sm btn-spinner btn-info" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                    </div>
                                                @endcan
                                                @can('admin.budget-usage.delete')
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
                                @can('admin.budget-usage.create')
                                    <a class="btn btn-primary btn-spinner" href="{{ url('admin/budget-usages/create', $divisi) }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.budget-usage.actions.create') }}</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </budget-usage-listing>

@endsection