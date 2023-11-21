<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231121154805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'création de tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, slug VARCHAR(128) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_64C19C1989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(128) NOT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_85F30B8C989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE icon (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, size INT NOT NULL, name VARCHAR(128) NOT NULL, slug VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_659429DB989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE link (id INT AUTO_INCREMENT NOT NULL, icon_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, name VARCHAR(128) NOT NULL, slug VARCHAR(128) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_36AC99F1989D9B62 (slug), INDEX IDX_36AC99F154B9D732 (icon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE link_has_category (id INT AUTO_INCREMENT NOT NULL, category_group_id INT DEFAULT NULL, category_id INT DEFAULT NULL, link_id INT NOT NULL, INDEX IDX_E5856337492E5D3C (category_group_id), INDEX IDX_E585633712469DE2 (category_id), INDEX IDX_E5856337ADA40271 (link_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(128) NOT NULL, slug VARCHAR(128) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_389B783989D9B62 (slug), INDEX IDX_389B783727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_link (tag_id INT NOT NULL, link_id INT NOT NULL, INDEX IDX_D8A32647BAD26311 (tag_id), INDEX IDX_D8A32647ADA40271 (link_id), PRIMARY KEY(tag_id, link_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE link ADD CONSTRAINT FK_36AC99F154B9D732 FOREIGN KEY (icon_id) REFERENCES icon (id)');
        $this->addSql('ALTER TABLE link_has_category ADD CONSTRAINT FK_E5856337492E5D3C FOREIGN KEY (category_group_id) REFERENCES category_group (id)');
        $this->addSql('ALTER TABLE link_has_category ADD CONSTRAINT FK_E585633712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE link_has_category ADD CONSTRAINT FK_E5856337ADA40271 FOREIGN KEY (link_id) REFERENCES link (id)');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B783727ACA70 FOREIGN KEY (parent_id) REFERENCES tag (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE tag_link ADD CONSTRAINT FK_D8A32647BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_link ADD CONSTRAINT FK_D8A32647ADA40271 FOREIGN KEY (link_id) REFERENCES link (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE link_entity');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE link DROP FOREIGN KEY FK_36AC99F154B9D732');
        $this->addSql('ALTER TABLE link_has_category DROP FOREIGN KEY FK_E5856337492E5D3C');
        $this->addSql('ALTER TABLE link_has_category DROP FOREIGN KEY FK_E585633712469DE2');
        $this->addSql('ALTER TABLE link_has_category DROP FOREIGN KEY FK_E5856337ADA40271');
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B783727ACA70');
        $this->addSql('ALTER TABLE tag_link DROP FOREIGN KEY FK_D8A32647BAD26311');
        $this->addSql('ALTER TABLE tag_link DROP FOREIGN KEY FK_D8A32647ADA40271');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_group');
        $this->addSql('DROP TABLE icon');
        $this->addSql('DROP TABLE link');
        $this->addSql('DROP TABLE link_has_category');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_link');
        $this->addSql('DROP TABLE user');
    }
}
