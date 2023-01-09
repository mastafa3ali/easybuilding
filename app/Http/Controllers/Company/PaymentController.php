<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Payment;
use App\Models\PaymentCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use DataTables;

class PaymentController extends Controller
{
    private $viewIndex = 'teacher.pages.payments.index';
    private $viewCashback = 'teacher.pages.payments.cashback';
    private $route      = 'teacher.payments';

    public function __construct()
    {
    }

    public function index(Request $request)
    {
        return view($this->viewIndex, get_defined_vars());
    }

    public function paymentsList(Request $request)
    {
        $data = Transaction::join('users', 'transactions.user_id', '=', 'users.id')
            ->join('courses', 'courses.id', '=', 'transactions.course_id')
            ->where('courses.teacher_id', auth()->id())
            ->with('section.course')
            ->with('lesson')
            ->with('user')
            ->select('transactions.*', 'users.name as fullname', 'users.phone', 'users.email');

        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d H:i');
            })
            ->addColumn('model_type', function ($item) {
                return $item->model_type == 'section' ? 'باب/وحده' : 'درس';
            })
            ->addColumn('model_title', function ($item) {
                if ($item->model_type == 'section') {
                    $course = $item->section->course->name ?? '';
                    return $item->section ? $course .':'. $item->section->name : '';
                }
                return $item->lesson->name ?? '';
            })
            ->addColumn('actions', function ($item) {
                $actionsBtn = '<a href="#" class="btn btn-primary btn-xs delete_item" data-url="'.route($this->route.'.destroy', $item->id).'">حذف واسترجاع الفلوس</a>';
                return $actionsBtn;
            })
            ->filterColumn('fullname', function ($query, $keyword) {
                $query->where('users.name', 'LIKE', "%{$keyword}%");
            })
            ->filterColumn('phone', function ($query, $keyword) {
                $query->where('users.phone', 'LIKE', "%{$keyword}%");
            })
            ->rawColumns(['check','actions'])
            ->make(true);
    }

    public function cashback(Request $request)
    {
        return view($this->viewCashback, get_defined_vars());
    }

    public function cashbackList(Request $request)
    {
        $data = Payment::join('courses', 'courses.id', '=', 'transactions.course_id')
                        ->with('user')
                        ->where('courses.teacher_id', auth()->id())
                        ->select('transactions.*');

        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d H:i');
            })
            ->addColumn('user', function ($item) {
                return $item->user->name ?? '';
            })
            ->rawColumns(['check','actions'])
            ->make(true);
    }
}
