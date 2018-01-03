#include <iostream>
#include <string>
#include <algorithm>

std::string decode(long long codedString)
{
    std::string result;

    while (codedString != 0) {
        char b = (char)codedString % 256;
        codedString /= 256;
        result += b;
    }

    std::reverse(result.begin(), result.end());
    return result;
}


int main()
{
    std::string answer;
    for (size_t i = 0; i < 10000000; ++i) {
        std::cout << "Say 'yes' if you really want a flag." << std::endl;
        std::cin >> answer;
        if (answer != "yes") {
            std::cout << "itfest2017_{juStS@ayYesDude}";
            return 1;
        }
    }

    // 4954467b7340795933734d7944334072437446667269336e447d
    long long flagPart1 = 0x4954467b734079;
    long long flagPart2 = 0x5933734d794433;
    long long flagPart3 = 0x40724374466672;
    long long flagPart4 = 0x69336e447d;

    std::cout << decode(flagPart1);
    std::cout << decode(flagPart2);
    std::cout << decode(flagPart3);
    std::cout << decode(flagPart4);

    return 0;
}