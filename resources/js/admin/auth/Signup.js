import AppForm from '../app-components/Form/AppForm';

Vue.component('signup-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                nama:  '' ,
                kelas_sekarang:  '' ,
                gender:  'laki_laki' ,
                no_wa:  '' ,
                nama_ortu:  '' ,
                no_wa_ortu:  '' ,
                email:  '' ,
                transportasi_pergi:  'transportasi_gereja' ,
                transportasi_pulang:  'transportasi_gereja' ,
                lokasi_gereja:  'gii_gardujati' ,
                nilai_persembahan:  '' ,
                status_pembayaran: 'bayar_sekarang',
            },
            mediaCollections: ['avatar', 'bukti_transfer']
        }
    },
    methods: {
        onSuccess(data) {
            if(data.notify) {
                this.$notify({ type: data.notify.type, title: data.notify.title, text: data.notify.message});
            } else if (data.redirect) {
                window.location.replace(data.redirect);
            }
        }
    }
});