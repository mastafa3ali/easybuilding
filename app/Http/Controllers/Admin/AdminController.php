<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Media;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Question;
use App\Models\Section;
use App\Models\User;
use App\Models\WalletCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Response;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $viewIndex  = 'admin.pages.dashboard.index';

    public function index(Request $request)
    {
        // $codesCounts = WalletCode::count();
        // $codesChargedCounts = WalletCode::where('is_used', 1)->count();
        // $studentsCounts = User::where('type','student')->count();
        // $studentsTodayCounts = User::where('type','student')->whereDate('created_at', Carbon::today())->count();

        // $teachersCount = User::where('type', 'teacher')->count();
        // $coursesCount  = Course::count();
        // $questionsCount = Question::count();
        // $lessonsCount = Lesson::count();
        // $transactionsSum = Transaction::where('created_at', '>=', now()->subMonth(1))
        //                      ->sum('credit');
        // $transactionsTodaySum = Transaction::whereDate('created_at', Carbon::today())->sum('credit')*60;

        return view($this->viewIndex, get_defined_vars());
    }

    public function mm()
    {
        $lessons = Lesson::where('attachments', '!=', null)->get();

        foreach ($lessons as $lesson) {
            $attachments = explode(',', $lesson->attachments);
            $media = Media::whereIn('id', $attachments)->where('type', 'image')->first();
            if ($media) {
                $lesson->image = $media->id;
                $lesson->save();
            }
        }
    }

    public function reset()
    {
        Transaction::truncate();
        Lesson::query()->update([
            'views' => 0,
            'sales_num' => 0,
            'sales_amount' => 0,
        ]);
        Section::query()->update([
            'sales_num' => 0,
            'sales_amount' => 0,
        ]);
    }

    public function fixLogin()
    {
        User::whereNull('password')->where('type', 'student')
            ->update(['password' => Hash::make(11111111)]);
    }

    public function fixCodes()
    {
        Transaction::query()->update([
                               'debit' => 0,
                               'credit' => DB::raw("`total`")
                           ]);
    }
}
