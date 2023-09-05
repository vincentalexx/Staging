import AppForm from '../app-components/Form/AppForm';

Vue.component('discipleship-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                divisi:  '' ,
                nama_pembinaan:  '' ,
                hari:  '' ,
            },
            
            divisiList: ["SMP", "SMA", "Pemuda"],
            hariList: ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"],
        }
    }
});