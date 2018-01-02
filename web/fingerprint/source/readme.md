Build:

```
docker build -t itf2017_webbrowser .
```

Run:
```
docker run -itd --rm -p 9090:80 --name itf2017_webbrowser_cont itf2017_webbrowser

```