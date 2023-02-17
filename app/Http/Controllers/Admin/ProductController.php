<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Order;
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

    public function order(Request $request): View
    {
        return view('admin.pages.products.orders', get_defined_vars());
    }
    public function index(Request $request): View
    {
        return view($this->viewIndex, get_defined_vars());
    }
    public function create(): View
    {
        $display = "display:none";
        return view($this->viewEdit, get_defined_vars());
    }
    public function edit($id): View
    {
        $item = Product::findOrFail($id);
        $display = "";
        if($item->type==1){
            $display = "display:none";
        }
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
             if ($request->hasFile('image')) {
                $image= $request->file('image');
                $fileName = time() . rand(0, 999999999) . '.' . $image->getClientOriginalExtension();
                $item->image->move(public_path('storage/products'), $fileName);
                $item->image = $fileName;
                $item->save();
            }
            return $item;
        }
        return null;
    }

    public function list(Request $request): JsonResponse
    {
        $data = Product::whereNull('company_id')->select('*');
        return DataTables::of($data)
        ->addIndexColumn()
            ->editColumn('type', function ($item) {
                return __('products.types.'.$item->type);
            })
            ->rawColumns(['type'])
        ->make(true);
    }
     public function orderlist(Request $request): object
    {

        $data = Order::whereHas('product')->where(function ($query) use ($request) {
            if ($request->filled('number')) {
                $query->where('number', $request->number);
            }
            if ($request->filled('date')) {
                $query->whereRaw('DATE(created_at) = ?', $request->date);
            }
        })->where('status','!=',Order::STATUS_PENDDING_X)
            ->OrderBy('id', 'DESC')->select('*');

        return DataTables::of($data)
            ->addIndexColumn()

            ->editColumn('status', function ($item) {
                $class="";
                switch ($item->status) {
                    case Order::STATUS_PENDDING:
                        $class="primary";
                        break;
                    case Order::STATUS_DONE:
                        $class="success";
                        break;
                    case Order::STATUS_REJECT:
                        $class="danger";
                        break;
                    default:
                        $class="primary";
                }
                return '<button type="button" class="btn btn-sm btn-outline-'.$class.' round waves-effect active border-0">' . strval(__('orders.statuses.' . $item->status)) . '</button>';
            })
            ->editColumn('type', function ($item) {
                return '<button type="button" class="btn btn-sm btn-outline-success round waves-effect active border-0">' . strval(__('orders.types.' . $item->type)) . '</button>';
            })
            ->editColumn('user', function ($item) {
                return $item->user?->name;
            })
            ->editColumn('change_status', function ($item) {
                $statusBtn = '';
                    if ($item->status == Order::STATUS_PENDDING) {
                            $statusBtn .= ' <a class="dropdown-item update_status" data-url="' . route('company.orders.changeToConfirmed') . '" data-order_id="' . $item->id . '"><i data-feather="check" class="font-medium-2"></i><span>' . __("orders.change_to_confirmed") . '</span></a>';

                            $statusBtn .= '<a class="dropdown-item  update_status" data-url="' . route('company.orders.changeToCanceled') . '"  data-order_id="' . $item->id . '"><i data-feather="x" class="x"></i><span>' . __("orders.change_to_canceled") . '</span></a>';
                    }
                return $statusBtn;
            })->editColumn('editUrl', function ($item) {
                $editBtn = '';
                    $editBtn = ' <a class="dropdown-item" href="' . route("company.orders.show", $item->id) . '">
                                <i data-feather="eye" class="font-medium-2"></i>
                                    <span> ' . __("products.actions.show") . '</span>
                                </a>';
                return $editBtn;
            })
            ->rawColumns([ 'status', 'change_status', 'editUrl','type','user'])
            ->make(true);
    }
}
