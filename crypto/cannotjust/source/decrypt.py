
key = "lol"

with open('decrypted.jpg', 'wb') as fout:
    with open('crypted.jpg', 'rb') as fin:
        idx = 0

        byte = fin.read(1)
        while byte:
            v = int.from_bytes(byte, byteorder='big')
            b = v ^ ord(key[idx])
            idx = (idx + 1) % 3
            fout.write(bytes([b]))
            byte = fin.read(1)
