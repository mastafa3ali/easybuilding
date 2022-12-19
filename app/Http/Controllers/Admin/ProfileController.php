<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\YearRequest;
use App\Models\Year;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use DataTables;

class ProfileController extends Controller
{
    private $viewProfile = 'admin.pages.profile.index';
    private $viewChangePassword = 'admin.pages.profile.change_password';

    public function __construct()
    {
    }


    public function index(Request $request)
    {
        return view($this->viewProfile, get_defined_vars());
    }


    public function changePassword()
    {
        return view($this->viewChangePassword, get_defined_vars());
    }


    public function edit($id)
    {
        $item = Year::findOrFail($id);
        return view($this->viewEdit, get_defined_vars());
    }


    public function show($id)
    {
        $item = Year::findOrFail($id);
        return view($this->viewShow, get_defined_vars());
    }


    public function destroy($id)
    {
        $item = Year::findOrFail($id);
        if ($item->delete()) {
            flash(__('years.messages.deleted'))->success();
            return redirect()->route($this->route. '.index');
        }
        abort(500);
    }


    public function store(YearRequest $request)
    {
        if ($this->processForm($request)) {
            flash(__('years.messages.created'))->success();
            return redirect()->route($this->route . '.index');
        }
        abort(500);
    }


    public function update(YearRequest $request, $id)
    {
        $item = Year::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('years.messages.updated'))->success();
            return redirect()->route($this->route . '.index');
        }
        abort(500);
    }


    protected function processForm($request, $id = null)
    {
        $item = $id == null ? new Year() : Year::find($id);
        $item = $item->fill($request->all());
        return $item->save() ? $item : null;
    }

    public function list(Request $request)
    {
        $data = Year::where(function ($query) use ($request) {
            if ($request->filled('name')) {
                $query->where('name', 'LIKE', '%'.$request->name.'%');
            }
        })
            ->with('business')
            ->select('*');

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('check', function ($item) {
                return '<div class="checkbox text-center">
                            <input type="checkbox" class="row_check" id="id_'.$item->id.'" form="deleteForm" name="id[]" value="'.$item->id.'" >
                            <label for="id_'.$item->id.'"></label>
                        </div>';
            })
            ->editColumn('business', function ($item) {
                return $item->business->name ?? '';
            })
            ->addColumn('actions', function ($item) {
                $actionsBtn = '<a href="'.route('admin.years.edit', $item->id).'" class="btn-actions btn-xs"><i class="fa fa-edit"></i></a>
							   <a href="#" class="btn-actions btn-xs delete_item" data-url="'.route('admin.years.destroy', $item->id).'"><i class="fa fa-trash"></i></a>';
                return $actionsBtn;
            })
            ->rawColumns(['check','actions'])
            ->make(true);
    }
}
