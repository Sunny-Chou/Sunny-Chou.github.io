#include <fstream>
#include <iostream>
#include <string>
#include<math.h>
#include<time.h>
using namespace std;
int main(void) {
	string s1, s2, temps;
	ifstream in1, in2;
	string f1, f2;
	cout << "請輸入原始檔案檔名(15位元以內)>>";
	cin >> f1;
	in1.open(f1);
	cout << "請輸入比對檔案檔名(15位元以內)>>";
	cin >> f2;
	in2.open(f2);
	double START, END;
	START = clock();
	getline(in2, s1);
	getline(in1, s2);
	while (getline(in2, temps)) {
		s1 += '\n';
		s1 += temps;
	}
	while (getline(in1, temps)) {
		s2 += '\n';
		s2 += temps;
	}
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
	double d11 = 1 - (double)d1[s1.length()][s2.length()] / (double)max(s1.length(), s2.length());
	double d22 = 1 - (double)d2[s1.length()][s2.length()] / (double)max(s1.length(), s2.length());
	if (d11 < 0) {
		d11 = 0;
	}
	if (d22 < 0) {
		d22 = 0;
	}
	END = clock();
	cout << "Minimum Edit Distances 的抄襲程度是 " << d11 << endl;
	cout << "Levenshtein Distance 的抄襲程度是 " << d22 << endl;
	cout << "Time: " << END - START << "ms";
	for (int i = 0; i < s1.length() + 1; i++) {
		delete[] d1[i];
		delete[] d2[i];
	}
	delete[]d1;
	delete[]d2;
	in1.close();
	in2.close();
	system("pause");
	return 0;
}
	