<?php
namespace App\Repository;
use App\Repository\ReadRepositoryInterface;
use App\Repository\WriteRepositoryInterface;
use ScriemCodat\Repository\AbstractRepository;


class Repository extends AbstractRepository implements ReadRepositoryInterface, WriteRepositoryInterface
{

    public function __construct($model)
    {
        $this->model = $model;
    }
}
