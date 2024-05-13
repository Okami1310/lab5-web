<?php
require_once 'function.php';

function baza(): void {
    $publications = [
        [
            'id' => 1,
            'title' => 'Курячі рулетики з грибами',
            'content' => 'Курячі рулетики з грибами прикрасять будь-який святковий стіл, що вже казати, про звичайному вечері. Рулетики виходять мякі, ніжні, а всередині сюрприз: смажені шампіньйони з цибулею ідеально доповнюють все це блюдо. Таке необхідно спробувати кожному, хоч раз у житті – смакота!',
            'author' => 'cookery',
            'image' => '1.jpg',
            'created' => '2024-04-20 22:00:00',

        ],
         [
            'id' => 2,
            'title' => 'Помідори по-корейськи',
            'content' => 'Ви любите пікантні овочеві страви – закуски? Тоді помідори по-корейськи можуть стати родзинкою вашого святкового або повсякденного столу. Ніжний, в міру гостре і дуже насичене страва підкорить вас своїм ароматом і смаком!',
            'author' => 'cookery',
            'image' => '6.jpg',
            'created' => '2024-04-19 18:00:00',

        ]
    ];

    $pdo = getDbConnection();
    foreach ($publications as $publication) {
        $sql = "INSERT INTO articles SET title = '{$publication['title']}', content = '{$publication['content']}', author = '{$publication['author']}', image = '{$publication['image']}', created = '{$publication['created']}'";
        $result = $pdo->exec($sql);
        if (false === $result) {
            var_dump($pdo->errorInfo());
            http_response_code(500);
        }
    }
}

/*create table articles
(
    id      int auto_increment
        primary key,
    title   varchar(100)  not null,
    content varchar(1000) not null,
    author  varchar(100)  not null,
    image   varchar(50)   not null,
    created datetime  not null
);*/
