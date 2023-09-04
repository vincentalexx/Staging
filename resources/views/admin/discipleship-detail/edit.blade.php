@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.discipleship-detail.actions.edit', ['name' => $discipleshipDetail->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <discipleship-detail-form
                :action="'{{ $discipleshipDetail->resource_url }}'"
                :data="{{ $discipleshipDetail->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.discipleship-detail.actions.edit', ['name' => $discipleshipDetail->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.discipleship-detail.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </discipleship-detail-form>

        </div>
    
</div>

@endsection