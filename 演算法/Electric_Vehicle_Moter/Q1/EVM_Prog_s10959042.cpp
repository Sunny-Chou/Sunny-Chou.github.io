#define _CRT_SECURE_NO_WARNINGS
#include "stdio.h"
#include "stdlib.h"
#include "time.h"
#include "math.h"
int main(void) {
	double START, END;
	FILE* inputmap;
	char s[10];
	printf("�п�J�ɮצW��(9�줸��)>>");
	scanf("%s", s);
	inputmap = fopen(s, "r");
	double mind = 2000, d;
	int x, y, x2, y2;
	int* allx=new int[1000000];
	int* ally = new int[1000000];
	int index = 0;
	int p;//-1:�q�ʾ��� 1:�S�Ŧ쪺�R�q�� 2:�@�ӪŦ쪺�R�q�� 3:��ӪŦ쪺�R�q�� �H������
	START = clock();
	for (int i = 0; i < 1000; i++) {//���ɮת��a�Ϧs�Jmap��
		for (int j = 0; j < 1000; j++) {
			fscanf(inputmap, "%d ", &p);
			if (p > 0) {
				allx[index] = j;
				ally[index++] = i;
			}
		}
	}
	for (int i = 0; i < index; i++) {//�p���R�q���̤p�Z��
		for (int j = i+1; j < index; j++) {
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
	printf("�y��(%d,%d)�M�y��(%d,%d)���R�q���Z���̪�A�Z����%f����\n", x, y, x2, y2, mind);
	END = clock();
	printf("Time:%.0fms", (END - START));
	delete[]allx;
	delete[]ally;
	fclose(inputmap);//�����a���ɮ�
	system("pause");
	return 0;
}