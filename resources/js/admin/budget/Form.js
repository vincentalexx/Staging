import AppForm from '../app-components/Form/AppForm';

Vue.component('budget-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                divisi:  '' ,
                nama_periode:  '' ,
                periode:  '' ,
                total_budget_awal:  0 ,

                budget_details: [
                    {
                        id: null,
                        nama_budget: '',
                        jumlah_orang_maksimum: 0,
                        budget: 0,
                        total: '',
                    }
                ],

                removed_budget_details: [],
            },

            divisiList: ["SMP", "SMA", "Pemuda"],
            
            datePickerConfig: {
                altInput: true,
                altFormat: "F Y",
                dateFormat: "Y-m",
            },
        }
    },
    methods: {
        addRowBudgetDetail() {
            this.form.budget_details.push({
                id: null,
                nama_budget: '',
                jumlah_orang_maksimum: 0,
                budget: 0,
                total: '',
            })
        },
        deleteRowBudgetDetail(index) {
            if (this.form.budget_details[index].id != null) {
                if (this.form.removed_budget_details == null) {
                    this.form.removed_budget_details = []
                }
                
                this.form.removed_budget_details.push(this.form.budget_details[index])
            }

            this.form.budget_details.splice(index, 1)
            this.calculateTotalBudget()
        },
        calculateBudgetDetail(index) {
            let total = 0

            total = this.form.budget_details[index].jumlah_orang_maksimum * this.form.budget_details[index].budget

            this.form.budget_details[index].total = total

            this.calculateTotalBudget()
        },
        calculateTotalBudget() {
            let total_budget = 0

            this.form.budget_details.map(budget => {
                total_budget += budget.total
            })

            this.form.total_budget_awal = total_budget
        }
    }
});