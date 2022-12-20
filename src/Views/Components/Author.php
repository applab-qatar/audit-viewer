<?php

namespace SeinOxygen\AuditViewer\Views\Components;

use Illuminate\View\Component;

class Author extends Component{

    public $user;
    public $avatar;
    public $size;

    public function __construct($user, $size = 100)
    {
        $this->user = $user;
        $this->size = $size;

        $email = $user->email ?? null;
        $name = $user->name ?? null;

        $default = 'retro';

        if(!empty($name)) {
            $default = 'https://ui-avatars.com/api/'.urlencode($name).'/'.($size * 2);
        }
        
        $this->avatar = 'https://www.gravatar.com/avatar/' . md5($email) . '?s='.($size * 2).'&d='.$default;
    }

    public function render()
    {
        return view('audit-viewer::components.author');
    }
}