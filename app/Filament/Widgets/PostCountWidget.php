<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\Widget;

class PostCountWidget extends Widget
{
    protected static string $view = 'filament.pages.post-count-widget';

    public function getCount(): int
    {
        return Post::count();
    }
}
