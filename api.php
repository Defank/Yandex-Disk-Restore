<?php

require_once 'vendor/autoload.php';

$token = 'ваш токен сюда';

$disk = new Arhitector\Yandex\Disk($token);

try {

    switch ($_POST['type']) {
        case 'restore':
            $aTrashResources = $disk->getTrashResources(1, 0)->getIterator();
            foreach ($aTrashResources as $oResource) {
                $oResource->restore();
            }
            break;
        case 'total_count':
            echo $disk->getTrashResource('trash:/', $limit = 1, $offset = 0)->toArray()['total'];
            break;
    }

} catch (Exception $exc) {
    http_response_code(403);
    echo $exc->getMessage();
}