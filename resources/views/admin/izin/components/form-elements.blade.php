<div class="form-group row align-items-center" :class="{'has-danger': errors.has('nama'), 'has-success': fields.nama && fields.nama.valid }">
    <label for="nama" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.izin.columns.nama') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.nama" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('nama'), 'form-control-success': fields.nama && fields.nama.valid}" id="nama" name="nama" placeholder="{{ trans('admin.izin.columns.nama') }}">
        <div v-if="errors.has('nama')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('nama') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('congregation_id'), 'has-success': fields.congregation_id && fields.congregation_id.valid }">
    <label for="congregation_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.izin.columns.congregation_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.congregation_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('congregation_id'), 'form-control-success': fields.congregation_id && fields.congregation_id.valid}" id="congregation_id" name="congregation_id" placeholder="{{ trans('admin.izin.columns.congregation_id') }}">
        <div v-if="errors.has('congregation_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('congregation_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('angkatan'), 'has-success': fields.angkatan && fields.angkatan.valid }">
    <label for="angkatan" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.izin.columns.angkatan') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.angkatan" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('angkatan'), 'form-control-success': fields.angkatan && fields.angkatan.valid}" id="angkatan" name="angkatan" placeholder="{{ trans('admin.izin.columns.angkatan') }}">
        <div v-if="errors.has('angkatan')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('angkatan') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('kegiatan'), 'has-success': fields.kegiatan && fields.kegiatan.valid }">
    <label for="kegiatan" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.izin.columns.kegiatan') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.kegiatan" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('kegiatan'), 'form-control-success': fields.kegiatan && fields.kegiatan.valid}" id="kegiatan" name="kegiatan" placeholder="{{ trans('admin.izin.columns.kegiatan') }}">
        <div v-if="errors.has('kegiatan')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('kegiatan') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('tgl_kegiatan'), 'has-success': fields.tgl_kegiatan && fields.tgl_kegiatan.valid }">
    <label for="tgl_kegiatan" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.izin.columns.tgl_kegiatan') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.tgl_kegiatan" :config="datePickerConfig" v-validate="'required|date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('tgl_kegiatan'), 'form-control-success': fields.tgl_kegiatan && fields.tgl_kegiatan.valid}" id="tgl_kegiatan" name="tgl_kegiatan" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('tgl_kegiatan')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('tgl_kegiatan') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('keterangan'), 'has-success': fields.keterangan && fields.keterangan.valid }">
    <label for="keterangan" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.izin.columns.keterangan') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.keterangan" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('keterangan'), 'form-control-success': fields.keterangan && fields.keterangan.valid}" id="keterangan" name="keterangan" placeholder="{{ trans('admin.izin.columns.keterangan') }}">
        <div v-if="errors.has('keterangan')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('keterangan') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('alasan'), 'has-success': fields.alasan && fields.alasan.valid }">
    <label for="alasan" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.izin.columns.alasan') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.alasan" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('alasan'), 'form-control-success': fields.alasan && fields.alasan.valid}" id="alasan" name="alasan" placeholder="{{ trans('admin.izin.columns.alasan') }}">
        <div v-if="errors.has('alasan')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('alasan') }}</div>
    </div>
</div>


