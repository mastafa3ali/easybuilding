<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class TermController extends Controller
{

    public function index(Request $request): View
    {
        $item = Term::where('company_id',auth()->user()->id)->first();
        $termsContent = '';
        if($item){
            $termsContent = $item->text;
        }
        return view('company.pages.terms.index', get_defined_vars());
    }

    public function create(): View
    {
        $item = Term::where('company_id',auth()->user()->id)->first();

        return view('company.pages.terms.index', get_defined_vars());
    }
    public function edit($id): View
    {
        $item = Term::findOrFail($id);
        return view('company.pages.terms.index', get_defined_vars());
    }

    public function destroy($id): RedirectResponse
    {
        $item = Term::findOrFail($id);
        if ($item->delete()) {
            flash(__('admin.messages.deleted'))->success();
        }
        return to_route('company.terms');
    }
    public function store(Request $request): RedirectResponse
    {
        if ($this->processForm($request)) {
            flash(__('admin.messages.created'))->success();
        }
        return to_route('company.terms');
    }
    public function update(Request $request, $id): RedirectResponse
    {
        $item = Term::findOrFail($id);
        if ($this->processForm($request, $id)) {
            flash(__('admin.messages.updated'))->success();
        }
        return to_route('company.terms');
    }

    protected function processForm($request, $id = null): Term|null
    {

        $item = Term::where('company_id', auth()->user()->id)->first();
        if(!$item){
            $item = new Term();
        }
        $item->company_id = auth()->user()->id;
        $item->text = $request->terms_content;
        if ($item->save()) {

            return $item;
        }
        return null;
    }




}
