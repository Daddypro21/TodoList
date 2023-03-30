<?php

namespace App\Security\Voter;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class TaskVoter extends Voter
{
    public const TASK_EDIT = 'editAction';
    public const TASK_DELETE = 'deleteTaskAction';
    public const TASK_TOGGLE = 'toggleTaskAction';
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, mixed $task): bool
    {
        
        return in_array($attribute, [self::TASK_EDIT, self::TASK_DELETE,self::TASK_TOGGLE])
            && $task instanceof \App\Entity\Task;
    }

    protected function voteOnAttribute(string $attribute, mixed $task, TokenInterface $token): bool
    {
        $user = $token->getUser();

         
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        //On verifie si l'utilisateur est Admin

        if( $this->security->isGranted("ROLE_ADMIN")) return true;

        //On verifie si la tache a un proprietaire

        if(null === $task->getUser()){

            return false;

        } 
        
        switch ($attribute) {
            case self::TASK_EDIT:

                //On verifie si l'utilisateur  peut editer 
                return $this->canEdit($task, $user);
                
                break;
            case self::TASK_DELETE:

                 //On verifie si l'utilisateur peut supprimer 
                 return $this->canDelete($task, $user);
                break;
            case self::TASK_TOGGLE:

                //On verifie si l'utilisateur peut marquer la tache 
                return $this->canToggle($task, $user);
                break;
        }

        return false;
    }

    private function canEdit( Task $task, User $user)
    {
        
        //le proprietaire de la tache peut modifier
        return $user === $task->getUser();
    }

    private function canDelete(Task $task, User $user)
    {
        //le proprietaire de la tache peut supprimer
        return $user === $task->getUser();
    }
    private function canToggle(Task $task, User $user)
    {
        //le proprietaire  peut marquer la tache
        return $user === $task->getUser();
    }
}
