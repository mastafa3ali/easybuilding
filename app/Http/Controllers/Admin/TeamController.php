<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamRequest;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class TeamController extends Controller
{
    private $viewIndex  = 'admin.pages.teams.index';
    private $viewEdit   = 'admin.pages.teams.create_edit';
    private $viewShow   = 'admin.pages.teams.show';
    private $route      = 'admin.teams';

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
        $item = Team::findOrFail($id);
        return view($this->viewEdit, get_defined_vars());
    }

    public function show($id): View
    {
        $item = Team::findOrFail($id);
        return view($this->viewShow, get_defined_vars());
    }

    public function destroy($id): RedirectResponse
    {
        $item = Team::findOrFail($id);
        if ($item->delete()) {
            flash(__('teams.messages.deleted'))->success();
        }
        return to_route($this->route . '.index');
    }

    public function store(TeamRequest $request): RedirectResponse
    {
        if ($this->processForm($request)) {
            flash(__('teams.messages.created'))->success();
        }
        return to_route($this->route . '.index');
    }

    public function update(TeamRequest $request, $id): RedirectResponse
    {
        $item = Team::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('teams.messages.updated'))->success();
        }
        return to_route($this->route . '.index');
    }

    protected function processForm($request, $id = null): Team|null
    {

        $item = $id == null ? new Team() : Team::find($id);
        $item = $item->fill($request->all());
        if ($item->save()) {
            if ($request->hasFile('image')) {
                $item->image = storeFile($request->file('image'), 'teams');
                $item->save();
            }
            return $item;
        }
        return null;
    }

    public function list(Request $request): JsonResponse
    {
        $data = Team::select('*');
        return FacadesDataTables::of($data)
            ->addIndexColumn()
            ->addColumn('photo', function ($item) {
                return '<img src="' . $item->photo . '" height="100px" width="100px">';
            })
            ->addColumn('type', function ($item) {
                return '<button class="btn btn-info">' . __('teams.types.' . $item->type) . '</button>';
            })
            ->rawColumns(['photo', 'type'])
            ->make(true);
    }
}
