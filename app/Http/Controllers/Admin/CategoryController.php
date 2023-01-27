<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class CategoryController extends Controller
{
    private $viewIndex  = 'admin.pages.categories.index';
    private $viewEdit   = 'admin.pages.categories.create_edit';
    private $viewShow   = 'admin.pages.categories.show';
    private $route      = 'admin.categories';

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
        $item = Category::findOrFail($id);
        return view($this->viewEdit, get_defined_vars());
    }

    public function show($id): View
    {
        $item = Category::findOrFail($id);
        return view($this->viewShow, get_defined_vars());
    }

    public function destroy($id): RedirectResponse
    {
        $item = Category::findOrFail($id);
        if ($item->delete()) {
            flash(__('categories.messages.deleted'))->success();
        }
        return to_route($this->route . '.index');
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        if ($this->processForm($request)) {
            flash(__('categories.messages.created'))->success();
        }
        return to_route($this->route . '.index');
    }
    public function select(Request $request): JsonResponse|string
    {
       $data = Category::distinct()
            ->where(function ($query) use ($request) {
                if ($request->filled('q')) {
                    $query->where('title', 'LIKE', '%' . $request->q . '%');
                }
            })
            ->select('id', 'title AS text')
            ->take(10)
            ->get();
        if ($request->filled('pure_select')) {
            $html = '<option value="">'. __('category.select') .'</option>';
            foreach ($data as $row) {
                $html .= '<option value="'.$row->id.'">'.$row->text.'</option>';
            }
            return $html;
        }
        return response()->json($data);
    }


    public function update(CategoryRequest $request, $id): RedirectResponse
    {
        $item = Category::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('categories.messages.updated'))->success();
        }
        return to_route($this->route . '.index');
    }

    protected function processForm($request, $id = null): Category|null
    {
        $item = $id == null ? new Category() : Category::find($id);
        $data= $request->except(['_token', '_method']);

        $item = $item->fill($data);
        if ($item->save()) {
            if ($request->hasFile('image')) {
                $item->image = storeFile($request->file('image'), 'categories');
                $item->save();
            }
            return $item;
        }
        return null;
    }

    public function list(Request $request): JsonResponse
    {
        $data = Category::select('*');
        return FacadesDataTables::of($data)
        ->addIndexColumn()
        ->addColumn('photo', function ($item) {
                return '<img src="' . $item->photo . '" height="100px" width="100px">';
            })
            ->rawColumns(['photo'])
        ->make(true);
    }
}
