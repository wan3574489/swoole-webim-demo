<?php

require_once "config.inc.php";
require_once "emotion.config.php";
require_once "functions.php";
require_once "classes/module/connect.class.php";
require_once "classes/module/message.class.php";
require_once "classes/module/event.class.php";
require_once "classes/module/packet.class.php";
require_once "classes/".STORAGE."/ChatBase.class.php";
require_once "classes/".STORAGE."/File.class.php";
require_once "classes/".STORAGE."/ChatUser.class.php";
require_once "classes/".STORAGE."/ChatLine.class.php";
require_once "classes/Chat.class.php";
require_once "classes/hsw.class.php";

@file_put_contents(__DIR__."/hsw_server.pid",posix_getpid());

$server = new hsw();

