#define _CRT_SECURE_NO_WARNINGS
#include "stdio.h"
#include "stdlib.h"
#include "time.h"
int main(void) {
	int n, m, v0, vi;
	int x = 0, y = 0;
	FILE* out;
	out = fopen("map.txt", "w");//���}�a���ɮ�
	
	srand(time(NULL));
	printf("�п�J�R�q���ƶq>>");
	do {
		scanf("%d", &m);
	} while (m < 0);
	
	printf("�п�J�q�ʾ����ƶq>>");
	do {
		scanf("%d", &n);
	} while (n < 0);
	printf("�п�J�@�ӥR�q���ִ̤X�ӪŦ�>>");
	do {
		scanf("%d", &v0);
	} while (v0 < 0);
	
	printf("�п�J�@�ӥR�q���̦h�X�ӪŦ�>>");
	do {
		scanf("%d", &vi);
	} while (vi < v0);
	
	int **map;//-1:�q�ʾ��� 1:�S�Ŧ쪺�R�q�� 2:�@�ӪŦ쪺�R�q�� 3:��ӪŦ쪺�R�q�� �H������
	map = new int* [1000];//new�@��1000*1000���}�C��@�a��
	for (int i = 0; i < 1000; i++) {
		map[i] = new int [1000];
	}

	for (int i = 0; i < 1000; i++){//�a�Ϫ�l��
		for (int j = 0; j < 1000; j++) {
			map[i][j] = 0;
		}
	}
	for (int i = 0; i < n; i++) {//�H�����͹q�ʨ���m
		do {
			x = rand() % 1000;
			y = rand() % 1000;
		} while (map[y][x] != 0);
		map[y][x] = -1;
	}

	for (int i = 0; i < m; i++) {//�H�����ͥR�q����m�M�Ѿl�Ŧ�ƶq
		do {
			x = rand() % 1000;
			y = rand() % 1000;
		} while (map[y][x] != 0);
		map[y][x] = rand() % (vi - v0 + 1) + v0 + 1;
	}

	for (int i = 0; i < 1000; i++) {//�ⲣ�ͪ��a�ϼg�JTXT��
		for (int j = 0; j < 1000; j++) {
			fprintf(out, "%d ", map[i][j]);
		}
		fprintf(out, "\n");
	}
	printf("�R�q����m�G\n");
	for (int i = 0; i < 1000; i++) {
		for (int j = 0; j < 1000; j++) {
			if (map[i][j] > 0) {
				printf("(%d,%d)�Ŧ�%d��,", j, i, map[i][j] - 1);
			}
		}
	}
	printf("\n");
	printf("�q�ʨ���m�G\n");
	for (int i = 0; i < 1000; i++) {
		for (int j = 0; j < 1000; j++) {
			if (map[i][j] == -1) {
				printf("(%d,%d),", j, i);
			}
		}
	}
	for (int i = 0; i < 1000; i++) {//�Nnew���a��delete��
		delete[]map[i];
	}
	delete[]map;
	fclose(out);//�����a���ɮ�
	system("pause");
	return 0;
}