<?php

session_start();

$_SESSION['input'] = "<span data-ty='input'>{$_POST['input']}</span>" .
"<span data-ty='progress'></span>" .
"<span data-ty>OK</span>";

//header('Location: ' . $_SERVER['HTTP_REFERER']);