# Futurama tasks

Build docker image
```
docker build -t itf2017_web_futurama .
```


Run task service
```
docker run -itd --rm -p 9080:80 --name itf2017_web_futurama_cont itf2017_web_futurama
```
