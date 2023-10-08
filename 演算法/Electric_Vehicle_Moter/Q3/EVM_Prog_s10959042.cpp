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
	int p;//-1:�q�ʾ��� 1:�S�Ŧ쪺�R�q�� 2:�@�ӪŦ쪺�R�q�� 3:��ӪŦ쪺�R�q�� �H������
	int* x = new int[1000000];
	int* y = new int[1000000];
	int index = 0;
	START = clock();
	for (int i = 0; i < 1000; i++) {//���ɮת��a�ϬD���R�q���s�J
		for (int j = 0; j < 1000; j++) {
			fscanf(inputmap, "%d ", &p);
			if (p > 0) {
				x[index] = j;
				y[index++] = i;
			}
		}
	}
	int* pointx = new int[index];
	int* pointy = new int[index];
	int index2 = 0;
	bool ispoint_big = true;
	bool ispoint_small = true;
	bool exist = true;
	for (int i = 0; i < index; i++) {
		for (int j = i+1; j < index; j++) {
			for (int k = 0; k < index && (ispoint_small || ispoint_big); k++) {
				if ((y[j] - y[i]) * x[k] + (x[i] - x[j]) * y[k] > x[i] * y[j] - y[i] * x[j]) {
					ispoint_small = false;
				}
				if ((y[j] - y[i]) * x[k] + (x[i] - x[j]) * y[k] < x[i] * y[j] - y[i] * x[j]) {
					ispoint_big = false;
				}
			}
			if (ispoint_small || ispoint_big) {
				for (int a = 0; a < index2; a++) {
					if (pointx[a] == x[i]) {
						if (pointy[a] == y[i]) {
							exist = false;
							break;
						}
					}
				}
				if (exist) {
					pointx[index2] = x[i];
					pointy[index2++] = y[i];
				}
				else {
					exist = true;
				}
				for (int a = 0; a < index2; a++) {
					if (pointx[a] == x[j]) {
						if (pointy[a] == y[j]) {
							exist = false;
							break;
						}
					}
				}
				if (exist) {
					pointx[index2] = x[j];
					pointy[index2++] = y[j];
				}
				else {
					exist = true;
				}
				ispoint_big = true;
				ispoint_small = true;
			}
			else {
				ispoint_big = true;
				ispoint_small = true;
			}
		}
	}
	printf("�R�q�������X���Y�]�������I���G\n");
	for (int i = 0; i < index2; i++) {
		printf("(%d,%d)\n", pointx[i], pointy[i]);
	}
	double center[2] = { 0,0 };
	int temp[2];
	for (int i = 0; i < index2; i++) {
		center[0] += pointx[i];
		center[1] += pointy[i];
	}
	center[0] /= index2;
	center[1] /= index2;
	for (int i = 0; i < index2 - 1; i++) {
		for (int j = 0; j < index2 - i - 1; j++) {
			if ((pointx[j] - center[0]) * (pointy[j + 1] - center[1]) - (pointx[j + 1] - center[0]) * (pointy[j] - center[1]) < 0) {
				temp[0] = pointx[j];
				temp[1] = pointy[j];
				pointx[j] = pointx[j + 1];
				pointy[j] = pointy[j + 1];
				pointx[j + 1] = temp[0];
				pointy[j + 1] = temp[1];
			}
		}
	}
	double area = 0;
	for (int i = 0; i < index2; i++) {
		area += pointx[i % index2] * pointy[(i + 1) % index2] - pointx[(i + 1) % index2] * pointy[i % index2];
	}
	area /= 2;
	printf("�Y�]�����n�G");
	printf("%f���褽��\n", area);
	double max = 0;
	for (int i = 0; i < index2; i++) {
		for (int j = i + 1; j < index2; j++) {
			if (pow(pointx[j] - pointx[i], 2) + pow(pointy[j] - pointy[i], 2) > max) {
				max = pow(pointx[j] - pointx[i], 2) + pow(pointy[j] - pointy[i], 2);
			}
		}
	}
	max = sqrt(max);
	printf("�����I�̻����Z����%f����\n", max);
	END = clock();
	printf("Time:%.0fms", (END - START));
	delete[]x;
	delete[]y;
	delete[]pointx;
	delete[]pointy;
	fclose(inputmap);//�����a���ɮ�
	system("pause");
	return 0;
}