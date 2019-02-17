-- MySQL Script generated by MySQL Workbench
-- Thu Feb 14 15:37:53 2019
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema fenacon
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema fenacon
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `fenacon` DEFAULT CHARACTER SET utf8 ;
USE `fenacon` ;

-- -----------------------------------------------------
-- Table `fenacon`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fenacon`.`usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(50) NOT NULL,
  `login` VARCHAR(50) NOT NULL,
  `senha` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fenacon`.`situacoes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fenacon`.`situacoes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fenacon`.`cargos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fenacon`.`cargos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fenacon`.`funcionarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fenacon`.`funcionarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `cpf` VARCHAR(14) NOT NULL,
  `endereco` TEXT NOT NULL,
  `carga_horaria` VARCHAR(50) NOT NULL,
  `data_admissao` DATE NOT NULL,
  `situacao_id` INT NOT NULL,
  `cargo_id` INT NOT NULL,
  `supervisor_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_funcionarios_situacoes1_idx` (`situacao_id`),
  INDEX `fk_funcionarios_cargos1_idx` (`cargo_id`),
  INDEX `fk_funcionarios_funcionarios1_idx` (`supervisor_id`),
  CONSTRAINT `fk_funcionarios_situacoes1`
    FOREIGN KEY (`situacao_id`)
    REFERENCES `fenacon`.`situacoes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_funcionarios_cargos1`
    FOREIGN KEY (`cargo_id`)
    REFERENCES `fenacon`.`cargos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_funcionarios_funcionarios1`
    FOREIGN KEY (`supervisor_id`)
    REFERENCES `fenacon`.`funcionarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fenacon`.`ferias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fenacon`.`ferias` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `dt_inicio` DATE NOT NULL,
  `dt_fim` DATE NOT NULL,
  `periodo` VARCHAR(4) NOT NULL,
  `funcionario_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ferias_funcionarios_idx` (`funcionario_id`),
  CONSTRAINT `fk_ferias_funcionarios`
    FOREIGN KEY (`funcionario_id`)
    REFERENCES `fenacon`.`funcionarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;