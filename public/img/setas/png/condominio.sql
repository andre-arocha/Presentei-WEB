CREATE DATABASE IF NOT EXISTS `condominio` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `condominio`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `apartamento`
--

DROP TABLE IF EXISTS `apartamento`;
CREATE TABLE `apartamento` (
  `numero_apartamento` int(3) NOT NULL,
  `tipo_apartamento` varchar(9) NOT NULL,
  `codigo_condominio` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONAMENTOS PARA TABELAS `apartamento`:
--   `codigo_condominio`
--       `condominio` -> `codigo`
--

--
-- Extraindo dados da tabela `apartamento`
--

INSERT INTO `apartamento` (`numero_apartamento`, `tipo_apartamento`, `codigo_condominio`) VALUES
(1, 'Cobertura', 3),
(2, 'normal', 3),
(3, 'normal', 3),
(4, 'normal', 3),
(5, 'normal', 3),
(6, 'Cobertura', 4),
(7, 'normal', 4),
(8, 'normal', 4),
(9, 'normal', 4),
(10, 'normal', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `condominio`
--

DROP TABLE IF EXISTS `condominio`;
CREATE TABLE `condominio` (
  `codigo` int(8) NOT NULL,
  `nome_condominio` varchar(80) NOT NULL,
  `endereço_condominio` varchar(80) NOT NULL,
  `matricula_sindico` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONAMENTOS PARA TABELAS `condominio`:
--   `matricula_sindico`
--       `sindico` -> `matricula`
--

--
-- Extraindo dados da tabela `condominio`
--

INSERT INTO `condominio` (`codigo`, `nome_condominio`, `endereço_condominio`, `matricula_sindico`) VALUES
(3, 'Auberts condominio', 'Rua Estrela do Norte', 11),
(4, 'Estrela condominio', 'Rua Juru', 12);

-- --------------------------------------------------------

--
-- Estrutura da tabela `garagem`
--

DROP TABLE IF EXISTS `garagem`;
CREATE TABLE `garagem` (
  `numero_garagem` int(3) NOT NULL,
  `tipo_garagem` varchar(9) NOT NULL,
  `numero_ap` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONAMENTOS PARA TABELAS `garagem`:
--   `numero_ap`
--       `apartamento` -> `numero_apartamento`
--

--
-- Extraindo dados da tabela `garagem`
--

INSERT INTO `garagem` (`numero_garagem`, `tipo_garagem`, `numero_ap`) VALUES
(1, 'Coberta', 1),
(2, 'normal', 2),
(3, 'normal', 3),
(4, 'normal', 4),
(5, 'normal', 5),
(6, 'normal', 1),
(7, 'normal', 1),
(8, 'normal', 2),
(9, 'normal', 2),
(10, 'normal', 3),
(11, 'normal', 3),
(12, 'normal', 4),
(13, 'normal', 4),
(14, 'normal', 5),
(15, 'normal', 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `proprietario`
--

DROP TABLE IF EXISTS `proprietario`;
CREATE TABLE `proprietario` (
  `rg_proprietario` int(9) NOT NULL,
  `nome_proprietario` varchar(80) NOT NULL,
  `telefone_proprietario` int(11) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONAMENTOS PARA TABELAS `proprietario`:
--

--
-- Extraindo dados da tabela `proprietario`
--

INSERT INTO `proprietario` (`rg_proprietario`, `nome_proprietario`, `telefone_proprietario`, `email`) VALUES
(324314378, 'Raul Peixoto', 2147483647, 'sebastiaoroto@vbrasildigital.net'),
(325314378, 'Sebastião Raul Peixoto', 2147483647, 'sebastiaoraulpeixoto__sebastiaoraulpeixoto@vbrasil'),
(428598057, 'Andrea da Luz', 2147483647, 'peixoto@vbrasildigital.net'),
(458598057, 'Andrea da Luz', 2147483647, 'peixoto@vbrasildigital.net'),
(467347057, 'Lara Lavínia Andrea da Luz', 2147483647, 'sebaslpeixoto@vbrasildigital.net'),
(477045187, 'André Leandro Paulo da Conceição', 2147483647, 'aandreleandropaulodaconceicao@prognum.com.br'),
(478123456, 'Aparecida Marina Oliveira', 2147483647, 'betinaapa@enable.com.br'),
(478598056, 'Betina Aparecida Marina Oliveira', 2147483647, 'betinaaparecidamarinaoliveira..betinaaparecidamari'),
(478598057, 'Andrea da Luz', 2147483647, 'peixoto@vbrasildigital.net'),
(558295057, 'Andrea da Luz', 2147483647, 'peixoto@vbrasildigital.net');

-- --------------------------------------------------------

--
-- Estrutura da tabela `proprietario_apartamento`
--

DROP TABLE IF EXISTS `proprietario_apartamento`;
CREATE TABLE `proprietario_apartamento` (
  `id_proprietario_apartamento` int(3) NOT NULL,
  `rg_proprietario` int(9) NOT NULL,
  `numero_apartamento` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONAMENTOS PARA TABELAS `proprietario_apartamento`:
--   `numero_apartamento`
--       `apartamento` -> `numero_apartamento`
--   `rg_proprietario`
--       `proprietario` -> `rg_proprietario`
--

--
-- Extraindo dados da tabela `proprietario_apartamento`
--

INSERT INTO `proprietario_apartamento` (`id_proprietario_apartamento`, `rg_proprietario`, `numero_apartamento`) VALUES
(2, 467347057, 1),
(3, 477045187, 2),
(4, 325314378, 3),
(5, 458598057, 4),
(6, 558295057, 5),
(7, 478598057, 6),
(8, 478598056, 7),
(9, 428598057, 8),
(10, 324314378, 9),
(11, 478123456, 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sindico`
--

DROP TABLE IF EXISTS `sindico`;
CREATE TABLE `sindico` (
  `matricula` int(10) NOT NULL,
  `nome_sindico` varchar(80) NOT NULL,
  `telefone_sindico` int(11) NOT NULL,
  `endereço_sindico` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELACIONAMENTOS PARA TABELAS `sindico`:
--

--
-- Extraindo dados da tabela `sindico`
--

INSERT INTO `sindico` (`matricula`, `nome_sindico`, `telefone_sindico`, `endereço_sindico`) VALUES
(11, 'Juan Alexandre Anthony da Mata', 2147483647, 'Rua Amélia Sornas Meneguetti'),
(12, 'Edson Caio Moreira', 2147483647, 'Rua Doutor Adolfo Bezerra de Menezes');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `apartamento`
--
ALTER TABLE `apartamento`
  ADD PRIMARY KEY (`numero_apartamento`),
  ADD KEY `fk_codigo_condominio` (`codigo_condominio`);

--
-- Índices para tabela `condominio`
--
ALTER TABLE `condominio`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `fk_matriculaSindico` (`matricula_sindico`);

--
-- Índices para tabela `garagem`
--
ALTER TABLE `garagem`
  ADD PRIMARY KEY (`numero_garagem`),
  ADD KEY `fk_numero_apartamento` (`numero_ap`);

--
-- Índices para tabela `proprietario`
--
ALTER TABLE `proprietario`
  ADD PRIMARY KEY (`rg_proprietario`);

--
-- Índices para tabela `proprietario_apartamento`
--
ALTER TABLE `proprietario_apartamento`
  ADD PRIMARY KEY (`id_proprietario_apartamento`),
  ADD KEY `fk_numero_apartamento_ap` (`numero_apartamento`),
  ADD KEY `fk_rg_proprietario_ap` (`rg_proprietario`);

--
-- Índices para tabela `sindico`
--
ALTER TABLE `sindico`
  ADD PRIMARY KEY (`matricula`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `condominio`
--
ALTER TABLE `condominio`
  MODIFY `codigo` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `proprietario_apartamento`
--
ALTER TABLE `proprietario_apartamento`
  MODIFY `id_proprietario_apartamento` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `sindico`
--
ALTER TABLE `sindico`
  MODIFY `matricula` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `apartamento`
--
ALTER TABLE `apartamento`
  ADD CONSTRAINT `fk_codigo_condominio` FOREIGN KEY (`codigo_condominio`) REFERENCES `condominio` (`codigo`);

--
-- Limitadores para a tabela `condominio`
--
ALTER TABLE `condominio`
  ADD CONSTRAINT `fk_matriculaSindico` FOREIGN KEY (`matricula_sindico`) REFERENCES `sindico` (`matricula`);

--
-- Limitadores para a tabela `garagem`
--
ALTER TABLE `garagem`
  ADD CONSTRAINT `fk_numero_apartamento` FOREIGN KEY (`numero_ap`) REFERENCES `apartamento` (`numero_apartamento`);

--
-- Limitadores para a tabela `proprietario_apartamento`
--
ALTER TABLE `proprietario_apartamento`
  ADD CONSTRAINT `fk_numero_apartamento_ap` FOREIGN KEY (`numero_apartamento`) REFERENCES `apartamento` (`numero_apartamento`),
  ADD CONSTRAINT `fk_rg_proprietario_ap` FOREIGN KEY (`rg_proprietario`) REFERENCES `proprietario` (`rg_proprietario`);
COMMIT;

UPDATE proprietario_apartamento
SET rg_proprietario = 458598057
WHERE numero_apartament = 9;

UPDATE proprietario_apartamento
SET rg_proprietario = 428598057
WHERE numero_apartament = 10;

DELETE FROM proprietario
WHERE rg_proprietario = 4781234562;