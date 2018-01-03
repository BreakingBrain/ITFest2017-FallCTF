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
