<div class="form-group row align-items-center" :class="{'has-danger': errors.has('tanggal'), 'has-success': fields.tanggal && fields.tanggal.valid }">
    <label for="tanggal" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.discipleship-detail.columns.tanggal') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.tanggal" :config="datePickerConfig" v-validate="'required'" class="flatpickr" :class="{'form-control-danger': errors.has('tanggal'), 'form-control-success': fields.tanggal && fields.tanggal.valid}" id="tanggal" name="tanggal" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('tanggal')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('tanggal') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('discipleship'), 'has-success': this.fields.discipleship && this.fields.discipleship.valid }">
    <label for="discipleship" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">
        {{ trans('admin.discipleship-detail.columns.discipleship') }}
    </label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect label="nama_pembinaan" name="discipleship" v-model="form.discipleship" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_options') }}" :options="{{ $discipleships }}" :multiple="false" open-direction="bottom" v-validate="" :class="{'form-control-danger': errors.has('discipleship'), 'form-control-success': this.fields.discipleship && this.fields.discipleship.valid}"></multiselect>
        <div v-if="errors.has('discipleship')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('discipleship') }}</div>
    </div>
</div>

<template v-if="!form.isTanggalSudahTerisi">
    <div class="form-group row align-items-center" :class="{'has-danger': errors.has('judul'), 'has-success': fields.judul && fields.judul.valid }">
        <label for="judul" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.discipleship-detail.columns.judul') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <input type="text" v-model="form.judul" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('judul'), 'form-control-success': fields.judul && fields.judul.valid}" id="judul" name="judul" placeholder="{{ trans('admin.discipleship-detail.columns.judul') }}">
            <div v-if="errors.has('judul')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('judul') }}</div>
        </div>
    </div>
</template>
<template v-else>
    <div class="form-group row align-items-center" :class="{'has-danger': errors.has('judul'), 'has-success': fields.judul && fields.judul.valid }">
        <label for="judul" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.discipleship-detail.columns.judul') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            @{{ this.discipleshipDetail.judul }}
        </div>
    </div>
</template>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('congregation'), 'has-success': this.fields.congregation && this.fields.congregation.valid }">
    <label for="congregation" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">
        {{ trans('admin.discipleship-detail.columns.congregation') }}
    </label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect name="congregations" track-by="id" label="nama_lengkap" v-model="form.congregations" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_options') }}" :options="dataJemaat" :multiple="true" open-direction="bottom" v-validate="'required'" :class="{'form-control-danger': errors.has('congregations'), 'form-control-success': this.fields.congregations && this.fields.congregations.valid}"></multiselect>
        <div v-if="errors.has('congregations')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('congregations') }}</div>
    </div>
</div>
