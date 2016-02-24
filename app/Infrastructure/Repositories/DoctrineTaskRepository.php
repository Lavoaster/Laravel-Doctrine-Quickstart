<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\TaskRepository;
use Doctrine\ORM\EntityRepository;

class DoctrineTaskRepository extends EntityRepository implements TaskRepository
{
    /**
     * Get all Tasks
     *
     * @param string $orderField
     * @param string $order
     *
     * @return \App\Domain\Entities\Task[]
     */
    public function all(string $orderField = 'id', string $order = 'ASC')
    {
        return $this->findBy([], [$orderField => $order]);
    }

    public function findByTaskName(string $name)
    {
        return $this->findBy(['name' => $name]);
    }

}
