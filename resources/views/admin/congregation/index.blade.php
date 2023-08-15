@extends('admin.layout.default')

@section('title', trans('admin.congregation.actions.index'))

@section('body')

    <congregation-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/congregations') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.congregation.actions.index') }}
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/congregations/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.congregation.actions.create') }}</a>
                        <span class="pull-right">&nbsp;</span>
                        <a class="btn btn-primary btn-sm pull-right" :href="`{{ url('admin/congregations/export-excel') }}`" role="button"><i class="fa fa-file-excel-o"></i>&nbsp; {{ trans('admin.congregation.actions.export-excel') }}</a>
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
                                        <th :column="'no'">{{ trans('admin.congregation.columns.no') }}</th>
                                        <th is='sortable' :column="'nama_lengkap'">{{ trans('admin.congregation.columns.nama_lengkap') }}</th>
                                        <th is='sortable' :column="'jenis_kelamin'">{{ trans('admin.congregation.columns.jenis_kelamin') }}</th>
                                        <th is='sortable' :column="'angkatan'">{{ trans('admin.congregation.columns.angkatan') }}</th>
                                        <th is='sortable' :column="'tgl_lahir'">{{ trans('admin.congregation.columns.tgl_lahir') }}</th>
                                        <th is='sortable' :column="'alamat'">{{ trans('admin.congregation.columns.alamat') }}</th>
                                        <th is='sortable' :column="'no_wa'">{{ trans('admin.congregation.columns.no_wa') }}</th>
                                        <th is='sortable' :column="'hobi'">{{ trans('admin.congregation.columns.hobi') }}</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                        <td>@{{ pagination.state.from + index }}</td>
                                        <td>@{{ item.nama_lengkap }}</td>
                                        <td>@{{ item.jenis_kelamin == 'laki_laki' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        <td>@{{ item.angkatan }}</td>
                                        <td>@{{ item.tgl_lahir | date('DD MMM YYYY') }}</td>
                                        <td>@{{ item.alamat }}</td>
                                        <td>@{{ item.no_wa }}</td>
                                        <td>@{{ item.hobi }}</td>
                                        
                                        <td>
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-info" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                </div>
                                                <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                </form>
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
                                <a class="btn btn-primary btn-spinner" href="{{ url('admin/congregations/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.congregation.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </congregation-listing>

@endsection