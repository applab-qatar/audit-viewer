<?php

namespace SeinOxygen\AuditViewer\Views\Components;

use Illuminate\View\Component;

class Badge extends Component{

    public $event;
    public $background;

    public function __construct($event)
    {
        $this->background = 'bg-secondary';

        switch ($event) {
            case 'created':
                $this->background = 'bg-success';
                break;
            case 'updated':
                $this->background = 'bg-warning';
                break;
            case 'deleted':
                $this->background = 'bg-danger';
                break;
            case 'restored':
                $this->background = 'bg-info';
                break;
        }

        $this->event = $event;
    }

    public function render()
    {
        return view('audit-viewer::components.badge');
    }
}