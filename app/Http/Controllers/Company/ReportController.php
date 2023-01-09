<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\_Class;
use App\Models\Transaction;
use App\Models\ClassRoom;
use App\Models\ClassUser;
use App\Models\LessonSeen;
use App\Models\SectionBooking;
use App\Models\User;
use App\Models\Section;
use App\Models\Lesson;
use App\Models\WalletCodeBooking;
use App\Utilities\WhatsappHelper;
use DataTables;
use Illuminate\Http\Request;
use Response;
use Rap2hpoutre\FastExcel\FastExcel;

class ReportController extends Controller
{
    public function studentsReport2(Request $request)
    {
        $classrooms = ClassRoom::all();
        return view('teacher.pages.reports.students2', get_defined_vars());
    }

    public function downloadStudentsReport2(Request $request)
    {
        $title = 'lessonsStudentsReport.xlsx';
        $request_item = $request->item_id;
        if ($request->item_id == null) {
            $request_item = [];
        }
        if ($request->filter_type == 'lesson') {
            $items = Lesson::join('transactions', function ($join) {
                $join->on('lessons.id', '=', 'transactions.model_id')
                    ->where('transactions.model_type', 'lesson');
            })
                ->join('users', 'users.id', '=', 'transactions.user_id')
                ->leftJoin('quiz_result', function ($join) {
                    $join->on('lessons.quiz_id', '=', 'quiz_result.quiz_id')
                        ->where('quiz_result.user_id', auth()->id());
                })
                ->whereIn('lessons.id', $request_item)
                ->select('users.*', 'quiz_result.marks')
                ->groupby('users.id')
                ->get();
        } else {
            $title = 'sectionsStudentsReport.xlsx';

            $items = Section::join('transactions', function ($join) {
                $join->on('sections.id', '=', 'transactions.model_id')
                    ->where('transactions.model_type', 'section');
            })
                ->join('users', 'users.id', '=', 'transactions.user_id')
                ->whereIn('sections.id', $request_item)
                ->select('users.*')
                ->groupby('users.id')
                ->get();
        }

        return (new FastExcel($items))->download($title, function ($user) {
            return [
                __('admin.name') => $user->name,
                __('admin.phone') => $user->phone,
                __('admin.parent_phone') => $user->parent_phone,
                __('admin.quiz_marks') => $user->marks ?? '',
            ];
        });
    }

    public function lessonsReport(Request $request)
    {
        $classrooms = ClassRoom::all();
        return view('teacher.pages.reports.lessons', get_defined_vars());
    }

    public function downloadLessonsReport(Request $request)
    {
        $lessons = Lesson::join('courses', 'lessons.course_id', '=', 'courses.id')
            ->where(function ($query) use ($request) {
                if ($request->filled('classroom_id')) {
                    $query->where('courses.classroom_id', $request->classroom_id);
                }
            })
            ->where('courses.teacher_id', auth()->id())
            ->select('lessons.*', 'courses.name as course_name')
            ->get();

        foreach ($lessons as $lesson) {
            $lesson['students_sum'] = Transaction::where('model_type', 'lesson')->where('model_id', $lesson->id)->count();
            $lesson['amount_sum'] = Transaction::where('model_type', 'lesson')->where('model_id', $lesson->id)->sum('amount') + 0;
            $lesson['views'] = LessonSeen::where('lesson_id', $lesson->id)->count();
        }

        return (new FastExcel($lessons))->download('lessonsReport.xlsx', function ($lesson) {
            return [
                __('lessons.default.name') => $lesson->name,
                __('lessons.course') => $lesson->course_name,
                __('lessons.views') => $lesson->views,
                __('lessons.price') => $lesson->price,
                __('lessons.students_count') => $lesson->students_sum,
                __('lessons.total') => $lesson->amount_sum,
            ];
        });
    }
}
