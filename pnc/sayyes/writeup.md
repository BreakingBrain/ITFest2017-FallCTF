# Say Yes One more time 

![Oh YES!](https://trello-attachments.s3.amazonaws.com/57e50abe9d8488ae13f33d8c/5a0aab6183daa4d212c8ebd0/11f9b9dd28bfeb6246b5fa241d095e16/oh-yes.jpg)

**Description:** И снова мы, тут оказывается есть сетевая версия прошлого инструмента. Можешь посмотреть?

**Author:** tiso a.k.a. tisOOv

**Category:** PNC Admin 

**Score:** 100

**Note:** Для локального запуска запуска сервиса необходимо перейти в директорию source и выполнить указания из README.md

**Write-up:**

Первым делом выполним инструкции для запуска сервиса и попробуем присоединиться к сервису при помощи netcat (Вам вновь понадобится linux-консоль):

```bash
➜  sayyes ✗ nc localhost 9090
Hi, Do you wanna a flag? Say "yes" one more time!
yes
Hi, Do you wanna a flag? Say "yes" one more time!
yes
Hi, Do you wanna a flag? Say "yes" one more time!
yes
Hi, Do you wanna a flag? Say "yes" one more time!
asd
ITF{It0LdY0uJustSaYyes}%
```

Как видим, сервис просит нас вводить слово **yes** и просит нас об этом многократно. В случае, если мы введём что-то отличное от **yes**, сервис отдаст нам флаг, но он, к сожалению, является ложным. Таак, что мы можем сделать? Мы можем попытаться сделать это задание руками, то есть терпеливо писать **yes**. Но автор задания не является терпеливым, надеюсь, что Вы тоже, а также автор задания весьма ленив, поэтому он предлагает быстренько накидать скрипт, который будет за нас сам писать серверу **yes**:

```python
import socket

if __name__ == '__main__':
    client = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    client.connect(("localhost", 9090))
    while True:
        data = client.recv(1024)
        print(data)
        if not data:
            break
        client.send(b"yes")
```

А воот и сам скрипт, довольно небольшой, не правда ли? И он действительно решает нашу задачу. В результате его работы мы получим флаг:

```
ITF{YesM3nG0Eahed}
```

Так что будьте ленивы, старайтесь автоматизировать всю рутину :)
