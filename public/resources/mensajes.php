<?php
if(isset($_SESSION['mensaje'])){
    echo "<h6 class='bg-dark text-light my-3 p-2'>{$_SESSION['mensaje']}</h6>";
    unset($_SESSION['mensaje']);
}