<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250613075527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, id_pizza_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_6BAF787084C6F1D7 (id_pizza_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, payment_id INT DEFAULT NULL, delivery_time VARCHAR(255) NOT NULL, delivery_address VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F52993984C3A3BB (payment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, payment_type VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE pizza (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, ok_celiacs TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE pizza_order (id INT AUTO_INCREMENT NOT NULL, id_pizza_id INT DEFAULT NULL, id_order_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_358914084C6F1D7 (id_pizza_id), INDEX IDX_3589140DD4481AD (id_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF787084C6F1D7 FOREIGN KEY (id_pizza_id) REFERENCES pizza (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` ADD CONSTRAINT FK_F52993984C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pizza_order ADD CONSTRAINT FK_358914084C6F1D7 FOREIGN KEY (id_pizza_id) REFERENCES pizza (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pizza_order ADD CONSTRAINT FK_3589140DD4481AD FOREIGN KEY (id_order_id) REFERENCES `order` (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE ingredient DROP FOREIGN KEY FK_6BAF787084C6F1D7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984C3A3BB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pizza_order DROP FOREIGN KEY FK_358914084C6F1D7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pizza_order DROP FOREIGN KEY FK_3589140DD4481AD
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE ingredient
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `order`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE payment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE pizza
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE pizza_order
        SQL);
    }
}
