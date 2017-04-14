<?php
require_once "classes/module/connect.class.php";

$time = connect::get_millisecond();
$a = $time - 3600*10000;
$b = $time - 100*10000;
$c = $time - 36000*10000;

connect::query("INSERT into jnp_fortune_event_history select * from jnp_fortune_event where time < $b ");
connect::query(" delete from jnp_fortune_event  where time < $b");

/*connect::query("INSERT into jnp_fortune_packet_info_history select * from jnp_fortune_packet_info where create_at < $a");
connect::query("  delete from jnp_fortune_packet_info  where create_at < $a");
connect::query(" INSERT into jnp_fortune_packet_history select * from jnp_fortune_packet where create_at < $c");
connect::query("delete from jnp_fortune_packet  where create_at < $c");*/