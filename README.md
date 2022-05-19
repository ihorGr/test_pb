<h1 align="center">
  Test PB
</h1>

## Запуск приложения
1. Git: git clone https://github.com/ihorGr/test_pb.git
2. cd ./test-pb
3. Docker: docker-compose --project-directory ./ up --build
4. Composer: В php-cli контейнере выполнить - composer install
5. Database: В php-cli контейнере выполнить - php bin/console doctrine:migrations:migrate
6. Fixtures: В php-cli контейнере выполнить - php bin/console doctrine:fixtures:load --group=PriceTestFixtures --group=CurrencyPairTestFixtures

## APi
### Получение курса криптовалюты  <br>
Получение курса криптовалюты за пределенный промежуток времени.

#### HTTP Request
`GET /api/get_prices?currency_pair={currency_pair}&from={from}&to={to}`

#### Параметры:<br>
-. `currency_pair` string (required) - валютная пара(прим. BTC-USD, BTC-EUR. и тд). Имеет строгий формат записи, 
3 символа в верхнем регистре одной валюты разделены знаком "-" с  3 символа в верхнем регистре другой валюты.<br>
-. `from` timestring (required) - дата старта диапазона, имеет строгий формат Y-m-d H:i:s<br>
-. `to` timestring (required) - дата конца диапазона, имеет строгий формат Y-m-d H:i:s<br>

#### HTTP Response

Example:
```json 
{
    "data":
        {
            "currency_pair":"BTC-EUR",
            "prices":
                [
                    {"value":"25390.96","time":"2022-05-19 09:37:09"},
                    {"value":"27155.25","time":"2022-05-19 08:37:09"},
                    {"value":"24314.41","time":"2022-05-19 07:37:09"},
                    {"value":"25757.59","time":"2022-05-19 06:37:09"}
                ]
        }
}
```

## Source
Отвечает за получение данных с удаленного источника.
Осуществляется через запуск комманды в терминале. При виполнении комманды получаем текущий валютный курс всех активных пар и сохраняем в БД. 
Для получения курсов о определенные интервалы запускаем комманду через крон(с укразанием нужного интервала запуска).

В php-cli контейнере выполнить:
```shell
php bin/console task-pb:get-cryptocurrency-price
```

## Storage
Отвечает за взаимодействие(запись/чтение) с хранилищем(БД). 