<?php

// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Bundle\FrameworkBundle\KernelBrowser;
// use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// class RegistrationControllerTest extends WebTestCase
// {
//     private KernelBrowser|null $client = null;

//     public function setUp() : void
//     {
//         $this->client = static::createClient();
//     }

//     public function testRegister()
//     {
//         $urlGenerator = $this->client->getContainer()->get('router.default');

//         $crawler = $this->client->request(Request::METHOD_GET, '/register');

//         dd($crawler->selectButton('Créer un compte'));
//         // $form = $crawler->selectButton('créer un compte')->form();
        
//         // $form['user[username]'] = 'goodUsername';
//         // $form['user[email]'] = 'daddymail@gmail.com';
//         // $form['user[password]'] ='123456';
//         // $form['user[roles]'] =['ROLE_USER'];
//         // $form['agreeTerms'] = true ;
//         // $this->client->submit($form); 

//         // $this->assertResponseStatusCodeSame(Response::HTTP_OK);

//     }
//}
