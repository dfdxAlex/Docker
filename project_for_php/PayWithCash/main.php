<?php

$ex = true;
$balanceOfPort = 0;

while ($ex):
    echo("\n\r");
    echo("Новый посетитель прибыл в порт Ройал\n\r");
    echo('Порт Ройал: баланс порта (в шилингах)'. $balanceOfPort);
    echo("\n\rШвартовщик: Эй, а ну постой. \n\r");
    echo("Швартовщик: Пришвартоваться у причала стоит шилинг\n\r");
    echo('Швартовщик: И назови своё имя ');
    $MyName = trim(fgets(STDIN));

    if ($MyName === "exit") {
        $ex = false;
    }

    if ($MyName === ""):
        echo("Вы: Может лучше три шилинга, а имя ... чёрт с ним?\n\r");
        echo("Швартовщик: С прибытием в порт Ройал мистер Смит!\n\r");
        $balanceOfPort = $balanceOfPort + 3;
    else:
        echo("Вы: Возьми шилинг и ни в чём себе не отказывай\n\r");
        $balanceOfPort = $balanceOfPort + 1;
        echo 'Швартовщик: С прибытием в порт Ройал мистер '. $MyName."\n\r";
    endif;
endwhile;
?>
