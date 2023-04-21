<?php 

namespace App\Tests\Entity;


use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use DateTimeImmutable;


class TaskTest extends KernelTestCase
{
    
    public function getEntity(): Task
    {
        $user = new User();
        return  (new Task())
            ->setTitle("Mon contenu")
            ->setContent("Mon contenu")
            ->setCreatedAt(new DateTimeImmutable())
            ->setIsDone(true)
            ->setUser($user)

            ;
    }

    public function assertHasErrors( Task $task,int $number )
    {
        self::bootKernel();
        $container = static::getContainer();
        $error = $container->get('validator')->validate($task);
        $this->assertCount($number,$error);
        return $error;
    }

    public function testValidEntity()
    {
            
        $this->assertHasErrors($this->getEntity(), 0);

    }

    public function testInvalidTitle()
    {
       $task = $this->getEntity();
       $task->getTitle("title");
        $this->assertHasErrors($this->getEntity(), 1);
    }

    public function testValidTitle()
    {
       $task = $this->getEntity();
       $task->getTitle("title");
        $this->assertHasErrors($this->getEntity(), 0);
    }
    public function testInvalidContent() 
    {
        $task = $this->getEntity();
        $task->getContent();
        $this->assertHasErrors($task, 1);
    }
    public function testValidContent() 
    {
        $task = $this->getEntity();
        $task->getContent(" Je suis le contenu");
        $this->assertHasErrors($task, 0);
    }


}