<?php

namespace App\Test\Controller;

use App\Entity\Guardian;
use App\Repository\GuardianRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GuardianControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private GuardianRepository $repository;
    private string $path = '/guardian/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Guardian::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Guardian index');

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
            'guardian[name]' => 'Testing',
            'guardian[surname]' => 'Testing',
            'guardian[email]' => 'Testing',
            'guardian[telephone]' => 'Testing',
            'guardian[adresse]' => 'Testing',
            'guardian[city]' => 'Testing',
            'guardian[codepostal]' => 'Testing',
            'guardian[gendre]' => 'Testing',
        ]);

        self::assertResponseRedirects('/guardian/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Guardian();
        $fixture->setName('My Title');
        $fixture->setSurname('My Title');
        $fixture->setEmail('My Title');
        $fixture->setTelephone('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setCity('My Title');
        $fixture->setCodepostal('My Title');
        $fixture->setGendre('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Guardian');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Guardian();
        $fixture->setName('My Title');
        $fixture->setSurname('My Title');
        $fixture->setEmail('My Title');
        $fixture->setTelephone('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setCity('My Title');
        $fixture->setCodepostal('My Title');
        $fixture->setGendre('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'guardian[name]' => 'Something New',
            'guardian[surname]' => 'Something New',
            'guardian[email]' => 'Something New',
            'guardian[telephone]' => 'Something New',
            'guardian[adresse]' => 'Something New',
            'guardian[city]' => 'Something New',
            'guardian[codepostal]' => 'Something New',
            'guardian[gendre]' => 'Something New',
        ]);

        self::assertResponseRedirects('/guardian/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getSurname());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getTelephone());
        self::assertSame('Something New', $fixture[0]->getAdresse());
        self::assertSame('Something New', $fixture[0]->getCity());
        self::assertSame('Something New', $fixture[0]->getCodepostal());
        self::assertSame('Something New', $fixture[0]->getGendre());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Guardian();
        $fixture->setName('My Title');
        $fixture->setSurname('My Title');
        $fixture->setEmail('My Title');
        $fixture->setTelephone('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setCity('My Title');
        $fixture->setCodepostal('My Title');
        $fixture->setGendre('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/guardian/');
    }
}
