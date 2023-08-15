import AppForm from '../app-components/Form/AppForm';

Vue.component('congregation-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                nama_lengkap:  '' ,
                jenis_kelamin:  '' ,
                angkatan:  '' ,
                sekolah:  '' ,
                tgl_lahir:  '' ,
                alamat:  '' ,
                no_wa:  '' ,
                hobi:  '' ,
            }
        }
    }

});