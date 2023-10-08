#include <iostream>
#include <string>
#include <time.h>
using namespace std;
int main(void) {
	string s1, s2;
	cout << "請輸入第一個字串(不能有空格)>>";
	cin >> s1;
	cout << "請輸入第二個字串(不能有空格)>>";
	cin >> s2;
	double START, END;
	START = clock();
	int** d1 = new int* [s1.length() + 1], ** d2 = new int* [s1.length() + 1];
	for (int i = 0; i < s1.length() + 1; i++) {
		d1[i] = new int[s2.length() + 1];
		d2[i] = new int[s2.length() + 1];
	}
	for (int i = 0; i < s1.length() + 1; i++) {
		d1[i][0] = i;
		d2[i][0] = i;
	}
	for (int i = 1; i < s2.length() + 1; i++) {
		d1[0][i] = i;
		d2[0][i] = i;
	}
	for (int i = 1; i < s1.length() + 1; i++) {
		for (int j = 1; j < s2.length() + 1; j++) {
			if (s1[i - 1] != s2[j - 1]) {
				if (d1[i - 1][j - 1] <= d1[i][j - 1] && d1[i - 1][j - 1] <= d1[i - 1][j]) {
					d1[i][j] = d1[i - 1][j - 1] + 1;
				}
				else if (d1[i - 1][j] <= d1[i][j - 1] && d1[i - 1][j] <= d1[i - 1][j - 1]) {
					d1[i][j] = d1[i - 1][j] + 1;
				}
				else {
					d1[i][j] = d1[i][j - 1] + 1;
				}
				if (d2[i - 1][j - 1] + 1 <= d2[i][j - 1] && d2[i - 1][j - 1] + 1 <= d2[i - 1][j]) {
					d2[i][j] = d2[i - 1][j - 1] + 2;
				}
				else if (d2[i - 1][j] <= d2[i][j - 1] && d2[i - 1][j] <= d2[i - 1][j - 1] + 1) {
					d2[i][j] = d2[i - 1][j] + 1;
				}
				else {
					d2[i][j] = d2[i][j - 1] + 1;
				}
			}
			else {
				d1[i][j] = d1[i - 1][j - 1];
				d2[i][j] = d2[i - 1][j - 1];
			}
		}
	}
	END = clock();
	cout << "Minimum Edit Distances is " << d1[s1.length()][s2.length()] << endl;
	cout << "Levenshtein Distance is " << d2[s1.length()][s2.length()] << endl;
	cout << "Time: " << END - START << "ms";
	for (int i = 0; i < s1.length() + 1; i++) {
		delete[] d1[i];
		delete[] d2[i];
	}
	delete[]d1;
	delete[]d2;
	system("pause");
	return 0;
}