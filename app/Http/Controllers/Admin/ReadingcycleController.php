<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReadingcycleRequest;
use App\Models\Readingcycle;
use App\Models\ReadingStudent;
use App\Models\Track;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class ReadingcycleController extends Controller
{
    private $viewIndex  = 'admin.pages.readingcycles.index';
    private $viewEdit   = 'admin.pages.readingcycles.create_edit';
    private $viewShow   = 'admin.pages.readingcycles.show';
    private $route      = 'admin.readingcycles';

    public function index(Request $request): View
    {
        return view($this->viewIndex, get_defined_vars());
    }

    public function create(): View
    {
        $tracks = Track::all();
        $supervisors = User::where('type', User::TYPE_SUPERVISOR)->get();
        return view($this->viewEdit, get_defined_vars());
    }

    public function edit($id): View
    {
        $tracks = Track::all();
        $supervisors = User::where('type', User::TYPE_SUPERVISOR)->get();
        $item = Readingcycle::findOrFail($id);
        return view($this->viewEdit, get_defined_vars());
    }

    public function show($id): View
    {
        $item = Readingcycle::findOrFail($id);
        return view($this->viewShow, get_defined_vars());
    }

    public function destroy($id): RedirectResponse
    {
        $item = Readingcycle::findOrFail($id);
        if ($item->delete()) {
            flash(__('readingcycles.messages.deleted'))->success();
        }
        return to_route($this->route . '.index');
    }

    public function store(ReadingcycleRequest $request): RedirectResponse
    {
        if ($this->processForm($request)) {
            flash(__('readingcycles.messages.created'))->success();
        }
        return to_route($this->route . '.index');
    }

    public function update(ReadingcycleRequest $request, $id): RedirectResponse
    {
        $item = Readingcycle::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('readingcycles.messages.updated'))->success();
        }
        return to_route($this->route . '.index');
    }
    public function addStudent($id): View
    {
        $item = Readingcycle::findOrFail($id);
        $students = User::where('type', User::TYPE_STUDENT)->get();
        return view('admin.pages.readingcycles.addstudent', get_defined_vars());
    }
    public function storeReadingStudents(Request $request, $id): RedirectResponse
    {
        $item = Readingcycle::findOrFail($id);
        $readingStudents = $item->readingStudents()->pluck('student_id')->toArray();
        $student_ids = [];
        if ($request->student_id) {
            $student_ids = $request->student_id;
        }
        $diffrent = array_diff($readingStudents, $student_ids);

        foreach ($diffrent as $key => $val) {
            ReadingStudent::where('readingcycle_id', $id)->where('student_id', $diffrent[$key])->delete();
        }
        foreach ($student_ids as $student_id) {
            ReadingStudent::updateOrCreate(
                [
                    'student_id' => $student_id,
                    'readingcycle_id' => $id,
                ]
            );
        }
        flash(__('readingcycles.messages.success'))->success();

        return back();
    }

    protected function processForm($request, $id = null): Readingcycle|null
    {
        $item = $id == null ? new Readingcycle() : Readingcycle::find($id);
        $item = $item->fill($request->all());
        $item->active = $request->active ? true : false;
        $item->created_by = auth()->id();
        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request): JsonResponse
    {
        $data = Readingcycle::where(function ($query) {
            if (session('supervisorId')) {
                $query->where('supervisor_id', session('supervisorId'));
            }
        })->select('*');
        return FacadesDataTables::of($data)
            ->addIndexColumn()
            ->addColumn('created_by', function ($item) {
                return $item->user?->name;
            })
            ->addColumn('track', function ($item) {
                return $item->track?->name;
            })
            ->addColumn('supervisor', function ($item) {
                return $item->supervisor?->name;
            })
            ->addColumn('active', function ($item) {
                return $item->active ? '<button class="btn btn-sm btn-outline-success me-1 waves-effect">
                            <i data-feather="check"></i>
                        </button>' : '<button class="btn btn-sm btn-outline-danger me-1 waves-effect">
                            <i data-feather="x"></i>
                        </button>';
            })
            ->rawColumns(['active', 'created_by', 'track', 'supervisor'])
            ->make(true);
    }
}
