<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250918191302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id_animal INT AUTO_INCREMENT NOT NULL, type VARCHAR(50) NOT NULL, base_weight_kg NUMERIC(15, 2) NOT NULL, base_price NUMERIC(15, 2) NOT NULL, average_productivity NUMERIC(15, 2) DEFAULT NULL, health_profile VARCHAR(255) NOT NULL, reproduction_cycle_days INT NOT NULL, created_at DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', breed VARCHAR(50) NOT NULL, gender VARCHAR(255) NOT NULL, PRIMARY KEY(id_animal)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal_activities (id INT AUTO_INCREMENT NOT NULL, id_user_machine_id INT DEFAULT NULL, id_user_batiment_id INT DEFAULT NULL, id_user_parcelle_id INT DEFAULT NULL, id_user_animal_id INT NOT NULL, description VARCHAR(255) NOT NULL, cost DOUBLE PRECISION NOT NULL, revenue DOUBLE PRECISION NOT NULL, veterinarian_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_68047701B88E5E42 (id_user_machine_id), INDEX IDX_680477019C67155F (id_user_batiment_id), INDEX IDX_68047701EA27122 (id_user_parcelle_id), INDEX IDX_68047701B3101CF4 (id_user_animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE batiment (id_batiment INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, type VARCHAR(255) NOT NULL, surface_m2 NUMERIC(15, 2) NOT NULL, storage_capacity INT DEFAULT NULL, base_price NUMERIC(15, 2) NOT NULL, condition_status VARCHAR(255) NOT NULL, created_at DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', animal_capacity INT NOT NULL, PRIMARY KEY(id_batiment)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE batiment_activities (id INT AUTO_INCREMENT NOT NULL, id_user_batiment_id INT NOT NULL, activity_type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, cost DOUBLE PRECISION NOT NULL, animal_count INT DEFAULT NULL, contractor_name VARCHAR(255) DEFAULT NULL, materials_used VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_E60515499C67155F (id_user_batiment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat_room (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, allowed_users JSON DEFAULT NULL, max_users INT NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel_ventes (Id_hotel_ventes INT AUTO_INCREMENT NOT NULL, item_type VARCHAR(50) NOT NULL, item_id INT NOT NULL, asking_price NUMERIC(15, 2) NOT NULL, final_price NUMERIC(15, 2) DEFAULT NULL, title LONGTEXT NOT NULL, is_sold TINYINT(1) DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', sold_at DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', PRIMARY KEY(Id_hotel_ventes)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE machine (id_machine INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, type VARCHAR(255) NOT NULL, brand VARCHAR(50) DEFAULT NULL, model VARCHAR(50) DEFAULT NULL, year_manufactured INT DEFAULT NULL, power_hp INT DEFAULT NULL, fuel_consumption NUMERIC(15, 2) DEFAULT NULL, base_price NUMERIC(15, 2) NOT NULL, condition_status VARCHAR(255) NOT NULL, created_at DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', PRIMARY KEY(id_machine)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE machine_activities (id INT AUTO_INCREMENT NOT NULL, id_user_machine_id INT DEFAULT NULL, activity_type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, cost DOUBLE PRECISION NOT NULL, hours_used DOUBLE PRECISION NOT NULL, mechanic_name VARCHAR(255) DEFAULT NULL, parts_replaced VARCHAR(255) DEFAULT NULL, next_maintenance_due DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', fuel_consumed DOUBLE PRECISION NOT NULL, INDEX IDX_C154B744B88E5E42 (id_user_machine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, room_id INT NOT NULL, content VARCHAR(255) NOT NULL, sender VARCHAR(255) NOT NULL, timestamp DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', message_type VARCHAR(255) DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_B6BD307F54177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meteo_data (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, temperature DOUBLE PRECISION NOT NULL, feels_like DOUBLE PRECISION NOT NULL, humidity DOUBLE PRECISION NOT NULL, wind_speed DOUBLE PRECISION DEFAULT NULL, wind_direction VARCHAR(255) DEFAULT NULL, pressure DOUBLE PRECISION NOT NULL, precipitation_type VARCHAR(255) DEFAULT NULL, weather VARCHAR(255) NOT NULL, summary VARCHAR(255) NOT NULL, cloud_cover INT DEFAULT NULL, zone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parcelle_activities (id INT AUTO_INCREMENT NOT NULL, id_user_machine_id INT DEFAULT NULL, id_user_parcelle_id INT DEFAULT NULL, activity_type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, cost DOUBLE PRECISION NOT NULL, revenue DOUBLE PRECISION NOT NULL, crop_type VARCHAR(255) NOT NULL, quantity_planted DOUBLE PRECISION NOT NULL, quantity_harvested DOUBLE PRECISION NOT NULL, INDEX IDX_444A0289B88E5E42 (id_user_machine_id), INDEX IDX_444A0289EA27122 (id_user_parcelle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parcelles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, surface_hectares NUMERIC(8, 2) NOT NULL, type_sol VARCHAR(255) NOT NULL, location INT DEFAULT NULL, fertility_level VARCHAR(255) NOT NULL, base_price NUMERIC(12, 2) NOT NULL, max_animals_capacity INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, id_parcelle_activity_id INT DEFAULT NULL, id_batiment_activities_id INT DEFAULT NULL, id_machine_activity_id INT DEFAULT NULL, id_animal_activity_id INT DEFAULT NULL, id_hotel_vente INT DEFAULT NULL, id_user_id INT NOT NULL, transaction_type VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_723705D1C9C507EC (id_parcelle_activity_id), INDEX IDX_723705D15E04D695 (id_batiment_activities_id), INDEX IDX_723705D1668FCA3B (id_machine_activity_id), INDEX IDX_723705D1A5580180 (id_animal_activity_id), INDEX IDX_723705D1734C297F (id_hotel_vente), INDEX IDX_723705D179F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', zone VARCHAR(255) NOT NULL, balance DOUBLE PRECISION NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_animal (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_animal INT NOT NULL, id_user_batiment_id INT DEFAULT NULL, id_user_parcelle_id INT DEFAULT NULL, is_name TINYINT(1) NOT NULL, custom_name VARCHAR(255) NOT NULL, current_location_type VARCHAR(255) NOT NULL, INDEX IDX_FF9382279F37AE5 (id_user_id), INDEX IDX_FF938224C9C96F2 (id_animal), INDEX IDX_FF938229C67155F (id_user_batiment_id), INDEX IDX_FF93822EA27122 (id_user_parcelle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_batiment (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_batiment INT NOT NULL, custom_name VARCHAR(255) NOT NULL, current_occupancy INT DEFAULT NULL, stored_quantity DOUBLE PRECISION DEFAULT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_1577540C79F37AE5 (id_user_id), INDEX IDX_1577540CA5215C99 (id_batiment), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_machine (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_machine INT NOT NULL, custom_name VARCHAR(255) NOT NULL, acquired_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', fuel_level DOUBLE PRECISION NOT NULL, last_maintenance_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_active TINYINT(1) NOT NULL, INDEX IDX_4D08C18E79F37AE5 (id_user_id), INDEX IDX_4D08C18ECB9876F4 (id_machine), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_parcelle (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_parcelle_id INT NOT NULL, custom_name VARCHAR(255) NOT NULL, current_crop VARCHAR(255) NOT NULL, expected_harvest_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_25E3C8F679F37AE5 (id_user_id), INDEX IDX_25E3C8F65C212091 (id_parcelle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal_activities ADD CONSTRAINT FK_68047701B88E5E42 FOREIGN KEY (id_user_machine_id) REFERENCES user_machine (id)');
        $this->addSql('ALTER TABLE animal_activities ADD CONSTRAINT FK_680477019C67155F FOREIGN KEY (id_user_batiment_id) REFERENCES user_batiment (id)');
        $this->addSql('ALTER TABLE animal_activities ADD CONSTRAINT FK_68047701EA27122 FOREIGN KEY (id_user_parcelle_id) REFERENCES user_parcelle (id)');
        $this->addSql('ALTER TABLE animal_activities ADD CONSTRAINT FK_68047701B3101CF4 FOREIGN KEY (id_user_animal_id) REFERENCES user_animal (id)');
        $this->addSql('ALTER TABLE batiment_activities ADD CONSTRAINT FK_E60515499C67155F FOREIGN KEY (id_user_batiment_id) REFERENCES user_batiment (id)');
        $this->addSql('ALTER TABLE machine_activities ADD CONSTRAINT FK_C154B744B88E5E42 FOREIGN KEY (id_user_machine_id) REFERENCES user_machine (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F54177093 FOREIGN KEY (room_id) REFERENCES chat_room (id)');
        $this->addSql('ALTER TABLE parcelle_activities ADD CONSTRAINT FK_444A0289B88E5E42 FOREIGN KEY (id_user_machine_id) REFERENCES user_machine (id)');
        $this->addSql('ALTER TABLE parcelle_activities ADD CONSTRAINT FK_444A0289EA27122 FOREIGN KEY (id_user_parcelle_id) REFERENCES user_parcelle (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1C9C507EC FOREIGN KEY (id_parcelle_activity_id) REFERENCES parcelle_activities (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D15E04D695 FOREIGN KEY (id_batiment_activities_id) REFERENCES batiment_activities (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1668FCA3B FOREIGN KEY (id_machine_activity_id) REFERENCES machine_activities (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1A5580180 FOREIGN KEY (id_animal_activity_id) REFERENCES animal_activities (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1734C297F FOREIGN KEY (id_hotel_vente) REFERENCES hotel_ventes (Id_hotel_ventes)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D179F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_animal ADD CONSTRAINT FK_FF9382279F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_animal ADD CONSTRAINT FK_FF938224C9C96F2 FOREIGN KEY (id_animal) REFERENCES animal (id_animal)');
        $this->addSql('ALTER TABLE user_animal ADD CONSTRAINT FK_FF938229C67155F FOREIGN KEY (id_user_batiment_id) REFERENCES user_batiment (id)');
        $this->addSql('ALTER TABLE user_animal ADD CONSTRAINT FK_FF93822EA27122 FOREIGN KEY (id_user_parcelle_id) REFERENCES user_parcelle (id)');
        $this->addSql('ALTER TABLE user_batiment ADD CONSTRAINT FK_1577540C79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_batiment ADD CONSTRAINT FK_1577540CA5215C99 FOREIGN KEY (id_batiment) REFERENCES batiment (id_batiment)');
        $this->addSql('ALTER TABLE user_machine ADD CONSTRAINT FK_4D08C18E79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_machine ADD CONSTRAINT FK_4D08C18ECB9876F4 FOREIGN KEY (id_machine) REFERENCES machine (id_machine)');
        $this->addSql('ALTER TABLE user_parcelle ADD CONSTRAINT FK_25E3C8F679F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_parcelle ADD CONSTRAINT FK_25E3C8F65C212091 FOREIGN KEY (id_parcelle_id) REFERENCES parcelles (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_activities DROP FOREIGN KEY FK_68047701B88E5E42');
        $this->addSql('ALTER TABLE animal_activities DROP FOREIGN KEY FK_680477019C67155F');
        $this->addSql('ALTER TABLE animal_activities DROP FOREIGN KEY FK_68047701EA27122');
        $this->addSql('ALTER TABLE animal_activities DROP FOREIGN KEY FK_68047701B3101CF4');
        $this->addSql('ALTER TABLE batiment_activities DROP FOREIGN KEY FK_E60515499C67155F');
        $this->addSql('ALTER TABLE machine_activities DROP FOREIGN KEY FK_C154B744B88E5E42');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F54177093');
        $this->addSql('ALTER TABLE parcelle_activities DROP FOREIGN KEY FK_444A0289B88E5E42');
        $this->addSql('ALTER TABLE parcelle_activities DROP FOREIGN KEY FK_444A0289EA27122');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1C9C507EC');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D15E04D695');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1668FCA3B');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1A5580180');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1734C297F');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D179F37AE5');
        $this->addSql('ALTER TABLE user_animal DROP FOREIGN KEY FK_FF9382279F37AE5');
        $this->addSql('ALTER TABLE user_animal DROP FOREIGN KEY FK_FF938224C9C96F2');
        $this->addSql('ALTER TABLE user_animal DROP FOREIGN KEY FK_FF938229C67155F');
        $this->addSql('ALTER TABLE user_animal DROP FOREIGN KEY FK_FF93822EA27122');
        $this->addSql('ALTER TABLE user_batiment DROP FOREIGN KEY FK_1577540C79F37AE5');
        $this->addSql('ALTER TABLE user_batiment DROP FOREIGN KEY FK_1577540CA5215C99');
        $this->addSql('ALTER TABLE user_machine DROP FOREIGN KEY FK_4D08C18E79F37AE5');
        $this->addSql('ALTER TABLE user_machine DROP FOREIGN KEY FK_4D08C18ECB9876F4');
        $this->addSql('ALTER TABLE user_parcelle DROP FOREIGN KEY FK_25E3C8F679F37AE5');
        $this->addSql('ALTER TABLE user_parcelle DROP FOREIGN KEY FK_25E3C8F65C212091');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE animal_activities');
        $this->addSql('DROP TABLE batiment');
        $this->addSql('DROP TABLE batiment_activities');
        $this->addSql('DROP TABLE chat_room');
        $this->addSql('DROP TABLE hotel_ventes');
        $this->addSql('DROP TABLE machine');
        $this->addSql('DROP TABLE machine_activities');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE meteo_data');
        $this->addSql('DROP TABLE parcelle_activities');
        $this->addSql('DROP TABLE parcelles');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_animal');
        $this->addSql('DROP TABLE user_batiment');
        $this->addSql('DROP TABLE user_machine');
        $this->addSql('DROP TABLE user_parcelle');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
