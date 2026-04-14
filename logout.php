<?php
session_start();
session_unset();
session_destroy();
header("Location:x-login.html");
exit();
