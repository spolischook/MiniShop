<?php

namespace Spolischook\CalendarBundle\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManager;
use Spolischook\MiniShopBundle\Entity\Bank;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141207191522 extends AbstractMigration implements ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function up(Schema $schema)
    {
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.entity_manager');

        $totalCash = $em->getRepository('MiniShopBundle:ProductSale')->getTotalCash();
        $totalCard = $em->getRepository('MiniShopBundle:ProductSale')->getTotalCard();

        $cash = new Bank();
        $cash->setType('cash')->setTotal($totalCash);

        $card = new Bank();
        $card->setType('card')->setTotal($totalCard);

        $em->persist($cash);
        $em->persist($card);

        $em->flush();
    }

    public function down(Schema $schema)
    {
    }
}
