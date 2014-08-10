<?php
namespace PMS\Bundle\ProjectBundle\Entity\Repository;

use Gedmo\Sortable\Entity\Repository\SortableRepository;

class StatusRepository extends SortableRepository
{
    public function findAllOrderedByUpdated()
    {
        return $this->getEntityManager()
                    ->createQuery('SELECT s FROM PMSProjectBundle:Status s ORDER BY s.updated ASC')
                    ->getResult();
    }
    
    public function search($query)
    {
        return $this->getEntityManager()
                ->createQuery($query)
                ->getResult();
    }
}
