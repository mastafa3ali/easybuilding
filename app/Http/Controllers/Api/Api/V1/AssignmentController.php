<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassRoomResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\AssignmentResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\TeacherResource;
use App\Http\Resources\UserResource;
use App\Models\ClassRoom;
use App\Models\Course;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\City;
use App\Models\Subject;
use App\Models\User;
use App\Models\QuizAnswer;
use App\Models\QuizResult;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use GLibs\HTTP\Response;

class AssignmentController extends Controller
{
    private $version = '1.0';

    public function index(Request $request)
    {
//        if($request->header('mobile_version') != '1.0.1') {
//            return apiResponse(false, null, 'Version Not Identical.', null, 400);
//        }
        $user  = User::find(auth()->id());
        $type  = $request->type ?? 1;
        $items = Quiz::leftjoin('quiz_result', function ($join) {
            $join->on('quizzes.id', '=', 'quiz_result.quiz_id')
                 ->where('quiz_result.user_id', '=', auth()->id());
        })
                    ->join('enrollments', function ($join) use ($user) {
                        $join->on('quizzes.course_id', '=', 'enrollments.course_id')
                            ->where('enrollments.user_id', '=', $user->id);
                    })
                    ->whereDate('date', '<=', Carbon::now())
                    ->where(function ($query) use ($request, $type, $user) {
                        if ($request->filled('type')) {
                            $query->where('type', $type);
                        }
                        if ($request->filled('subject_id')) {
                            $query->where('subject_id', $request->subject_id);
                        }
                        if ($request->filled('teacher_id')) {
                            $query->where('teacher_id', $request->teacher_id);
                        }
                        if ($request->filled('course_id')) {
                            $query->where('course_id', $request->course_id);
                        }
                        if ($request->filled('section_id')) {
                            $query->where('section_id', $request->section_id);
                        }
                        if ($request->filled('lesson_id')) {
                            $query->where('lesson_id', $request->lesson_id);
                        }
                        if ($user->classroom_id) {
                            $query->where('classroom_id', $user->classroom_id);
                        }
                    })
               ->where('is_exam', 0)
               ->with('classroom')
               ->with('teacher')
               ->with('subject')
               ->select('quizzes.*', 'quiz_result.marks AS quiz_result', 'quiz_result.quiz_id', 'quiz_result.in_progress')
               ->groupBy('quizzes.id')
               ->paginate(20);

        return AssignmentResource::collection($items)->additional([
            'success' => true,
            'message' => null,
            'errors' => null,
            'status'  => 200
        ]);
    }


    public function show(Request $request, $id)
    {
//        if($request->header('mobile_version') != '1.0.1') {
//            return apiResponse(false, null, 'Version Not Identical.', null, 400);
//        }
        $item = Quiz::where('is_exam', 0)
                    ->with('classroom')
                    ->with('teacher')
                    ->with('subject')
                    ->find($id);
        if (!$item) {
            return apiResponse(false, null, __('api.not_found'), null, 404);
        }
        $quizResult = QuizResult::latest()
                        ->where('user_id', auth()->id())
                        ->where('quiz_id', $item->id)
                        ->first();

        if (!$quizResult) {
            $quizResult = new QuizResult();
            $quizResult->marks = 0;
        }
        $quizResult->user_id = auth()->id();
        $quizResult->quiz_id = $item->id;
        $quizResult->in_progress = 1;
        $quizResult->save();

        $questionsIds = QuizQuestion::where('quiz_id', $id)->pluck('question_id')->toArray();
        $questions    = Question::with('options')->whereIn('id', $questionsIds)->get();
        $myAnswers    = QuizAnswer::where('user_id', auth()->id())->whereIn('question_id', $questionsIds)->select('question_id', 'answer', 'marks')->get();
        //$item['enrolled'] = count($myAnswers) > 0 ? 1 : 0;
        $item['answers_marks'] = $myAnswers->sum('marks') ?? 0;
        $item['questions']  = $questions;
        $item['my_answers'] = $myAnswers;

        $item['in_progress'] = $quizResult->in_progress;
        $item['quiz_result'] = $quizResult->marks;
        $item['quiz_id']     = $quizResult->quiz_id;

        return new AssignmentResource($item);
    }


    public function storeAnswers(Request $request, $id)
    {
//        if($request->header('mobile_version') != '1.0.1') {
//            return apiResponse(false, null, 'Version Not Identical.', null, 400);
//        }
        $validate = array(
            'answers' => 'required',
        );
        $validatedData = Validator::make($request->all(), $validate);
        if ($validatedData->fails()) {
            return apiResponse(false, null, __('api.validation_error'), $validatedData->errors()->all(), 422);
        }
        $item = Quiz::find($id);
        if (!$item) {
            return apiResponse(false, null, __('api.not_found'), null, 404);
        }
        $userId = auth()->id();
        $myAnswers = QuizAnswer::where('user_id', $userId)->where('quiz_id', $id)->count();
        if ($myAnswers > 0) {
            return apiResponse(false, null, __('api.answered_before'), null, 400);
        }
        $arr =[];
        $questionsIds = QuizQuestion::where('quiz_id', $id)->pluck('question_id')->toArray();
        $questions    = Question::whereIn('id', $questionsIds)->get();

        foreach ($request->answers as $answer) {
            $question  = $questions->where('id', $answer['question_id'])->first();
            $isCorrect = $question->correct == $answer['answer'] ? true : false;
            $arr =[
                'user_id'     => $userId,
                'quiz_id'     => $id,
                'question_id' => $answer['question_id'],
                'answer'      => $answer['answer'],
                'is_correct'  => $isCorrect,
                'marks'       => $isCorrect ? $question['marks'] : 0,
            ];
        }
        if (count($arr) > 0) {
            QuizAnswer::insert($arr);
            return apiResponse(true, null, null, null, 200);
        }
        return apiResponse(false, null, null, null, 400);
    }
}
