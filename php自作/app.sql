-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2021-12-02 09:51:06
-- サーバのバージョン： 10.4.21-MariaDB
-- PHP のバージョン: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `app`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `browsingstories`
--

CREATE TABLE `browsingstories` (
  `user_id` varchar(20) DEFAULT NULL COMMENT 'ユーザーID',
  `junre` varchar(50) DEFAULT NULL COMMENT 'ジャンル',
  `count` int(11) DEFAULT 0 COMMENT '閲覧回数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `browsingstories`
--

INSERT INTO `browsingstories` (`user_id`, `junre`, `count`) VALUES
('Okuda11', 'アクション', 26),
('Okuda11', 'あ　う', 1),
('Okuda11', 'ホラー', 4),
('Miyaji09', 'ホラー', 4),
('Miyaji09', 'アクション', 3),
('takuya22', 'ホラー', 3),
('takuya22', 'アクション', 4),
('takuya22', 'ダークアクション', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL COMMENT '投稿者ID',
  `content` varchar(100) NOT NULL COMMENT 'チャット内容',
  `time` time NOT NULL DEFAULT current_timestamp() COMMENT 'チャット日時',
  `opponent_user_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `chats`
--

INSERT INTO `chats` (`id`, `user_id`, `content`, `time`, `opponent_user_id`) VALUES
(190, 'Miyaji09', 'こんにちは。', '13:54:43', 'takuya22'),
(191, 'takuya22', 'こんにちは。', '16:46:49', 'Okuda11');

-- --------------------------------------------------------

--
-- テーブルの構造 `fav`
--

CREATE TABLE `fav` (
  `id` int(11) NOT NULL,
  `user_id` varchar(20) DEFAULT NULL COMMENT 'ユーザーID',
  `del_flg` int(11) DEFAULT 0,
  `post_id` int(11) DEFAULT NULL COMMENT '投稿ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `fav`
--

INSERT INTO `fav` (`id`, `user_id`, `del_flg`, `post_id`) VALUES
(160, 'Okuda11', 0, 92),
(165, 'takuya22', 1, 105);

-- --------------------------------------------------------

--
-- テーブルの構造 `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `name` varchar(60) DEFAULT NULL COMMENT 'ゲーム名',
  `junre` varchar(30) NOT NULL COMMENT 'ジャンル名',
  `value` int(11) NOT NULL COMMENT '自己評価値',
  `user_id` varchar(20) DEFAULT NULL COMMENT '投稿者ID',
  `intro` varchar(500) NOT NULL COMMENT '紹介コメント',
  `time` datetime DEFAULT current_timestamp(),
  `fav` int(11) NOT NULL COMMENT 'いいね！の数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `games`
--

INSERT INTO `games` (`id`, `name`, `junre`, `value`, `user_id`, `intro`, `time`, `fav`) VALUES
(85, 'アストラルチェイン', 'アクション', 4, 'Okuda11', 'テストテストテストテスト\r\nテストテストテストテスト\r\n\r\n\r\nテストテストテストテストテスト\r\n\r\nテストテストテストテスト\r\nテストテストテスト\r\nテストテスト\r\nテストテスト\r\n\r\nテストテストテストテスト\r\nvテストテストテスト\r\nテストテスト', '2021-12-01 14:41:29', 0),
(104, 'DarkSoul', 'ダークアクション', 3, 'Okuda11', 'aefapoiweufhawoeiufhoawileuhfoawielugfhla\r\nieuwrfholiaerjflaierugぉｗ；うえｊｇふぉ\r\nいえるｆｈｌれいすｇｈぃれうｇｓｈぃえｒ\r\nｊｇぇいｗｒぐｈわｓ', '2021-12-02 13:50:12', 0),
(105, 'バイオハザード', 'ホラー', 4, 'Miyaji09', 'sdiuoahsdoigfuaerpofiuresgo9ruiheagourhgo\r\nliaeurfghliesroughreijgasleriujgrelsiugal\r\norejghl;oewrjglse;oriughrlei', '2021-12-02 13:51:04', 0),
(108, 'アストラルチェイン', 'アクション', 3, 'takuya22', 'qwfawegserthgwesrthesrptiohjsoptihgjpsodr\r\nitghjsfoepdigjsretigujhbvedpszhblriul;giz\r\nvuerhgolerushgsiolureghosirltg', '2021-12-02 16:47:31', 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `chat_id` varchar(20) NOT NULL COMMENT 'チャットID',
  `password` varchar(20) NOT NULL COMMENT 'パスワード',
  `role` int(11) NOT NULL COMMENT '権限:1=管理者 0=一般ユーザー',
  `ban_flg` int(11) NOT NULL DEFAULT 0 COMMENT 'アカウント処分フラグ:1=処分 0=未処分',
  `image_path` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `chat_id`, `password`, `role`, `ban_flg`, `image_path`) VALUES
(27, 'Okuda11', 'infelnity22', 0, 0, NULL),
(28, 'Miyaji09', 'stupid22', 0, 0, NULL),
(41, '12345678', 'aaaaaaaa', 0, 0, NULL),
(42, 'takuya22', 'dream1022', 0, 0, NULL);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `fav`
--
ALTER TABLE `fav`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- テーブルの AUTO_INCREMENT `fav`
--
ALTER TABLE `fav`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- テーブルの AUTO_INCREMENT `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
