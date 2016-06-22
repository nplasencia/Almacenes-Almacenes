<?php

namespace App\Http\ViewComposers;

class PaginationComposer
{
    public function compose($view) {
        $firstElement = ($view->paginationClass->currentPage()-1) * $view->paginationClass->perPage() + 1;
        $lastElement = $view->paginationClass->total();
        $total = $view->paginationClass->total();

        if ($view->paginationClass->currentPage() * $view->paginationClass->perPage() < $total) {
            $lastElement = $view->paginationClass->currentPage() * $view->paginationClass->perPage();
        }
        $view->paginationText = "Mostrando del $firstElement al $lastElement de $total registros";
    }
}