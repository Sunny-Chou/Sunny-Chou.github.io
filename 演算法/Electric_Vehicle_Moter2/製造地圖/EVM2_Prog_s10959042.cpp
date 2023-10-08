#define _CRT_SECURE_NO_WARNINGS
#include "stdio.h"
#include "stdlib.h"
#include "time.h"
int main(void) {
	int n, m, v0, vi;
	int x = 0, y = 0;
	int w, h;
	FILE* out;
	out = fopen("map.txt", "w");//打開地圖檔案
	
	srand(time(NULL));
	printf("請輸入寬(x)>>");
	do {
		scanf("%d", &w);
	} while (w <= 0);
	printf("請輸入高(y)>>");
	do {
		scanf("%d", &h);
	} while (h <= 0);
	printf("請輸入充電站數量>>");
	do {
		scanf("%d", &m);
	} while (m < 0 || m>w * h);
	printf("請輸入電動機車數量>>");
	do {
		scanf("%d", &n);
	} while (n < 0 || n>w * h - m);
	printf("請輸入一個充電站最少幾個空位>>");
	do {
		scanf("%d", &v0);
	} while (v0 < 0);
	
	printf("請輸入一個充電站最多幾個空位>>");
	do {
		scanf("%d", &vi);
	} while (vi < v0);
	
	int **map;//-1:電動機車 1:沒空位的充電站 2:一個空位的充電站 3:兩個空位的充電站 以此類推
	map = new int* [h];//new一個1000*1000的陣列當作地圖
	for (int i = 0; i < h; i++) {
		map[i] = new int [w];
	}

	for (int i = 0; i < h; i++){//地圖初始化
		for (int j = 0; j < w; j++) {
			map[i][j] = 0;
		}
	}
	for (int i = 0; i < n; i++) {//隨機產生電動車位置
		do {
			x = rand() % w;
			y = rand() % h;
		} while (map[y][x] != 0);
		map[y][x] = -1;
	}

	for (int i = 0; i < m; i++) {//隨機產生充電站位置和剩餘空位數量
		do {
			x = rand() % w;
			y = rand() % h;
		} while (map[y][x] != 0);
		map[y][x] = rand() % (vi - v0 + 1) + v0 + 1;
	}

	for (int i = 0; i < h; i++) {//把產生的地圖寫入TXT檔
		for (int j = 0; j < w; j++) {
			fprintf(out, "%d ", map[i][j]);
		}
		fprintf(out, "\n");
	}
	printf("充電站位置：\n");
	for (int i = 0; i < h; i++) {
		for (int j = 0; j < w; j++) {
			if (map[i][j] > 0) {
				printf("(%d,%d)空位%d個,", j, i, map[i][j] - 1);
			}
		}
	}
	printf("\n");
	printf("電動車位置：\n");
	for (int i = 0; i < h; i++) {
		for (int j = 0; j < w; j++) {
			if (map[i][j] == -1) {
				printf("(%d,%d),", j, i);
			}
		}
	}
	for (int i = 0; i < h; i++) {//將new的地圖delete掉
		delete[]map[i];
	}
	delete[]map;
	fclose(out);//關掉地圖檔案
	system("pause");
	return 0;
}