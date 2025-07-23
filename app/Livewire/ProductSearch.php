<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Produto;

class ProductSearch extends Component
{
    public $search = '';
    public $matchAllWords = false;
    public $selectedColumns = []; 
    public $searchAllColumns = true; // Nova propriedade para o checkbox "Todas"

    public $sortColumn = 'nome';
    public $sortDirection = 'asc';
    public $perPage = 20;

    public $availableColumns = [
        'nome' => 'Nome',
        'descricao' => 'Descrição',
        'original' => 'Original',
        'secundario' => 'Secundário',
        'localizacao' => 'Localização',
        'diversa' => 'Diversa'
    ];

    // Hook: Executado quando 'searchAllColumns' é alterado
    public function updatedSearchAllColumns($value)
    {
        if ($value) {
            $this->selectedColumns = []; // Se marcou "Todas", limpa as outras seleções
        }
    }

    // Hook: Executado quando 'selectedColumns' é alterado
    public function updatedSelectedColumns($value)
    {
        // Se selecionou alguma coluna individual, desmarca "Todas"
        if (!empty($value)) {
            $this->searchAllColumns = false;
        } else {
            // Se limpou todas as seleções, volta a marcar "Todas"
            $this->searchAllColumns = true;
        }
    }

    public function clearFilters()
    {
        $this->selectedColumns = [];
        $this->searchAllColumns = true;
        $this->sortColumn = 'nome';
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

        // Determina em quais colunas buscar
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