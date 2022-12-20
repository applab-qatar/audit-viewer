<?php

namespace SeinOxygen\AuditViewer\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $audits = Audit::with('user')->when($request->search, 
            function($query) use ($request) {
                $query->where('auditable_type', 'like', '%'.$request->search.'%')
                ->orWhere('event', 'like', '%'.$request->search.'%');
            }
        )->orderBy('id', 'desc')->paginate()->appends(request()->input());

        return view('audit-viewer::index', [
            'audits' => $audits
        ]);
    }

    public function show($id)
    {
        $audits = Audit::where('id', $id)->with('user')->orderBy('id', 'desc')->get();

        return view('audit-viewer::show', [
            'audits' => $audits
        ]);
    }

    public function model($model, $id = null)
    {
        if($id) {
            $audits = Audit::where('auditable_id', $id)->where('auditable_type', $model)->with('user')->orderBy('id', 'desc')->get();
        } else {
            $audits = Audit::where('auditable_type', $model)->with('user')->orderBy('id', 'desc')->paginate();
        }

        return view($id ? 'audit-viewer::show' : 'audit-viewer::index', [
            'audits' => $audits
        ]);
    }

    public function rollback($id, $field = null)
    {
        $audit = Audit::findOrFail($id);

        $model = $audit->auditable_type;
        
        $model = app()->make($model)->find($audit->auditable_id);
        if($model) {
            if($field) {
                $model->{$field} = $audit->old_values[$field];
            } 
            else {
                $model->fill($audit->old_values);
            }
            $model->save();
        }

        return redirect()->back()->with('success', 'Rollback success!');
    }
}