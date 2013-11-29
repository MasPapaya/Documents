-- -----------------------------------------------------
-- Require: languages, entities
-- -----------------------------------------------------


-- -----------------------------------------------------
-- Drops
-- -----------------------------------------------------

DROP TABLE IF EXISTS documents;
DROP TABLE IF EXISTS document_types;


-- -----------------------------------------------------
-- Table document_types
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS document_types (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  entity_id INT UNSIGNED NOT NULL,
  name VARCHAR(45) NOT NULL,
  alias VARCHAR(45) NOT NULL,
  is_multiple TINYINT(1) NOT NULL,
  use_user_id TINYINT(1) NOT NULL,
  PRIMARY KEY (id),
  KEY fk_doc_typ_ent (entity_id)
) ENGINE=InnoDB  ;

ALTER TABLE document_types ADD INDEX doctyp_ent_idx (entity_id ASC);


-- -----------------------------------------------------
-- Table documents
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS documents (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  document_type_id INT UNSIGNED NOT NULL,
  language_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED DEFAULT NULL,
  parent_entityid INT UNSIGNED NOT NULL,
  title VARCHAR(100) NOT NULL,
  excerpt VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  created DATETIME NOT NULL,
  modified DATETIME NOT NULL,
  published DATETIME NOT NULL,
  deleted DATETIME NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

ALTER TABLE documents ADD INDEX doc_doctyp_idx (document_type_id ASC);
ALTER TABLE documents ADD INDEX doc_lan_idx (language_id ASC);
ALTER TABLE documents ADD INDEX doc_use_idx (user_id ASC);


-- -----------------------------------------------------
-- Constraints
-- -----------------------------------------------------

ALTER TABLE documents
ADD CONSTRAINT doc_doctyp_fk FOREIGN KEY (document_type_id) REFERENCES document_types (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT doc_lan_fk FOREIGN KEY (language_id) REFERENCES languages (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT doc_use_fk FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE document_types
ADD CONSTRAINT doctyp_ent_fk FOREIGN KEY (entity_id) REFERENCES entities (id) ON DELETE NO ACTION ON UPDATE NO ACTION;


-- -----------------------------------------------------
-- View view_cms_documents
-- -----------------------------------------------------

CREATE OR REPLACE VIEW view_cms_documents AS
SELECT
Document.id AS document_id, Document.title, Document.excerpt, Document.content, Document.published,
Document.created, Document.parent_entityid AS parent_id,
DocumentType.id AS document_type_id, DocumentType.alias AS document_type_alias, DocumentType.is_multiple,
Entity.alias AS entity_alias,
Language.id AS language_id, Language.code, Language.code2
FROM documents Document
LEFT JOIN document_types DocumentType ON Document.document_type_id = DocumentType.id
LEFT JOIN entities Entity ON DocumentType.entity_id = Entity.id
LEFT JOIN languages Language ON Document.language_id = Language.id
WHERE Document.deleted = '0000-00-00 00:00:00' AND Document.published > '0000-00-00 00:00:00'
AND DocumentType.use_user_id = 0 AND Document.user_id IS NULL
ORDER BY Document.published DESC;
