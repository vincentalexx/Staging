@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.discipleship.actions.edit', ['name' => $discipleship->nama_pembinaan]))

@section('body')
    <div class="container-xl">
        <div class="card">
            <discipleship-form
                :action="'{{ $discipleship->resource_url }}'"
                :data="{{ $discipleship->toJson() }}"
                v-cloak
                inline-template>
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.discipleship.actions.edit', ['name' => $discipleship->nama_pembinaan]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.discipleship.components.form-elements')
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                </form>
            </discipleship-form>
        </div>
    </div>
@endsection