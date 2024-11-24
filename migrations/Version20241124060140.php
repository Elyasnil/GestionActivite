<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241124060140 extends AbstractMigration
{
   public function getDescription(): string
   {
      return '';
   }
   
   public function up(Schema $schema): void
   {
       $this->addSql('ALTER TABLE ACTIVITE ADD (projet_source_id NUMBER(10) NOT NULL)');
      $this->addSql('ALTER TABLE ACTIVITE ADD CONSTRAINT FK_B8755515B6C2FBB5 FOREIGN KEY (projet_source_id) REFERENCES projet (id)');
      $this->addSql('CREATE INDEX IDX_B8755515B6C2FBB5 ON ACTIVITE (projet_source_id)');
      $this->addSql('ALTER TABLE PROJET ADD (demande_source_id NUMBER(10) NOT NULL)');
      $this->addSql('ALTER TABLE PROJET ADD CONSTRAINT FK_50159CA9E010E6B4 FOREIGN KEY (demande_source_id) REFERENCES demande (id)');
      $this->addSql('CREATE INDEX IDX_50159CA9E010E6B4 ON PROJET (demande_source_id)');
      $this->addSql('ALTER TABLE TACHE ADD (activite_id NUMBER(10) DEFAULT NULL NULL)');
      $this->addSql('ALTER TABLE TACHE ADD CONSTRAINT FK_938720759B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id)');
      $this->addSql('CREATE INDEX IDX_938720759B0F88B1 ON TACHE (activite_id)');
      // this up() migration is auto-generated, please modify it to your needs
      $this->addSql('CREATE TABLE messenger_messages (id NUMBER(20) DEFAULT messenger_messages_seq.nextval NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR2(190) NOT NULL, created_at TIMESTAMP(0) NOT NULL, available_at TIMESTAMP(0) NOT NULL, delivered_at TIMESTAMP(0) DEFAULT NULL NULL, PRIMARY KEY(id))');
      $this->addSql('DECLARE
          constraints_Count NUMBER;
          BEGIN
          SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count
          FROM USER_CONSTRAINTS
          WHERE TABLE_NAME = \'MESSENGER_MESSAGES\'
          AND CONSTRAINT_TYPE = \'P\';
          IF constraints_Count = 0 OR constraints_Count = \'\' THEN
          EXECUTE IMMEDIATE \'ALTER TABLE MESSENGER_MESSAGES ADD CONSTRAINT MESSENGER_MESSAGES_AI_PK PRIMARY KEY (ID)\';
          END IF;
          END;');
          $this->addSql('CREATE SEQUENCE MESSENGER_MESSAGES_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1');
          $this->addSql('CREATE TRIGGER MESSENGER_MESSAGES_AI_PK
           BEFORE INSERT
           ON MESSENGER_MESSAGES
           FOR EACH ROW
        DECLARE
           last_Sequence NUMBER;
           last_InsertID NUMBER;
        BEGIN
           IF (:NEW.ID IS NULL OR :NEW.ID = 0) THEN
              SELECT MESSENGER_MESSAGES_SEQ.NEXTVAL INTO :NEW.ID FROM DUAL;
           ELSE
              SELECT NVL(Last_Number, 0) INTO last_Sequence
                FROM User_Sequences
               WHERE Sequence_Name = \'MESSENGER_MESSAGES_SEQ\';
              SELECT :NEW.ID INTO last_InsertID FROM DUAL;
              WHILE (last_InsertID > last_Sequence) LOOP
                 SELECT MESSENGER_MESSAGES_SEQ.NEXTVAL INTO last_Sequence FROM DUAL;
              END LOOP;
              SELECT MESSENGER_MESSAGES_SEQ.NEXTVAL INTO last_Sequence FROM DUAL;
           END IF;
        END;');
         $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
         $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
         $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
         $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
         $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
         $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');

}

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE activite DROP CONSTRAINT FK_B8755515B6C2FBB5');
        $this->addSql('DROP INDEX IDX_B8755515B6C2FBB5');
        $this->addSql('ALTER TABLE activite DROP (projet_source_id)');
        $this->addSql('ALTER TABLE tache DROP CONSTRAINT FK_938720759B0F88B1');
        $this->addSql('DROP INDEX IDX_938720759B0F88B1');
        $this->addSql('ALTER TABLE tache DROP (activite_id)');
        $this->addSql('ALTER TABLE projet DROP CONSTRAINT FK_50159CA9E010E6B4');
        $this->addSql('DROP INDEX IDX_50159CA9E010E6B4');
        $this->addSql('ALTER TABLE projet DROP (demande_source_id)');
    }
}