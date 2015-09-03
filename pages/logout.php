<?php
//@ignore
if (!defined('IN_INDEX')) {
    exit();
}

session_destroy();
error("Delogarea a avut succes! <meta http-equiv='refresh' content='1; URL=?page=home' />", "success")
?>