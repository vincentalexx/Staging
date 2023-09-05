<div class="form-group row align-items-center" :class="{'has-danger': errors.has('divisi'), 'has-success': this.fields.divisi && this.fields.divisi.valid }">
    <label for="divisi" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">
        {{ trans('admin.discipleship.columns.divisi') }}
    </label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect name="divisi" v-model="form.divisi" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_options') }}" :options="divisiList" :multiple="false" open-direction="bottom" v-validate="'required'" :class="{'form-control-danger': errors.has('divisi'), 'form-control-success': this.fields.divisi && this.fields.divisi.valid}"></multiselect>
        <div v-if="errors.has('divisi')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('divisi') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('nama_pembinaan'), 'has-success': fields.nama_pembinaan && fields.nama_pembinaan.valid }">
    <label for="nama_pembinaan" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.discipleship.columns.nama_pembinaan') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.nama_pembinaan" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('nama_pembinaan'), 'form-control-success': fields.nama_pembinaan && fields.nama_pembinaan.valid}" id="nama_pembinaan" name="nama_pembinaan" placeholder="{{ trans('admin.discipleship.columns.nama_pembinaan') }}">
        <div v-if="errors.has('nama_pembinaan')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('nama_pembinaan') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('hari'), 'has-success': this.fields.hari && this.fields.hari.valid }">
    <label for="hari" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">
        {{ trans('admin.discipleship.columns.hari') }}
    </label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect name="hari" v-model="form.hari" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_options') }}" :options="hariList" :multiple="false" open-direction="bottom" v-validate="'required'" :class="{'form-control-danger': errors.has('hari'), 'form-control-success': this.fields.hari && this.fields.hari.valid}"></multiselect>
        <div v-if="errors.has('hari')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('hari') }}</div>
    </div>
</div>