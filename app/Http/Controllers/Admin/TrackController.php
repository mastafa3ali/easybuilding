<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrackRequest;
use App\Models\StudentTrack;
use App\Models\Track;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class TrackController extends Controller
{
    private $viewIndex  = 'admin.pages.tracks.index';
    private $viewEdit   = 'admin.pages.tracks.create_edit';
    private $viewShow   = 'admin.pages.tracks.show';
    private $route      = 'admin.tracks';

    public function index(Request $request): View
    {
        return view($this->viewIndex, get_defined_vars());
    }

    public function create(): View
    {
        return view($this->viewEdit, get_defined_vars());
    }

    public function edit($id): View
    {
        $item = Track::findOrFail($id);
        return view($this->viewEdit, get_defined_vars());
    }

    public function show($id): View
    {
        $item = Track::findOrFail($id);
        return view($this->viewShow, get_defined_vars());
    }

    public function destroy($id): RedirectResponse
    {
        $item = Track::findOrFail($id);
        if ($item->delete()) {
            flash(__('tracks.messages.deleted'))->success();
        }
        return to_route($this->route . '.index');
    }

    public function store(TrackRequest $request): RedirectResponse
    {
        if ($this->processForm($request)) {
            flash(__('tracks.messages.created'))->success();
        }
        return to_route($this->route . '.index');
    }

    public function update(TrackRequest $request, $id): RedirectResponse
    {
        $item = Track::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('tracks.messages.updated'))->success();
        }
        return to_route($this->route . '.index');
    }

    protected function processForm($request, $id = null): Track|null
    {
        $item = $id == null ? new Track() : Track::find($id);
        $item = $item->fill($request->all());
        $item->active = $request->active ? true : false;
        $item->created_by = auth()->id();
        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function addStudent($id): View
    {
        $item = Track::findOrFail($id);
        $students = User::where('type', User::TYPE_STUDENT)->get();
        return view('admin.pages.tracks.addstudent', get_defined_vars());
    }
    public function storeTrackStudents(Request $request, $id): RedirectResponse
    {
        $item = Track::findOrFail($id);
        $trackStudents = $item->studentsTrack()->pluck('student_id')->toArray();
        $student_ids = [];
        if ($request->student_id) {
            $student_ids = $request->student_id;
        }
        $diffrent = array_diff($trackStudents, $student_ids);

        foreach ($diffrent as $key => $val) {
            StudentTrack::where('track_id', $id)->where('student_id', $diffrent[$key])->delete();
        }
        foreach ($student_ids as $student_id) {
            StudentTrack::updateOrCreate(
                [
                    'student_id' => $student_id,
                    'track_id' => $id,
                ]
            );
        }
        flash(__('tracks.messages.success'))->success();

        return back();
    }

    public function list(Request $request): JsonResponse
    {
        $data = Track::select('*');
        return FacadesDataTables::of($data)
            ->addIndexColumn()
            ->addColumn('created_by', function ($item) {
                return $item->user?->name;
            })
            ->addColumn('active', function ($item) {
                return $item->active ? '<button class="btn btn-sm btn-outline-success me-1 waves-effect">
                            <i data-feather="check"></i>
                        </button>' : '<button class="btn btn-sm btn-outline-danger me-1 waves-effect">
                            <i data-feather="x"></i>
                        </button>';
            })
            ->rawColumns(['active', 'created_by'])
            ->make(true);
    }
}
