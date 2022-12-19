<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Models\Transaction;
use App\Models\Section;
use App\Models\SectionBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use DataTables;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SectionController extends Controller
{
    private $viewIndex  = 'teacher.pages.sections.index';
    private $viewEdit   = 'teacher.pages.sections.create_edit';
    private $viewShow   = 'teacher.pages.sections.show';
    private $viewBooking  = 'teacher.pages.sections.transactions';
    private $route      = 'teacher.sections';

    public function __construct()
    {
    }

    public function index(Request $request)
    {
        return view($this->viewIndex, get_defined_vars());
    }

    public function edit($id)
    {
        $item = Section::findOrFail($id);

        if (!$item) {
            abort(404);
        }

        return view($this->viewEdit, get_defined_vars());
    }

    public function create(): View
    {
        return view($this->viewEdit, get_defined_vars());
    }

    public function show($id)
    {
        $item = Section::join('courses', 'courses.id', '=', 'sections.course_id')
            ->where('courses.teacher_id', auth()->id())
            ->findOrFail($id);

        if (!$item) {
            abort(404);
        }
        return view($this->viewShow, get_defined_vars());
    }

    public function store(SectionRequest $request): RedirectResponse
    {
        if ($this->processForm($request)) {
            flash(__('sections.messages.created'))->success();
        }
        return to_route($this->route . '.index');
    }


    public function update(SectionRequest $request, $id): RedirectResponse
    {
        $item = Section::where(function ($query) {
            if (session()->has('teacherId')) {
                $query->where('teacher_id', session('teacherId'));
            }
        })
            ->findOrFail($id);

        if ($this->processForm($request, $id)) {
            flash(__('sections.messages.updated'))->success();
        }
        return to_route($this->route . '.index');
    }

    protected function processForm($request, $id = null): Section | null
    {
        $item = $id == null ? new Section() : Section::find($id);
        $item->teacher_id = session('teacherId');
        $item = $item->fill($request->all());
        return $item->save() ? $item : null;
    }


    public function list(Request $request)
    {
        $data = Section::join('courses', 'courses.id', '=', 'sections.course_id')
            ->where(function ($query) use ($request) {
                if ($request->filled('name')) {
                    $query->where('name', 'LIKE', '%' . $request->name . '%');
                }
                if ($request->filled('course_id')) {
                    $query->where('course_id', $request->course_id);
                }
            })
            ->where('courses.teacher_id', auth()->id())
            ->with('course:id,name')
            ->select('sections.*');

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('check', function ($item) {
                return '<div class="checkbox text-center">
                            <input type="checkbox" class="row_check" id="id_' . $item->id . '" form="deleteForm" name="id[]" value="' . $item->id . '" >
                            <label for="id_' . $item->id . '"></label>
                        </div>';
            })
            ->addColumn('course', function ($item) {
                return $item->course->name ?? '';
            })
            ->addColumn('students_sum', function ($item) {
                return Transaction::where('model_type', 'section')->where('model_id', $item->id)->count();
            })
            ->addColumn('amount_sum', function ($item) {
                return Transaction::where('model_type', 'section')->where('model_id', $item->id)->sum('total') + 0;
            })
            ->addColumn('actions', function ($item) {
                $actionsBtn = '<a href="' . route('teacher.sections.transactions', $item->id) . '" class="btn-actions btn-xs">' . __('sections.transactions') . '</a>
                               <a href="' . route('teacher.sections.edit', $item->id) . '" class="btn-actions btn-xs"><i class="fa fa-eye"></i></a>';
                return $actionsBtn;
            })
            ->rawColumns(['check', 'actions'])
            ->make(true);
    }


    public function select(Request $request)
    {
        $q = $request->q;
        $data = Section::where(function ($query) use ($request) {
            if ($request->filled('course_id')) {
                $query->where('course_id', $request->course_id);
            }
        })
            ->select('id', 'name AS text', 'course_id')
            //->take(10)
            ->get();

        if ($request->filled('pure_select')) {
            $html = '<option value="">' . __('sections.select') . '</option>';
            foreach ($data as $section) {
                $html .= '<option value="' . $section->id . '">' . $section->text . '</option>';
            }
            return $html;
        }
        return response()->json($data);
    }


    public function transactions($id)
    {
        $section = Section::findOrFail($id);
        $items   = Transaction::with('user')->where('model_id', $section->id)->where('model_type', 'section')->paginate(20);
        return view($this->viewBooking, get_defined_vars());
    }
}
