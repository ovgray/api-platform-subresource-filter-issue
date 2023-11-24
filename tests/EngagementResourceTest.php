<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Bag;
use App\Entity\Engagement;
use App\Entity\Item;
use App\Entity\Organization;
use App\Entity\Person;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;

class EngagementResourceTest extends ApiTestCase
{
    private Engagement $engagement1;

    private EntityManagerInterface $em;

    public function testGetCollectionWithNoFilter(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/engagements');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['hydra:totalItems' => 1]);
    }

    public function testGetCollectionWithActiveFilter(): void
    {
        $this->engagement1->setActive(true);
        $this->em->flush();
        $client = static::createClient();

        $client->request('GET', '/api/engagements?active=true');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['hydra:totalItems' => 1]);
    }
    public function testGetCollectionWithMinFilter(): void
    {
        $this->engagement1->setActive(true);
        $item1 = new Item();
        $item1->setName('Item1');
        $item2 = new Item();
        $item2->setName('Item2');
        $this->engagement1->getBag()->addItem($item1);
        $this->engagement1->getBag()->addItem($item2);
        $this->em->flush();

        $client = static::createClient();

        $client->request('GET', '/api/engagements?min=1');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['hydra:totalItems' => 1]);

        $client->request('GET', '/api/engagements?min=2');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['hydra:totalItems' => 1]);

        $client->request('GET', '/api/engagements?min=3');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['hydra:totalItems' => 0]);
    }

   public function testGetCollectionWithMinAndActiveFilters(): void
    {
        $this->engagement1->setActive(true);
        $item1 = new Item();
        $item1->setName('Item1');
        $item2 = new Item();
        $item2->setName('Item2');
        $this->engagement1->getBag()->addItem($item1);
        $this->engagement1->getBag()->addItem($item2);
        $this->em->flush();

        $client = static::createClient();

        $client->request('GET', '/api/engagements?active=true&min=1');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['hydra:totalItems' => 1]);

        $client->request('GET', '/api/engagements?active=true&min=2');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['hydra:totalItems' => 1]);

        $client->request('GET', '/api/engagements?active=true&min=3');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['hydra:totalItems' => 0]);
    }

    public function testGetSubresourceCollectionWithNoFilter(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/organizations/blue/engagements');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['hydra:totalItems' => 1]);
    }

    public function testGetSubresourceCollectionWithActiveFilter(): void
    {
        $this->engagement1->setActive(true);
        $this->em->flush();
        $client = static::createClient();

        $client->request('GET', '/api/organizations/blue/engagements?active=true');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['hydra:totalItems' => 1]);
    }
    public function testGetSubresourceCollectionWithMinFilter(): void
    {
        $this->engagement1->setActive(true);
        $item1 = new Item();
        $item1->setName('Item1');
        $item2 = new Item();
        $item2->setName('Item2');
        $this->engagement1->getBag()->addItem($item1);
        $this->engagement1->getBag()->addItem($item2);
        $this->em->flush();

        $client = static::createClient();

        $client->request('GET', '/api/organizations/blue/engagements?min=1');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['hydra:totalItems' => 1]);

        $client->request('GET', '/api/organizations/blue/engagements?min=2');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['hydra:totalItems' => 1]);

        $client->request('GET', '/api/organizations/blue/engagements?min=3');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['hydra:totalItems' => 0]);
    }

   public function testGetSubresourceCollectionWithMinAndActiveFilters(): void
    {
        $this->engagement1->setActive(true);
        $item1 = new Item();
        $item1->setName('Item1');
        $item2 = new Item();
        $item2->setName('Item2');
        $this->engagement1->getBag()->addItem($item1);
        $this->engagement1->getBag()->addItem($item2);
        $this->em->flush();

        $client = static::createClient();

        $client->request('GET', '/api/organizations/blue/engagements?active=true&min=1');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['hydra:totalItems' => 1]);

        $client->request('GET', '/api/organizations/blue/engagements?active=true&min=2');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['hydra:totalItems' => 1]);

        $client->request('GET', '/api/organizations/blue/engagements?active=true&min=3');
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['hydra:totalItems' => 0]);
    }

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();
        $this->em = static::getContainer()->get('doctrine')->getManager();
        $purger = new ORMPurger($this->em);
        $purger->purge();

        $org1 = new Organization();
        $org1->setCode('blue');
        $this->em->persist($org1);
        $person1 = new Person();
        $this->em->persist($person1);
        $bag1 = new Bag();
        $this->em->persist($bag1);

        $this->engagement1 = new Engagement();
        $this->engagement1->setPerson($person1);
        $this->engagement1->setBag($bag1);
        $org1->addEngagement($this->engagement1);
        $this->em->flush();
    }
}
