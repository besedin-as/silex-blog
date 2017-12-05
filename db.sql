CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `body` text COLLATE utf8_general_ci NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip_address` varchar(255) COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `comments` (`id`, `body`, `id_user`, `id_article`, `created`, `ip_address`) VALUES
(1, 'First.', 1, 1, '2016-01-15 01:53:33', '192.168.20.1'),
(2, 'Second.', 3, 1, '2016-01-15 01:53:33', '192.168.20.3'),
(3, 'Third.', 1, 1, '2016-01-15 02:01:48', '192.168.20.1');

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `body` text COLLATE utf8_general_ci NOT NULL,
  `id_user` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `slug` varchar(255) COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `posts` (`id`, `title`, `body`, `id_user`, `created`, `slug`) VALUES
(1, 'First news', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae dolorem sint recusandae quasi voluptatibus vero et natus eaque fugiat blanditiis, molestiae, nulla esse consequuntur. Ex itaque ipsam aspernatur. Ab quibusdam, soluta similique obcaecati veniam minus, tempora eum numquam accusantium aut quaerat beatae hic minima consectetur illum corporis veritatis adipisci, fuga?', 1, '2015-12-26 19:12:58', 'first-news'),
(2, 'Second news', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae dolorem sint recusandae quasi voluptatibus vero et natus eaque fugiat blanditiis, molestiae, nulla esse consequuntur. Ex itaque ipsam aspernatur. Ab quibusdam, soluta similique obcaecati veniam minus, tempora eum numquam accusantium aut quaerat beatae hic minima consectetur illum corporis veritatis adipisci, fuga?', 1, '2015-12-26 19:12:58', 'second-news'),
(3, 'Third news', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae dolorem sint recusandae quasi voluptatibus vero et natus eaque fugiat blanditiis, molestiae, nulla esse consequuntur. Ex itaque ipsam aspernatur. Ab quibusdam, soluta similique obcaecati veniam minus, tempora eum numquam accusantium aut quaerat beatae hic minima consectetur illum corporis veritatis adipisci, fuga?', 1, '2015-12-26 19:13:29', 'third-news');

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL,
  `roles` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `username`, `password`, `email`, `roles`) VALUES
(1, 'admin', 'tuWbMbA3Yqz/kgV5OGwAabKFDYbw8q6WW6Q25fAZ+50ShYjkhVqRYoMiNi5umxBF+UjWYjMs0hEVn4Fk6zXSLg==', '', 'ROLE_ADMIN');
