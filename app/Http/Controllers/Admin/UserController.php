<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    private $viewIndex  = 'admin.pages.users.index';
    private $viewEdit   = 'admin.pages.users.create_edit';
    private $viewShow   = 'admin.pages.users.show';
    private $route      = 'admin.users';

    public function index(Request $request): View
    {
        return view($this->viewIndex, get_defined_vars());
    }

    public function create(): View
    {
        $userRoles = [];
        return view($this->viewEdit, get_defined_vars());
    }

    public function edit($id): View
    {
        $item = User::findOrFail($id);
        $userRoles = $item->roles->pluck('id')->toArray();
        return view($this->viewEdit, get_defined_vars());
    }

    public function show($id): View
    {
        $item = User::findOrFail($id);
        return view($this->viewShow, get_defined_vars());
    }

    public function destroy($id)
    {
        $item = User::where('id', '!=', auth()->id())->findOrFail($id);
        if ($item->delete()) {
            flash(__('users.messages.deleted'))->success();
        }
        return redirect()->route($this->route . '.index');
    }

    public function store(UserRequest $request)
    {
        if ($this->processForm($request)) {
            flash(__('users.messages.created'))->success();
        }
        return redirect()->route($this->route . '.index');
    }

    public function update(UserRequest $request, $id)
    {
        User::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('users.messages.updated'))->success();
        }
        return redirect()->route($this->route . '.index');
    }


    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new User() : User::find($id);
        $data= $request->except(['_token', '_method', 'password']);
        $item = $item->fill($data);
        if ($item->save()) {
            if ($request->filled('password')) {
                $item->password = Hash::make($request->password);
                $item->save();
            }
            if ($request->hasFile('image')) {
                $item->image = storeFile($request->file('image'), 'users');
                $item->save();
            }
            if ($request->hasFile('passport')) {
                $item->passport = storeFile($request->file('passport'), 'users');
                $item->save();
            }
            if ($request->hasFile('licence')) {
                $item->licence = storeFile($request->file('licence'), 'users');
                $item->save();
            }
            $item->roles()->detach();
            if ($request->filled('type')) {
                $role = null;
                if ($request->type == User::TYPE_ADMIN) {
                    $role = Role::where('name', 'admin')->first();
                } elseif ($request->type == User::TYPE_COMPANY) {
                    $role = Role::where('name', 'company')->first();
                } elseif ($request->type == User::TYPE_OWNER) {
                    $role = Role::where('name', 'owner')->first();
                }
                if ($role) {
                    $item->syncRoles([$role->id]);
                }
            }
            if ($request->filled('role_id')) {
            }

            return $item;
        }
        return null;
    }

    public function list(Request $request)
    {
        $data = User::select('*');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('type', function ($item) {
                return __('users.types.' . $item->type);
            })
            ->rawColumns(['type'])
            ->make(true);
    }
}
