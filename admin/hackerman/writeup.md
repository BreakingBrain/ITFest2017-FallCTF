# Хакерман-трафикмен 

![Hackerman](https://trello-attachments.s3.amazonaws.com/57e50abe9d8488ae13f33d8c/5a2c327f99b4142ceb95ea99/d56757398d3e180b5a54c2cadecada7b/4d7.png)

**Description:** Наш профессиональный хакер перехватил трафик, но вот нужный файл вытащить не сумел. Попробуй посмотри, может ты что-нибудь сможешь вынести полезного из него

**Hint:** Ищите basic auth

**Author:** tiso a.k.a. tisOOv

**Category:** Admin, Stegastic

**Score:** 300

**Note:** Файл трафика находится в директории source

**Write-up:**

Анализ трафика бывает довольно нудным и скучным делом, которое требует от исследователя усидчивости. Поэтому давайте запасёмся терпением, откроем wireshark и приступим к анализу перехваченного трафика.

Для начала мы можем просто пройтись глазами по всему трафику, но это займёт некоторое время, поэтому для начала я бы предложил попробовать поискать в трафике что-то, что может быть связано с сервисом соревнований, то есть с breakingbrain. Это сделать не так сложно, как Вам может показаться: вам нужно выбрать поиск по байтам в пакете и в качестве строки поиска указать **breakingbrain**. Wireshark услужливо Вам предложит кучу пакетов, часть из них это dns-трафик, который нас не особо интересует, пойдём дальше. Следующий пакет является Get запросом, вот тут уже стоит быть внимательнее. Wireshark предоставляет возможность посмотреть весь поток HTTP-общения, это можно сделать, если на пакете выбрать опцию **Follow HTTP stream**:

```
GET / HTTP/1.1
Host: itfest2017.breakingbrain.org:8002
User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
Accept-Language: en-US,en;q=0.5
Accept-Encoding: gzip, deflate
Connection: keep-alive
Upgrade-Insecure-Requests: 1

HTTP/1.1 401 Unauthorized
Server: nginx/1.10.3 (Ubuntu)
Date: Sat, 09 Dec 2017 20:01:40 GMT
Content-Type: text/html
Content-Length: 204
Connection: keep-alive
WWW-Authenticate: Basic realm="Restricted"

<html>
<head><title>401 Authorization Required</title></head>
<body bgcolor="white">
<center><h1>401 Authorization Required</h1></center>
<hr><center>nginx/1.10.3 (Ubuntu)</center>
</body>
</html>
GET / HTTP/1.1
Host: itfest2017.breakingbrain.org:8002
User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
Accept-Language: en-US,en;q=0.5
Accept-Encoding: gzip, deflate
Connection: keep-alive
Upgrade-Insecure-Requests: 1
Authorization: Basic YXNkOmFzZA==

HTTP/1.1 401 Unauthorized
Server: nginx/1.10.3 (Ubuntu)
Date: Sat, 09 Dec 2017 20:01:43 GMT
Content-Type: text/html
Content-Length: 204
Connection: keep-alive
WWW-Authenticate: Basic realm="Restricted"

<html>
<head><title>401 Authorization Required</title></head>
<body bgcolor="white">
<center><h1>401 Authorization Required</h1></center>
<hr><center>nginx/1.10.3 (Ubuntu)</center>
</body>
</html>
GET / HTTP/1.1
Host: itfest2017.breakingbrain.org:8002
User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
Accept-Language: en-US,en;q=0.5
Accept-Encoding: gzip, deflate
Connection: keep-alive
Upgrade-Insecure-Requests: 1
Authorization: Basic c2VjcmV0OmFzZA==

HTTP/1.1 401 Unauthorized
Server: nginx/1.10.3 (Ubuntu)
Date: Sat, 09 Dec 2017 20:01:47 GMT
Content-Type: text/html
Content-Length: 204
Connection: keep-alive
WWW-Authenticate: Basic realm="Restricted"

<html>
<head><title>401 Authorization Required</title></head>
<body bgcolor="white">
<center><h1>401 Authorization Required</h1></center>
<hr><center>nginx/1.10.3 (Ubuntu)</center>
</body>
</html>
GET / HTTP/1.1
Host: itfest2017.breakingbrain.org:8002
User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
Accept-Language: en-US,en;q=0.5
Accept-Encoding: gzip, deflate
Connection: keep-alive
Upgrade-Insecure-Requests: 1
Authorization: Basic c2VjcmV0OlMzY3JldA==

HTTP/1.1 200 OK
Server: nginx/1.10.3 (Ubuntu)
Date: Sat, 09 Dec 2017 20:01:52 GMT
Content-Type: text/html
Transfer-Encoding: chunked
Connection: keep-alive
Content-Encoding: gzip

<html>
<head><title>Index of /</title></head>
<body bgcolor="white">
<h1>Index of /</h1><hr><pre><a href="../">../</a>
<a href="linux.png">linux.png</a>                                          09-Dec-2017 19:50              229700
<a href="music.mp3">music.mp3</a>                                          09-Dec-2017 19:49            13704192
<a href="readme.txt">readme.txt</a>                                         09-Dec-2017 19:51                  28
</pre><hr></body>
</html>
GET /favicon.ico HTTP/1.1
Host: itfest2017.breakingbrain.org:8002
User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
Accept-Language: en-US,en;q=0.5
Accept-Encoding: gzip, deflate
Authorization: Basic c2VjcmV0OlMzY3JldA==
Connection: keep-alive

HTTP/1.1 404 Not Found
Server: nginx/1.10.3 (Ubuntu)
Date: Sat, 09 Dec 2017 20:01:52 GMT
Content-Type: text/html
Transfer-Encoding: chunked
Connection: keep-alive
Content-Encoding: gzip

<html>
<head><title>404 Not Found</title></head>
<body bgcolor="white">
<center><h1>404 Not Found</h1></center>
<hr><center>nginx/1.10.3 (Ubuntu)</center>
</body>
</html>
GET /music.mp3 HTTP/1.1
Host: itfest2017.breakingbrain.org:8002
User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
Accept-Language: en-US,en;q=0.5
Accept-Encoding: gzip, deflate
Referer: http://itfest2017.breakingbrain.org:8002/
Authorization: Basic c2VjcmV0OlMzY3JldA==
Connection: keep-alive
Upgrade-Insecure-Requests: 1
```

Из этого трафика мы узнаем, что кто-то осуществлял доступ к ресурсу itfest2017.breakingbrain.org:8002, который защищен Basic Auth. Благодаря перехваченному трафику мы знаем **пароли и явки**:

```Authorization: Basic c2VjcmV0OlMzY3JldA==```

Если декодировать base64 строку, то получим:

```bash
echo c2VjcmV0OlMzY3JldA== | base64 -d
secret:S3cret
```

Отлично, теперь у нас есть логин/пароль. Смотрим, что дальше происходило в трафике:

```
<html>
<head><title>Index of /</title></head>
<body bgcolor="white">
<h1>Index of /</h1><hr><pre><a href="../">../</a>
<a href="linux.png">linux.png</a>                                          09-Dec-2017 19:50              229700
<a href="music.mp3">music.mp3</a>                                          09-Dec-2017 19:49            13704192
<a href="readme.txt">readme.txt</a>                                         09-Dec-2017 19:51                  28
</pre><hr></body>
</html>
```

Ага, этот сервис, который содержит разные файлики, которые можно скачать:

```
GET /music.mp3 HTTP/1.1
Host: itfest2017.breakingbrain.org:8002
User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:57.0) Gecko/20100101 Firefox/57.0
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
Accept-Language: en-US,en;q=0.5
Accept-Encoding: gzip, deflate
Referer: http://itfest2017.breakingbrain.org:8002/
Authorization: Basic c2VjcmV0OlMzY3JldA==
Connection: keep-alive
Upgrade-Insecure-Requests: 1

```

И пользователь, трафик которого мы перехватили, скачал music.mp3. К сожалению, этого файла в трафике нет, поэтому мы можем воспользоваться перехваченными логином и паролем для самостоятельного скачивания файла. На случай, если сервис уже отключен, в директории source лежит файл music.mp3.

Таак, файл скачан, теперь мы можем приступить к его анализу. Давайте попробуем его открыть с помощью hexdump:

```
hexdump -C music.mp3 | less

00000000  49 44 33 04 00 00 00 23  70 00 54 49 54 32 00 00  |ID3....#p.TIT2..|
00000010  00 16 00 00 03 46 61 6c  6c 69 6e 67 20 66 72 6f  |.....Falling fro|
00000020  6d 20 74 68 65 20 53 6b  79 00 54 50 45 31 00 00  |m the Sky.TPE1..|
00000030  00 0e 00 00 03 4a 6f 6e  61 68 20 52 61 70 69 6e  |.....Jonah Rapin|
00000040  6f 00 54 52 43 4b 00 00  00 03 00 00 03 35 00 54  |o.TRCK.......5.T|
00000050  41 4c 42 00 00 00 06 00  00 03 48 69 67 68 00 54  |ALB.......High.T|
00000060  44 52 43 00 00 00 15 00  00 03 32 30 31 31 2d 30  |DRC.......2011-0|
00000070  32 2d 32 31 54 31 35 3a  30 38 3a 32 38 00 54 43  |2-21T15:08:28.TC|
00000080  4f 4e 00 00 00 0a 00 00  00 4d 61 73 73 44 69 73  |ON.......MassDis|
00000090  74 00 54 43 4f 50 00 00  00 77 00 00 03 41 74 74  |t.TCOP...w...Att|
000000a0  72 69 62 75 74 69 6f 6e  2d 4e 6f 6e 63 6f 6d 6d  |ribution-Noncomm|
000000b0  65 72 63 69 61 6c 2d 4e  6f 20 44 65 72 69 76 61  |ercial-No Deriva|
000000c0  74 69 76 65 20 57 6f 72  6b 73 20 33 2e 30 20 55  |tive Works 3.0 U|
000000d0  6e 69 74 65 64 20 53 74  61 74 65 73 3a 20 68 74  |nited States: ht|
000000e0  74 70 3a 2f 2f 63 72 65  61 74 69 76 65 63 6f 6d  |tp://creativecom|
000000f0  6d 6f 6e 73 2e 6f 72 67  2f 6c 69 63 65 6e 73 65  |mons.org/license|
00000100  73 2f 62 79 2d 6e 63 2d  6e 64 2f 33 2e 30 2f 75  |s/by-nc-nd/3.0/u|
00000110  73 2f 00 54 44 41 54 00  00 00 15 00 00 03 32 30  |s/.TDAT.......20|
00000120  31 31 2d 30 32 2d 32 31  20 31 35 3a 30 38 3a 32  |11-02-21 15:08:2|

```

Нуу, вообще если честно, этот файл очень похож на .mp3 файл, давайте тогда попробуем его послушать, может это что-то нам даст... Иии ничего не дало. Кроме того, что было потрачено 8 минут :( Ок, можно посмотреть в редакторе, возможно что-то скрыто в спектре и аномилии можно будет увидеть визуально... Но перед тем, как мы начнём это делать, давайте вспомним (или узнаем) про такой инструмент как binwalk. 

```
Binwalk is a fast, easy to use tool for analyzing, reverse engineering, and extracting firmware images.
```

Так написано о binwalk в репозитории проекта [на Github](https://github.com/ReFirmLabs/binwalk). А так, это очень удобный инструмент для распознавания сигнатур, которые скрыты в файле. Ведь на самом деле, кто сказал, что в нашем случае используется сложный способ стеганографии такой, как сокрытие данных в спектре, в незначащих битах и т.п.? Сначала нужно проверять самое простое, а потом двигаться к сложному.

Проверим, что нам скажет анализ при помощи binwalk:

```bash
✗ binwalk music.mp3 

DECIMAL       HEXADECIMAL     DESCRIPTION
--------------------------------------------------------------------------------
228           0xE4            Unix path: /creativecommons.org/licenses/by-nc-nd/3.0/us/
330           0x14A           JPEG image data, JFIF standard 1.01
1771          0x6EB           Copyright string: "Copyright 2007 Apple Inc., all rights reserved."
587219        0x8F5D3         Unix path: /freemusicarchive.org/music/Jonah_Rapino/High/05_Falling_from_the_Sky
587341        0x8F64D         Copyright string: "Copyright: Attribution-Noncommercial-No Derivative Works 3.0 United States: http://creativecommons.org/licenses/by-nc-nd/3.0/us/"
587423        0x8F69F         Unix path: /creativecommons.org/licenses/by-nc-nd/3.0/us/
13390871      0xCC5417        JPEG image data, JFIF standard 1.01
13533260      0xCE804C        JPEG image data, JFIF standard 1.01
13626768      0xCFED90        JPEG image data, JFIF standard 1.01
13662471      0xD07907        Zip archive data, encrypted at least v1.0 to extract, compressed size: 34, uncompressed size: 22, name: flag.txt
13662665      0xD079C9        End of Zip archive
13662687      0xD079DF        JPEG image data, JFIF standard 1.01

```

И мы видим, что в этом файле скрыто много всего, куча изображений и даже архив. Давайте попробуем при помощи binwalk вытащить данные из музыки. Если Вам это не удалось, то Вы можете сделать это при помощи команды dd (данная команда вытаскивает сразу файл с флагом, Вы же можете сначала вытащить другие файлы в качестве практики):

```bash
dd if=music.mp3 skip=13390871 bs=1 of=flag.jpg
```

Иии мы получим изображение:

![flag](source/flag.jpg)

Флаг - ```ITF{H0n3yPoooo_T_T}```

Вот и всё. Не забывайте перед тем, как приступить к сложному стеганографическому анализу, проверить файл binwalk'ом. Может уже этого будет достаточно :)