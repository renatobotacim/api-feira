SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`inf_tipos_usuarios`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`inf_tipos_usuarios` (
  `tipo_usuario_id` INT NOT NULL AUTO_INCREMENT ,
  `tipo_usuario_nome` VARCHAR(45) NULL ,
  `tipo_usuario_envia` TINYINT(1) NULL ,
  `tipo_usuario_recebe` TINYINT(1) NULL ,
  PRIMARY KEY (`tipo_usuario_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`inf_usuarios`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`inf_usuarios` (
  `usuario_id` INT NOT NULL AUTO_INCREMENT ,
  `usuario_nome` VARCHAR(100) NOT NULL ,
  `usuario_cpf_cnpj` VARCHAR(14) NOT NULL ,
  `usuario_email` VARCHAR(45) NOT NULL ,
  `usuario_senha` VARCHAR(200) NOT NULL ,
  `usuario_tipo_usuario_id` INT NOT NULL ,
  `usuario_registro` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  `usuario_saldo` DECIMAL(10,2) NULL ,
  `usuario_status` INT NULL ,
  PRIMARY KEY (`usuario_id`) ,
  UNIQUE INDEX `usuario_cpf_UNIQUE` (`usuario_cpf_cnpj` ASC) ,
  UNIQUE INDEX `usuario_email_UNIQUE` (`usuario_email` ASC) ,
  INDEX `fk_usuario_tipo_usuario_id` (`usuario_tipo_usuario_id` ASC) ,
  CONSTRAINT `fk_usuario_tipo_usuario_id`
    FOREIGN KEY (`usuario_tipo_usuario_id` )
    REFERENCES `mydb`.`inf_tipos_usuarios` (`tipo_usuario_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`inf_transferencias`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`inf_transferencias` (
  `transferencia_id` INT NOT NULL AUTO_INCREMENT ,
  `transferencia_valor` DECIMAL(10,2) NOT NULL ,
  `transferencia_pagador` INT NOT NULL ,
  `transferencia_beneficiado` INT NOT NULL ,
  `transferencia_data` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  `transferencia_status` INT NULL ,
  `transferencia_mensagem` VARCHAR(50) NULL ,
  PRIMARY KEY (`transferencia_id`) ,
  INDEX `fk_transferencia_pagador` (`transferencia_pagador` ASC) ,
  INDEX `fk_transferencia_beneficiado` (`transferencia_beneficiado` ASC) ,
  CONSTRAINT `fk_transferencia_pagador`
    FOREIGN KEY (`transferencia_pagador` )
    REFERENCES `mydb`.`inf_usuarios` (`usuario_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_transferencia_beneficiado`
    FOREIGN KEY (`transferencia_beneficiado` )
    REFERENCES `mydb`.`inf_usuarios` (`usuario_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
