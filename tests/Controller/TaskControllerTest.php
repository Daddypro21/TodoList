<?php
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
    public function testListActionAuthorized()
    {
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('daddy2@gmail.com');
        $this->client->loginUser($testUser);
        $urlGenerator = $this->client->getContainer()->get('router.default');

        $this->client->request(Request::METHOD_GET, $urlGenerator->generate('task_list'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);


    }

    public function testListActionUnauthorized()
    {
        //$urlGenerator = $this->client->getContainer()->get('router.default');

        $this->client->request(Request::METHOD_GET, '/tasks');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);


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
        // $form['task[createdAt]'] = '2023-04-21';
        $this->client->submit($form); 
        $this->assertResponseRedirects('/tasks');
        // $this->client->followRedirect();
        // $this->assertSelectorTextContains('div.alert.alert-success','La tâche a été bien été ajoutée.');

    }
}