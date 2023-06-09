<?php
use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    private KernelBrowser|null $client = null;

    public function setUp() : void
    {
        $this->client = static::createClient();
    }
    public function testListActionWithAuthentication()
    {
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('daddy2@gmail.com');
        $this->client->loginUser($testUser);
        $urlGenerator = $this->client->getContainer()->get('router.default');

        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_list'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);


    }

    public function testListActionWithoutAuthentication()
    {
        //$urlGenerator = $this->client->getContainer()->get('router.default');

        $this->client->request(Request::METHOD_GET, '/tasks');
        $this->assertResponseRedirects('/login');
        $this->client->followRedirect();


    }

    public function testTaskCreate()
    {
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('daddy2@gmail.com');
        $this->client->loginUser($testUser);
        $urlGenerator = $this->client->getContainer()->get('router.default');

        $crawler = $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_create'));
        $form = $crawler->selectButton('Ajouter')->form();

        $form['task[title]'] = 'Mon premier jour';
        $form['task[content]'] = 'Tout allait bien jusqu\'à ce que ......';
        $form['task[isDone]'] =true;
        //$form['task[createdAt]'] = (new DateTimeImmutable())->setDate(2023,04,05);
        $this->client->submit($form); 
        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('div.alert.alert-success','La tâche a été bien été ajoutée.');

    }

    public function testEditTask()
    {
        // S'authentifier
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('daddy2@gmail.com');
        $this->client->loginUser($testUser);

        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
        $testTask = $taskRepository->findBy(['user'=> $testUser]);
        $crawler = $this->client->request(Request::METHOD_GET, '/tasks/'.$testTask[0]->getId().'/edit');
        $form = $crawler->selectButton('Modifier')->form();

        $form['task[title]'] = 'Mon premier jour1';
        $form['task[content]'] = 'Tout allait bien jusqu\'à ce que ......';
        $form['task[isDone]'] =true;
        $this->client->submit($form); 
        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('div.alert.alert-success','La tâche a bien été modifiée.');
    }

    public function testDeleteTask() 
    {
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('daddy2@gmail.com');
        $this->client->loginUser($testUser);

        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
        $testTask = $taskRepository->findBy(['user'=> $testUser]);
        $this->client->request(Request::METHOD_GET, '/tasks/'.$testTask[0]->getId().'/delete');
        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('div.alert.alert-success','La tâche a bien été supprimée.');
    }

    public function testToggleTask() 
    {
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('daddy2@gmail.com');
        $this->client->loginUser($testUser);

        $taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
        $testTask = $taskRepository->findBy(['user'=> $testUser]);
        $this->client->request(Request::METHOD_GET, '/tasks/'.$testTask[0]->getId().'/toggle');
        $this->assertResponseRedirects('/tasks');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('div.alert.alert-success','La tâche la derniere clef a bien été marquée comme faite.');
    }
}