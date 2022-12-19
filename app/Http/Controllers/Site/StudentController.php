<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Readingcycle;
use App\Models\ReadingStudent;
use App\Models\Section;
use App\Models\Setting;
use App\Models\StudentTrack;
use App\Models\Track;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StudentController extends Controller
{
    private $viewIndex  = 'website.pages.students_achievement';
    private $achievement_panel  = 'website.pages.achievement_panel';
    public function index(Request $request)
    {
        $readingcycles = Readingcycle::where(function ($query) {
            if (session()->has('supervisorId')) {
                $query->where('supervisor_id', session('supervisorId'));
            }
        })->get();
        return view($this->viewIndex, get_defined_vars());
    }

    public function achievementPanel()
    {
        $students = User::where('type', User::TYPE_STUDENT)->get();
        $tracks = Track::all();

        return view($this->achievement_panel, get_defined_vars());
    }

    public function getStudents(Request $request)
    {
        $readingcycles = ReadingStudent::with('student')->where('readingcycle_id', $request->readingcycle_id)->get();
        return view('website.pages.studentslist', get_defined_vars());
    }

    public function partStore(Request $request)
    {

        $readingStudent = ReadingStudent::findOrFail($request->readingcycle_id);
        if ($readingStudent) {
            $key = "part_" . $request->part;
            if ($readingStudent->$key == 1) {
                $readingStudent->$key = 0;
            } else {
                $readingStudent->$key = 1;
            }
            $readingStudent->save();
        }
    }
    public function trackStore(Request $request)
    {
        $student_track = StudentTrack::where('student_id', $request->student_id)->where('track_id', $request->track_id)->first();
        if ($student_track) {
            $student_track->delete();
        } else {
            StudentTrack::create(['student_id' => $request->student_id, 'track_id' => $request->track_id]);
        }
    }


    public function show($id)
    {
        abort(404);
    }
    public function contactus(Request $request)
    {
        $item = new Contact();
        $item = $item->fill($request->all());
        $item->save();
        Session::flash('success', 'Success');
        return to_route('home');
    }


    public function list(Request $request)
    {
    }
}
