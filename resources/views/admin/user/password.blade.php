@extends('admin.layout.default')

@section('title', trans('admin.user.actions.edit_password', ['name' => $user->first_name]))

@section('body')
    <div class="container-xl">
        <div class="card">
            <user-form
                :action="'{{ $user->resource_url }}'"
                :data="{{ $user->toJson() }}"
                inline-template>
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="this.action" novalidate>
                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.user.actions.edit', ['name' => $user->first_name]) }}
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                @include('admin.user.components.password-form', $user)
                            </div>
                            <div class="col-md-4">
                                <p style="padding-left: 23px">Persyaratan Kata Sandi: </p>
                                <ul>
                                    <li>Minimal menggunakan satu huruf besar</li>
                                    <li>Minimal menggunakan satu huruf kecil</li>
                                    <li>Minimal menggunakan satu angka</li>
                                    <li>Minimal 8 karakter</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
	                    <button type="submit" class="btn btn-primary" :disabled="submiting">
		                    <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
		                    {{ trans('brackets/admin-ui::admin.btn.save') }}
	                    </button>
                    </div>
                </form>
            </user-form>
        </div>
    </div>
@endsection