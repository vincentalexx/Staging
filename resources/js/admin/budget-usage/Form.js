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
            })
        },
        getTotalReimburs() {
            let reimburs = this.form.reimburs

            reimburs = 0
            if (this.form.jumlah_orang > this.form.jenis_budget.jumlah_orang_maksimum) {
                if (this.form.total > this.form.jenis_budget.total) {
                    reimburs = this.form.total
                } else {
                    reimburs = this.form.jenis_budget.total
                }
            }

            this.form.reimburs = reimburs
        },
    },
    watch: {
        "form.tanggal": function(val) {
            this.getBudgetDetailByTanggal(val)
        }
    }
});