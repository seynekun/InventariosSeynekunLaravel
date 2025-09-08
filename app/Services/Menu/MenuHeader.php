<?php

namespace App\Services\Menu;

class MenuHeader implements MenuElement
{

    protected string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function render(): string
    {
        return view('layouts.includes.admin.menu-header', [
            'title' => $this->title,
        ])->render();
    }

    public function authorize(): bool
    {
        return true;
    }
}
