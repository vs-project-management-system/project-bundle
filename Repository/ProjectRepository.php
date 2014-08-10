<?php
namespace PMS\Bundle\ProjectBundle\Entity\Repository;

use Gedmo\Sortable\Entity\Repository\SortableRepository;

class ProjectRepository extends SortableRepository
{
    public function findAllOrderedByUpdated()
    {
        return $this->getEntityManager()
                ->createQuery('SELECT p FROM PMSProjectBundle:Project p ORDER BY p.updated ASC')
                ->getResult();
    }

    public function getRecent($limit = 3)
    {
        return $this->getEntityManager()
                ->createQuery('SELECT p FROM PMSProjectBundle:Project p ORDER BY p.updated ASC')
                ->setMaxResults($limit)
                ->getResult();
    }
    
    public function search($query)
    {
        return $this->getEntityManager()
                ->createQuery($query)
                ->getResult();
    }
}
