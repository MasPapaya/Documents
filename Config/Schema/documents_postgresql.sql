
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table entities
-- -----------------------------------------------------
DROP TABLE IF EXISTS entities ;
DROP SEQUENCE IF EXISTS ent_sq;

CREATE SEQUENCE ent_sq START 1;
CREATE TABLE IF NOT EXISTS entities (
	id INTEGER DEFAULT NEXTVAL('ent_sq') NOT NULL,
	name CHARACTER VARYING(45) NOT NULL,
  alias CHARACTER VARYING(45) NOT NULL,
  folder CHARACTER VARYING(45) NOT NULL,
	CONSTRAINT ent_pk PRIMARY KEY (id)
);
CREATE UNIQUE INDEX ent_idx ON entities (id);

-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
DROP TABLE IF EXISTS languages ;
DROP SEQUENCE IF EXISTS lan_sq;

-- -----------------------------------------------------
-- Table languages
-- -----------------------------------------------------

CREATE SEQUENCE lan_sq START 1;
CREATE TABLE languages (
	id integer DEFAULT NEXTVAL('lan_sq') NOT NULL,
	name character varying(45) NOT NULL,
	code character varying(45) NOT NULL,
	code2 character varying(45) NOT NULL,
	website boolean NOT NULL,
	CONSTRAINT lan_pk PRIMARY KEY (id)
);
CREATE UNIQUE INDEX lan_idx ON languages (id);

-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------
-- -----------------------------------------------------

DROP TABLE IF EXISTS document_types ;
DROP SEQUENCE IF EXISTS doc_typ_sq;

DROP TABLE IF EXISTS documents ;
DROP SEQUENCE IF EXISTS doc_sq;

-- -----------------------------------------------------
-- Table document_types
-- -----------------------------------------------------

CREATE SEQUENCE doc_typ_sq START 1;
CREATE TABLE document_types (
	id integer DEFAULT NEXTVAL('doc_typ_sq') NOT NULL,
	entity_id integer NOT NULL,
	name character varying(45) NOT NULL,
	alias character varying(45) NOT NULL,
	is_multiple boolean NOT NULL,
	use_user_id boolean NOT NULL,
	CONSTRAINT doc_typ_pk PRIMARY KEY (id),
	CONSTRAINT doc_typ_ent_fk FOREIGN KEY (entity_id) REFERENCES entities (id) ON DELETE NO ACTION ON UPDATE NO ACTION
);
CREATE UNIQUE INDEX doc_typ_idx ON document_types (id);
CREATE INDEX doc_typ_ent_fkidx ON document_types (entity_id);

-- -----------------------------------------------------
-- Table documents
-- -----------------------------------------------------

CREATE SEQUENCE doc_sq START 1;
CREATE TABLE documents (
	id integer DEFAULT NEXTVAL('doc_sq') NOT NULL,
	document_type_id integer NOT NULL,
	language_id integer NOT NULL,
	user_id integer NULL,
	parent_entityid integer NOT NULL,
	title character varying(100) NOT NULL,
	"excerpt" character varying(255) NOT NULL,
	content text NOT NULL,
	created timestamp without time zone NOT NULL,
	modified timestamp without time zone NOT NULL,
	published timestamp without time zone NOT NULL,
	deleted timestamp without time zone NOT NULL,
	CONSTRAINT doc_pk PRIMARY KEY (id),
	CONSTRAINT doc_doc_typ_fk FOREIGN KEY (document_type_id) REFERENCES document_types (id) ON DELETE NO ACTION ON UPDATE NO ACTION,
	CONSTRAINT doc_lan_fk FOREIGN KEY (language_id) REFERENCES languages (id) ON DELETE NO ACTION ON UPDATE NO ACTION
);
CREATE UNIQUE INDEX doc_idx ON document_types (id);
CREATE INDEX doc_doc_typ_fkidx ON documents (document_type_id);
CREATE INDEX doc_lan_fkidx ON documents (language_id);
