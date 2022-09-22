<?php
if(! isset($_SESSIONS)){
    session_start();
}

echo json_encode($_SESSION);