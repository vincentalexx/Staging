<div class="form-group row align-items-center" :class="{'has-danger': errors.has('tanggal'), 'has-success': fields.tanggal && fields.tanggal.valid }">
    <label for="tanggal" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.discipleship-detail.columns.tanggal') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        {{ $tanggal }}
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('judul'), 'has-success': this.fields.judul && this.fields.judul.valid }">
    <label for="judul" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">
        {{ trans('admin.discipleship-detail.columns.judul') }}
    </label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        {{ $discipleshipDetail->judul }}
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('congregation'), 'has-success': this.fields.congregation && this.fields.congregation.valid }">
    <label for="congregation" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">
        {{ trans('admin.discipleship-detail.columns.congregation') }}
    </label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        {{ $congregation->nama_lengkap }}
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('keterangan'), 'has-success': this.fields.keterangan && this.fields.keterangan.valid }">
    <label for="keterangan" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">
        {{ trans('admin.discipleship-detail.columns.keterangan') }}
    </label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect name="keterangan" v-model="form.keterangan" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_options') }}" :options="keteranganList" :multiple="false" open-direction="bottom" v-validate="" :class="{'form-control-danger': errors.has('keterangan'), 'form-control-success': this.fields.keterangan && this.fields.keterangan.valid}"></multiselect>
        <div v-if="errors.has('keterangan')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('keterangans') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('alasan'), 'has-success': this.fields.alasan && this.fields.alasan.valid }">
    <label for="alasan" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.discipleship-detail.columns.alasan') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <textarea rows="3" v-model="form.alasan" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('alasan'), 'form-control-success': this.fields.alasan && this.fields.alasan.valid}" id="alasan" name="alasan" placeholder="{{ trans('admin.discipleship-detail.columns.alasan') }}"></textarea>
        <div v-if="errors.has('alasan')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('alasan') }}</div>
    </div>
</div>