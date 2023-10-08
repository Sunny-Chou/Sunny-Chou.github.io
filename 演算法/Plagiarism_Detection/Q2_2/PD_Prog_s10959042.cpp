#include <fstream>
#include <iostream>
#include <string>
#include<math.h>
#include <time.h>
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
	for (int i = 0, j = 0; i < s1.length(); i++) {
		if (s1[i] == '\n') {
			if (j == 1) {
				s1.erase(i, 1);
				i--;
			}
			else if (j == 2) {
				s1.erase(i - 1, 1);
				i--;
			}
			j = 1;
		}
		else if (s1[i] == ' ' || s1[i] == '\t') {
			if (j) {
				s1.erase(i, 1);
				i--;
			}
			j = 2;
		}
		else {
			j = 0;
		}
	}
	int part1 = 1, part2 = 1;
	for (int i = 0; i < s1.length(); i++) {
		if (s1[i] == '\n') {
			part1++;
		}
	}
	for (int i = 0, j = 0; i < s2.length(); i++) {
		if (s2[i] == '\n') {
			if (j == 1) {
				s2.erase(i, 1);
				i--;
			}
			else if (j == 2) {
				s2.erase(i - 1, 1);
				i--;
			}
			j = 1;
		}
		else if (s2[i] == ' ' || s2[i] == '\t') {
			if (j) {
				s2.erase(i, 1);
				i--;
			}
			j = 2;
		}
		else {
			j = 0;
		}
	}
	for (int i = 0; i < s2.length(); i++) {
		if (s2[i] == '\n') {
			part2++;
		}
	}
	double** d1 = new double* [part2], ** d2 = new double* [part2];
	for (int i = 0; i < part2; i++) {
		d1[i] = new double[part1];
		d2[i] = new double[part1];
	}
	int index1 = 0, index2 = 0;
	for (int p2 = 0; p2 < part2; p2++) {
		int partlength2 = 0;
		index1 = 0;
		for (index2; index2 < s2.length(); index2++) {
			if (s2[index2] == '\n') {
				break;
			}
			partlength2++;
		}
		index2++;
		for (int p1 = 0; p1 < part1; p1++) {
			int partlength1 = 0;
			for (index1; index1 < s1.length(); index1++) {
				if (s1[index1] == '\n') {
					break;
				}
				partlength1++;
			}
			index1++;
			int** sd1 = new int* [partlength1 + 1], ** sd2 = new int* [partlength1 + 1];
			for (int i = 0; i < partlength1 + 1; i++) {
				sd1[i] = new int[partlength2 + 1];
				sd2[i] = new int[partlength2 + 1];
			}
			for (int i = 0; i < partlength1 + 1; i++) {
				sd1[i][0] = i;
				sd2[i][0] = i;
			}
			for (int i = 1; i < partlength2 + 1; i++) {
				sd1[0][i] = i;
				sd2[0][i] = i;
			}
			for (int i = 1; i < partlength1 + 1; i++) {
				for (int j = 1; j < partlength2 + 1; j++) {
					if (s1[index1 - 2 - partlength1 + i] != s2[index2 - 2 - partlength2 + j]) {
						if (sd1[i - 1][j - 1] <= sd1[i][j - 1] && sd1[i - 1][j - 1] <= sd1[i - 1][j]) {
							sd1[i][j] = sd1[i - 1][j - 1] + 1;
						}
						else if (sd1[i - 1][j] <= sd1[i][j - 1] && sd1[i - 1][j] <= sd1[i - 1][j - 1]) {
							sd1[i][j] = sd1[i - 1][j] + 1;
						}
						else {
							sd1[i][j] = sd1[i][j - 1] + 1;
						}
						if (sd2[i - 1][j - 1] + 1 <= sd2[i][j - 1] && sd2[i - 1][j - 1] + 1 <= sd2[i - 1][j]) {
							sd2[i][j] = sd2[i - 1][j - 1] + 2;
						}
						else if (sd2[i - 1][j] <= sd2[i][j - 1] && sd2[i - 1][j] <= sd2[i - 1][j - 1] + 1) {
							sd2[i][j] = sd2[i - 1][j] + 1;
						}
						else {
							sd2[i][j] = sd2[i][j - 1] + 1;
						}
					}
					else {
						sd1[i][j] = sd1[i - 1][j - 1];
						sd2[i][j] = sd2[i - 1][j - 1];
					}
				}
			}
			if (1 - (double)sd1[partlength1][partlength2] / (double)partlength1 >= 0) {
					d1[p2][p1] = 1 - (double)sd1[partlength1][partlength2] / (double)max(partlength1,partlength2);
				}
			else {
				d1[p2][p1] = 0;
			}
			if (1 - (double)sd2[partlength1][partlength2] / (double)partlength1 >= 0) {
					d2[p2][p1] = 1 - (double)sd2[partlength1][partlength2] / (double)max(partlength1, partlength2);
				}
			else {
				d2[p2][p1] = 0;
			}
			for (int i = 0; i < partlength1 + 1; i++) {
				delete[] sd1[i];
				delete[] sd2[i];
			}
			delete[]sd1;
			delete[]sd2;
		}
	}
	double d11 = 0, d22 = 0;
	for (int i = 0; i < part2; i++) {
		double max1 = d1[i][0], max2 = d2[i][0];
		for (int j = 1; j < part1; j++) {
			if (max1 < d1[i][j]) {
				max1 = d1[i][j];
			}
			if (max2 < d2[i][j]) {
				max2 = d2[i][j];
			}
		}
		d11 += max1;
		d22 += max2;
		cout << "原始檔案第" << i + 1 << "段和比對檔案的段抄襲程度(Minimum Edit Distances)是 " << max1 << endl;
		cout << "原始檔案第" << i + 1 << "段和比對檔案的段抄襲程度(Levenshtein Distance)是 " << max2 << endl;
	}
	d11 /= part2;
	d22 /= part2;
	double ds1 = 0, ds2 = 0;
	for (int i = 0; i < part2; i++) {
		double max1 = d1[i][0], max2 = d2[i][0];
		for (int j = 1; j < part1; j++) {
			if (max1 < d1[i][j]) {
				max1 = d1[i][j];
			}
			if (max2 < d2[i][j]) {
				max2 = d2[i][j];
			}
		}
		ds1 += pow(max1 - d11, 2);
		ds2 += pow(max2 - d22, 2);
	}
	ds1 /= part2;
	ds2 /= part2;
	END = clock();
	cout << "Minimum Edit Distances :" << endl << "兩篇文章抄襲程度 : " << d11 << endl << "輸出段抄襲程度的變異數 : " << ds1 << endl << "輸出段抄襲程度的標準差 : " << sqrt(ds1) << endl;
	cout << "Levenshtein Distance :" << endl << "兩篇文章抄襲程度 : " << d22 << endl << "輸出段抄襲程度的變異數 : " << ds2 << endl << "輸出段抄襲程度的標準差 : " << sqrt(ds2) << endl;
	cout << "Time: " << END - START << "ms";
	for (int i = 0; i < part2; i++) {
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
