#define _CRT_SECURE_NO_WARNINGS
#include "stdio.h"
#include "stdlib.h"
#include "time.h"
#include "math.h"
int main(void) {
	double START, END;
	FILE* inputmap;
	char s[10];
	printf("請輸入檔案名稱(9位元內)>>");
	scanf("%s", s);
	inputmap = fopen(s, "r");
	double mind = 2000, d;
	int x, y, x2, y2;
	int* allx = new int[1000000];
	int* ally = new int[1000000];
	int index = 0;
	int p;//-1:電動機車 1:沒空位的充電站 2:一個空位的充電站 3:兩個空位的充電站 以此類推
	START = clock();
	for (int i = 0; i < 1000; i++) {//把檔案的地圖存入map中
		for (int j = 0; j < 1000; j++) {
			fscanf(inputmap, "%d ", &p);
			if (p == -1) {
				allx[index] = j;
				ally[index++] = i;
			}
		}
	}
	for (int i = 0; i < index; i++) {//計算兩電動機車最小距離
		for (int j = i + 1; j < index; j++) {
			d = sqrt(pow((allx[j] - allx[i]), 2) + pow((ally[j] - ally[i]), 2));
			if (d < mind) {
				y = ally[i];
				x = allx[i];
				y2 = ally[j];
				x2 = allx[j];
				mind = d;
			}
		}
	}
	printf("座標(%d,%d)和座標(%d,%d)的電動機車距離最近，距離為%f公里\n", x, y, x2, y2, mind);
	END = clock();
	printf("Time:%.0fms", (END - START));
	delete[]allx;
	delete[]ally;
	fclose(inputmap);//關掉地圖檔案
	system("pause");
	return 0;
}