<?php
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class UserControllerTest extends WebTestCase
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

    public function testUserCreate()
    {
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('daddy1@gmail.com');
        $this->client->loginUser($testUser);
        $urlGenerator = $this->client->getContainer()->get('router.default');

        $crawler = $this->client->request(Request::METHOD_GET, $urlGenerator->generate('user_create'));
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'goodUsername';
        $form['user[email]'] = 'monemail@gmail.com';
        $form['user[password]'] ='123456';
        $form['user[roles]'] =['ROLE_USER'];
        $this->client->submit($form); 
        $this->assertResponseRedirects('/users');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('div.alert.alert-success','L\'utilisateur a bien été ajouté.');

    }

    public function testUserEdit()
    {
        // S'authentifier
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('daddy1@gmail.com');
        $this->client->loginUser($testUser);

       $userRepo = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepo->findOneByEmail('daddy2@gmail.com');
        $crawler = $this->client->request(Request::METHOD_GET, '/users/'.$testUser->getId().'/edit');
        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'Dadda';
        $form['user[email]'] = 'daddy20@gamil.com';
        $form['user[password]'] = '123456';
        $form['user[roles]'] = ['ROLE_USER'];
        $this->client->submit($form); 
        $this->assertResponseRedirects('/users');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('div.alert.alert-success','L\'utilisateur a bien été modifié');
    }

   
}