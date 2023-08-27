@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.budget.actions.edit', ['name' => $budget->nama_periode]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <budget-form
                :action="'{{ $budget->resource_url }}'"
                :data="{{ $budget->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.budget.actions.edit', ['name' => $budget->nama_periode]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.budget.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </budget-form>

        </div>
    
</div>

@endsection