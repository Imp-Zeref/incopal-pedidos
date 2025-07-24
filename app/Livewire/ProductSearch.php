<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Produto;

class ProductSearch extends Component
{
    public $search = '';
    public $sortColumn = 'codigo';
    public $sortDirection = 'asc';
    public const PER_PAGE = 25;
    public $perPage = self::PER_PAGE;

    public $totalProducts = 0;

    public function loadMore()
    {
        $this->perPage += self::PER_PAGE;
    }

    public function render()
    {
        $query = Produto::query();

        if (!empty(trim($this->search))) {
            $searchTerm = implode(' & ', array_filter(explode(' ', $this->search)));

            if (!empty($searchTerm)) {
                $query->whereRaw("search_vector @@ to_tsquery('portuguese', ?)", [$searchTerm]);
            }
        }

        $this->totalProducts = $query->count();

        $produtos = $query->orderBy($this->sortColumn, $this->sortDirection)
                          ->take($this->perPage)
                          ->get();

        return view('livewire.product-search', [
            'produtos' => $produtos
        ]);
    }
}