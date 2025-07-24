<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Produto;

class ProductSearch extends Component
{
    public $search = '';
    public $matchAllWords = false;
    public $selectedColumns = []; 
    public $searchAllColumns = true;

    public $sortColumn = 'descricao';
    public $sortDirection = 'asc';
    public $perPage = 20;

    public $availableColumns = [
        'descricao' => 'Descrição',
        'original' => 'Original',
        'secundario' => 'Secundário',
        'localizacao' => 'Localização',
        'diversa' => 'Diversa'
    ];

    public function updatedSearchAllColumns($value)
    {
        if ($value) {
            $this->selectedColumns = [];
        }
    }

    public function updatedSelectedColumns($value)
    {
        if (!empty($value)) {
            $this->searchAllColumns = false;
        } else {
            $this->searchAllColumns = true;
        }
    }

    public function clearFilters()
    {
        $this->selectedColumns = [];
        $this->searchAllColumns = true;
        $this->sortColumn = 'descricao';
        $this->sortDirection = 'asc';
        $this->matchAllWords = false;
    }

    public function loadMore()
    {
        $this->perPage += 10;
    }

    public function render()
    {
        $query = Produto::query();

        $columnsToSearch = $this->searchAllColumns ? array_keys($this->availableColumns) : $this->selectedColumns;

        if (!empty($this->search) && !empty($columnsToSearch)) {
            $searchTerms = $this->matchAllWords ? explode(' ', $this->search) : [$this->search];
            
            $query->where(function ($q) use ($searchTerms, $columnsToSearch) {
                foreach ($searchTerms as $term) {
                    $q->where(function ($subQ) use ($term, $columnsToSearch) {
                        foreach ($columnsToSearch as $column) {
                            $subQ->orWhere($column, 'like', '%' . trim($term) . '%');
                        }
                    });
                }
            });
        }

        $produtos = $query->orderBy($this->sortColumn, $this->sortDirection)
                          ->take($this->perPage)
                          ->get();

        return view('livewire.product-search', [
            'produtos' => $produtos
        ]);
    }
}