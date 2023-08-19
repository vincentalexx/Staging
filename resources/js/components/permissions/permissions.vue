<template>
    <div class="row">
        <div v-for="(group,i) in permissionGroup" :key='i' class="col-md-4" v-cloak>
            <div class="card" style="min-height: 300px;max-height: 300px;overflow-y:auto;">
                <div class="card-body">
                    <h5 style="margin-bottom: 1rem;">{{ i.toUpperCase() }}</h5>
                    <div v-for="(data,j) in group" :key='j'>
                        <label class="switch switch-3d switch-danger" >
                            <input type="checkbox" class="switch-input" name="data.name" :value="data.name" v-model="data.checked" @change="onChange">
                            <span class="switch-slider"></span>
                        </label>

                        <span style="position: absolute;left: 4.5rem;text-transform: capitalize;margin-top: .2rem;font-weight: 450;" >
                            {{ data.label }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['permissions', 'selected-permissions'],

        data() {
            return {
                permissionGroup: JSON.parse(this.permissions),
                selectedItems: JSON.parse(this.selectedPermissions)
            }
        },
        methods: {
            updateItem (e) {
                this.$emit('selectedItems', this.selectedItems)
            },
            onChange: function(e) {
                var indexItem = this.selectedItems.indexOf(e.target.defaultValue);
                if (indexItem != -1){
                    this.selectedItems.splice(indexItem, 1);
                } else {
                    this.selectedItems.push(e.target.defaultValue);
                }
                this.$emit('input', this.selectedItems)
            }
        }
    }
</script>
