// homework1.cpp : 此檔案包含 'main' 函式。程式會於該處開始執行及結束執行。
//

#include <iostream>
#include<ctime>
#include <cstdlib>
#include<iomanip>
using namespace std;

int check(int **count,int n,int m) {
    for (int i = 0; i < n; i++) {
        for (int j = 0; j < m; j++) {
            if (count[i][j] == 0) {
                return 0;
            }
        }
    }
    return 1;
}

void finalCount(int **count,int n,int m) {
    cout << setw(7) << "x\\y";
    for (int i = 0; i < m; i++) {
        cout << setw(5)<<"y=" << setw(2) << i+1;
    }
    cout << endl;
    for (int i = 0; i < n; i++) {
        cout << setw(5) << "x=" << setw(2) << i+1;
        for (int j = 0; j < m; j++) {
            cout << setw(7) << count[i][j] ;
        }
        cout << endl << endl << endl << endl;
    }
}
int main()
{
    srand(time(NULL));
    const int imove[8] = {-1,0,1,1,1,0,-1,-1};
    const int jmove[8] = {1,1,1,0,-1,-1,-1,0};
    int n, m, x, y, k, time = 50000;
    cout << "Create a rectangular room of size nxm tiles." << endl;
    cout << "Input n(range:2<n<=40)>>";
    cin >> n;
    while (n > 40 || n <= 2) {
        cout << "Input ERROR!!!" << endl << "the range of n should be 2<n<=40 >>" ;
        cin >> n;
    }

    cout << "Input m(range:2<=m<=20)>>";
    cin >> m;
    while (m > 20 || m < 2) {
        cout << "Input ERROR!!!" << endl << "the range of m should be 2<=m<=20 >>";
        cin >> m;
    }

    int **count;
    count = new int* [n];
    for (int i = 0; i < n; i++) {
        count[i] = new int[m];
    }

    for (int i = 0; i < n; i++) {
        for (int j = 0; j < m; j++) {
            count[i][j] = 0;

        }
    }
  
    cout << "Create the starting point (x,y)." << endl;
    cout << "Input x(range:1<=x<="<<n<<")>>";
    cin >> x;
    while (x > n || x <= 0) {
        cout << "Input ERROR!!!" << endl << "the range of x should be 1<=x<=" << n << " >>";
        cin >> x;
    }
    
    cout << "Input y(range:1<=y<=" << m << ")>>";
        cin >> y;
    while (y > m || y <= 0) {
        cout << "Input ERROR!!!" << endl << "the range of y should be 1<=y<=" << m << " >>" ;
        cin >> y;
    }
    x--;
    y--;
    while (time) {
        do {
            k = rand() % 8;
            
        } while (x + imove[k] >= n || x + imove[k] < 0 || y + jmove[k] >= m || y + jmove[k] < 0);
        time--;
        x += imove[k];
        y += jmove[k];
        count[x][y]++;

        if (check(count,n,m)) {
            break;
        }
    }
    
    cout << "The total number of legal moves : " << 50000 - time << endl << "DENSITY OF WALK:" << endl;

    finalCount(count,n,m);

    delete[](count);

}

