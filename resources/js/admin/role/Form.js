import AppForm from '../app-components/Form/AppForm';
import permissions from '../../components/permissions/permissions';

Vue.component('role-form', {
    mixins: [AppForm],
    components: {permissions},
    data: function() {
        return {
            form: {
                name:  '' ,
            }
        }
    }

});