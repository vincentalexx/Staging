import AppForm from '../app-components/Form/AppForm';

Vue.component('discipleship-detail-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                discipleship:  '' ,
                divisi:  '' ,
                judul:  '' ,
                tanggal:  '' ,
                isTanggalSudahTerisi: false,
            },

            discipleshipDetail: '',

            datePickerConfig: {
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d",
            },

            discipleshipList: [],
            dataJemaat: [],
            keteranganList: ["Sakit", "Izin"],
        }
    },
    methods: {
        getCongregationList(tanggal, discipleship) {
            if (tanggal != "" && discipleship != "") {
                axios({
                    method: "GET",
                    url: "/admin/discipleship-details/get-congregation-list",
                    params: {
                        tanggal: tanggal,
                        discipleship: discipleship.id,
                    }
                }).then((response) => {
                    this.dataJemaat = response.data.congregations
                    this.discipleshipDetail = response.data.discipleshipDetail
                    if (response.data.discipleshipDetail != null) {
                        this.form.isTanggalSudahTerisi = true
                        this.form.judul = response.data.discipleshipDetail.judul
                    } else {
                        this.form.isTanggalSudahTerisi = false
                        this.form.judul = ''
                    }
                })
            }
        },
    },
    watch: {
        'form.tanggal': function (val) {
            this.getCongregationList(val, this.form.discipleship)
        },
        'form.discipleship': function (val) {
            this.getCongregationList(this.form.tanggal, val)
        },
    }
});