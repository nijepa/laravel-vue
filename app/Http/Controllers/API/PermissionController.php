<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * @var Role
     */
    private $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Illuminate\Http\Resources\Json\Resource
     */
    public function index()
    {
        return PermissionResource::collection($this->permission->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $role = $this->permission->create([
            'name' => $request->name,
        ]);

        return response(['message' => 'Permission Created']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Permission $permission
     * @return array
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name'     => 'required',
        ]);

        $permission->update([
            'name'     => $request->name,
        ]);

        return response(['message' => 'Permission Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return array
     */
    public function destroy($id)
    {
        return $this->permission->destroy($id);
    }
}
