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
    private $viewIndex  = 'admin.pages.categoies.index';
    private $viewEdit   = 'admin.pages.categoies.create_edit';
    private $viewShow   = 'admin.pages.categoies.show';
    private $route      = 'admin.categoies';

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
            flash(__('categoies.messages.deleted'))->success();
        }
        return to_route($this->route . '.index');
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        if ($this->processForm($request)) {
            flash(__('categoies.messages.created'))->success();
        }
        return to_route($this->route . '.index');
    }

    public function update(CategoryRequest $request, $id): RedirectResponse
    {
        $item = Category::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('categoies.messages.updated'))->success();
        }
        return to_route($this->route . '.index');
    }

    protected function processForm($request, $id = null): Category|null
    {
        $item = $id == null ? new Category() : Category::find($id);
        $item = $item->fill($request->all());
        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request): JsonResponse
    {
        $data = Category::select('*');
        return FacadesDataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
