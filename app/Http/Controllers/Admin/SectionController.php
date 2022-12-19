<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Models\Section;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class SectionController extends Controller
{
    private $viewIndex  = 'admin.pages.sections.index';
    private $viewEdit   = 'admin.pages.sections.create_edit';
    private $viewShow   = 'admin.pages.sections.show';
    private $route      = 'admin.sections';

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
        $item = Section::findOrFail($id);
        return view($this->viewEdit, get_defined_vars());
    }

    public function show($id): View
    {
        $item = Section::findOrFail($id);
        return view($this->viewShow, get_defined_vars());
    }

    public function destroy($id): RedirectResponse
    {
        $item = Section::findOrFail($id);
        if ($item->delete()) {
            flash(__('sections.messages.deleted'))->success();
        }
        return to_route($this->route . '.index');
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
        $item = Section::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('sections.messages.updated'))->success();
        }
        return to_route($this->route . '.index');
    }

    protected function processForm($request, $id = null): Section|null
    {
        $item = $id == null ? new Section() : Section::find($id);
        $item = $item->fill($request->all());
        if ($item->save()) {
            return $item;
        }
        return null;
    }

    public function list(Request $request): JsonResponse
    {
        $data = Section::select('*');
        return FacadesDataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
