@extends('admin.layout.default')

@section('title', trans('admin.discipleship-detail.actions.edit'))

@section('body')
    <div class="container-xl">
        <div class="card">
            <discipleship-detail-edit-detail-form
                :action="'{{ url('admin/discipleship-details/' . $congregation->id . '/' . $discipleshipDetail->id . '/update') }}'"
                :data="{{ $congregationDiscpleshipDetail == null ? '{}' : $congregationDiscpleshipDetail->toJson() }}"
                v-cloak
                inline-template>
                <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                    <div class="card-header">
                        <i class="fa fa-plus"></i> {{ trans('admin.discipleship-detail.actions.edit') }}
                    </div>

                    <div class="card-body">
                        @include('admin.discipleship-detail.components.form-elements-edit-detail')
                    </div>
                                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                </form>
            </discipleship-detail-edit-detail-form>
        </div>
    </div>
@endsection