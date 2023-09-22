<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\ApiNotification;
use App\Models\Category;
use App\Models\CompanyProduct;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    private $notifications  = 'company.pages.products_rent.notifications';
    private $viewEdit   = 'company.pages.products_rent.create_edit';
    private $viewShow   = 'company.pages.products_rent.show';
    private $route      = 'company.products';

    public function index(Request $request): View
    {
        return view('company.pages.products_rent.index', get_defined_vars());
    }
    public function notifications(Request $request): View
    {
        return view($this->notifications, get_defined_vars());
    }
    public function create(): View
    {
        $display = "display:none";
        return view($this->viewEdit, get_defined_vars());
    }
    public function edit($id): View
    {
        $item = CompanyProduct::with('product')->findOrFail($id);
        $display = "";
        if($item->product?->type == 1) {
            $display = "display:none";
        }
        return view($this->viewEdit, get_defined_vars());
    }
    public function show($id): View
    {
        $item = CompanyProduct::with('product')->findOrFail($id);
        return view($this->viewShow, get_defined_vars());
    }
    public function destroy($id): RedirectResponse
    {
        $item = CompanyProduct::findOrFail($id);
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
        $item = CompanyProduct::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('products.messages.updated'))->success();
        }
        return to_route($this->route . '.index');
    }

    protected function processForm($request, $id = null): CompanyProduct|null
    {
        $item = null;
        if($id == null) {
            $item = CompanyProduct::where('company_id', auth()->id())->where('product_id', $request->product_id)->first();
        }
        if($item == null) {
            $item = $id == null ? new CompanyProduct() : CompanyProduct::find($id);
        }
        $data = $request->except(['_token', '_method','type']);
        $item = $item->fill($data);
        $item->company_id = auth()->id();

        if($request->filled('available')) {
            $item->available = 1;
        } else {
            $item->available = 0;
        }

        if ($item->save()) {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = time() . rand(0, 999999999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('storage/products'), $fileName);
                $item->image = $fileName;
                $item->save();
            }
            $images = [];
            if($files = $request->file('images')) {
                foreach($files as $file) {
                    $name = $file->getClientOriginalName();
                    $file->move(public_path('storage/products'), $name);
                    $images[] = $name;
                }
                $item->images = $images;
                $item->save();
            }
            return $item;
        }
        return null;
    }

    public function listnotifications(Request $request): JsonResponse
    {
        $data = ApiNotification::where('user_id', auth()->id())->orderBy('id', 'DESC')->select('*');
        return DataTables::of($data)
        ->addIndexColumn()

        ->make(true);
    }

    public function list(Request $request): JsonResponse
    {
        $data = CompanyProduct::with('product')->leftJoin('products', 'products.id', 'company_products.product_id')
        ->where('products.type', Product::TYPE_RENT)
        ->where('company_products.company_id', auth()->id())->select([
            'products.type',
            'company_products.product_id',
            'company_products.description_en',
            'company_products.description_ar',
            'products.name_en',
            'products.name_ar',
            'company_products.price',
            'company_products.id',
            'company_products.guarantee_amount'
        ]);
        return DataTables::of($data)
        ->addIndexColumn()
            ->editColumn('type', function ($item) {
                return __('products.types.'.$item->type);
            })

            ->filterColumn('description', function ($query, $keyword) {
                if(App::isLocale('en')) {
                    return $query->where('company_products.description_en', 'like', '%'.$keyword.'%');
                } else {
                    return $query->where('company_products.description_ar', 'like', '%'.$keyword.'%');
                }
            })

            ->rawColumns(['type'])
        ->make(true);
    }

    public function select(Request $request): JsonResponse|string
    {
        $data = Product::whereNull('company_id')->distinct()
             ->where('products.type', Product::TYPE_RENT)
                ->where(function ($query) use ($request) {
                    if ($request->filled('q')) {
                        if(App::isLocale('en')) {
                            return $query->where('name_en', 'like', '%'.$request->q.'%');
                        } else {
                            return $query->where('name_ar', 'like', '%'.$request->q.'%');
                        }
                    }
                })->select('id', 'name_en', 'name_ar', 'category_id', 'description_en', 'description_ar')->get();
        return response()->json($data);
    }

    public function check(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        if($product->sub_category_id == 1) {
            return 1;
        }
        return 0;
    }

    public function selectcategories(Request $request): JsonResponse|string
    {
        $data = Category::distinct()
         ->where(function ($query) use ($request) {
             if ($request->filled('q')) {
                 if(App::isLocale('en')) {
                     return $query->where('title_en', 'like', '%'.$request->q.'%');
                 } else {
                     return $query->where('title_ar', 'like', '%'.$request->q.'%');
                 }
             }
         })->select('id', 'title_en', 'title_ar')->get();

        return response()->json($data);
    }
    public function selectSubCategory(Request $request): JsonResponse|string
    {

        $data = Category::distinct()
                 ->where(function ($query) use ($request) {
                     if ($request->filled('category_id')) {
                         $query->where('category_id', $request->category_id);
                     }
                     if ($request->filled('q')) {
                         if(App::isLocale('en')) {
                             return $query->where('name_en', 'like', '%'.$request->q.'%');
                         } else {
                             return $query->where('name_ar', 'like', '%'.$request->q.'%');
                         }
                     }
                 })->select('id', 'name_en', 'name_ar')->get();

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
