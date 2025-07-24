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
    public $useCommaAsAnd = false;

    public $totalProducts = 0;

    public function loadMore()
    {
        $this->perPage += self::PER_PAGE;
    }

    public function render()
    {
        $query = Produto::query();

        if (!empty(trim($this->search))) {
            if ($this->useCommaAsAnd) {
                $terms = preg_split('/\s*,\s*/', $this->search);
                $searchString = implode(' ', array_filter($terms));
            } else {
                $searchString = $this->search;
            }

            if (!empty($searchString)) {
                $query->whereRaw("search_vector @@ plainto_tsquery('portuguese', unaccent(?))", [$searchString]);
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
