<?php

namespace Spolischook\CalendarBundle\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141208133022 extends AbstractMigration implements ContainerAwareInterface
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

        $sales = $em->getRepository('MiniShopBundle:ProductSale')->findAll();

        foreach ($sales as $sale) {
            $sale->setBank($em->getRepository('MiniShopBundle:Bank')->findOneByType($sale->getMethodOfPayment()));
        }

        $em->flush();
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
