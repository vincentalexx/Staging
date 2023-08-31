import AppListing from '../app-components/Listing/AppListing';

Vue.component('budget-listing', {
    mixins: [AppListing],
    methods: {
        duplicateItem: function duplicateItem(url) {
            var _this7 = this;

            this.$modal.show('dialog', {
                title: 'Warning!',
                text: 'Do you really want to duplicate this item?',
                buttons: [{ title: 'No, cancel.' }, {
                    title: '<span class="btn-dialog btn-warning">Yes, duplicate.<span>',
                    handler: function handler() {
                        _this7.$modal.hide('dialog');
                        axios.post(url).then(function (response) {
                            _this7.loadData();
                            _this7.$notify({ type: 'success', title: 'Success!', text: response.data.message ? response.data.message : 'Item successfully duplicated.' });
                        }, function (error) {
                            _this7.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });
                        });
                    }
                }]
            });
        },
    }
});