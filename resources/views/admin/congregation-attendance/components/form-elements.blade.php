<div class="form-group row align-items-center" :class="{'has-danger': errors.has('tanggal'), 'has-success': fields.tanggal && fields.tanggal.valid }">
    <label for="tanggal" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.congregation-attendance.columns.tanggal') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.tanggal" :config="datePickerConfig" v-validate="'required'" class="flatpickr" :class="{'form-control-danger': errors.has('tanggal'), 'form-control-success': fields.tanggal && fields.tanggal.valid}" id="tanggal" name="tanggal" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('tanggal')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('tanggal') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('congregation'), 'has-success': this.fields.congregation && this.fields.congregation.valid }">
    <label for="congregation" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">
        {{ trans('admin.congregation-attendance.columns.congregation') }}
    </label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect name="congregations" track-by="id" label="nama_lengkap" v-model="form.congregations" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_options') }}" :options="dataJemaat" :multiple="true" open-direction="bottom" v-validate="'required'" :class="{'form-control-danger': errors.has('congregations'), 'form-control-success': this.fields.congregations && this.fields.congregations.valid}"></multiselect>
        <div v-if="errors.has('congregations')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('congregations') }}</div>
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