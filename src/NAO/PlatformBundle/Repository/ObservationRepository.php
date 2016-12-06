<?php

namespace NAO\PlatformBundle\Repository;

/**
 * ObservationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ObservationRepository extends \Doctrine\ORM\EntityRepository
{
    function getListObsByUser($id)    {
        $qb = $this->createQueryBuilder('obs')
            ->leftJoin('obs.user', 'user')
            ->where('user.id = :id_user')
            ->setParameter('id_user', $id);
        return $qb->getQuery()->getResult();
    }

    function getListObsNonvalideEnAttente() {
        $qb = $this->createQueryBuilder('obs')
            ->leftJoin('obs.user', 'user')
            ->where('obs.valide = :valide')
            ->andWhere('user.typeCompte = :typeCompte')
            ->andWhere('obs.enAttente = :enAttente')
            ->setParameters(array('valide' => false, 'typeCompte' => 0, 'enAttente' => true));
        return $qb->getQuery()->getResult();
    }

    //pour récupérer les observations traitées par un naturaliste
    function getListObsTraiteeParNaturaliste($id) {
        $qb = $this->createQueryBuilder('obs')
            ->leftJoin('obs.validateur', 'user')
            ->where('user.id = :id')
            ->setParameter('id', $id);
        return $qb->getQuery()->getResult();
    }

    //pour récupérer les observations refusées par un naturaliste
    function getListObsRefuseesParNaturaliste($id) {
        $qb = $this->createQueryBuilder('obs')
            ->leftJoin('obs.validateur', 'user')
            ->where('user.id = :id')
            ->andWhere('obs.valide = :valid')
            ->andWhere('obs.enAttente = :enAttente')
            ->setParameters(array(
                'id'=> $id,
                'valid'=>false,
                'enAttente'=>false
            ));
        return $qb->getQuery()->getResult();
    }

    function getAllObserv() { // Pour l'export de toutes les observations
        return $this->createQueryBuilder('obs')->getQuery()->getResult();
    }

    function getDerObsValides($jours) { // Observation des X derniers jours / à mettre sur la page d'accueil ?
        $qb = $this->createQueryBuilder('obs')
            ->where('obs.dateObs > :todayMoinsJours')
            ->andWhere('obs.valide = :valide')
            ->setParameters(array(
                'todayMoinsJours' => (new \Datetime())->sub(new \DateInterval('P'.$jours.'D')),
                'valide' => true
                ));
        return $qb->getQuery()->getResult();
    }

    function getListObsByNomVernValides($nomVern)    {
        $qb = $this->createQueryBuilder('obs')
            ->leftJoin('obs.especeNomVern', 'especeNV')
            ->where('especeNV.nomVern = :nomVern')
            ->andWhere('obs.valide = :valide')
            ->setParameters(array(
                'nomVern'=> $nomVern,
                'valide' => true
                ));
        return $qb->getQuery()->getResult();
    }

    function getListObsByNomConcatValides($nomConcat){
        $qb = $this->createQueryBuilder('obs')
            ->leftJoin('obs.especeNomVern', 'especeNV')
            ->where('especeNV.nomConcat = :nomConcat')
            ->andWhere('obs.valide = :valide')
            ->setParameters(array(
                'nomConcat'=> $nomConcat,
                'valide' => true
            ));
        return $qb->getQuery()->getResult();
    }

 /*   function getListObsByNomLatin($id)    {
        $qb = $this->createQueryBuilder('obs')
            ->leftJoin('obs.EspeceNomLatin', 'especeNL')
            ->where('especeNL.id = :id_NL')
            ->setParameter('id_NL', $id);
        return $qb->getQuery()->getResult();
    }*/
}
