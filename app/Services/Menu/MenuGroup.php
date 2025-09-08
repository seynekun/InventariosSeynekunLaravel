<?php

namespace App\Services\Menu;


class MenuGroup implements MenuElement
{
    protected string $title;
    protected string $icon;
    protected bool $active;
    protected array $items = [];


    public function __construct(string $title, string $icon, bool $active = false)
    {
        $this->title = $title;
        $this->icon = $icon;
        $this->active = $active;
    }

    public function addItem(string $title, string $icon, string $route, bool $active = false): self
    {
        $this->items[] = new MenuLink(
            title: $title,
            icon: $icon,
            route: $route,
            active: $active,
        );
        return $this;
    }

    public function render(): string
    {
        return view('layouts.includes.admin.menu-group', [
            'title' => $this->title,
            'icon' => $this->icon,
            'active' => $this->active,
            'items' => $this->items,
        ])->render();
    }

    public function authorize(): bool
    {
        return true;
    }
}
