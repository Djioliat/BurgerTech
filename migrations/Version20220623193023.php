<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220623193023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gaetan ADD articles_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gaetan ADD CONSTRAINT FK_898D11B81EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id)');
        $this->addSql('CREATE INDEX IDX_898D11B81EBAF6CC ON gaetan (articles_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gaetan DROP FOREIGN KEY FK_898D11B81EBAF6CC');
        $this->addSql('DROP INDEX IDX_898D11B81EBAF6CC ON gaetan');
        $this->addSql('ALTER TABLE gaetan DROP articles_id');
    }
}