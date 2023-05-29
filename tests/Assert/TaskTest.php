<?php 

namespace App\Tests\Assert;


use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use DateTimeImmutable;


class TaskTest extends KernelTestCase
{
    private const TITLE_ERROR_MESSAGE = 'Your title  must be at least 3 characters long';
    private const NO_BLANCK_MESSAGE = 'This value should not be blank.';
    
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
        return $error ;
        
        
       

    }

    public function testValidEntity()
    {
            
        $this->assertHasErrors($this->getEntity(), 0);

    }

    public function testInvalidTitle()
    {
       $task = new Task();
       $task->setTitle("ti");
       $this->assertHasErrors($task,3);
        
    }

    public function testValidTitle()
    {
       $task = $this->getEntity();
       $task->setTitle("title");
        $this->assertHasErrors($this->getEntity(), 0);
    }
    public function testInvalidContent() 
    {
        $task = new Task();
        $task->setContent("");
        $this->assertHasErrors($task, 2);
    }
    public function testValidContent() 
    {
        $task = $this->getEntity();
        $task->setContent(" Je suis le contenu");
        $this->assertHasErrors($task, 0);
    }

    public function testInValidIsDone() 
    {
        $task = new Task();
        $task->setIsDone("");
        $this->assertHasErrors($task, 2);
    }
    


}



