<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
class ProductController extends Controller
{
    private $viewIndex  = 'admin.pages.products.index';
    private $viewEdit   = 'admin.pages.products.create_edit';
    private $viewShow   = 'admin.pages.products.show';
    private $route      = 'admin.products';

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
        $item = Product::findOrFail($id);
        return view($this->viewEdit, get_defined_vars());
    }
    public function show($id): View
    {
        $item = Product::findOrFail($id);
        return view($this->viewShow, get_defined_vars());
    }
    public function destroy($id): RedirectResponse
    {
        $item = Product::findOrFail($id);
        if ($item->delete()) {
            flash(__('products.messages.deleted'))->success();
        }
        return to_route($this->route . '.index');
    }
    public function store(ProductRequest $request): RedirectResponse
    {
        if ($this->processForm($request)) {
            flash(__('products.messages.created'))->success();
        }
        return to_route($this->route . '.index');
    }
    public function update(ProductRequest $request, $id): RedirectResponse
    {
        $item = Product::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('products.messages.updated'))->success();
        }
        return to_route($this->route . '.index');
    }

    protected function processForm($request, $id = null): Product|null
    {
        $item = $id == null ? new Product() : Product::find($id);
        $data= $request->except(['_token', '_method']);

        $item = $item->fill($data);
        if(auth()->user()->type==User::TYPE_COMPANY){
            $item->company_id=auth()->id();
        }
        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request): JsonResponse
    {
        $data = Product::select('*');
        return DataTables::of($data)
        ->addIndexColumn()   
              ->addColumn('company', function ($item) {
                return $item->company->name;
            })
            ->rawColumns(['company'])
        ->make(true);
    }
}
