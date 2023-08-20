import axios from 'axios';
import AppForm from '../app-components/Form/AppForm';

Vue.component('congregation-attendance-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                tanggal:  '' ,
                listJemaat: [],
                keterangan: '',
                tempat_kebaktian: '',
            },

            datePickerConfig: {
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d",
                "enable": [
                    function(date) {
                        return (date.getDay() === 0 );
                    }
                ],
            },

            keteranganList: ['Sakit', 'Izin'],
            tempatKebaktianList: ['SMP', 'SMA'],

            dataJemaat: [],
        }
    },
    methods: {
        getCongregationAttendanceList(tanggal) {
            axios({
                method: "GET",
                url: "/admin/congregation-attendances/get-congregation-list",
                params: {
                    tanggal: tanggal
                }
            }).then((response) => {
                this.dataJemaat = response.data
            })
        }
    },
    watch: {
        'form.tanggal': function (val) {
            this.getCongregationAttendanceList(val)
        }
    }
});