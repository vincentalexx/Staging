import AppForm from '../app-components/Form/AppForm';

Vue.component('izin-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                nama:  '' ,
                congregation_id:  '' ,
                angkatan:  '' ,
                kegiatan:  '' ,
                tgl_kegiatan:  '' ,
                keterangan:  '' ,
                alasan:  '' ,
                
            }
        }
    }

});