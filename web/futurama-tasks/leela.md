# Leela

![Leela](https://trello-attachments.s3.amazonaws.com/57e50abe9d8488ae13f33d8c/5a0412e6a4eddc571ebadc30/0f82f6beffbbd5433aa4c9f9341c6302/Futurama-Leela.jpg)

**Description:** У Лилы сломалась страница, но ей срочно нужно получить важную страницу, которая там была. Помоги ей это сделать

**Author:** tiso a.k.a. tisOOv

**Category:** Web

**Score:** 150

**Note:** Для локального запуска запуска сервиса необходимо перейти в директорию source и выполнить указания из README.md

**Write-up:** Последнее задание, которое требует небольших познаний в программировании.


Посетим страницу Лилы. При заходе на страницу мы можем отметить, что кроме Лилы на страницы есть форма отправки, но она выглядит какой-то странной. Из задания мы знаем, что форма сломана. Давайте посмотрим исходный код страницы:

```html
<html>
<head>
    <title>Leela</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>
    <div class="container">
            <img src="static/leela_eye.gif"/>
            <div class="col-lg-4 col-lg-offset-4">
                <div class="input-group">
                    <form action="" method="post">
                    <!--<input id="name" type="password" class="form-control" />  -->
                    <input id="secret" type="password" class="form-control" /> 
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">Get info!</button>
                    </span>
                    </form>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-4 -->
    </div>
</body>
</html>

```

Хм, мы видим, что на странице есть форма, которую можно отправить на сервер методом POST. Одно из полей закомментировано, это поле "name". Попробуем раскоментировать и отправить данные. Но на самом деле я бы предложил воспользоваться вам curl'ом, и ничего не чинить. То есть мы можем из браузера скопировать POST-запрос в виде curl (нужно лишь открыть инструменты разработчика, перейти в раздел **Network**, жамкнуть на кпопку "Get Info" и скопировать post-запрос в виде curl):

```bash
curl 'http://localhost:9080/leela.php' -H 'Host: localhost:9080' -H 'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' -H 'Accept-Language: en-US,en;q=0.5' --compressed -H 'Referer: http://localhost:9080/leela.php' -H 'Content-Type: application/x-www-form-urlencoded' -H 'Cookie: Pycharm-1b24b76c=6fb7d582-0b5f-4cfc-9367-6dc6035dfbce; fry_flag=SVRGe0ZSWVNASURIRUxMTExMT09PT09PfQo%3D' -H 'Connection: keep-alive' -H 'Upgrade-Insecure-Requests: 1' --data ''
```

Теперь мы можем выполнить данную команду в консоли (linux), "счастливым" обладателям Windows советую или поставить Ubuntu for Windows (Windows10), или поставить один из дистрибутивов Linux на виртуальную машину (лучший выбор, пожалуй, будет Kali Linux). На самом деле Вам стоит это сделать как можно скорее, потому что исследователь по безопасности должен дружить с Linux, а инструментов, которые предоставляет Windows, Вам часто не будет хватать.

Дополним аргумент --data полями, которые присутствуют в форме:

```bash
curl 'http://localhost:9080/leela.php' -H 'Host: localhost:9080' -H 'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' -H 'Accept-Language: en-US,en;q=0.5' --compressed -H 'Referer: http://localhost:9080/leela.php' -H 'Content-Type: application/x-www-form-urlencoded' -H 'Cookie: Pycharm-1b24b76c=6fb7d582-0b5f-4cfc-9367-6dc6035dfbce; fry_flag=SVRGe0ZSWVNASURIRUxMTExMT09PT09PfQo%3D' -H 'Connection: keep-alive' -H 'Upgrade-Insecure-Requests: 1' --data 'name=asd&secret=asd'
```

Если выполним подобный запрос, то в результате мы получим "ничего полезного". А всё потому, что в качестве значений мы подставили *asd*. Наверное, там должно быть что-то более вразумительное... Небольшое отступление: исследователь, который анализирует защищенность приложений, часто сталкивается с тем, что ему нужно гадать. Ему нужно думать, как именно решить ту или иную проблему, он должен мыслить творчески, если у него что-то не получается, он не должен опускать руки, он должен пытаться ещё раз и ещё раз, до тех пор, пока у него не иссякнуть полностью силы, или он не сможет всё-таки решить эту проблему... В данном случае мы тоже должны придумать то, какие значения на странице Лилы мы должны ввести в форму. На странице **Лилы**. Понимаете, к чему я клоню? Наверное, всё-таки в поле **name** на странице **Лилы** должно быть её имя? давайте попробуем:


```bash
curl 'http://localhost:9080/leela.php' -H 'Host: localhost:9080' -H 'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' -H 'Accept-Language: en-US,en;q=0.5' --compressed -H 'Referer: http://localhost:9080/leela.php' -H 'Content-Type: application/x-www-form-urlencoded' -H 'Cookie: Pycharm-1b24b76c=6fb7d582-0b5f-4cfc-9367-6dc6035dfbce; fry_flag=SVRGe0ZSWVNASURIRUxMTExMT09PT09PfQo%3D' -H 'Connection: keep-alive' -H 'Upgrade-Insecure-Requests: 1' --data 'name=Leela&secret=asd'
```

Эмм, не прокатило. Ноо! Мы не поменяли поле secret. Наверное, всё-таки и поле secret должно содержать какой-то секретный секрет. Тут уже ничего кроме брутфорса нас не спасет. Мы можем попробовать накидать скрипт и перебрать различные известные пароли по словарю. Но прежде, чем мы это сделаем, давайте попробуем в поле **secret** написать **secret**. Why not? Может прокатит... :)

```bash
curl 'http://localhost:9080/leela.php' -H 'Host: localhost:9080' -H 'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' -H 'Accept-Language: en-US,en;q=0.5' --compressed -H 'Referer: http://localhost:9080/leela.php' -H 'Content-Type: application/x-www-form-urlencoded' -H 'Cookie: Pycharm-1b24b76c=6fb7d582-0b5f-4cfc-9367-6dc6035dfbce; fry_flag=SVRGe0ZSWVNASURIRUxMTExMT09PT09PfQo%3D' -H 'Connection: keep-alive' -H 'Upgrade-Insecure-Requests: 1' --data 'name=Leela&secret=secret'
```

Иииии...

```html
ITF{EasYP@ssssw0rd}<html>
<head>
    <title>Leela</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>
    <div class="container">
            <img src="static/leela_eye.gif"/>
            <div class="col-lg-4 col-lg-offset-4">
                <div class="input-group">
                    <form action="" method="post">
                    <!--<input id="name" type="password" class="form-control" />  -->
                    <input id="secret" type="password" class="form-control" /> 
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">Get info!</button>
                    </span>
                    </form>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-4 -->
    </div>
</body>
</html>

```

Прокатило!!! Флаг - ```ITF{EasYP@ssssw0rd}``` Мы сделали это, всего-то - не стоит сразу опускать руки :)
