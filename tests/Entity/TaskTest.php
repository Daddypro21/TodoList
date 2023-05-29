<?php 

namespace App\Tests\Entity;


use App\Entity\Task;
use DateTime;
use ReflectionClass;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;


class TaskTest extends TestCase
{
    private $title = "Titre";
    private $content = "Contenu du task";
    private $isDone = true;

    public function testGetterTask() : Void
    {

        // $taskReflection = new ReflectionClass(Task::class);
        // $task = $taskReflection->newInstanceWithoutConstructor();
        // $taskReflection->getProperty('title')->setValue($task, $this->title);
        // $taskReflection->getProperty('content')->setValue($task,$this->content);
        // $taskReflection->getProperty('isDone')->setValue($task, $this->isDone);
        // $taskReflection->getProperty('createdAt')->setValue($task,(new DateTimeImmutable())->setDate( 2023,04,01)->setTime(12,00,00,00));
      
        
        $task = new Task();
        $task->setTitle($this->title);
        $task->setContent($this->content);
        $task->setIsDone($this->isDone);
        $task->setCreatedAt((new DateTimeImmutable())->setDate( 2023,04,01)->setTime(12,00,00,00));
        
        
        $this->assertNull($task->getId());
        $this->assertEquals($this->title, $task->getTitle());
        $this->assertEquals($this->content, $task->getContent());
        $this->assertEquals((new DateTimeImmutable())->setDate( 2023,04,01)->setTime(12,00,00,00), $task->getCreatedAt());
        $this->assertEquals($this->isDone, $task->getIsDone());
    }
   
}



