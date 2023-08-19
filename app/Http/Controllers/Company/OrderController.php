<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\ApiNotification;
use App\Models\Order;
use App\Notifications\SendPushNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;
use Rap2hpoutre\FastExcel\Facades\FastExcel;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function __construct()
    {
    }


    public function index(Request $request)
    {
        return view('company.pages.orders.index');
    }



    public function list(Request $request): object
    {

        $data = Order::with('user')
        ->where('company_id', session('companyId'))
        ->where(function ($query) use ($request) {
            if ($request->filled('number')) {
                $query->where('number', $request->number);
            }
            if ($request->filled('date')) {
                $query->whereRaw('DATE(created_at) = ?', $request->date);
            }
        })->where('status', '!=', Order::STATUS_PENDDING_X)
            ->OrderBy('id', 'DESC')->select('*');

        return DataTables::of($data)
            ->addIndexColumn()

            ->editColumn('status', function ($item) {

                return '<button type="button" class="btn btn-sm btn-outline-primary round waves-effect active border-0">' . strval(__('orders.statuses.' . $item->status)) . '</button>';
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
                    $statusBtn .= ' <a class="dropdown-item update_status" data-url="' . route('company.orders.changeToConfirmed') . '" data-order_id="' . $item->id . '" data-status="0"><i data-feather="check" class="font-medium-2"></i><span>' . __("orders.change_to_confirmed") . '</span></a>';

                    $statusBtn .= '<a class="dropdown-item  update_status" data-url="' . route('company.orders.changeToCanceled') . '"  data-order_id="' . $item->id . '" data-status="1"><i data-feather="x" class="x"></i><span>' . __("orders.change_to_canceled") . '</span></a>';
                }
                if ($item->status == Order::STATUS_ONPROGRESS) {
                    $statusBtn .= ' <a class="dropdown-item update_status" data-url="' . route('company.orders.changeTopRrogress') . '" data-order_id="' . $item->id . '" data-status="0"><i data-feather="check" class="font-medium-2"></i><span>' . __("orders.change_to_progress") . '</span></a>';
                }
                if ($item->status == Order::STATUS_ON_WAY) {
                    $statusBtn .= ' <a class="dropdown-item update_status" data-url="' . route('company.orders.changeToDeliverd') . '" data-order_id="' . $item->id . '" data-status="0"><i data-feather="check" class="font-medium-2"></i><span>' . __("orders.change_to_deliverd") . '</span></a>';
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

    public function changeToConfirmed(Request $request): RedirectResponse
    {
        try {
            $item = Order::findOrFail($request->order_id);
            $item->update(['status' => Order::STATUS_ONPROGRESS]);
            $fcmTokens[] = $item->user?->fcm_token;
            $message = __('api.order_confirmed', ['code'=>$item->code]);
            $notifications = [
                    'user_id'=>$item->user_id,
                    'text'=>$message,
                    'day'=>date('Y-m-d'),
                    'time'=>date('H:i'),
                ];
            ApiNotification::create($notifications);
            Notification::send(null, new SendPushNotification($message, $fcmTokens));
            flash(__('orders.messages.updated'))->success();
        } catch (\Exception $e) {
            flash($e->getMessage())->error();
        }
        return back();
    }
    public function changeTopRrogress(Request $request): RedirectResponse
    {
        try {
            $item = Order::findOrFail($request->order_id);
            $item->update(['status' => Order::STATUS_ON_WAY]);
            $fcmTokens[] = $item->user?->fcm_token;
            $message = __('api.order_confirmed', ['code'=>$item->code]);
            $notifications = [
                    'user_id'=>$item->user_id,
                    'text'=>$message,
                    'day'=>date('Y-m-d'),
                    'time'=>date('H:i'),
                ];
            ApiNotification::create($notifications);
            Notification::send(null, new SendPushNotification($message, $fcmTokens));
            flash(__('orders.messages.updated'))->success();
        } catch (\Exception $e) {
            flash($e->getMessage())->error();
        }
        return back();
    }
    public function changeToDeliverd(Request $request): RedirectResponse
    {
        try {
            $item = Order::findOrFail($request->order_id);
            $item->update(['status' => Order::STATUS_DELIVERD]);
            $fcmTokens[] = $item->user?->fcm_token;
            $message = __('api.order_deliverd', ['code'=>$item->code]);
            $notifications = [
                    'user_id'=>$item->user_id,
                    'text'=>$message,
                    'day'=>date('Y-m-d'),
                    'time'=>date('H:i'),
                ];
            ApiNotification::create($notifications);
            Notification::send(null, new SendPushNotification($message, $fcmTokens));
            flash(__('orders.messages.updated'))->success();
        } catch (\Exception $e) {
            flash($e->getMessage())->error();
        }
        return back();
    }
    public function changeToCanceled(Request $request): RedirectResponse
    {
        try {
            $item = Order::findOrFail($request->order_id);
            $item->update(['status' => Order::STATUS_REJECTED,'reason'=>$request->reason]);
            $fcmTokens[] = $item->user?->fcm_token;
            $message = __('api.order_canceled', ['code'=>$item->code]);
            $message .= ' '.$request->reason;
            $notifications = [
                    'user_id'=>$item->user_id,
                    'text'=>$message,
                    'day'=>date('Y-m-d'),
                    'time'=>date('H:i'),
                ];
            ApiNotification::create($notifications);
            Notification::send(null, new SendPushNotification($message, $fcmTokens));

            flash(__('orders.messages.updated'))->success();
        } catch (\Exception $e) {
            flash($e->getMessage())->error();
        }
        return back();
    }


    public function edit($id): View
    {
        $item = Order::findOrFail($id);

        return view('company.pages.orders.create_edit', ['item' => $item]);
    }


    public function show($id): View
    {
        $item = Order::findOrFail($id);

        return view('company.pages.orders.create_edit', ['item' => $item]);
    }
    public function download(Request $request)
    {
        $orders =  Order::whereHas('product', function ($query) {
            $query->where('company_id', session('companyId'));
        })->get()->toArray();

        return FastExcel::data($orders)->download('orders.xlsx', function ($item) {

            return [
                __('books.sub_sender_name') => $item['order_details']['sub_sender_name'] ?? '',
                __('books.sender_name') => $item['order_details']['sender_name'] ?? '',
                __('books.sender_phone') => $item['order_details']['sender_phone'] ?? '',
                __('books.sender_government') => $item['order_details']['sender_government'] ? getGovernment($item['order_details']['sender_government']) : '',
                __('books.sender_area') => $item['order_details']['sender_area'] ?? '',
                __('books.sender_address') => $item['order_details']['sender_address'] ?? '',
                __('books.order_num') => $item['number'] ?? '',
                __('books.order_content') => $item['order_details']['order_content'] ?? '',
                __('books.order_status') => __('orders.statuses.' . $item['status']),
                __('books.sender_email') => $item['order_details']['sender_email'] ?? '',
                __('books.followup_number') => $item['order_details']['followup_number'] ?? '',
            ];
        });
    }
    public function destroy($id): RedirectResponse
    {
        try {
            $item = Order::whereHas('product', function ($query) {
                $query->where('company_id', session('companyId'));
            })->findOrFail($id);
            $item->delete();
            flash(__('orders.messages.deleted'))->success();
        } catch (\Exception $e) {
            flash($e->getMessage())->error();
        }
        return back();
    }
}
