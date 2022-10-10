<?php

namespace App\Test\Controller;

use App\Entity\Eleve;
use App\Repository\EleveRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EleveControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EleveRepository $repository;
    private string $path = '/eleve/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Eleve::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Eleve index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'eleve[name]' => 'Testing',
            'eleve[surname]' => 'Testing',
            'eleve[dateNaissance]' => 'Testing',
            'eleve[photo]' => 'Testing',
            'eleve[desciption]' => 'Testing',
            'eleve[dateInsriptionAt]' => 'Testing',
            'eleve[guardian]' => 'Testing',
            'eleve[gendre]' => 'Testing',
        ]);

        self::assertResponseRedirects('/eleve/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Eleve();
        $fixture->setName('My Title');
        $fixture->setSurname('My Title');
        $fixture->setDateNaissance('My Title');
        $fixture->setPhoto('My Title');
        $fixture->setDesciption('My Title');
        $fixture->setDateInsriptionAt('My Title');
        $fixture->setGuardian('My Title');
        $fixture->setGendre('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Eleve');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Eleve();
        $fixture->setName('My Title');
        $fixture->setSurname('My Title');
        $fixture->setDateNaissance('My Title');
        $fixture->setPhoto('My Title');
        $fixture->setDesciption('My Title');
        $fixture->setDateInsriptionAt('My Title');
        $fixture->setGuardian('My Title');
        $fixture->setGendre('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'eleve[name]' => 'Something New',
            'eleve[surname]' => 'Something New',
            'eleve[dateNaissance]' => 'Something New',
            'eleve[photo]' => 'Something New',
            'eleve[desciption]' => 'Something New',
            'eleve[dateInsriptionAt]' => 'Something New',
            'eleve[guardian]' => 'Something New',
            'eleve[gendre]' => 'Something New',
        ]);

        self::assertResponseRedirects('/eleve/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getSurname());
        self::assertSame('Something New', $fixture[0]->getDateNaissance());
        self::assertSame('Something New', $fixture[0]->getPhoto());
        self::assertSame('Something New', $fixture[0]->getDesciption());
        self::assertSame('Something New', $fixture[0]->getDateInsriptionAt());
        self::assertSame('Something New', $fixture[0]->getGuardian());
        self::assertSame('Something New', $fixture[0]->getGendre());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Eleve();
        $fixture->setName('My Title');
        $fixture->setSurname('My Title');
        $fixture->setDateNaissance('My Title');
        $fixture->setPhoto('My Title');
        $fixture->setDesciption('My Title');
        $fixture->setDateInsriptionAt('My Title');
        $fixture->setGuardian('My Title');
        $fixture->setGendre('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/eleve/');
    }
}
