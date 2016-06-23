<?php
/**
 * Created by PhpStorm.
 * User: gurez
 * Date: 22.06.2016
 * Time: 14:07
 */

namespace ApiBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface,FixtureInterface, ContainerAwareInterface
{
    private $container;
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $objectManager)
    {
        $clientManager = $this->container->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setRedirectUris([]);
        $client->setAllowedGrantTypes(['password']);
        $clientManager->updateClient($client);
    }
    public function getOrder()
    {
        return 1;
    }
}