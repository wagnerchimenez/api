<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\Persistence\ObjectRepository;

class InMemoryAbstractRepository implements ObjectRepository
{
    /** @return object|null */
    public function find($id)
    {
        return null;
    }

    /** @return array<int, object> */
    public function findAll()
    {
        return [];
    }

    /** @return array<int, object> */
    public function findOneBy(array $criteria)
    {
        return [];
    }

    /** @return object[] */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
    {
        return [];
    }

    /** @return string */
    public function getClassName()
    {
        return '';
    }
}
