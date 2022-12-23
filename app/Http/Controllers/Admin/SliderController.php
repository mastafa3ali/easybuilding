<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Response;
use DataTables;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class SliderController extends Controller
{
    private $viewIndex  = 'admin.pages.sliders.index';
    private $viewEdit   = 'admin.pages.sliders.create_edit';
    private $viewShow   = 'admin.pages.sliders.show';
    private $route      = 'admin.sliders';

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
        $item = Slider::findOrFail($id);
        return view($this->viewEdit, get_defined_vars());
    }

    public function show($id): View
    {
        $item = Slider::findOrFail($id);
        return view($this->viewShow, get_defined_vars());
    }

    public function destroy($id): RedirectResponse
    {
        $item = Slider::findOrFail($id);
        if ($item->delete()) {
            flash(__('sliders.messages.deleted'))->success();
        }
        return to_route($this->route . '.index');
    }

    public function store(SliderRequest $request): RedirectResponse
    {
        if ($this->processForm($request)) {
            flash(__('sliders.messages.created'))->success();
        }
        return to_route($this->route . '.index');
    }

    public function update(SliderRequest $request, $id): RedirectResponse
    {
        $item = Slider::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('sliders.messages.updated'))->success();
        }
        return to_route($this->route . '.index');
    }

    protected function processForm($request, $id = null): Slider|null
    {
        $item = $id == null ? new Slider() : Slider::find($id);
        $data= $request->except(['_token', '_method']);

        $item = $item->fill($data);        if ($item->save()) {
            if ($request->hasFile('image')) {
                $item->image = storeFile($request->file('image'), 'sliders');
                $item->save();
            }
            return $item;
        }
        return null;
    }

    public function list(Request $request): JsonResponse
    {
        $data = Slider::select('*');
        return FacadesDataTables::of($data)
            ->addIndexColumn()
            ->addColumn('photo', function ($item) {
                return '<img src="' . $item->photo . '" height="100px" width="100px">';
            })
            ->rawColumns(['photo'])
            ->make(true);
    }
}
