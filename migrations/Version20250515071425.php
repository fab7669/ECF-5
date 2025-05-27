<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250515071425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A5450D2529
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE presence ADD CONSTRAINT FK_6977C7A5450D2529 FOREIGN KEY (enfant_id) REFERENCES enfant (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A5450D2529
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE presence ADD CONSTRAINT FK_6977C7A5450D2529 FOREIGN KEY (enfant_id) REFERENCES enfant (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
    }
}
