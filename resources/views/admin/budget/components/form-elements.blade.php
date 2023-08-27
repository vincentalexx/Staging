<div class="form-group row align-items-center" :class="{'has-danger': errors.has('nama_periode'), 'has-success': fields.nama_periode && fields.nama_periode.valid }">
    <label for="nama_periode" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.budget.columns.nama_periode') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.nama_periode" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('nama_periode'), 'form-control-success': fields.nama_periode && fields.nama_periode.valid}" id="nama_periode" name="nama_periode" placeholder="{{ trans('admin.budget.columns.nama_periode') }}">
        <div v-if="errors.has('nama_periode')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('nama_periode') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('periode'), 'has-success': fields.periode && fields.periode.valid }">
    <label for="periode" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.budget.columns.periode') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.periode" :config="datePickerConfig" v-validate="'required'" class="flatpickr" :class="{'form-control-danger': errors.has('periode'), 'form-control-success': fields.periode && fields.periode.valid}" id="periode" name="periode" placeholder="Select month"></datetime>
        </div>
        <div v-if="errors.has('periode')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('periode') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('divisi'), 'has-success': this.fields.divisi && this.fields.divisi.valid }">
    <label for="divisi" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">
        {{ trans('admin.budget.columns.divisi') }}
    </label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect name="divisi" v-model="form.divisi" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_options') }}" :options="divisiList" :multiple="false" open-direction="bottom" v-validate="'required'" :class="{'form-control-danger': errors.has('divisi'), 'form-control-success': this.fields.divisi && this.fields.divisi.valid}"></multiselect>
        <div v-if="errors.has('divisi')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('divisi') }}</div>
    </div>
</div>

<div class="rows" style="padding-top: 50px;">
    <!-- <div class="col-md-4"></div> -->
    <div class="col-md-12" style="margin-left: auto; margin-right: auto; width: 80%">
        <table class="table table-listing table-hovered">
            <thead>
                <tr>
                    <th style="width: 20%">Nama Budget</th>
                    <th style="width: 10%">Orang</th>
                    <th style="width: 10%">Budget</th>
                    <th style="width: 10%">Total</th>
        
                    <th style="width: 5%"></th>
                </tr>
            </thead>
            <tbody>
                <template v-if="form.user != ''">
                    <tr v-for="(budget_detail, d) in form.budget_details" :key="d">
                        <td>
                            <input type="text" :name="'budget_detail_nama_budget' + d" :id="'budget_detail_nama_budget' + d" v-model="budget_detail.nama_budget" class="form-control">
                        </td>
                        <td>
                            <input type="number" :name="'budget_detail_jumlah_orang_maksimum' + d" :id="'budget_detail_jumlah_orang_maksimum' + d" v-model="budget_detail.jumlah_orang_maksimum" class="form-control" @input="calculateBudgetDetail(d)" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
                        </td>
                        <td>
                            <input type="number" :name="'budget_detail_budget' + d" :id="'budget_detail_budget' + d" v-model="budget_detail.budget" class="form-control" @input="calculateBudgetDetail(d)" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
                        </td>
                        <td style="text-align: right">
                            @{{ budget_detail.total == '' ? 0 : budget_detail.total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") }}
                        </td>
                        <td>
                            <button @click="deleteRowBudgetDetail(d)" v-if="form.budget_details.length > 0" type="button" class="btn btn-danger color-white"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
        <button type="button" v-if="form.user != ''" @click="addRowBudgetDetail()" class="btn btn-block btn-sm btn-primary color-white">ADD MORE</button>
    </div>
</div>

<div class="row" style="padding-top: 20px; margin-right: 10%">
    <div class="col-md-7"></div>

    <div class="col-md-5">
        <div class="row">
            <div class="col-md-5">
                <h2>Total</h2>
            </div>
            <div class="col-md-7">
                <h2 style="text-align:right;">Rp. @{{ form.total_budget_awal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") }},00</h2>
            </div>
        </div>
    </div>
</div>
