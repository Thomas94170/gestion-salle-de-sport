<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }


    //searchbar

    public function findBySearch($result)
    {
        $qb = $this->createQueryBuilder('b')
            ->where('b.name LIKE :search')
            ->setParameter('search', '%'.$result.'%');
        return $qb->getQuery()->getResult();
    }

    //gestion des pages salles pour afficher la bonne page correspondante

    public function findUser($value)
    {
        return $this->createQueryBuilder('s')
            ->select('s.id')
            ->andWhere('s.name = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    public function findPermissions($value)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.permission', 'i')
            ->andWhere('i.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }



}
