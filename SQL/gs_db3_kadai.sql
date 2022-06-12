-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2022 年 6 月 11 日
-- サーバのバージョン： 5.7.32
-- PHP のバージョン: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `gs_db3_kadai.sql`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `gs_user_table_with_photo`
--

CREATE TABLE `gs_user_table_with_photo` (
  `id` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `lid` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `lpw` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `Wants_flg` int(1) NOT NULL,
  `Done_flg` int(1) NOT NULL DEFAULT '0',
  `img` varchar(256) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- テーブルのデータのダンプ `gs_user_table_with_photo`
--

INSERT INTO `gs_user_table_with_photo` (`id`, `name`, `lid`, `lpw`, `Wants_flg`, `Done_flg`, `img`) VALUES
(1, '田中', 'id1', 'pw1', 0, 1, '41B4Qu9BLBL._SX343_BO1,204,203,200_.jpg'),
(3, '田中', 'id2', 'pw2', 0, 1, '41GTtfeR26L._SX367_BO1,204,203,200_.jpg'),
(4, '山田', 'id3', 'pw3', 0, 0, '51e9kw1ENiL._SY370_BO1,204,203,200_.jpg'),
(5, 'John', 'id4', 'pw4', 1, 0, ''),
(7, 'Tom', '0', '0', 1, 0, ''),
(8, '0', '0', '0', 1, 0, '');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `gs_user_table_with_photo`
--
ALTER TABLE `gs_user_table_with_photo`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `gs_user_table_with_photo`
--
ALTER TABLE `gs_user_table_with_photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
