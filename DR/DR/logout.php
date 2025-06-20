<?php
session_start();
session_unset();
session_destroy();
header("Location: /dapur_rasa/semua.php");
exit;
