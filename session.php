<?php

   date_default_timezone_set('Europe/Berlin');

   ini_set('session.cookie_lifetime', 7 * 24 * 60 * 60);
   ini_set('session.gc_maxlifetime', 7 * 24 * 60 * 60);
   ini_set('session.save_path', dirname(__FILE__) . '/assets/sessions');

   session_start();
