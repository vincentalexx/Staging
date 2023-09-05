@extends('admin.layout.default')

@section('title', trans('admin.discipleship-detail.actions.index'))

@section('body')
<discipleship-detail-listing :data="{{ $data['data']['data']->toJson() }}" :temp-attendance="{{ json_encode($data['data']['attendance']) }}" :url="'{{ url('admin/discipleship-details', $data['data']['divisi']) }}'" :divisi-data="{{ json_encode($data['data']['divisi']) }}" inline-template>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Absensi Jemaat
                    <!-- <a class="btn btn-primary btn-sm pull-right m-b-0 color-white" href="{{ url('admin/work-days/sync-fingerprint') }}" role="button" style="min-width: max-content"><i class="fa fa-500px"></i>&nbsp; {{ trans('admin.work-day.actions.sync-fingerprint') }}</a> -->
                    <!-- <button class="btn btn-primary btn-sm pull-right m-b-0 color-white" @click="importExcelPopup()" style="min-width: max-content"><i class="fa fa-file-excel-o"></i>&nbsp; {{ trans('admin.discipleship-detail.actions.export-attendance') }}</button> -->
                    @can('admin.discipleship-detail.create')
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0 color-white" href="{{ url('admin/discipleship-details/create', $data['data']['divisi']) }}" role="button"><i class="fa fa-edit"></i>&nbsp; {{ trans('admin.discipleship-detail.actions.create') }}</a>
                    @endcan
                    <span class="pull-right">&nbsp;</span>
                    @can('admin.discipleship-detail.export-excel')
                        <a class="btn btn-primary btn-sm pull-right" :href="'/admin/discipleship-details/export-excel/' + year + '/' + month + '/' + divisiData" role="button"><i class="fa fa-file-excel-o"></i>&nbsp; {{ trans('admin.discipleship-detail.actions.export-excel') }}</a>
                    @endcan
                </div>
                <div class="card-body" v-cloak style="overflow-y: auto">
                    <form @submit.prevent="">
                        <div class="row justify-content-md-between">
                            <div class="col col-lg-8 col-xl-7 form-group">
                                <div class="row">
                                    <div class="btn-group mr-2" role="group" aria-label="Second group" style="margin-left: 15px;">
                                        <button type="button" class="btn btn-primary color-white" @click="prevMonth()">
                                            <i class="fa fa-angle-left"></i> Prev
                                        </button>
                                        <button type="button" class="btn btn-primary color-white" @click="nextMonth()">
                                            Next <i class="fa fa-angle-right"></i>
                                        </button>
                                    </div>
                                    <div class="btn-group" role="group" aria-label="Third group">
                                        <button type="button" class="btn btn-primary color-white" @click="currentMonth()">Bulan Sekarang</button>
                                    </div>
                                    <!-- <div class="col-md-3">
                                        <select name="work_day_type" v-model="work_day_type" class="form-control">
                                            <option value="Period">Period</option>
                                            <option value="Bulan">Bulan</option>
                                        </select>
                                    </div> -->
                                    <div class="col-md-4">
                                        <h3 class="pull-left" v-if="work_day_type == 'Period'">@{{ period_name }}</h3>
                                        <h3 class="pull-left" v-else>@{{ nameOfMonth }} @{{ year }}</h3>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-sm-auto form-group ">
                                <select class="form-control" v-model="pagination.state.per_page">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="100">100</option>
                                </select>
                            </div> -->
                        </div>
                        <div class="row justify-content-md-between">
                            <div class="col col-md-4 form-group">
                                <div class="input-group">
                                    <input class="form-control" placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-primary" @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('brackets/admin-ui::admin.btn.search') }}</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col col-md-4 form-group">
                                <select class="form-control" v-model="selectedDiscipleshipId">
                                    <option v-for="discipleship in discipleshipList" :value="discipleship.id">@{{ discipleship.nama_pembinaan }}</option>
                                </select>
                            </div>
                        </div>
                    </form>

                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Judul</th>
                                <th v-for="(judul, j) in judulPembinaan">
                                    @{{ judul.judul }}

                                    @can('admin.discipleship-detail.delete')
                                        <form @submit.prevent="deleteItem('/admin/discipleship-details/' + judul.id)" class="pull-right">
                                            <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                        </form>
                                    @endcan
                                </th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>Kehadiran</th>
                                <th v-for="kehadiran in totalHadir">@{{ kehadiran }} orang</th>
                            </tr>
                            <tr>
                                <th style="width: 10px">{{ trans('admin.discipleship-detail.columns.no') }}</th>
                                <th is='sortable' :column="'nama_lengkap'">{{ trans('admin.discipleship-detail.columns.congregation') }}</th>
                                <th v-for="days in daysInPeriod">@{{ days | date('DD MMM YYYY') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in items" :key="item.id">
                                <td>@{{ pagination.state.from + index }}</td>
                                <td>@{{ item.nama_lengkap }}</td>
                                <template v-for="(days, d) in getCongregationAttendancePeriod[index]">
                                    <template v-if="days.length > 0">
                                        <template v-for="day in days">
                                            <td v-if="day.keterangan == 'Sakit'" style="background-color: yellow;">
                                                Sakit
                                                
                                                <template v-if="judulPembinaan[new Date(daysInPeriod[d]).getTime()/1000] != null">
                                                    @can('admin.discipleship-detail.delete-detail')
                                                        <form @submit.prevent="deleteItem('/admin/discipleship-details/delete/' + day.id + '/detail')" class="pull-right">
                                                            <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                        </form>
                                                    @endcan
                                                    <span class="pull-right">&nbsp;</span>
                                                    @can('admin.discipleship-detail.edit-detail')
                                                        <a class="btn btn-primary btn-spinner btn-sm m-b-0 color-white pull-right" :href="'/admin/discipleship-details/edit/' + item.id + '/' + day.tanggal + '/' + judulPembinaan[new Date(daysInPeriod[d]).getTime()/1000].id" role="button"><i class="fa fa-edit"></i></a>
                                                    @endcan
                                                </template>
                                            </td>
                                            <td v-else-if="day.keterangan == 'Izin'" style="background-color: orange;">
                                                Izin

                                                <template v-if="judulPembinaan[new Date(daysInPeriod[d]).getTime()/1000] != null">
                                                    @can('admin.discipleship-detail.delete-detail')
                                                        <form @submit.prevent="deleteItem('/admin/discipleship-details/delete/' + day.id + '/detail')" class="pull-right">
                                                            <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                        </form>
                                                    @endcan
                                                    <span class="pull-right">&nbsp;</span>
                                                    @can('admin.discipleship-detail.edit-detail')
                                                        <a class="btn btn-primary btn-spinner btn-sm m-b-0 color-white pull-right" :href="'/admin/discipleship-details/edit/' + item.id + '/' + day.tanggal + '/' + judulPembinaan[new Date(daysInPeriod[d]).getTime()/1000].id" role="button"><i class="fa fa-edit"></i></a>
                                                    @endcan
                                                </template>
                                            </td>
                                            <td v-else-if="day.keterangan == null" style="background-color: lightgreen;">
                                                Hadir

                                                <template v-if="judulPembinaan[new Date(daysInPeriod[d]).getTime()/1000] != null">
                                                    @can('admin.discipleship-detail.delete-detail')
                                                        <form @submit.prevent="deleteItem('/admin/discipleship-details/delete/' + day.id + '/detail')" class="pull-right">
                                                            <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                        </form>
                                                    @endcan
                                                    <span class="pull-right">&nbsp;</span>
                                                    @can('admin.discipleship-detail.edit-detail')
                                                        <a class="btn btn-primary btn-spinner btn-sm m-b-0 color-white pull-right" :href="'/admin/discipleship-details/edit/' + item.id + '/' + day.tanggal + '/' + judulPembinaan[new Date(daysInPeriod[d]).getTime()/1000].id" role="button"><i class="fa fa-edit"></i></a>
                                                    @endcan
                                                </template>
                                            </td>
                                        </template>
                                    </template>
                                    <td v-else style="background-color: pink;">
                                        -
                                        <template v-if="judulPembinaan[new Date(daysInPeriod[d]).getTime()/1000] != null">
                                            <a class="btn btn-primary btn-spinner btn-sm m-b-0 color-white pull-right" :href="'/admin/discipleship-details/edit/' + item.id + '/' + daysInPeriod[d] + '/' + judulPembinaan[new Date(daysInPeriod[d]).getTime()/1000].id" role="button"><i class="fa fa-edit"></i></a>
                                        </template>
                                    </td>
                                </template>
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

                    <div class="no-items-found" v-if="items.length === 0">
                        <i class="icon-magnifier"></i>
                        <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                        <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</discipleship-detail-listing>

@endsection