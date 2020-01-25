-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema hgvj
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema hgvj
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `hgvj` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `hgvj` ;

-- -----------------------------------------------------
-- Table `hgvj`.`permissao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`permissao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`pessoa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`pessoa` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `cpf` VARCHAR(15) NOT NULL,
  `telefone` VARCHAR(16) NULL,
  `celular1` VARCHAR(16) NULL,
  `celular2` VARCHAR(16) NULL,
  `email` VARCHAR(100) NULL,
  `senha` VARCHAR(45) NULL,
  `bloqueado` VARCHAR(45) NULL,
  `permissao_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_pessoa_permissao1_idx` (`permissao_id` ASC),
  CONSTRAINT `fk_pessoa_permissao1`
    FOREIGN KEY (`permissao_id`)
    REFERENCES `hgvj`.`permissao` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`medico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`medico` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `registro` VARCHAR(45) NULL,
  `pessoa_id` INT NOT NULL,
  `ativo` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_medico_pessoa1_idx` (`pessoa_id` ASC),
  CONSTRAINT `fk_medico_pessoa1`
    FOREIGN KEY (`pessoa_id`)
    REFERENCES `hgvj`.`pessoa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`especialidade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`especialidade` (
  `id` INT NOT NULL,
  `nome` VARCHAR(80) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`medico_especialidade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`medico_especialidade` (
  `medico_id` INT NOT NULL,
  `especialidade_id` INT NOT NULL,
  PRIMARY KEY (`medico_id`, `especialidade_id`),
  INDEX `fk_medico_has_especialidade_especialidade1_idx` (`especialidade_id` ASC),
  INDEX `fk_medico_has_especialidade_medico1_idx` (`medico_id` ASC),
  CONSTRAINT `fk_medico_has_especialidade_medico1`
    FOREIGN KEY (`medico_id`)
    REFERENCES `hgvj`.`medico` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_medico_has_especialidade_especialidade1`
    FOREIGN KEY (`especialidade_id`)
    REFERENCES `hgvj`.`especialidade` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`local`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`local` (
  `id` INT NOT NULL,
  `nome` VARCHAR(80) NULL,
  `ativo` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`agenda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`agenda` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `dia_semana` INT NULL,
  `ativo` INT NULL,
  `local_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_agenda_medica_local1_idx` (`local_id` ASC),
  CONSTRAINT `fk_agenda_medica_local1`
    FOREIGN KEY (`local_id`)
    REFERENCES `hgvj`.`local` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`agenda_horario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`agenda_horario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `horario` TIME NOT NULL,
  `agenda_id` INT NOT NULL,
  `ativo` INT NULL,
  INDEX `fk_horario_has_agenda_medica_agenda_medica1_idx` (`agenda_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_horario_has_agenda_medica_agenda_medica1`
    FOREIGN KEY (`agenda_id`)
    REFERENCES `hgvj`.`agenda` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`agenda_status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`agenda_status` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`agenda_paciente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`agenda_paciente` (
  `id` INT NOT NULL,
  `data` DATE NULL,
  `data_pedido` TIMESTAMP NULL,
  `data_status` TIMESTAMP NULL,
  `agenda_horario_id` INT NOT NULL,
  `agenda_status_id` INT NOT NULL,
  `pessoa_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_agenda_consulta_agenda_medica_horario1_idx` (`agenda_horario_id` ASC),
  INDEX `fk_agenda_consulta_agenda_status1_idx` (`agenda_status_id` ASC),
  INDEX `fk_agenda_paciente_pessoa1_idx` (`pessoa_id` ASC),
  CONSTRAINT `fk_agenda_consulta_agenda_medica_horario1`
    FOREIGN KEY (`agenda_horario_id`)
    REFERENCES `hgvj`.`agenda_horario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_agenda_consulta_agenda_status1`
    FOREIGN KEY (`agenda_status_id`)
    REFERENCES `hgvj`.`agenda_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_agenda_paciente_pessoa1`
    FOREIGN KEY (`pessoa_id`)
    REFERENCES `hgvj`.`pessoa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`secretaria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`secretaria` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `ativo` INT NULL,
  `medico_id` INT NOT NULL,
  `pessoa_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_secretaria_medico1_idx` (`medico_id` ASC),
  INDEX `fk_secretaria_pessoa1_idx` (`pessoa_id` ASC),
  CONSTRAINT `fk_secretaria_medico1`
    FOREIGN KEY (`medico_id`)
    REFERENCES `hgvj`.`medico` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_secretaria_pessoa1`
    FOREIGN KEY (`pessoa_id`)
    REFERENCES `hgvj`.`pessoa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`exame_categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`exame_categoria` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(80) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`exame`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`exame` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(80) NULL,
  `ativo` INT NULL,
  `exame_categoria_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_exame_exame_categoria1_idx` (`exame_categoria_id` ASC),
  CONSTRAINT `fk_exame_exame_categoria1`
    FOREIGN KEY (`exame_categoria_id`)
    REFERENCES `hgvj`.`exame_categoria` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`agenda_exame`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`agenda_exame` (
  `agenda_id` INT NOT NULL,
  `exame_id` INT NOT NULL,
  PRIMARY KEY (`agenda_id`, `exame_id`),
  INDEX `fk_agenda_exame_exame1_idx` (`exame_id` ASC),
  CONSTRAINT `fk_agenda_exame_agenda1`
    FOREIGN KEY (`agenda_id`)
    REFERENCES `hgvj`.`agenda` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_agenda_exame_exame1`
    FOREIGN KEY (`exame_id`)
    REFERENCES `hgvj`.`exame` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`agenda_medica`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`agenda_medica` (
  `agenda_id` INT NOT NULL,
  `medico_id` INT NOT NULL,
  PRIMARY KEY (`agenda_id`, `medico_id`),
  INDEX `fk_agenda_medica_medico2_idx` (`medico_id` ASC),
  CONSTRAINT `fk_agenda_medica_agenda1`
    FOREIGN KEY (`agenda_id`)
    REFERENCES `hgvj`.`agenda` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_agenda_medica_medico2`
    FOREIGN KEY (`medico_id`)
    REFERENCES `hgvj`.`medico` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`pergunta_categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`pergunta_categoria` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(80) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`pergunta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`pergunta` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(200) NULL,
  `resposta` TEXT NULL,
  `pergunta_categoria_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_pergunta_pergunta_categoria1_idx` (`pergunta_categoria_id` ASC),
  CONSTRAINT `fk_pergunta_pergunta_categoria1`
    FOREIGN KEY (`pergunta_categoria_id`)
    REFERENCES `hgvj`.`pergunta_categoria` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`mensagem_categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`mensagem_categoria` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(80) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`mensagem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`mensagem` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `remetente` VARCHAR(100) NULL,
  `email` VARCHAR(100) NULL,
  `assunto` VARCHAR(200) NULL,
  `conteudo` TEXT NULL,
  `telefone` VARCHAR(18) NULL,
  `data_envio` TIMESTAMP NULL,
  `status` INT NULL,
  `data_status` TIMESTAMP NULL,
  `mensagem_categoria_id` INT NOT NULL,
  `resposta` TEXT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_mensagem_mensagem_categoria1_idx` (`mensagem_categoria_id` ASC),
  CONSTRAINT `fk_mensagem_mensagem_categoria1`
    FOREIGN KEY (`mensagem_categoria_id`)
    REFERENCES `hgvj`.`mensagem_categoria` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`glossario_categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`glossario_categoria` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`glossario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`glossario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(100) NULL,
  `descricao` TEXT NULL,
  `glossario_categoria_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_glossario_glossario_categoria1_idx` (`glossario_categoria_id` ASC),
  CONSTRAINT `fk_glossario_glossario_categoria1`
    FOREIGN KEY (`glossario_categoria_id`)
    REFERENCES `hgvj`.`glossario_categoria` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`area_cargo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`area_cargo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(60) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`curriculo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`curriculo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `data_submissao` TIMESTAMP NULL,
  `status` INT NULL,
  `data_status` TIMESTAMP NULL,
  `pessoa_id` INT NOT NULL,
  `area_cargo_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_curriculo_pessoa1_idx` (`pessoa_id` ASC),
  INDEX `fk_curriculo_area_cargo1_idx` (`area_cargo_id` ASC),
  CONSTRAINT `fk_curriculo_pessoa1`
    FOREIGN KEY (`pessoa_id`)
    REFERENCES `hgvj`.`pessoa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_curriculo_area_cargo1`
    FOREIGN KEY (`area_cargo_id`)
    REFERENCES `hgvj`.`area_cargo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hgvj`.`noticia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `hgvj`.`noticia` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(100) NULL,
  `conteudo` TEXT NULL,
  `data` TIMESTAMP NULL,
  `fonte` VARCHAR(100) NULL,
  `ativo` INT NULL,
  `usuario_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_noticia_pessoa1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_noticia_pessoa1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `hgvj`.`pessoa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
