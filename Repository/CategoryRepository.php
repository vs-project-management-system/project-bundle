<?php
namespace PMS\Bundle\ProjectBundle\Entity\Repository;

use Gedmo\Sortable\Entity\Repository\SortableRepository;

class CategoryRepository extends SortableRepository
{
    public function findAllOrderedByUpdated()
    {
        return $this->getEntityManager()
                    ->createQuery('SELECT c FROM PMSProjectBundle:Category c ORDER BY c.updated ASC')
                    ->getResult();
    }
    
    public function search($query)
    {
        return $this->getEntityManager()
                ->createQuery($query)
                ->getResult();
    }
}
