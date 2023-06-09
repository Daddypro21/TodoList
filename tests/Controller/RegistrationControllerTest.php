<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    private KernelBrowser|null $client = null;

    public function setUp() : void
    {
        $this->client = static::createClient();
    }

    public function testRegister()
    {
        $urlGenerator = $this->client->getContainer()->get('router.default');

        $crawler = $this->client->request(Request::METHOD_GET,'/register');

      
        $form = $crawler->selectButton('Créer un compte')->form();
       
        $form['registration_form[username]'] = 'goodUsername';
        $form['registration_form[email]'] = 'daddymail@gmail.com';
        $form['registration_form[plainPassword]'] ='123456';
        $form['registration_form[roles]'] =['ROLE_USER'];
        $form['registration_form[agreeTerms]'] = true ;

        
        $this->client->submit($form); 
        $crawler = $this->client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

    }
}
