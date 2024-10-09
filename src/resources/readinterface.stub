<?php
namespace App\Repository;

use Illuminate\Pagination\LengthAwarePaginator;


interface ReadRepositoryInterface
{
    public function get();
    public function find($id);
    public function findOrFail($id);
    public function all($columns = ['*'], $relations = []);
    public function allTrashed();
    public function findById($id, $columns=['*'], $relations=[], $append=[]);
    public function findByColumns($conditions, $columns=['*'], $relations=[]);
    public function findTrashedById($id);
    public function findOnlyTrashedById($id);
    public function first();
   // public function searchByValues(array $values, string $search);
    public function getPaginated(?string $q, ?string $sortBy,array $searchIn,array $validSortColumns, string $orderBy = 'asc', int $itemsPerPage = 15, int $page = 1): LengthAwarePaginator;

}


