<?php
    if(!isset($_SESSION)){
        session_save_path("/tmp");
        session_start();
    }

    if( posix_kill( $_SESSION['procees_pid'], 0 ) ) {
        unset( $_SESSION['procees_pid'] );
    }
?>