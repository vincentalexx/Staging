<div class="form-group row align-items-center" :class="{'has-danger': errors.has('tanggal'), 'has-success': fields.tanggal && fields.tanggal.valid }">
    <label for="tanggal" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.congregation-attendance.columns.tanggal') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        {{ $tanggal }}
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('congregation'), 'has-success': this.fields.congregation && this.fields.congregation.valid }">
    <label for="congregation" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">
        {{ trans('admin.congregation-attendance.columns.congregation') }}
    </label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        {{ $congregation->nama_lengkap }}
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('jam_datang'), 'has-success': fields.jam_datang && fields.jam_datang.valid }">
    <label for="jam_datang" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.congregation-attendance.columns.jam_datang') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.jam_datang" :config="timePickerConfig" v-validate="" class="flatpickr" :class="{'form-control-danger': errors.has('jam_datang'), 'form-control-success': fields.jam_datang && fields.jam_datang.valid}" id="jam_datang" name="jam_datang" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_time') }}"></datetime>
        </div>
        <div v-if="errors.has('jam_datang')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('jam_datang') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('tempat_kebaktian'), 'has-success': this.fields.tempat_kebaktian && this.fields.tempat_kebaktian.valid }">
    <label for="tempat_kebaktian" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">
        {{ trans('admin.congregation-attendance.columns.tempat_kebaktian') }}
    </label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect name="tempat_kebaktian" v-model="form.tempat_kebaktian" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_options') }}" :options="tempatKebaktianList" :multiple="false" open-direction="bottom" v-validate="" :class="{'form-control-danger': errors.has('tempat_kebaktian'), 'form-control-success': this.fields.tempat_kebaktian && this.fields.tempat_kebaktian.valid}"></multiselect>
        <div v-if="errors.has('tempat_kebaktian')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('tempat_kebaktian') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('keterangan'), 'has-success': this.fields.keterangan && this.fields.keterangan.valid }">
    <label for="keterangan" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">
        {{ trans('admin.congregation-attendance.columns.keterangan') }}
    </label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect name="keterangan" v-model="form.keterangan" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_options') }}" :options="keteranganList" :multiple="false" open-direction="bottom" v-validate="" :class="{'form-control-danger': errors.has('keterangan'), 'form-control-success': this.fields.keterangan && this.fields.keterangan.valid}"></multiselect>
        <div v-if="errors.has('keterangan')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('keterangans') }}</div>
    </div>
</div>
