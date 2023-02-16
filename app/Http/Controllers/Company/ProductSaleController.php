<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
class ProductSaleController extends Controller
{
    private $viewIndex  = 'company.pages.products.index';
    private $viewEdit   = 'company.pages.products.create_edit';
    private $viewShow   = 'company.pages.products.show';
    private $route      = 'company.product_ssale';

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
    public function store(Request $request): RedirectResponse
    {
        if ($this->processForm($request)) {
            flash(__('products.messages.created'))->success();
        }
        return to_route($this->route . '.index');
    }
    public function update(Request $request, $id): RedirectResponse
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
        $item->company_id=auth()->id();
        if ($item->save()) {
             if ($request->hasFile('image')) {
                $image= $request->file('image');
                $fileName = time() . rand(0, 999999999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('storage/products'), $fileName);
                $item->image = $fileName;
                $item->save();
            }
            $images = [];
            if($files=$request->file('images')){
                foreach($files as $file){
                    $name=$file->getClientOriginalName();
                    $file->move(public_path('storage/products'), $name);
                    $images[]=$name;
                }
                $item->images = $images;
                $item->save();
            }
            return $item;
        }
        return null;
    }

    public function list(Request $request): JsonResponse
    {
        $data = Product::with('category')->where('company_id',auth()->id())
        ->select('*');
        return DataTables::of($data)
        ->addIndexColumn()
           ->editColumn('category', function ($item) {
                return $item->category?->title;
            })
            ->rawColumns(['category'])
        ->make(true);
    }
    public function select(Request $request): JsonResponse|string
    {
       $data = Product::whereNull('company_id')->distinct()
            ->where(function ($query) use ($request) {
                if ($request->filled('q')) {
                    $query->where('name', 'LIKE', '%' . $request->q . '%');
                }
            })
            ->select('id', 'name AS text')
            ->take(20)
            ->get();
        return response()->json($data);
    }
    public function selectcategories(Request $request): JsonResponse|string
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
        return response()->json($data);
    }
    public function selectSubCategory(Request $request): JsonResponse|string
    {
       $data = SubCategory::distinct()
            ->where(function ($query) use ($request) {
                if ($request->filled('q')) {
                    $query->where('name', 'LIKE', '%' . $request->q . '%');
                }
                if ($request->filled('category_id')) {
                    $query->where('category_id',$request->category_id);
                }
            })
            ->select('id', 'name AS text')
            ->get();
        if ($request->filled('pure_select')) {
            $html = '<option value="">'. __('categories.select') .'</option>';
            foreach ($data as $row) {
                $html .= '<option value="'.$row->id.'">'.$row->text.'</option>';
            }
            return $html;
        }
        return response()->json($data);
    }


}
