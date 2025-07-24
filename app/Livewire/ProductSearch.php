<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Produto;

class ProductSearch extends Component
{
    public $search = '';
    public $sortColumn = 'codigo';
    public $sortDirection = 'asc';
    public const PER_PAGE = 50;
    public $perPage = self::PER_PAGE;
    public $useCommaAsAnd = true;

    public $totalProducts = 0;

    public function sortBy($field)
    {
        if ($this->sortColumn === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function mount()
    {
        $this->totalProducts = Produto::count();
    }

    public function loadMore()
    {
        if ($this->perPage < $this->totalProducts) {
            $this->perPage += self::PER_PAGE;
        }
    }

    public function updatedSearch()
    {
        $this->perPage = self::PER_PAGE;
    }

    public function render()
    {
        $query = Produto::query();

        if (!empty(trim($this->search))) {
            if ($this->useCommaAsAnd) {
                $terms = preg_split('/\s*,\s*/', $this->search);
                $processedTerms = array_map(fn($term) => trim($term) . ':*', array_filter($terms));
                $searchString = implode(' & ', $processedTerms);
            } else {
                $terms = preg_split('/\s+/', $this->search);
                $processedTerms = array_map(fn($term) => trim($term) . ':*', array_filter($terms));
                $searchString = implode(' | ', $processedTerms);
            }

            if (!empty($searchString)) {
                $query->whereRaw("search_vector @@ to_tsquery('portuguese', unaccent(?))", [$searchString]);
            }
        }

        $this->totalProducts = $query->clone()->count();

        $produtos = $query->orderBy($this->sortColumn, $this->sortDirection)
            ->take($this->perPage)
            ->get();

        return view('livewire.product-search', [
            'produtos' => $produtos
        ]);
    }
}
