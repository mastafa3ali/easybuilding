<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Models\Lesson;
use App\Models\News;
use App\Models\Section;
use App\Models\TeacherUser;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class NewghaithController extends Controller
{
    private $viewIndex  = 'admin.pages.newghaith.index';
    private $viewEdit   = 'admin.pages.newghaith.create_edit';
    private $viewShow   = 'admin.pages.newghaith.show';
    private $route      = 'admin.newghaith';

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
        $item = News::findOrFail($id);
        return view($this->viewEdit, get_defined_vars());
    }

    public function show($id): View
    {
        $item = News::findOrFail($id);
        return view($this->viewShow, get_defined_vars());
    }

    public function destroy($id): RedirectResponse
    {
        $item = News::findOrFail($id);
        if ($item->delete()) {
            flash(__('newghaith.messages.deleted'))->success();
        }
        return to_route($this->route . '.index');
    }

    public function store(NewsRequest $request): RedirectResponse
    {
        if ($this->processForm($request)) {
            flash(__('newghaith.messages.created'))->success();
        }
        return to_route($this->route . '.index');
    }

    public function update(NewsRequest $request, $id): RedirectResponse
    {
        $item = News::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('newghaith.messages.updated'))->success();
        }
        return to_route($this->route . '.index');
    }

    protected function processForm($request, $id = null): News | null
    {
        $item = $id == null ? new News() : News::find($id);
        $item->created_by = auth()->id();
        $item = $item->fill($request->all());

        if ($item->save()) {
            if ($request->hasFile('image')) {
                $item->image = storeFile($request->file('image'), 'news');
                $item->save();
            }
            return $item;
        }
        return null;
    }

    public function list(Request $request): JsonResponse
    {
        $data = News::select('*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('photo', function ($item) {
                return '<img src="'.$item->photo.'" height="100px" width="100px">';
            })
            ->rawColumns(['photo'])
            ->make(true);
    }

    public function select(Request $request): JsonResponse
    {
        $q = $request->q;
        $data = News::distinct()
            ->where('type', 'teacher')
            ->where(function ($query) use ($q, $request) {
                if (!empty($q)) {
                    $query->where('name', 'LIKE', '%' . $q . '%');
                }
                if ($request->filled('subject_id')) {
                    $query->where('subject_id', $request->subject_id);
                }
            })
            ->select('id', 'name AS text')
            ->take(10)
            ->get();
        return response()->json($data);
    }

    
    public function generateUniqueCode()
    {
        $code = mt_rand(1, 1000000);
        if (News::where('code', $code)->exists()) {
            $this->generateUniqueCode();
        }
        return $code;
    }
}
