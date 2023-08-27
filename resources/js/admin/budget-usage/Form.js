import axios from 'axios';
import AppForm from '../app-components/Form/AppForm';

Vue.component('budget-usage-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                tanggal:  '' ,
                jenis_budget:  '' ,
                deskripsi:  '' ,
                jumlah_orang:  0 ,
                total:  0 ,
                reimburs:  0 ,
            },

            budgetDetailList: [],
            mediaCollections: ['bon_transaksi'],

            datePickerConfig: {
                altInput: true,
                altFormat: "d F Y",
                dateFormat: "Y-m-d",
            },
        }
    },
    methods: {
        getBudgetDetailByTanggal(val) {
            axios({
                url: "/admin/budget-usages/get-budget-detail-by-tanggal",
                method: "GET",
                params: {
                    tanggal: val
                }
            }).then(response => {
                this.budgetDetailList = response.data.budget_detail

                if (this.form.id != null) {
                    this.budgetDetailList.map(budgetDetail => {
                        if(budgetDetail.id == this.form.budget_detail_id) {
                            this.form.jenis_budget = budgetDetail
                        }
                    })
                }
            })
        },
        getTotalReimburs() {
            let reimburs = this.form.reimburs

            console.log("Asd")

            reimburs = 0
            let maksimum_reimburs = 0
            if (this.form.jumlah_orang > this.form.jenis_budget.jumlah_orang_maksimum) {
                maksimum_reimburs = this.form.jenis_budget.total
                if (this.form.total > maksimum_reimburs) {
                    reimburs = maksimum_reimburs
                } else {
                    reimburs = this.form.total
                }
            } else {
                maksimum_reimburs = this.form.jumlah_orang * this.form.jenis_budget.budget
                if (this.form.total > maksimum_reimburs) {
                    reimburs = maksimum_reimburs
                } else {
                    reimburs = this.form.total
                }
            }

            console.log(reimburs)

            this.form.reimburs = reimburs
        },
    },
    watch: {
        "form.tanggal": function(val) {
            this.getBudgetDetailByTanggal(val)
        }
    }
});