Сборка:

docker build -t itf2017_yes .

Запуск как демона на 9090 порту

docker run -itd --rm -p 9090:9090 --name itf2017_yes_cont itf2017_yes