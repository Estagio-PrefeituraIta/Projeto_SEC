
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


-- -----------------------------------------------------
-- Table `sec`.`variavel`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sec`.`variavel` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `matricula` INT NOT NULL,
  `mes` VARCHAR(45) NULL,
  `ano` VARCHAR(45) NULL,
  `sequencia` VARCHAR(45) NULL,
  `provento` VARCHAR(45) NULL,
  `referencia` VARCHAR(45) NULL,
  `valor` VARCHAR(45) NULL,
  `f_v` VARCHAR(45) NULL,
  `data_cadastro` VARCHAR(45) NULL,
  `data_alteracao` VARCHAR(45) NULL,
  `sinal` VARCHAR(45) NULL,
  `ir` VARCHAR(45) NULL,
  `previdencia` VARCHAR(45) NULL,
  `pensao` VARCHAR(45) NULL,
  INDEX `fk_variavel_funcionarios1_idx` (`matricula` ASC) ,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_variavel_funcionarios1`
    FOREIGN KEY (`matricula`)
    REFERENCES `sec`.`funcionarios` (`id_matricula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

