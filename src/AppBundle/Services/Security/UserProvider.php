<?php

namespace AppBundle\Services\Security;


use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Usuario;

class UserProvider implements UserProviderInterface
{
    private $repository;

    public function __construct(EntityRepository $repository) {
            $this->repository = $repository;
        }

    public function loadUserByUsername($username)
    {
        $userData = $this->repository->findOneByUsuario($username);
    
        if ($userData) {

            if($userData->getActivo()==false)
                throw new CustomUserMessageAuthenticationException(
                    sprintf('El usuario "%s" se encuentra bloqueado. Consulte con el administrador', $username));
                
            return $userData;
        }

        throw new UsernameNotFoundException(
            sprintf('El usuario "%s" no existe.', $username)
        );
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof Usuario) {
            throw new UnsupportedUserException(
                sprintf('Intancias de "%s" no son soportadas.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return Usuario::class === $class;
    }
}