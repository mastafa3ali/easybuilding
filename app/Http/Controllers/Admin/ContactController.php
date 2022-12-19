<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class contactController extends Controller
{
    private $viewIndex  = 'admin.pages.contacts.index';
    private $route      = 'admin.contacts';

    public function index(Request $request): View
    {
        return view($this->viewIndex, get_defined_vars());
    }

    public function destroy($id): RedirectResponse
    {
        $item = contact::findOrFail($id);
        if ($item->delete()) {
            flash(__('contacts.messages.deleted'))->success();
        }
        return to_route($this->route . '.index');
    }


    public function list(Request $request): JsonResponse
    {
        $data = contact::select('*');
        return FacadesDataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
