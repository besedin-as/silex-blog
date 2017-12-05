<?php

for ($i = 18; $i < 500; $i++){
    $s = "INSERT INTO `posts`(`id`, `title`, `body`, `id_user`, `created`, `slug`) VALUES (".$i.",'test post','test body....', 2,'2015-12-26 19:12:58','test postik');";
    echo $s."\n";
}