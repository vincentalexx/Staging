<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\DestroyRole;
use App\Http\Requests\Admin\Role\IndexRole;
use App\Http\Requests\Admin\Role\StoreRole;
use App\Http\Requests\Admin\Role\UpdateRole;
use App\Models\Role;
use App\Models\Permission;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexRole $request
     * @return Response|array
     */
    public function index(IndexRole $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Role::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name'],

            // set columns to searchIn
            ['id', 'name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.role.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Response
     */
    public function create(IndexRole $request)
    {
        $this->authorize('admin.role.create');

        $permissions = [];
        $selectedPermissions = [];
        $tempPermissions = Permission::all()->pluck('name');
        foreach ($tempPermissions as $permission) {
            $temp = explode(".",$permission);
            if (count($temp) > 2) {
                $permissions[$temp[1]][] = ['name' => $permission, 'label' => $temp[2], 'checked' => false];
            }
        }

        return view('admin.role.create', [
            'permissions' => $permissions,
            'selectedPermissions' => $selectedPermissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRole $request
     * @return Response|array
     */
    public function store(StoreRole $request)
    {
        // Sanitize input
        $sanitized['name'] = $request['name'];
        $sanitized['guard_name'] = 'admin';

        $permissions = ['admin'];
        $permissions = array_merge($permissions, $request->get('permissions'));

        // Store the Role
        $role = Role::create($sanitized);
        $role->syncPermissions($permissions);

        if ($request->ajax()) {
            return ['redirect' => url('admin/roles'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/roles');
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @throws AuthorizationException
     * @return void
     */
    public function show(Role $role)
    {
        $this->authorize('admin.role.show', $role);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @throws AuthorizationException
     * @return Response
     */
    public function edit(Role $role)
    {
        $this->authorize('admin.role.edit', $role);

        $selectedPermissions = $role->permissions()->pluck('name');
        $tempPermissions = Permission::all()->pluck('name');
        $permissions = [];
        foreach ($tempPermissions as $permission) {
            $temp = explode(".",$permission);
            if (count($temp) > 2) {
                $permissions[$temp[1]][] = ['name' => $permission, 'label' => $temp[2], 'checked' => $selectedPermissions->contains($permission)];
            }
        }

        return view('admin.role.edit', [
            'role' => $role,
            'permissions' => $permissions,
            'selectedPermissions' => $selectedPermissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRole $request
     * @param Role $role
     * @return Response|array
     */
    public function update(UpdateRole $request, Role $role)
    {
        // Sanitize input
        $sanitized = $request->validated();
        $sanitized['guard_name'] = 'admin';

        // Update changed values Role
        $role->update($sanitized);
        if(!is_null($request->get('permissions'))) {
            $role->syncPermissions($request->get('permissions'));
        }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/roles'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/roles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRole $request
     * @param Role $role
     * @throws Exception
     * @return Response|bool
     */
    public function destroy(DestroyRole $request, Role $role)
    {
        $role->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param DestroyRole $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(DestroyRole $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Role::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
