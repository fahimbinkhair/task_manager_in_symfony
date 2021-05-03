<?php
/**
 * create initial database and relevant entries
 */
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20210428165117
 *
 * @package DoctrineMigrations7
 */
final class Version20210428165117 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'create initial database and relevant entries';
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Exception
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName()
            !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, date_from DATETIME NOT NULL, date_to DATETIME DEFAULT NULL, date_created DATETIME NOT NULL, date_updated DATETIME DEFAULT NULL, INDEX IDX_527EDB256BF700BD (status_id), INDEX IDX_527EDB25A76ED395 (user_id), INDEX index_title (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE title (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(99) NOT NULL, name VARCHAR(99) NOT NULL, date_created DATETIME NOT NULL, date_updated DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB256BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');

        $sql = "INSERT INTO status (id, name)
                VALUES
                       (1, 'Active'),
                       (2, 'Inactive'),
                       (3, 'Archived'),
                       (4, 'Deleted')";
        $this->addSql($sql);

        $sql = "INSERT INTO user (email, name, date_created) VALUES ('me@me.com', 'Fahim', '2021-04-28 19:17:01')";
        $this->addSql($sql);
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Exception
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName()
            !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB256BF700BD');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25A76ED395');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE title');
        $this->addSql('DROP TABLE user');
    }
}
