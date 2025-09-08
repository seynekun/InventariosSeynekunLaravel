<?php

namespace App\Services\Menu;


class MenuLink implements MenuElement

{
    protected string $title;
    protected string $icon;
    protected string $route;
    protected bool $active;



    public function __construct(string $title, string $icon, string $route, bool $active = false)
    {
        $this->title = $title;
        $this->icon = $icon;
        $this->route = $route;
        $this->active = $active;
    }


    public function render(): string
    {
        return view('layouts.includes.admin.menu-link', [
            'title' => $this->title,
            'icon' => $this->icon,
            'route' => $this->route,
            'active' => $this->active,
        ])->render();
    }

    public function authorize(): bool
    {
        return true;
    }
}
