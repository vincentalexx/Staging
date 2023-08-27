<div class="form-group row align-items-center" :class="{'has-danger': errors.has('tanggal'), 'has-success': fields.tanggal && fields.tanggal.valid }">
    <label for="tanggal" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.budget-usage.columns.tanggal') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.tanggal" :config="datePickerConfig" v-validate="'required'" class="flatpickr" :class="{'form-control-danger': errors.has('tanggal'), 'form-control-success': fields.tanggal && fields.tanggal.valid}" id="tanggal" name="tanggal" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('tanggal')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('tanggal') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('jenis_budget'), 'has-success': this.fields.jenis_budget && this.fields.jenis_budget.valid }">
    <label for="jenis_budget" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">
        {{ trans('admin.budget-usage.columns.jenis_budget') }}
    </label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect label="nama_budget" name="jenis_budget" v-model="form.jenis_budget" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_options') }}" :options="budgetDetailList" :multiple="false" open-direction="bottom" v-validate="" :class="{'form-control-danger': errors.has('jenis_budget'), 'form-control-success': this.fields.jenis_budget && this.fields.jenis_budget.valid}"></multiselect>
        <div v-if="errors.has('jenis_budget')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('jenis_budget') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('deskripsi'), 'has-success': fields.deskripsi && fields.deskripsi.valid }">
    <label for="deskripsi" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.budget-usage.columns.deskripsi') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.deskripsi" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('deskripsi'), 'form-control-success': fields.deskripsi && fields.deskripsi.valid}" id="deskripsi" name="deskripsi" placeholder="{{ trans('admin.budget-usage.columns.deskripsi') }}">
        <div v-if="errors.has('deskripsi')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('deskripsi') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('jumlah_orang'), 'has-success': fields.jumlah_orang && fields.jumlah_orang.valid }">
    <label for="jumlah_orang" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.budget-usage.columns.jumlah_orang') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="number" v-model="form.jumlah_orang" v-validate="'required|integer'" @input="getTotalReimburs()" class="form-control" :class="{'form-control-danger': errors.has('jumlah_orang'), 'form-control-success': fields.jumlah_orang && fields.jumlah_orang.valid}" id="jumlah_orang" name="jumlah_orang" placeholder="{{ trans('admin.budget-usage.columns.jumlah_orang') }}">
        <div v-if="errors.has('jumlah_orang')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('jumlah_orang') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('total'), 'has-success': fields.total && fields.total.valid }">
    <label for="total" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.budget-usage.columns.total') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="number" v-model="form.total" v-validate="'required|decimal'" @input="getTotalReimburs()" class="form-control" :class="{'form-control-danger': errors.has('total'), 'form-control-success': fields.total && fields.total.valid}" id="total" name="total" placeholder="{{ trans('admin.budget-usage.columns.total') }}">
        <div v-if="errors.has('total')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('total') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('reimburs'), 'has-success': fields.reimburs && fields.reimburs.valid }">
    <label for="reimburs" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.budget-usage.columns.reimburs') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        @{{ form.reimburs.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") }}
    </div>
</div>

<div class="row form-group align-items-center">
    <label class="col-md-2 col-form-label text-md-right">Bon Transaksi</label>
    <div class="col-md-8">
        @include('brackets/admin-ui::admin.includes.media-uploader', [
            'mediaCollection' => app(App\Models\BudgetUsage::class)->getMediaCollection('bon_transaksi'),
            'media' => $budgetUsage->getThumbs200ForCollection('bon_transaksi'),
            'label' => 'Foto Bon Transaksi',
        ])
    </div>
</div>
