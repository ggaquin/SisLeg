CREATE SCHEMA `sistema_legislativo` DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_general_ci;
CREATE USER 'legislativo_web'@'%' IDENTIFIED BY 'legislativo_web_*';
GRANT SELECT,INSERT,UPDATE,DELETE,EXECUTE  ON sistema_legislativo.* TO 'legislativo_web'@'%';