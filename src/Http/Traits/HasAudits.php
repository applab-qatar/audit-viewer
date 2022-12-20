<?php

namespace SeinOxygen\AuditViewer\Http\Traits;

use Illuminate\Support\Facades\Session;
use OwenIt\Auditing\Models\Audit;

trait HasAudits
{
    public function setModel()
    {
        return null;
    }
  
    public function audit($id)
    {

        $model = $this->setModel();

        if (! auth()->check()) {
            //abort (403, 'Only only logged in users can view the audit.');
        }

        $instance = app()->make($model);

        $audits = Audit::where('auditable_id', $id)->where('auditable_type', $this->setModel())->with('user')->orderBy('id', 'desc')->get();
        
        return view('audit-viewer::show', [
            'audits' => $audits,
            'model' => $instance,
            'id' => $id
        ]);
    }
}
