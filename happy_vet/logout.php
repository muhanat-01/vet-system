<?php
include "connect.php"                    // najaribu kutengenexa logout ya from farmers side

session_start();

session_unset();
session_destroy();

header("Location: happy_vet/login.html");  // hiii ikon happy_vet/login labda hiio ndo shida jaribu kutoa
exit();
?>
