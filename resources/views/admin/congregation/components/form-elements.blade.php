<div class="form-group row align-items-center" :class="{'has-danger': errors.has('id_card'), 'has-success': fields.id_card && fields.id_card.valid }">
    <label for="id_card" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.congregation.columns.id_card') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.id_card" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('id_card'), 'form-control-success': fields.id_card && fields.id_card.valid}" id="id_card" name="id_card" placeholder="{{ trans('admin.congregation.columns.id_card') }}">
        <div v-if="errors.has('id_card')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('id_card') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('nama_lengkap'), 'has-success': fields.nama_lengkap && fields.nama_lengkap.valid }">
    <label for="nama_lengkap" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.congregation.columns.nama_lengkap') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.nama_lengkap" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('nama_lengkap'), 'form-control-success': fields.nama_lengkap && fields.nama_lengkap.valid}" id="nama_lengkap" name="nama_lengkap" placeholder="{{ trans('admin.congregation.columns.nama_lengkap') }}">
        <div v-if="errors.has('nama_lengkap')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('nama_lengkap') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('jenis_kelamin'), 'has-success': fields.jenis_kelamin && fields.jenis_kelamin.valid }">
    <label for="jenis_kelamin" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.congregation.columns.jenis_kelamin') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.jenis_kelamin" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('jenis_kelamin'), 'form-control-success': fields.jenis_kelamin && fields.jenis_kelamin.valid}" id="jenis_kelamin" name="jenis_kelamin" placeholder="{{ trans('admin.congregation.columns.jenis_kelamin') }}">
        <div v-if="errors.has('jenis_kelamin')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('jenis_kelamin') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('kelas'), 'has-success': fields.kelas && fields.kelas.valid }">
    <label for="kelas" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.congregation.columns.kelas') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.kelas" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('kelas'), 'form-control-success': fields.kelas && fields.kelas.valid}" id="kelas" name="kelas" placeholder="{{ trans('admin.congregation.columns.kelas') }}">
        <div v-if="errors.has('kelas')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('kelas') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('tgl_lahir'), 'has-success': fields.tgl_lahir && fields.tgl_lahir.valid }">
    <label for="tgl_lahir" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.congregation.columns.tgl_lahir') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.tgl_lahir" :config="datePickerConfig" v-validate="'required|date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('tgl_lahir'), 'form-control-success': fields.tgl_lahir && fields.tgl_lahir.valid}" id="tgl_lahir" name="tgl_lahir" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('tgl_lahir')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('tgl_lahir') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('alamat'), 'has-success': fields.alamat && fields.alamat.valid }">
    <label for="alamat" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.congregation.columns.alamat') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.alamat" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('alamat'), 'form-control-success': fields.alamat && fields.alamat.valid}" id="alamat" name="alamat" placeholder="{{ trans('admin.congregation.columns.alamat') }}">
        <div v-if="errors.has('alamat')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('alamat') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('no_wa'), 'has-success': fields.no_wa && fields.no_wa.valid }">
    <label for="no_wa" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.congregation.columns.no_wa') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.no_wa" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('no_wa'), 'form-control-success': fields.no_wa && fields.no_wa.valid}" id="no_wa" name="no_wa" placeholder="{{ trans('admin.congregation.columns.no_wa') }}">
        <div v-if="errors.has('no_wa')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('no_wa') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('hobi'), 'has-success': fields.hobi && fields.hobi.valid }">
    <label for="hobi" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.congregation.columns.hobi') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.hobi" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('hobi'), 'form-control-success': fields.hobi && fields.hobi.valid}" id="hobi" name="hobi" placeholder="{{ trans('admin.congregation.columns.hobi') }}">
        <div v-if="errors.has('hobi')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('hobi') }}</div>
    </div>
</div>


