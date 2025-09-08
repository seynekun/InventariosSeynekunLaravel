<?php

namespace App\Services\Menu;


interface MenuElement
{
    public function render(): string;

    public function authorize(): bool;
}
