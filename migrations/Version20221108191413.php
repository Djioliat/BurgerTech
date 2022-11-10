<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221108191413 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE articles_episode');
        $this->addSql('ALTER TABLE articles ADD episode_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168362B62A0 FOREIGN KEY (episode_id) REFERENCES episode (id)');
        $this->addSql('CREATE INDEX IDX_BFDD3168362B62A0 ON articles (episode_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articles_episode (articles_id INT NOT NULL, episode_id INT NOT NULL, INDEX IDX_98CF787B1EBAF6CC (articles_id), INDEX IDX_98CF787B362B62A0 (episode_id), PRIMARY KEY(articles_id, episode_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE articles_episode ADD CONSTRAINT FK_98CF787B1EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles_episode ADD CONSTRAINT FK_98CF787B362B62A0 FOREIGN KEY (episode_id) REFERENCES episode (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168362B62A0');
        $this->addSql('DROP INDEX IDX_BFDD3168362B62A0 ON articles');
        $this->addSql('ALTER TABLE articles DROP episode_id');
    }
}
