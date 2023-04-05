<?php 

namespace App\Tests\Entity;

//use PHPUnit\Framework\TestCase;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraints\DateTime;

class TaskTest extends KernelTestCase 
{
    
    public function getEntity(): Task
    {
        $user = new User();
        return (new Task())
            ->setTitle("Mon contenu")
            ->setContent("Mon contenu")
            ->setCreatedAt(new DateTimeImmutable())
            ->setIsDone(true)
            ->setUser($user)
            ;
    }

    public function getValidate( Task $task,int $number )
    {
        self::bootKernel();
        $container = static::getContainer();

        $error = $container->get('validator')->validate($task);
        $this->assertCount($number,$error);
    }

    public function testValidEntity()
    {
        $task = $this->getEntity();

        $this->getValidate($task, 0);

    }

   public function testInValidEntity()
   {
    $task = $this->getEntity();

        $task->setTitle();
        $task->setContent();
        $task->setCreatedAt("DateTime");
        $task->setIsDone("");

        $this->getValidate($task, 4);
   }

   public function testInvalidTitle(){

    $task = $this->getEntity();
    $task->setTitle("t");
    $this->getValidate($task, 1);

   }

   public function testInvalidContent(){

    $task = $this->getEntity();
    $task->setContent();
    $this->getValidate($task, 1);

   }


}