@extends('admin.layout.default')

@section('title', trans('admin.congregation-attendance.actions.index'))

@section('body')
<congregation-attendance-listing :data="{{ $data['data']['data']->toJson() }}" :temp-attendance="{{ json_encode($data['data']['attendance']) }}" :url="'{{ url('admin/congregation-attendances') }}'" inline-template>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Absensi Jemaat
                    <!-- <a class="btn btn-primary btn-sm pull-right m-b-0 color-white" href="{{ url('admin/work-days/sync-fingerprint') }}" role="button" style="min-width: max-content"><i class="fa fa-500px"></i>&nbsp; {{ trans('admin.work-day.actions.sync-fingerprint') }}</a> -->
                    <!-- <button class="btn btn-primary btn-sm pull-right m-b-0 color-white" @click="importExcelPopup()" style="min-width: max-content"><i class="fa fa-file-excel-o"></i>&nbsp; {{ trans('admin.congregation-attendance.actions.export-attendance') }}</button> -->
                    @can('admin.congregation-attendance.edit-attendance')
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0 color-white" href="{{ url('admin/congregation-attendances/edit') }}" role="button"><i class="fa fa-edit"></i>&nbsp; {{ trans('admin.congregation-attendance.actions.edit') }}</a>
                    @endcan
                    <span class="pull-right">&nbsp;</span>
                    @can('admin.congregation-attendance.export-excel')
                        <a class="btn btn-primary btn-sm pull-right" :href="'/admin/congregation-attendances/export-excel/' + year + '/' + month" role="button"><i class="fa fa-file-excel-o"></i>&nbsp; {{ trans('admin.congregation-attendance.actions.export-excel') }}</a>
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
                            <div class="col col-lg-7 col-xl-5 form-group">
                                <div class="input-group">
                                    <input class="form-control" placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-primary" @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('brackets/admin-ui::admin.btn.search') }}</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>

                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th v-for="kehadiranSMP in totalHadirSMP">SMP: @{{ kehadiranSMP }} orang</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th v-for="kehadiranSMA in totalHadirSMA">SMA: @{{ kehadiranSMA }} orang</th>
                            </tr>
                            <tr>
                                <th style="width: 10px">{{ trans('admin.congregation-attendance.columns.no') }}</th>
                                <th is='sortable' :column="'nama_lengkap'">{{ trans('admin.congregation-attendance.columns.congregation') }}</th>
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
                                                
                                                @can('admin.congregation-attendance.delete-detail')
                                                    <form @submit.prevent="deleteItem('/admin/congregation-attendances/delete/' + day.id)" class="pull-right">
                                                        <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                    </form>
                                                @endcan
                                                <span class="pull-right">&nbsp;</span>
                                                @can('admin.congregation-attendance.edit-detail')
                                                    <a class="btn btn-primary btn-spinner btn-sm m-b-0 color-white pull-right" :href="'/admin/congregation-attendances/edit/' + item.id + '/' + day.tanggal" role="button"><i class="fa fa-edit"></i></a>
                                                @endcan
                                            </td>
                                            <td v-else-if="day.keterangan == 'Izin'" style="background-color: orange;">
                                                Izin
                                                
                                                @can('admin.congregation-attendance.delete-detail')
                                                    <form @submit.prevent="deleteItem('/admin/congregation-attendances/delete/' + day.id)" class="pull-right">
                                                        <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                    </form>
                                                @endcan
                                                <span class="pull-right">&nbsp;</span>
                                                @can('admin.congregation-attendance.edit-detail')
                                                    <a class="btn btn-primary btn-spinner btn-sm m-b-0 color-white pull-right" :href="'/admin/congregation-attendances/edit/' + item.id + '/' + day.tanggal" role="button"><i class="fa fa-edit"></i></a>
                                                @endcan
                                            </td>
                                            <td v-else-if="day.keterangan == null" style="background-color: lightgreen;">
                                                <a href="#" :id="'popover-target-'+day.id" style="color: black">
                                                    <template v-if="day.tempat_kebaktian == 'SMP'">
                                                        SMP
                                                    </template>
                                                    <template v-else-if="day.tempat_kebaktian == 'SMA'">
                                                        SMA
                                                    </template>
                                                </a>
                                                <b-popover :target="'popover-target-'+day.id" triggers="hover" placement="bottom">
                                                    <b>Jam Masuk : </b> @{{ day.jam_datang }}
                                                </b-popover>

                                                @can('admin.congregation-attendance.delete-detail')
                                                    <form @submit.prevent="deleteItem('/admin/congregation-attendances/delete/' + day.id)" class="pull-right">
                                                        <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                    </form>
                                                @endcan
                                                <span class="pull-right">&nbsp;</span>
                                                @can('admin.congregation-attendance.edit-detail')
                                                    <a class="btn btn-primary btn-spinner btn-sm m-b-0 color-white pull-right" :href="'/admin/congregation-attendances/edit/' + item.id + '/' + day.tanggal" role="button"><i class="fa fa-edit"></i></a>
                                                @endcan
                                            </td>
                                        </template>
                                    </template>
                                    <td v-else style="background-color: pink;">
                                        -
                                        <a class="btn btn-primary btn-spinner btn-sm m-b-0 color-white pull-right" :href="'/admin/congregation-attendances/edit/' + item.id + '/' + daysInPeriod[d]" role="button"><i class="fa fa-edit"></i></a>
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
                        <a class="btn btn-primary btn-spinner" href="{{ url('admin/work-days/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.work-day.actions.create') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</congregation-attendance-listing>

@endsection