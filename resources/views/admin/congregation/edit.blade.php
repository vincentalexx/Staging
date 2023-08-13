@extends('admin.layout.default')

@section('title', trans('admin.congregation.actions.edit', ['name' => $congregation->nama_lengkap]))

@section('body')
    <div class="container-xl">
        <div class="card">
            <congregation-form
                :action="'{{ $congregation->resource_url }}'"
                :data="{{ $congregation->toJson() }}"
                v-cloak
                inline-template>
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.congregation.actions.edit', ['name' => $congregation->nama_lengkap]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.congregation.components.form-elements')
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                </form>
        </congregation-form>
    </div>
</div>

@endsection