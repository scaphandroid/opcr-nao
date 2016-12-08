<?php

namespace NAO\PlatformBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    function getComptesNatNonValides() {
        $qb = $this->createQueryBuilder('user')
            ->where('user.typeCompte = :typeCompte')
            ->andWhere('user.enAttente = :enAttente')
            ->setParameters(array(
                'typeCompte' => 0,
                'enAttente' => true
        ));
        return $qb->getQuery()->getResult();
    }

    function getComptesNat(){
        $qb = $this->createQueryBuilder('user')
            ->where('user.typeCompte = :typeCompte')
            ->andWhere('user.enAttente = :enAttente')
            ->setParameters(array(
                'typeCompte' => 1,
                'enAttente' => false
        ));
        return $qb->getQuery()->getResult();
    }
}
