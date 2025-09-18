<?php

/**
 * This file is part of the Symfony Project.
 *
 * (c) Nicola Szwaja <nicola.szwaja@student.uj.edu.pl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace App\Repository;

use App\Entity\Admin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * Repository for the Admin entity.
 *
 * @extends ServiceEntityRepository<Admin>
 */
class AdminRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    /**
     * Initializes the repository for the Admin entity using the given manager registry.
     *
     * @param ManagerRegistry $registry The manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Admin::class);
    }

    /**
     * Upgrades (rehashes) the user's password automatically over time.
     *
     * @param PasswordAuthenticatedUserInterface $user              The user whose password will be upgraded
     * @param string                             $newHashedPassword The new hashed password to store
     *
     * @throws UnsupportedUserException When the provided user is not an Admin instance
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Admin) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
}
