@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.budget-usage.actions.edit', ['name' => $budgetUsage->deskripsi]))

@section('body')
    <div class="container-xl">
        <div class="card">
            <budget-usage-form
                :action="'{{ $budgetUsage->resource_url }}'"
                :data="{{ $budgetUsage->toJson() }}"
                :divisi-data="{{ json_encode($divisi) }}"
                v-cloak
                inline-template>
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.budget-usage.actions.edit', ['name' => $budgetUsage->deskripsi]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.budget-usage.components.form-elements')
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                </form>
        </budget-usage-form>
    </div>
</div>
@endsection