ex = True
balanceOfPort = 0

while ex:
    print('\r\r\r\r')
    print('Новый посетитель прибыл в порт Ройал')
    print('Порт Ройал: баланс порта (в шилингах)', balanceOfPort)
    print('Швартовщик: Эй, а ну постой.')
    print('Швартовщик: Пришвартоваться у причала стоит шилинг')
    MyName = input('Швартовщик: И назови своё имя ')

    if MyName == 'exit':
        ex = False

    if MyName == '':
        print('Вы: Может лучше три шилинга, а имя ... чёрт с ним?')
        print('Швартовщик: С прибытием в порт Ройал мистер Смит!')
        balanceOfPort = balanceOfPort + 3
    else:
        print('Вы: Возьми шилинг и ни в чём себе не отказывай')
        balanceOfPort = balanceOfPort + 1
        print('Швартовщик: С прибытием в порт Ройал мистер ', MyName)
    
    
