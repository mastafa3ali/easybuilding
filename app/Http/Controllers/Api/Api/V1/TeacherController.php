<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Transaction;
use App\Models\Lesson;
use App\Models\Product;
use App\Models\User;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function dashboard(Request $request)
    {
        $lessonsCount = Lesson::join('courses', 'courses.id', '=', 'lessons.course_id')
                              ->where('courses.teacher_id', auth()->id())
                              ->count();

        $studentsCount = User::join('transactions', 'users.id', '=', 'transactions.user_id')
                        ->join('courses', 'courses.id', '=', 'transactions.course_id')
                        ->where('courses.teacher_id', auth()->id())
                        ->count();

        $transactionsCount = Transaction::join('users', 'transactions.user_id', '=', 'users.id')
                        ->join('courses', 'courses.id', '=', 'transactions.course_id')
                        ->where('courses.teacher_id', auth()->id())
                        ->count();

        $transactionsSum = Transaction::join('users', 'transactions.user_id', '=', 'users.id')
                        ->join('courses', 'courses.id', '=', 'transactions.course_id')
                        ->where('courses.teacher_id', auth()->id())
                        ->sum('credit');

        $data = [
            'lessonsCount' => $lessonsCount,
            'studentsCount' => $studentsCount,
            'transactionsCount' => $transactionsCount,
            'transactionsSum' => $transactionsSum,
        ];

        return apiResponse(true, $data, null, null, 200);
    }
}
