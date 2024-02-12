
--  criam um esquema de banco de dados nomeado sec com um conjunto de caracteres padrão UTF-8 e depois passam a usar esse secesquema para operações adicionais na sessão atual do banco de dados
CREATE SCHEMA IF NOT EXISTS `sec` DEFAULT CHARACTER SET utf8 ; 
USE `sec` ;

-- -----------------------------------------------------
-- Table `sec`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sec`.`usuarios` (
  `cpf_user` VARCHAR(11) NOT NULL,
  `nome` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`cpf_user`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `sec`.`infor_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sec`.`infor_user` (
  `usuarios_cpf_user` VARCHAR(11) NOT NULL,
  `nome_user` VARCHAR(170) NOT NULL,
  `telefone_user` VARCHAR(20) NOT NULL,
  `email_user` VARCHAR(100) NOT NULL,
  `senha_user` VARCHAR(8) NOT NULL,
  INDEX `fk_infor_user_usuarios1_idx` (`usuarios_cpf_user` ASC) ,
  CONSTRAINT `fk_infor_user_usuarios1`
    FOREIGN KEY (`usuarios_cpf_user`)
    REFERENCES `sec`.`usuarios` (`cpf_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `sec`.`funcionarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sec`.`funcionarios` (
  `id_matricula` INT NOT NULL AUTO_INCREMENT,
  `matricula` VARCHAR(45) NULL,
  `lotacao` VARCHAR(50) NULL,
  `cargo` VARCHAR(50) NULL,
  `usuarios_cpf_user` VARCHAR(11) NOT NULL,
  PRIMARY KEY (`id_matricula`),
  INDEX `fk_funcionarios_usuarios1_idx` (`usuarios_cpf_user` ASC) ,
  CONSTRAINT `fk_funcionarios_usuarios1`
    FOREIGN KEY (`usuarios_cpf_user`)
    REFERENCES `sec`.`usuarios` (`cpf_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;