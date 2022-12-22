<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\TransactionEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClassRoomResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\ListCoursesResource;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\TeacherResource;
use App\Http\Resources\UserResource;
use App\Models\ClassRoom;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonBooking;
use App\Models\Transaction;
use App\Models\Section;
use App\Models\Enrollment;
use App\Models\SectionBooking;
use App\Models\City;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use GLibs\HTTP\Response;

class CourseController extends Controller
{
    private $version = '1.0';

    public function states(Request $request)
    {
        return CityResource::collection(City::all())->additional([
            'success' => true,
            'message' => null,
            'errors' => null,
            'status'  => 200
        ]);
    }

    public function index(Request $request)
    {
        //        if($request->header('mobile_version') != '1.0.1') {
        //            return apiResponse(false, null, 'Version Not Identical.', null, 400);
        //        }
        $user = User::find(auth()->id());
        $items = Course::where(function ($query) use ($request, $user) {
            if ($request->filled('name')) {
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            }
            if ($user->classroom_id) {
                $query->where('classroom_id', $user->classroom_id);
            }
        })
            ->where('published', 1)
            ->with('teacher')
            ->with('classroom')
            ->with(['sections.lessons.videos', 'sections.lessons.urls', 'sections.lessons.quiz.quizResult'])
            ->paginate(20);

        return CourseResource::collection($items)->additional([
            'success' => true,
            'message' => null,
            'errors' => null,
            'status'  => 200
        ]);
    }
    public function teacherCourses($id)
    {
        $user = User::find(auth()->id());
        $items = Course::where('classroom_id', $user->classroom_id)
            ->where('teacher_id', $id)
            ->where('published', 1)
            ->get();

        return ListCoursesResource::collection($items)->additional([
            'success' => true,
            'message' => null,
            'errors' => null,
            'status'  => 200
        ]);
    }

    public function sticky(Request $request)
    {
        //        if($request->header('mobile_version') != '1.0.1') {
        //            return apiResponse(false, null, 'Version Not Identical.', null, 400);
        //        }
        $items = Course::where('sticky', 1)
            ->orderby('id', 'DESC')
            ->paginate(20);
        return CourseResource::collection($items)->additional([
            'success' => true,
            'message' => null,
            'errors' => null,
            'status'  => 200
        ]);
    }

    public function show(Request $request, $id)
    {
        //if($request->header('mobile_version') != '1.0.1') {
        //    return apiResponse(false, null, 'Version Not Identical.', null, 400);
        //}
        $item = Course::with('sections.lessons', 'sections.lessons.transaction', 'sections.lessons.quiz.quizResult', 'sections.transaction')->find($id);
        if (!$item) {
            return response()->json(
                [
                    'version' => $this->version,
                    'success' => false,
                    'status' => 404,
                    'message' => 'Not found.',
                ],
                400
            );
        }
        return new CourseResource($item);
    }

    public function bookSection(Request $request, $id)
    {
        //if($request->header('mobile_version') != '1.0.1') {
        //    return apiResponse(false, null, 'Version Not Identical.', null, 400);
        //}
        try {
            DB::beginTransaction();
            $item = Section::find($id);
            $user = User::find(auth()->id());

            $transactionBefore = Transaction::where('user_id', $user->id)
                ->where('model_type', 'section')
                ->where('model_id', $item->id)
                ->first();
            $studentsIncrement = $transactionBefore ? 0 : 1;
            $price = $item->price;

            if ($transactionBefore && $item->price2 > 0) {
                $price = $item->price2;
            }

            if ($user->wallet < $price) {
                return apiResponse(false, null, __('api.wallet_not_enough'), null, 400);
            }
            $latestTransaction = Transaction::latest()->where('user_id', auth()->id())->first();

            $transaction = new Transaction();
            $transaction->user_id = auth()->id();
            $transaction->transaction_type = TransactionEnum::SELL->value;
            $transaction->model_type = 'section';
            $transaction->model_id = $item->id;
            $transaction->course_id = $item->course_id;
            $transaction->debit = 0;
            $transaction->credit = $price;
            $transaction->total = $latestTransaction ? ($latestTransaction->total - $price) : -$price;
            $transaction->start_date = date('Y-m-d');
            $transaction->end_date = date('Y-m-d', strtotime("+10 day", strtotime(date('Y-m-d'))));
            $transaction->save();
            $enrollment = Enrollment::where(['user_id' => $user->id, 'course_id' => $item->course_id])->first();
            if (!$enrollment) {
                $enrollment = new Enrollment();
                $enrollment->user_id = $user->id;
                $enrollment->course_id = $item->course_id;
                $enrollment->save();
            }
            $user->wallet -= $price;
            $user->save();

            $item->sales_num += $studentsIncrement;
            $item->sales_amount += $price;
            $item->save();
            DB::commit();
            return apiResponse(true, null, null, null, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return apiResponse(false, null, null, null, 400);
        }
    }

    public function bookLesson(Request $request, $id)
    {
        //        if($request->header('mobile_version') != '1.0.1') {
        //            return apiResponse(false, null, 'Version Not Identical.', null, 400);
        //        }
        try {
            DB::beginTransaction();
            $item = Lesson::find($id);
            $user = User::find(auth()->id());

            $transactionLessonSectionBefore = Transaction::where('user_id', $user->id)
                ->where('model_type', 'section')
                ->where('model_id', $item->section_id)
                ->first();

            if ($transactionLessonSectionBefore) {
                return apiResponse(false, null, __('api.purchased_before'), null, 400);
            }

            $transactionBefore = Transaction::where('user_id', $user->id)
                ->where('model_type', 'lesson')
                ->where('model_id', $item->id)
                ->first();
            $studentsIncrement = $transactionBefore ? 0 : 1;
            $price = $item->price;

            if ($transactionBefore && $item->price2 > 0) {
                $price = $item->price2;
            }
            if ($user->wallet < $price) {
                return apiResponse(false, null, __('api.wallet_not_enough'), null, 400);
            }
            $latestTransaction = Transaction::latest()->where('user_id', auth()->id())->first();

            $transaction = new Transaction();
            $transaction->user_id = auth()->id();
            $transaction->transaction_type = TransactionEnum::SELL->value;
            $transaction->model_type = 'lesson';
            $transaction->model_id = $item->id;
            $transaction->course_id = $item->course_id;
            $transaction->debit = 0;
            $transaction->credit = $price;
            $transaction->total = $latestTransaction ? ($latestTransaction->total - $price) : -$price;
            $transaction->start_date = date('Y-m-d');
            $transaction->end_date = date('Y-m-d', strtotime("+10 day", strtotime(date('Y-m-d'))));
            $transaction->save();

            $enrollment = Enrollment::where(['user_id' => $user->id, 'course_id' => $item->course_id])->first();
            if (!$enrollment) {
                $enrollment = new Enrollment();
                $enrollment->user_id = $user->id;
                $enrollment->course_id = $item->course_id;
                $enrollment->save();
            }
            $user->wallet -= $price;
            $user->save();

            $item->sales_num += $studentsIncrement;
            $item->sales_amount += $price;
            $item->save();
            DB::commit();
            return apiResponse(true, null, null, null, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return apiResponse(false, null, null, null, 400);
        }
    }
}
