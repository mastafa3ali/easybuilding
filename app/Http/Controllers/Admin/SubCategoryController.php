<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\SubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class SubCategoryController extends Controller
{
    private $viewIndex  = 'admin.pages.sub_categories.index';
    private $viewEdit   = 'admin.pages.sub_categories.create_edit';
    private $viewShow   = 'admin.pages.sub_categories.show';
    private $route      = 'admin.sub_categories';

    public function index(Request $request): View
    {
        return view($this->viewIndex, get_defined_vars());
    }

    public function create(): View
    {
        return view($this->viewEdit, get_defined_vars());
    }

    public function edit($id): View
    {
        $item = SubCategory::findOrFail($id);
        return view($this->viewEdit, get_defined_vars());
    }

    public function show($id): View
    {
        $item = SubCategory::findOrFail($id);
        return view($this->viewShow, get_defined_vars());
    }

    public function destroy($id): RedirectResponse
    {
        $item = SubCategory::findOrFail($id);
        if ($item->delete()) {
            flash(__('sub_categories.messages.deleted'))->success();
        }
        return to_route($this->route . '.index');
    }

    public function store(SubCategoryRequest $request): RedirectResponse
    {
        if ($this->processForm($request)) {
            flash(__('sub_categories.messages.created'))->success();
        }
        return to_route($this->route . '.index');
    }
    public function select(Request $request): JsonResponse|string
    {
        $data = SubCategory::distinct()
             ->where(function ($query) use ($request) {
                 if ($request->filled('q')) {
                     $query->where('name', 'LIKE', '%' . $request->q . '%');
                 }
                 if ($request->filled('category_id')) {
                     $query->where('category_id', $request->category_id);
                 }
             })
             ->select('id', 'name_en', 'name_ar')
             ->get();
        if ($request->filled('pure_select')) {
            $html = '<option value="">' . __('categories.select') . '</option>';
            foreach ($data as $row) {
                $html .= '<option value="' . $row->id . '">' . $row->text . '</option>';
            }
            return $html;
        }
        return response()->json($data);
    }

    public function update(SubCategoryRequest $request, $id): RedirectResponse
    {
        $item = SubCategory::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('sub_categories.messages.updated'))->success();
        }
        return to_route($this->route . '.index');
    }

    protected function processForm($request, $id = null): SubCategory|null
    {
        $item = $id == null ? new SubCategory() : SubCategory::find($id);
        $data = $request->except(['_token', '_method']);

        $item = $item->fill($data);
        if ($item->save()) {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = time() . rand(0, 999999999) . '.' . $image->getClientOriginalExtension();
                $item->image->move(public_path('storage/sub_categories'), $fileName);
                $item->image = $fileName;
                $item->save();
            }
            return $item;
        }
        return null;
    }

    public function list(Request $request): JsonResponse
    {
        $data = SubCategory::with('category')->select('*');
        return FacadesDataTables::of($data)
        ->addIndexColumn()
        ->addColumn('photo', function ($item) {
            return '<img src="' . $item->photo . '" height="100px" width="100px">';
        })
        ->addColumn('category', function ($item) {
            return $item->category?->title;
        })
        ->filterColumn('name', function ($query, $keyword) {
            if(App::isLocale('en')) {
                return $query->where('name_en', 'like', '%' . $keyword . '%');
            } else {
                return $query->where('name_ar', 'like', '%' . $keyword . '%');
            }
        })
        ->rawColumns(['photo','category'])
        ->make(true);
    }
}
