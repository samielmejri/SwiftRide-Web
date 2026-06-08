<?php

namespace App\Test\Controller;

use App\Entity\Voiture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VoitureControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/voiture/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Voiture::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Voiture index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'voiture[marque]' => 'Testing',
            'voiture[model]' => 'Testing',
            'voiture[matricule]' => 'Testing',
            'voiture[cartegrise]' => 'Testing',
            'voiture[couleur]' => 'Testing',
            'voiture[etat]' => 'Testing',
            'voiture[prix]' => 'Testing',
            'voiture[kilometrage]' => 'Testing',
            'voiture[image]' => 'Testing',
            'voiture[position]' => 'Testing',
            'voiture[entrepriseId]' => 'Testing',
            'voiture[dateAjout]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Voiture();
        $fixture->setMarque('My Title');
        $fixture->setModel('My Title');
        $fixture->setMatricule('My Title');
        $fixture->setCartegrise('My Title');
        $fixture->setCouleur('My Title');
        $fixture->setEtat('My Title');
        $fixture->setPrix('My Title');
        $fixture->setKilometrage('My Title');
        $fixture->setImage('My Title');
        $fixture->setPosition('My Title');
        $fixture->setEntrepriseId('My Title');
        $fixture->setDateAjout('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Voiture');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Voiture();
        $fixture->setMarque('Value');
        $fixture->setModel('Value');
        $fixture->setMatricule('Value');
        $fixture->setCartegrise('Value');
        $fixture->setCouleur('Value');
        $fixture->setEtat('Value');
        $fixture->setPrix('Value');
        $fixture->setKilometrage('Value');
        $fixture->setImage('Value');
        $fixture->setPosition('Value');
        $fixture->setEntrepriseId('Value');
        $fixture->setDateAjout('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'voiture[marque]' => 'Something New',
            'voiture[model]' => 'Something New',
            'voiture[matricule]' => 'Something New',
            'voiture[cartegrise]' => 'Something New',
            'voiture[couleur]' => 'Something New',
            'voiture[etat]' => 'Something New',
            'voiture[prix]' => 'Something New',
            'voiture[kilometrage]' => 'Something New',
            'voiture[image]' => 'Something New',
            'voiture[position]' => 'Something New',
            'voiture[entrepriseId]' => 'Something New',
            'voiture[dateAjout]' => 'Something New',
        ]);

        self::assertResponseRedirects('/voiture/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getMarque());
        self::assertSame('Something New', $fixture[0]->getModel());
        self::assertSame('Something New', $fixture[0]->getMatricule());
        self::assertSame('Something New', $fixture[0]->getCartegrise());
        self::assertSame('Something New', $fixture[0]->getCouleur());
        self::assertSame('Something New', $fixture[0]->getEtat());
        self::assertSame('Something New', $fixture[0]->getPrix());
        self::assertSame('Something New', $fixture[0]->getKilometrage());
        self::assertSame('Something New', $fixture[0]->getImage());
        self::assertSame('Something New', $fixture[0]->getPosition());
        self::assertSame('Something New', $fixture[0]->getEntrepriseId());
        self::assertSame('Something New', $fixture[0]->getDateAjout());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Voiture();
        $fixture->setMarque('Value');
        $fixture->setModel('Value');
        $fixture->setMatricule('Value');
        $fixture->setCartegrise('Value');
        $fixture->setCouleur('Value');
        $fixture->setEtat('Value');
        $fixture->setPrix('Value');
        $fixture->setKilometrage('Value');
        $fixture->setImage('Value');
        $fixture->setPosition('Value');
        $fixture->setEntrepriseId('Value');
        $fixture->setDateAjout('Value');

        $$this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/voiture/');
        self::assertSame(0, $this->repository->count([]));
    }
}
