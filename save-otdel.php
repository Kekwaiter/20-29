<?php
    require_once 'secure.php';
    if (!Helper::can('admin') && !Helper::can('manager')) {
        header('Location: 404.php');
        exit();
    }

    if (isset($_POST['otdel_id'])) {
        $otdel = new otdel();
        $otdel->otdel_id = Helper::clearInt($_POST['otdel_id']);
        $otdel->name = Helper::clearString($_POST['name']);
        $otdel->active = Helper::clearInt($_POST['active']);
        if ((new otdelMap())->save($otdel)) {
            header('Location: view-otdel.php?id='.$otdel->otdel_id);
        } 
        else {
            if ($otdel->otdel_id) {
                header('Location: add-otdel.php?id='.$otdel->otdel_id);
            } 
            else {
                header('Location: add-otdel.php');
            }
        }
    }