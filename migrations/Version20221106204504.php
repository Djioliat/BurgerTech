<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221106204504 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP user');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E963379586');
        $this->addSql('DROP INDEX IDX_1483A5E963379586 ON users');
        $this->addSql('ALTER TABLE users DROP comments_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment ADD user VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE users ADD comments_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E963379586 FOREIGN KEY (comments_id) REFERENCES comment (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1483A5E963379586 ON users (comments_id)');
    }
}
