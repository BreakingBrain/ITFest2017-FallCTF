import socket
import threading

BIND_IP = '0.0.0.0'
BIND_PORT = 9090


def handle_client(client_socket):
    for i in range(1000):
        client_socket.send(b'Hi, Do you wanna a flag? Say "yes" one more time!\n')
        request = client_socket.recv(1024)
        answer = request.decode('utf-8')
        if answer.strip() != 'yes':
            client_socket.send(b'ITF{It0LdY0uJustSaYyes}')
            client_socket.close()
            return
    client_socket.send(b'ITF{YesM3nG0Eahed}')
    client_socket.close()


def tcp_server():
    server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    server.bind((BIND_IP, BIND_PORT))
    server.listen(100)
    print("[*] Listening on %s:%d" % (BIND_IP, BIND_PORT))

    while 1:
        client, addr = server.accept()
        print("[*] Accepted connection from: %s:%d" % (addr[0], addr[1]))
        client_handler = threading.Thread(target=handle_client, args=(client,))
        client_handler.start()


if __name__ == '__main__':
    tcp_server()
