<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RateRequest;
use App\Models\Rate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class RateController extends Controller
{
    private $viewIndex  = 'admin.pages.rates.index';
    private $viewEdit   = 'admin.pages.rates.create_edit';
    private $viewShow   = 'admin.pages.rates.show';
    private $route      = 'admin.rates';

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
        $item = Rate::findOrFail($id);
        return view($this->viewEdit, get_defined_vars());
    }

    public function show($id): View
    {
        $item = Rate::findOrFail($id);
        return view($this->viewShow, get_defined_vars());
    }

    public function destroy($id): RedirectResponse
    {
        $item = Rate::findOrFail($id);
        if ($item->delete()) {
            flash(__('rates.messages.deleted'))->success();
        }
        return to_route($this->route . '.index');
    }

    public function store(RateRequest $request): RedirectResponse
    {
        if ($this->processForm($request)) {
            flash(__('rates.messages.created'))->success();
        }
        return to_route($this->route . '.index');
    }

    public function update(RateRequest $request, $id): RedirectResponse
    {
        $item = Rate::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('rates.messages.updated'))->success();
        }
        return to_route($this->route . '.index');
    }

    protected function processForm($request, $id = null): Rate|null
    {
        $item = $id == null ? new Rate() : Rate::find($id);
        $data = $request->except(['_token', '_method']);

        $item = $item->fill($data);
        if ($item->save()) {


            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = time() . rand(0, 999999999) . '.' . $image->getClientOriginalExtension();
                $item->image->move(public_path('storage/rates'), $fileName);
                $item->image = $fileName;
                $item->save();
            }
            return $item;
        }
        return null;
    }

    public function list(Request $request): JsonResponse
    {
        $data = Rate::select('*');
        return FacadesDataTables::of($data)
            ->addIndexColumn()
            ->addColumn('photo', function ($item) {
                return '<img src="' . $item->photo . '" height="100px" width="100px">';
            })
             ->filterColumn('title', function ($query, $keyword) {
                 if(App::isLocale('en')) {
                     return $query->where('title_en', 'like', '%' . $keyword . '%');
                 } else {
                     return $query->where('title_ar', 'like', '%' . $keyword . '%');
                 }
             })
            ->rawColumns(['photo'])
            ->make(true);
    }
}
