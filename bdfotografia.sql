-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26-Jul-2021 às 01:10
-- Versão do servidor: 10.4.19-MariaDB
-- versão do PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bdfotografia`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbalbumfoto`
--

CREATE TABLE `tbalbumfoto` (
  `idAlbum` int(11) NOT NULL,
  `dataCriacao` date NOT NULL,
  `horaCriacao` time NOT NULL,
  `fotoCapa` varchar(400) NOT NULL,
  `idUsuario` int(11) NOT NULL DEFAULT 0,
  `tituloAlbum` varchar(500) NOT NULL DEFAULT '0',
  `urlAlbum` varchar(300) DEFAULT NULL,
  `idCategoria` int(11) DEFAULT NULL,
  `dataEvento` date NOT NULL,
  `slug` varchar(500) DEFAULT NULL,
  `descricaoAlbum` longtext NOT NULL,
  `view` int(11) NOT NULL,
  `curtida` int(11) NOT NULL,
  `tituloFoto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tbalbumfoto`
--

INSERT INTO `tbalbumfoto` (`idAlbum`, `dataCriacao`, `horaCriacao`, `fotoCapa`, `idUsuario`, `tituloAlbum`, `urlAlbum`, `idCategoria`, `dataEvento`, `slug`, `descricaoAlbum`, `view`, `curtida`, `tituloFoto`) VALUES
(32, '2021-01-12', '16:44:09', 'imagens/albuns/ENSAIO-DE-CASAL/sdafffffffff/fotoCapa/IMG_7452.jpg', 1, 'sdafffffffff', 'imagens/albuns/ENSAIO DE CASAL/sdafffffffff', 12, '2021-01-30', 'Teste-editado', 'adsffffffffff', 333, 0, 'IMG_7452.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbarquivosartigos`
--

CREATE TABLE `tbarquivosartigos` (
  `idArquivoArtigo` int(11) NOT NULL,
  `descricaoLink` varchar(100) NOT NULL DEFAULT '0',
  `urlArquivo` varchar(400) NOT NULL DEFAULT '0',
  `idArtigo` int(11) NOT NULL DEFAULT 0,
  `nomeArquivo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tbarquivosartigos`
--

INSERT INTO `tbarquivosartigos` (`idArquivoArtigo`, `descricaoLink`, `urlArquivo`, `idArtigo`, `nomeArquivo`) VALUES
(1, 'Baixe aqui seu arquivo', 'imagens/artigos/QUAL_MOMENTO_IDEAL_PARA_FAZER_O_ENSAIO_GESTANTE_LALALA_OLAAAAAAAA/arquivosArtigo/duvidas.txt', 24, 'duvidas.txt');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbarquivosclientes`
--

CREATE TABLE `tbarquivosclientes` (
  `idarquivocliente` int(11) NOT NULL,
  `idClienteEbook` int(11) NOT NULL DEFAULT 0,
  `idArquivoArtigo` int(11) NOT NULL DEFAULT 0,
  `dataBaixado` date NOT NULL,
  `horaBaixado` time NOT NULL,
  `notificacao` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbartigos`
--

CREATE TABLE `tbartigos` (
  `idArtigo` int(11) NOT NULL,
  `html` longtext DEFAULT NULL,
  `htmlEdit` longtext DEFAULT NULL,
  `autor` varchar(50) DEFAULT '0',
  `tituloArtigo` varchar(500) NOT NULL DEFAULT '0',
  `dataCriado` date NOT NULL,
  `horaCriado` time NOT NULL,
  `idUsuario` int(11) NOT NULL DEFAULT 0,
  `fotoCapa` varchar(200) NOT NULL,
  `descricaoArtigo` text DEFAULT NULL,
  `urlArtigo` varchar(400) NOT NULL,
  `publicoCMS` tinyint(4) NOT NULL,
  `aprovado` tinyint(4) DEFAULT NULL,
  `observacao` text DEFAULT NULL,
  `revisado` tinyint(4) NOT NULL,
  `notificacaoAprovado` tinyint(4) NOT NULL,
  `notificacaoRevisado` tinyint(4) NOT NULL,
  `notificacaoObservacao` tinyint(4) NOT NULL,
  `slug` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tbartigos`
--

INSERT INTO `tbartigos` (`idArtigo`, `html`, `htmlEdit`, `autor`, `tituloArtigo`, `dataCriado`, `horaCriado`, `idUsuario`, `fotoCapa`, `descricaoArtigo`, `urlArtigo`, `publicoCMS`, `aprovado`, `observacao`, `revisado`, `notificacaoAprovado`, `notificacaoRevisado`, `notificacaoObservacao`, `slug`) VALUES
(24, '<pre><img style=\"float: left;\" src=\"../../storage/imagens/artigos/QUAL_MOMENTO_IDEAL_PARA_FAZER_O_ENSAIO_GESTANTE_LALALA_OLAAAAAAAA/fotosArtigo/1614871480C__Data_Users_DefApps_AppData_INTERNETEXPLORER_Temp_Saved Images_images(1).jpg\" alt=\"\" width=\"400\" height=\"320\" /> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</pre>\r\n<div dir=\"ltr\" style=\"padding-left: 80px;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; O ideal &eacute; fazer o ensaio gestante no in&iacute;cio do 7&deg; m&ecirc;s de gesta&ccedil;&atilde;o. Nesse per&iacute;odo a barriga</div>\r\n<div dir=\"ltr\" style=\"padding-left: 80px;\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; est&aacute; empinada e a mam&atilde;e n&atilde;o est&aacute; inchada.</div>\r\n<div dir=\"ltr\" style=\"padding-left: 120px;\">&nbsp;</div>\r\n<div dir=\"ltr\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Entre 27 e 31 semanas &eacute; o per&iacute;odo perfeito paras as fotos. A barrigona aparece bem e a</div>\r\n<div dir=\"ltr\">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; mam&atilde;e ainda est&aacute; em forma!!</div>\r\n<div dir=\"ltr\">&nbsp;</div>\r\n<div dir=\"ltr\">Deixar mais para o final pode ser arriscado. Muitas mam&atilde;es incham, e come&ccedil;am a ficar bem cansadas &agrave; medida que o &uacute;tero se expande e empurra o diafragma contra os pulm&otilde;es.</div>', NULL, 'mauricio', 'Qual Momento ideal para Fazer o Ensaio Gestante?!? LALALA??? olaaaaaaaa ????', '2021-01-05', '15:03:26', 1, 'imagens/artigos/QUAL_MOMENTO_IDEAL_PARA_FAZER_O_ENSAIO_GESTANTE_LALALA_OLAAAAAAAA/fotoCapaArtigo/IMG_7205-Editar.jpg', 'asdddddddddddddddd', 'imagens/artigos/QUAL_MOMENTO_IDEAL_PARA_FAZER_O_ENSAIO_GESTANTE_LALALA_OLAAAAAAAA', 1, 1, '', 0, 1, 0, 0, 'Momento-ideal-para-Fazer-o-Ensaio-Gestante-gravida-gestação-melhor-epoca-para-sessao-de-fotos'),
(42, '<center><h2>Modo Edição</h2></center>\r\n                    <div class=\"blockStyle blockStyle--style7\" style=\"display: flex; flex-direction: column;\">\r\n            \r\n            <div class=\"blockStyle__content-group\">\r\n                <div class=\"blockStyle__blockContent blockStyle__blockContent--image\">\r\n                    \r\n                    <img src=\"http://127.0.0.1:8000/storage/imagens/artigos/SADDDDDDDDDDDDDDDD/fotosArtigo/Ensaio_Gestante_Gestação_Fotografia_de_gravida_Por_do_Sol_Pedra_Grande_Atibaia-3.jpg\" class=\"blockStyle__image\">\r\n                    <input type=\"file\" class=\"blockStyle__blockContent--imageFile\" name=\"file\" style=\"display: none;\">\r\n                </div>    \r\n\r\n                <div class=\"blockStyle__blockContent blockStyle__blockContent--image\">\r\n                    \r\n                    <img src=\"http://127.0.0.1:8000/storage/imagens/artigos/SADDDDDDDDDDDDDDDD/fotosArtigo/Ensaio_Gestante_Gestação_Fotografia_de_gravida_Por_do_Sol_Pedra_Grande_Atibaia-6.jpg\" class=\"blockStyle__image\">\r\n                    <input type=\"file\" class=\"blockStyle__blockContent--imageFile\" name=\"file\" style=\"display: none;\">\r\n                </div>  \r\n            </div>\r\n        </div>\r\n                              \r\n            <div class=\"blockStyle blockStyle--style1\" style=\"display: flex;\">\r\n            \r\n            \r\n            <div class=\"blockStyle__blockContent htmlSlot\">\r\n                \r\n                \r\n            </div>\r\n        </div>', '<center><h2>Modo Edição</h2></center>\r\n                    <div class=\"blockStyle blockStyle--style7\" style=\"display: flex; flex-direction: column;\">\r\n            <span class=\"blockStyle__close close\">X</span>\r\n            <div class=\"blockStyle__content-group\">\r\n                <div class=\"blockStyle__blockContent blockStyle__blockContent--image\">\r\n                    <div class=\"blockContent--image__header\">\r\n                        <div class=\"blockContent--image__header--slot leftImage\">&lt;</div>\r\n                        <div class=\"blockContent--image__header--slot increaseImage\">+</div>\r\n                        <div class=\"blockContent--image__header--slot centerImage\">...</div>\r\n                        <div class=\"blockContent--image__header--slot decreaseImage\">-</div>\r\n                        <div class=\"blockContent--image__header--slot rightImage\">&gt;</div>\r\n                    </div>\r\n                    <img src=\"http://127.0.0.1:8000/storage/imagens/artigos/SADDDDDDDDDDDDDDDD/fotosArtigo/Ensaio_Gestante_Gestação_Fotografia_de_gravida_Por_do_Sol_Pedra_Grande_Atibaia-3.jpg\" class=\"blockStyle__image\">\r\n                    <input type=\"file\" class=\"blockStyle__blockContent--imageFile\" name=\"file\" style=\"display: none;\">\r\n                </div>    \r\n\r\n                <div class=\"blockStyle__blockContent blockStyle__blockContent--image\">\r\n                    <div class=\"blockContent--image__header\">\r\n                        <div class=\"blockContent--image__header--slot leftImage\">&lt;</div>\r\n                        <div class=\"blockContent--image__header--slot increaseImage\">+</div>\r\n                        <div class=\"blockContent--image__header--slot centerImage\">...</div>\r\n                        <div class=\"blockContent--image__header--slot decreaseImage\">-</div>\r\n                        <div class=\"blockContent--image__header--slot rightImage\">&gt;</div>\r\n                    </div>\r\n                    <img src=\"http://127.0.0.1:8000/storage/imagens/artigos/SADDDDDDDDDDDDDDDD/fotosArtigo/Ensaio_Gestante_Gestação_Fotografia_de_gravida_Por_do_Sol_Pedra_Grande_Atibaia-6.jpg\" class=\"blockStyle__image\">\r\n                    <input type=\"file\" class=\"blockStyle__blockContent--imageFile\" name=\"file\" style=\"display: none;\">\r\n                </div>  \r\n            </div>\r\n        </div>\r\n                              \r\n            <div class=\"blockStyle blockStyle--style1\" style=\"display: flex;\">\r\n            <span class=\"blockStyle__close close\">X</span>\r\n            \r\n            <div class=\"blockStyle__blockContent htmlSlot\">\r\n                <button class=\"blockStyle__btnStyle blockStyle__btnAddHtml\">html</button>\r\n                <button class=\"blockStyle__btnStyle blockStyle__btnClearHtml\">limpar</button>\r\n            </div>\r\n        </div>', 'mauricio', 'sadddddddddddddddd', '2021-04-07', '10:20:09', 1, 'imagens/artigos/SADDDDDDDDDDDDDDDD/fotoCapaArtigo/C__Data_Users_DefApps_AppData_INTERNETEXPLORER_Temp_SavedImages_images(5).jpg', 'saddddddddddddddddddddddd', 'imagens/artigos/SADDDDDDDDDDDDDDDD', 1, 0, '', 0, 0, 0, 0, 'SDAAAAAAAAAAAAAA-DSAAAAAA-DSAAAAAAAAAA');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbcategoriaalbum`
--

CREATE TABLE `tbcategoriaalbum` (
  `idCategoria` int(11) NOT NULL,
  `nomeCategoria` varchar(50) NOT NULL DEFAULT '0',
  `slugCategoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tbcategoriaalbum`
--

INSERT INTO `tbcategoriaalbum` (`idCategoria`, `nomeCategoria`, `slugCategoria`) VALUES
(12, 'ENSAIO DE CASAL', 'ENSAIO-DE-CASAL');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbclientes`
--

CREATE TABLE `tbclientes` (
  `idCliente` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL DEFAULT '0',
  `email` varchar(300) NOT NULL DEFAULT '0',
  `dataCadastro` date DEFAULT NULL,
  `horaCadastro` time DEFAULT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `notificacao` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbclientesebook`
--

CREATE TABLE `tbclientesebook` (
  `idClienteEbook` int(11) NOT NULL,
  `email` varchar(300) NOT NULL DEFAULT '0',
  `nome` varchar(100) NOT NULL DEFAULT '0',
  `telefone` varchar(100) NOT NULL DEFAULT '0',
  `notificacao` tinyint(4) NOT NULL,
  `dataCadastro` date NOT NULL,
  `horaCadastro` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbconfigsite`
--

CREATE TABLE `tbconfigsite` (
  `idConfig` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL DEFAULT '0',
  `valor` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tbconfigsite`
--

INSERT INTO `tbconfigsite` (`idConfig`, `titulo`, `valor`) VALUES
(1, 'logo', 'b2274e679fbabf4ae261504fcddf734c.jpeg'),
(2, 'sobre', '<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec felis purus, ultricies id efficitur porta, lobortis a risus. Praesent semper semper sem, at posuere dolor tristique non. Suspendisse iaculis egestas sapien, sed scelerisque quam venenatis nec. Integer tempor orci vestibulum malesuada suscipit. Vivamus imperdiet mollis elit id hendrerit. Etiam congue ante non dolor sodales, a eleifend nulla blandit. Maecenas dictum, nisi sed molestie consectetur, magna dolor venenatis est, sit amet pretium metus sem quis nisi. Cras sem tortor, vehicula quis bibendum ut, commodo quis nibh. Cras in rutrum libero. Vestibulum rutrum orci non ipsum cursus tincidunt. Vivamus non nunc orci. Donec imperdiet risus urna, eget cursus urna mattis quis. Morbi egestas urna purus, cursus varius ex aliquet euismod. Curabitur elementum nulla sem, ac convallis neque eleifend eu. Proin ullamcorper rhoncus ultricies.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Fusce sit amet aliquet sapien. Donec scelerisque eget lacus vitae laoreet. Nulla a sapien ut diam volutpat bibendum quis ut tellus. Praesent nulla nibh, ornare sed odio id, pretium rutrum nunc. Nam consectetur purus nec commodo rutrum. Curabitur faucibus sit amet elit vel iaculis. Maecenas mollis leo porta mauris tempor bibendum. Sed sed nisi sed nisi rutrum laoreet. Cras pulvinar ipsum vitae euismod cursus. Quisque nisl magna, euismod ut rhoncus id, rutrum ac leo. Donec malesuada pulvinar libero, pharetra ultrices lectus bibendum in.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Pellentesque eleifend, sem dapibus rutrum scelerisque, nunc purus pulvinar ipsum, sed efficitur odio lectus non leo. Pellentesque euismod velit in faucibus feugiat. Pellentesque fermentum fermentum sodales. Nulla congue faucibus augue eget tempor. Etiam convallis vestibulum lacus sit amet porttitor. Cras porttitor nec tortor non hendrerit. Nullam sed odio gravida, ornare ligula ac, tempor ante. Donec gravida ante at metus pharetra, sed condimentum turpis gravida. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec maximus sodales elementum. Fusce viverra convallis orci ut scelerisque.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Integer semper tellus ligula, vitae varius justo consequat sed. Cras lacinia consectetur mi sed tempor. Maecenas varius molestie euismod. In volutpat libero at arcu viverra dignissim. Ut ultrices augue tempus leo malesuada dapibus. Aliquam accumsan tortor nec est euismod tincidunt. Etiam vel mauris id turpis sagittis commodo. In et libero sit amet ipsum tempor pellentesque. Suspendisse ac quam dolor. Morbi tincidunt molestie metus, ut gravida tortor elementum dignissim. Mauris porttitor turpis euismod turpis pulvinar, semper dictum erat venenatis. Aenean eu tellus ultrices ante porta pellentesque sit amet at velit. Nam consequat enim leo, non vulputate sem ornare et. Etiam eget imperdiet nisl, at semper orci. Etiam eu aliquet magna.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec felis purus, ultricies id efficitur porta, lobortis a risus. Praesent semper semper sem, at posuere dolor tristique non. Suspendisse iaculis egestas sapien, sed scelerisque quam venenatis nec. Integer tempor orci vestibulum malesuada suscipit. Vivamus imperdiet mollis elit id hendrerit. Etiam congue ante non dolor sodales, a eleifend nulla blandit. Maecenas dictum, nisi sed molestie consectetur, magna dolor venenatis est, sit amet pretium metus sem quis nisi. Cras sem tortor, vehicula quis bibendum ut, commodo quis nibh. Cras in rutrum libero. Vestibulum rutrum orci non ipsum cursus tincidunt. Vivamus non nunc orci. Donec imperdiet risus urna, eget cursus urna mattis quis. Morbi egestas urna purus, cursus varius ex aliquet euismod. Curabitur elementum nulla sem, ac convallis neque eleifend eu. Proin ullamcorper rhoncus ultricies.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Fusce sit amet aliquet sapien. Donec scelerisque eget lacus vitae laoreet. Nulla a sapien ut diam volutpat bibendum quis ut tellus. Praesent nulla nibh, ornare sed odio id, pretium rutrum nunc. Nam consectetur purus nec commodo rutrum. Curabitur faucibus sit amet elit vel iaculis. Maecenas mollis leo porta mauris tempor bibendum. Sed sed nisi sed nisi rutrum laoreet. Cras pulvinar ipsum vitae euismod cursus. Quisque nisl magna, euismod ut rhoncus id, rutrum ac leo. Donec malesuada pulvinar libero, pharetra ultrices lectus bibendum in.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Pellentesque eleifend, sem dapibus rutrum scelerisque, nunc purus pulvinar ipsum, sed efficitur odio lectus non leo. Pellentesque euismod velit in faucibus feugiat. Pellentesque fermentum fermentum sodales. Nulla congue faucibus augue eget tempor. Etiam convallis vestibulum lacus sit amet porttitor. Cras porttitor nec tortor non hendrerit. Nullam sed odio gravida, ornare ligula ac, tempor ante. Donec gravida ante at metus pharetra, sed condimentum turpis gravida. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec maximus sodales elementum. Fusce viverra convallis orci ut scelerisque.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Integer semper tellus ligula, vitae varius justo consequat sed. Cras lacinia consectetur mi sed tempor. Maecenas varius molestie euismod. In volutpat libero at arcu viverra dignissim. Ut ultrices augue tempus leo malesuada dapibus. Aliquam accumsan tortor nec est euismod tincidunt. Etiam vel mauris id turpis sagittis commodo. In et libero sit amet ipsum tempor pellentesque. Suspendisse ac quam dolor. Morbi tincidunt molestie metus, ut gravida tortor elementum dignissim. Mauris porttitor turpis euismod turpis pulvinar, semper dictum erat venenatis. Aenean eu tellus ultrices ante porta pellentesque sit amet at velit. Nam consequat enim leo, non vulputate sem ornare et. Etiam eget imperdiet nisl, at semper orci. Etiam eu aliquet magna.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec felis purus, ultricies id efficitur porta, lobortis a risus. Praesent semper semper sem, at posuere dolor tristique non. Suspendisse iaculis egestas sapien, sed scelerisque quam venenatis nec. Integer tempor orci vestibulum malesuada suscipit. Vivamus imperdiet mollis elit id hendrerit. Etiam congue ante non dolor sodales, a eleifend nulla blandit. Maecenas dictum, nisi sed molestie consectetur, magna dolor venenatis est, sit amet pretium metus sem quis nisi. Cras sem tortor, vehicula quis bibendum ut, commodo quis nibh. Cras in rutrum libero. Vestibulum rutrum orci non ipsum cursus tincidunt. Vivamus non nunc orci. Donec imperdiet risus urna, eget cursus urna mattis quis. Morbi egestas urna purus, cursus varius ex aliquet euismod. Curabitur elementum nulla sem, ac convallis neque eleifend eu. Proin ullamcorper rhoncus ultricies.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Fusce sit amet aliquet sapien. Donec scelerisque eget lacus vitae laoreet. Nulla a sapien ut diam volutpat bibendum quis ut tellus. Praesent nulla nibh, ornare sed odio id, pretium rutrum nunc. Nam consectetur purus nec commodo rutrum. Curabitur faucibus sit amet elit vel iaculis. Maecenas mollis leo porta mauris tempor bibendum. Sed sed nisi sed nisi rutrum laoreet. Cras pulvinar ipsum vitae euismod cursus. Quisque nisl magna, euismod ut rhoncus id, rutrum ac leo. Donec malesuada pulvinar libero, pharetra ultrices lectus bibendum in.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Pellentesque eleifend, sem dapibus rutrum scelerisque, nunc purus pulvinar ipsum, sed efficitur odio lectus non leo. Pellentesque euismod velit in faucibus feugiat. Pellentesque fermentum fermentum sodales. Nulla congue faucibus augue eget tempor. Etiam convallis vestibulum lacus sit amet porttitor. Cras porttitor nec tortor non hendrerit. Nullam sed odio gravida, ornare ligula ac, tempor ante. Donec gravida ante at metus pharetra, sed condimentum turpis gravida. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec maximus sodales elementum. Fusce viverra convallis orci ut scelerisque.</p>\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; background-color: #ffffff;\">Integer semper tellus ligula, vitae varius justo consequat sed. Cras lacinia consectetur mi sed tempor. Maecenas varius molestie euismod. In volutpat libero at arcu viverra dignissim. Ut ultrices augue tempus leo malesuada dapibus. Aliquam accumsan tortor nec est euismod tincidunt. Etiam vel mauris id turpis sagittis commodo. In et libero sit amet ipsum tempor pellentesque. Suspendisse ac quam dolor. Morbi tincidunt molestie metus, ut gravida tortor elementum dignissim. Mauris porttitor turpis euismod turpis pulvinar, semper dictum erat venenatis. Aenean eu tellus ultrices ante porta pellentesque sit amet at velit. Nam consequat enim leo, non vulputate sem ornare et. Etiam eget imperdiet nisl, at semper orci. Etiam eu aliquet magna.</p>\r\n<p>;</p>;'),
(3, 'corMenu', '#ffffff'),
(4, 'corFonteMenu', '#000000'),
(5, 'corPagina', '#ffffff'),
(6, 'tituloSobre', 'Sobre Mim'),
(7, 'whatsApp', '5511991457859'),
(8, 'emailContato', 'contato@marcossousafotografia.com'),
(9, 'numContato', '(11) 99999-4444'),
(10, 'bannerAbout', 'eda0d1bcef75e2540cf31c48a55ceabd.jpeg'),
(11, 'bannerContact', '296bb976b5ebc49d42c38639225b15c1.jpeg'),
(12, 'instagramLink', 'https://www.instagramTeste.com.br/'),
(13, 'emailLink', 'mailto:contato@marcossousafotografia.com'),
(14, 'pinterestLink', 'https://www.PinterestTeste.com/'),
(15, 'tituloSite', 'Fotografia'),
(16, 'descricaoSite', 'sdafdsfdsafds'),
(17, 'palavrasChave', 'teste/teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbdepoimentos`
--

CREATE TABLE `tbdepoimentos` (
  `idDepoimento` int(11) NOT NULL,
  `depoimento` mediumtext NOT NULL,
  `autor` varchar(100) NOT NULL DEFAULT '0',
  `dataDepoimento` date NOT NULL,
  `horaDepoimento` time NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tbdepoimentos`
--

INSERT INTO `tbdepoimentos` (`idDepoimento`, `depoimento`, `autor`, `dataDepoimento`, `horaDepoimento`, `idUsuario`) VALUES
(2, '<p>Nossa experiencia com o Marcos foi incrivel. O resultado das fotos nos surpreendeu. &Eacute; o tipo de fotografo que te deixa bem a vontade e o ensaio fica bem descontraido</p>', 'mauricio', '2021-04-07', '12:13:04', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbeventos`
--

CREATE TABLE `tbeventos` (
  `idEvento` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL DEFAULT 0,
  `dataEvento` date NOT NULL,
  `descricaoEvento` text NOT NULL,
  `comoEncontrou` varchar(150) DEFAULT NULL,
  `confirmar` tinyint(4) NOT NULL,
  `notificacao` tinyint(4) NOT NULL,
  `dataRegistroEvento` date DEFAULT NULL,
  `horaRegistroEvento` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbfichatecnica`
--

CREATE TABLE `tbfichatecnica` (
  `idFichaTecnica` int(11) NOT NULL,
  `idAlbum` int(11) NOT NULL DEFAULT 0,
  `html` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tbfichatecnica`
--

INSERT INTO `tbfichatecnica` (`idFichaTecnica`, `idAlbum`, `html`) VALUES
(32, 32, '<p>dfsafffffffffff</p>');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbfotos`
--

CREATE TABLE `tbfotos` (
  `idFoto` int(11) NOT NULL,
  `tituloFoto` varchar(1000) NOT NULL,
  `caminhoFoto` varchar(200) NOT NULL,
  `idAlbum` int(11) NOT NULL DEFAULT 0,
  `dataAdicao` date NOT NULL,
  `horaAdicao` time NOT NULL,
  `idUsuario` int(11) NOT NULL DEFAULT 0,
  `favorita` tinyint(4) NOT NULL DEFAULT 0,
  `dataFavoritada` date DEFAULT NULL,
  `horaFavoritada` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tbfotos`
--

INSERT INTO `tbfotos` (`idFoto`, `tituloFoto`, `caminhoFoto`, `idAlbum`, `dataAdicao`, `horaAdicao`, `idUsuario`, `favorita`, `dataFavoritada`, `horaFavoritada`) VALUES
(18, 'IMG_7205-Editar.jpg', 'imagens/albuns/ENSAIO DE CASAL/sdafffffffff/fotosAlbum/IMG_7205-Editar.jpg', 32, '2021-01-12', '16:44:25', 1, 0, NULL, NULL),
(19, 'IMG_7232-Editar.jpg', 'imagens/albuns/ENSAIO DE CASAL/sdafffffffff/fotosAlbum/IMG_7232-Editar.jpg', 32, '2021-01-12', '16:44:25', 1, 1, '2021-01-12', '16:47:47'),
(20, 'IMG_7259-Editar.jpg', 'imagens/albuns/ENSAIO DE CASAL/sdafffffffff/fotosAlbum/IMG_7259-Editar.jpg', 32, '2021-01-12', '16:44:25', 1, 0, NULL, NULL),
(21, 'IMG_7262-Editar.jpg', 'imagens/albuns/ENSAIO DE CASAL/sdafffffffff/fotosAlbum/IMG_7262-Editar.jpg', 32, '2021-01-12', '16:44:25', 1, 0, NULL, NULL),
(22, 'IMG_7266-Editar.jpg', 'imagens/albuns/ENSAIO DE CASAL/sdafffffffff/fotosAlbum/IMG_7266-Editar.jpg', 32, '2021-01-12', '16:44:25', 1, 1, '2021-01-12', '16:47:53'),
(23, 'IMG_7291-Editar 3.jpg', 'imagens/albuns/ENSAIO DE CASAL/sdafffffffff/fotosAlbum/IMG_7291-Editar 3.jpg', 32, '2021-01-12', '16:44:25', 1, 1, '2021-01-12', '16:47:51'),
(24, 'IMG_7302-Editar.jpg', 'imagens/albuns/ENSAIO DE CASAL/sdafffffffff/fotosAlbum/IMG_7302-Editar.jpg', 32, '2021-01-12', '16:44:25', 1, 1, '2021-01-12', '16:47:49'),
(25, 'IMG_7326-Editar.jpg', 'imagens/albuns/ENSAIO DE CASAL/sdafffffffff/fotosAlbum/IMG_7326-Editar.jpg', 32, '2021-01-12', '16:44:25', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbimagensartigo`
--

CREATE TABLE `tbimagensartigo` (
  `idimagensArtigo` int(11) NOT NULL,
  `urlImagem` varchar(400) NOT NULL DEFAULT '0',
  `idArtigo` int(11) NOT NULL DEFAULT 0,
  `nomeImagem` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tbimagensartigo`
--

INSERT INTO `tbimagensartigo` (`idimagensArtigo`, `urlImagem`, `idArtigo`, `nomeImagem`) VALUES
(1, 'imagens/artigos/SADDDDDDDDDDDDDDDD/fotosArtigo/Ensaio_Gestante_Gestação_Fotografia_de_gravida_Por_do_Sol_Pedra_Grande_Atibaia-3.jpg', 42, 'Ensaio_Gestante_Gestação_Fotografia_de_gravida_Por_do_Sol_Pedra_Grande_Atibaia-3.jpg'),
(3, 'imagens/artigos/SADDDDDDDDDDDDDDDD/fotosArtigo/Ensaio_Gestante_Gestação_Fotografia_de_gravida_Por_do_Sol_Pedra_Grande_Atibaia-3.jpg', 42, 'Ensaio_Gestante_Gestação_Fotografia_de_gravida_Por_do_Sol_Pedra_Grande_Atibaia-3.jpg'),
(4, 'imagens/artigos/SADDDDDDDDDDDDDDDD/fotosArtigo/Ensaio_Gestante_Gestação_Fotografia_de_gravida_Por_do_Sol_Pedra_Grande_Atibaia-6.jpg', 42, 'Ensaio_Gestante_Gestação_Fotografia_de_gravida_Por_do_Sol_Pedra_Grande_Atibaia-6.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbmenus`
--

CREATE TABLE `tbmenus` (
  `idMenu` int(11) NOT NULL,
  `numMenu` int(11) NOT NULL DEFAULT 0,
  `titulo` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tbmenus`
--

INSERT INTO `tbmenus` (`idMenu`, `numMenu`, `titulo`) VALUES
(1, 1, 'H o m e'),
(2, 2, 'H i s t ó r i a s'),
(3, 3, 'B l o g'),
(4, 4, 'M a r c o s'),
(5, 5, 'C o n t a t o');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbusuarios`
--

CREATE TABLE `tbusuarios` (
  `idUsuario` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '0',
  `password` varchar(500) NOT NULL DEFAULT '0',
  `ativo` tinyint(1) NOT NULL DEFAULT 0,
  `fotoPerfil` varchar(100) DEFAULT NULL,
  `permissoes` varchar(100) NOT NULL,
  `token` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tbusuarios`
--

INSERT INTO `tbusuarios` (`idUsuario`, `nome`, `email`, `password`, `ativo`, `fotoPerfil`, `permissoes`, `token`) VALUES
(1, 'Marcos', 'marcos@marcossousafotografia.com', '$2y$10$0AXiDbPrbZxA6wCnKM945.GXunwu415rjUPUNZ4AcdTRJEh/ph9iy', 1, 'user.png', 'ADM', '$2y$10$w75LJaAELz8aIn.Q.UKXrO/qdQdZGFa3RQJRv1J1FB3BUOsWFX.36');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbusuariotoken`
--

CREATE TABLE `tbusuariotoken` (
  `idToken` int(11) NOT NULL,
  `hash` varchar(500) NOT NULL DEFAULT '0',
  `idUsuario` int(11) NOT NULL DEFAULT 0,
  `expiradoEm` datetime NOT NULL,
  `ativo` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tbalbumfoto`
--
ALTER TABLE `tbalbumfoto`
  ADD PRIMARY KEY (`idAlbum`),
  ADD KEY `FK__tbusuarios` (`idUsuario`),
  ADD KEY `FK_tbalbumfoto_tbcategoriaalbum` (`idCategoria`);

--
-- Índices para tabela `tbarquivosartigos`
--
ALTER TABLE `tbarquivosartigos`
  ADD PRIMARY KEY (`idArquivoArtigo`);

--
-- Índices para tabela `tbarquivosclientes`
--
ALTER TABLE `tbarquivosclientes`
  ADD PRIMARY KEY (`idarquivocliente`),
  ADD KEY `FK_tbarquivosclientes_tbclientesebook` (`idClienteEbook`),
  ADD KEY `FK_tbarquivosclientes_tbarquivosartigos` (`idArquivoArtigo`);

--
-- Índices para tabela `tbartigos`
--
ALTER TABLE `tbartigos`
  ADD PRIMARY KEY (`idArtigo`),
  ADD KEY `FK_tbartigo_tbusuarios` (`idUsuario`);

--
-- Índices para tabela `tbcategoriaalbum`
--
ALTER TABLE `tbcategoriaalbum`
  ADD PRIMARY KEY (`idCategoria`) USING BTREE;

--
-- Índices para tabela `tbclientes`
--
ALTER TABLE `tbclientes`
  ADD PRIMARY KEY (`idCliente`);

--
-- Índices para tabela `tbclientesebook`
--
ALTER TABLE `tbclientesebook`
  ADD PRIMARY KEY (`idClienteEbook`);

--
-- Índices para tabela `tbconfigsite`
--
ALTER TABLE `tbconfigsite`
  ADD PRIMARY KEY (`idConfig`);

--
-- Índices para tabela `tbdepoimentos`
--
ALTER TABLE `tbdepoimentos`
  ADD PRIMARY KEY (`idDepoimento`);

--
-- Índices para tabela `tbeventos`
--
ALTER TABLE `tbeventos`
  ADD PRIMARY KEY (`idEvento`),
  ADD KEY `FK_tbevento_tbclientes` (`idCliente`);

--
-- Índices para tabela `tbfichatecnica`
--
ALTER TABLE `tbfichatecnica`
  ADD PRIMARY KEY (`idFichaTecnica`),
  ADD KEY `FK_tbfichatecnica_tbalbumfoto` (`idAlbum`);

--
-- Índices para tabela `tbfotos`
--
ALTER TABLE `tbfotos`
  ADD PRIMARY KEY (`idFoto`),
  ADD KEY `FK_tbfotos_tbalbumfoto` (`idAlbum`),
  ADD KEY `FK_tbfotos_tbusuarios` (`idUsuario`);

--
-- Índices para tabela `tbimagensartigo`
--
ALTER TABLE `tbimagensartigo`
  ADD PRIMARY KEY (`idimagensArtigo`),
  ADD KEY `FK_tbimagensartigo_tbartigos` (`idArtigo`);

--
-- Índices para tabela `tbmenus`
--
ALTER TABLE `tbmenus`
  ADD PRIMARY KEY (`idMenu`);

--
-- Índices para tabela `tbusuarios`
--
ALTER TABLE `tbusuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Índices para tabela `tbusuariotoken`
--
ALTER TABLE `tbusuariotoken`
  ADD PRIMARY KEY (`idToken`),
  ADD KEY `FK_tbusuariotoken_tbusuarios` (`idUsuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbalbumfoto`
--
ALTER TABLE `tbalbumfoto`
  MODIFY `idAlbum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `tbarquivosartigos`
--
ALTER TABLE `tbarquivosartigos`
  MODIFY `idArquivoArtigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tbarquivosclientes`
--
ALTER TABLE `tbarquivosclientes`
  MODIFY `idarquivocliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbartigos`
--
ALTER TABLE `tbartigos`
  MODIFY `idArtigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de tabela `tbcategoriaalbum`
--
ALTER TABLE `tbcategoriaalbum`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `tbclientes`
--
ALTER TABLE `tbclientes`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `tbclientesebook`
--
ALTER TABLE `tbclientesebook`
  MODIFY `idClienteEbook` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbconfigsite`
--
ALTER TABLE `tbconfigsite`
  MODIFY `idConfig` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `tbdepoimentos`
--
ALTER TABLE `tbdepoimentos`
  MODIFY `idDepoimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tbeventos`
--
ALTER TABLE `tbeventos`
  MODIFY `idEvento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `tbfichatecnica`
--
ALTER TABLE `tbfichatecnica`
  MODIFY `idFichaTecnica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `tbfotos`
--
ALTER TABLE `tbfotos`
  MODIFY `idFoto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `tbimagensartigo`
--
ALTER TABLE `tbimagensartigo`
  MODIFY `idimagensArtigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tbmenus`
--
ALTER TABLE `tbmenus`
  MODIFY `idMenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tbusuarios`
--
ALTER TABLE `tbusuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tbusuariotoken`
--
ALTER TABLE `tbusuariotoken`
  MODIFY `idToken` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tbalbumfoto`
--
ALTER TABLE `tbalbumfoto`
  ADD CONSTRAINT `FK__tbusuarios` FOREIGN KEY (`idUsuario`) REFERENCES `tbusuarios` (`idUsuario`),
  ADD CONSTRAINT `FK_tbalbumfoto_tbcategoriaalbum` FOREIGN KEY (`idCategoria`) REFERENCES `tbcategoriaalbum` (`idCategoria`);

--
-- Limitadores para a tabela `tbarquivosclientes`
--
ALTER TABLE `tbarquivosclientes`
  ADD CONSTRAINT `FK_tbarquivosclientes_tbarquivosartigos` FOREIGN KEY (`idArquivoArtigo`) REFERENCES `tbarquivosartigos` (`idArquivoArtigo`),
  ADD CONSTRAINT `FK_tbarquivosclientes_tbclientesebook` FOREIGN KEY (`idClienteEbook`) REFERENCES `tbclientesebook` (`idClienteEbook`);

--
-- Limitadores para a tabela `tbartigos`
--
ALTER TABLE `tbartigos`
  ADD CONSTRAINT `FK_tbartigo_tbusuarios` FOREIGN KEY (`idUsuario`) REFERENCES `tbusuarios` (`idUsuario`);

--
-- Limitadores para a tabela `tbeventos`
--
ALTER TABLE `tbeventos`
  ADD CONSTRAINT `FK_tbevento_tbclientes` FOREIGN KEY (`idCliente`) REFERENCES `tbclientes` (`idCliente`);

--
-- Limitadores para a tabela `tbfichatecnica`
--
ALTER TABLE `tbfichatecnica`
  ADD CONSTRAINT `FK_tbfichatecnica_tbalbumfoto` FOREIGN KEY (`idAlbum`) REFERENCES `tbalbumfoto` (`idAlbum`);

--
-- Limitadores para a tabela `tbfotos`
--
ALTER TABLE `tbfotos`
  ADD CONSTRAINT `FK_tbfotos_tbalbumfoto` FOREIGN KEY (`idAlbum`) REFERENCES `tbalbumfoto` (`idAlbum`),
  ADD CONSTRAINT `FK_tbfotos_tbusuarios` FOREIGN KEY (`idUsuario`) REFERENCES `tbusuarios` (`idUsuario`);

--
-- Limitadores para a tabela `tbimagensartigo`
--
ALTER TABLE `tbimagensartigo`
  ADD CONSTRAINT `FK_tbimagensartigo_tbartigos` FOREIGN KEY (`idArtigo`) REFERENCES `tbartigos` (`idArtigo`);

--
-- Limitadores para a tabela `tbusuariotoken`
--
ALTER TABLE `tbusuariotoken`
  ADD CONSTRAINT `FK_tbusuariotoken_tbusuarios` FOREIGN KEY (`idUsuario`) REFERENCES `tbusuarios` (`idUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
