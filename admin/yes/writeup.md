# Say "Yes" 

![Yeeees](https://trello-attachments.s3.amazonaws.com/57e50abe9d8488ae13f33d8c/5a0aab6183daa4d212c8ebd0/51d78cc7578c0ca6b7d31b83ecc9a99b/n0gny.jpg)

**Description:** Мы обнаружили в старом проекте очень странный инструмент для проверки установки. Скидываем тебе, посмотри, что там. Может найдешь что-нибудь интересное.

**Author:** tiso a.k.a. tisOOv

**Category:** Admin, Reverse

**Score:** 100

**Note:** Для локального запуска запуска сервиса необходимо перейти в директорию source и выполнить указания из README.md

**Write-up:** 

 На самом деле это очень простое задание, которое даже не требует никакого реверса и никакого программирования :) Но любители реверса могут решить этот таск своим путём. Мы же попробуем решить этот таск в одну строчку, нам всего лишь понадобится linux-консоль и немного умения писать в ней что-нибудь более-менее вразумительное:

 ```bash
 yes yes | ./source/builds/yes
 ```

 Разберем команду: ```yes yes``` - это вызов команды **yes**, которая выводит слово **yes**, выход этой программы при помощи *трубы* передается на вход нашей программы **yes**. Воот и всё :) Легко и просто, а полученный флаг:
 
 ```
 ITF{s@yY3sMyD3@rCtFfri3nD}
 ```