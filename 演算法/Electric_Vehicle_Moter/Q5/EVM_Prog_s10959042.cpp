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
	int* pointx = new int[1000000];//�q�ʨ�
	int* pointy = new int[1000000];
	int* pointx2 = new int[1000000];//�R�q��
	int* pointy2 = new int[1000000];
	int index = 0;//�q�ʨ�
	int index2 = 0;//�R�q��
	START = clock();
	for (int i = 0; i < 1000; i++) {//���ɮת��a�Ϧs�Jmap��
		for (int j = 0; j < 1000; j++) {
			fscanf(inputmap, "%d ", &p);
			if (p == -1) {
				pointx[index] = j;
				pointy[index++] = i;
			}
			else if (p > 0) {
				pointx2[index2] = j;
				pointy2[index2++] = i;
			}
		}
	}
	double** pointcost = new double*[index];
	double** tamppointcost = new double* [index];
	double** tamppointcost2 = new double* [index];
	for (int i = 0; i < index; i++) {
		pointcost[i] = new double[index2];
		tamppointcost[i] = new double[index2];
		tamppointcost2[i] = new double[index2];
	}
	for (int i = 0; i < index; i++) {//�p��C�ӹq�ʨ��M�C�ӥR�q�����Z��
		for (int j = 0; j < index2; j++) {
			pointcost[i][j] = sqrt(pow(pointx[i] - pointx2[j], 2) + pow(pointy[i] - pointy2[j], 2));
		}
	}
	for (int i = 0; i < index; i++) {
		for (int j = 0; j < index2; j++) {
			tamppointcost[i][j] = pointcost[i][j];
		}
	}
	double min = 2000;
	for (int i = 0; i < index; i++) {//step1�G�N�C�C��ӦC�̤p����
		for (int j = 0; j < index2; j++) {
			if (min > tamppointcost[i][j]) {
				min = tamppointcost[i][j];
			}
		}
		for (int j = 0; j < index2; j++) {
			tamppointcost[i][j] -= min;
		}
		min = 2000;
	}
	for (int i = 0; i < index2; i++) {//step2�G�N�C���Ӧ�̤p����
		for (int j = 0; j < index; j++) {
			if (min > tamppointcost[j][i]) {
				min = tamppointcost[j][i];
			}
		}
		for (int j = 0; j < index; j++) {
			tamppointcost[j][i] -= min;
		}
		min = 2000;
	}	
	int max = 0;
	int max2 = 0;
	int compare = 0;
	int compare2 = 0;
	int c = 0;
	int maxwhere[2] = { 0,0 };
	int* cline = new int[index];//step4�e���a�u
	int* rline = new int[index];//step4�S�e����u
	int index3 = 0, index4 = 0;//cline�Mrline�����ޭ�
	int* countx = new int[index];//mark��0��x�b��
	int* county = new int[index];//mark��0��y�b��
	int index5 = 0;//count�����ޭ�
	int minwhere = 0;
	bool ifrepeat = true;//�P�_�O�_�����j��
	bool ifcontain = true;//�P�_�Y�I�O�_�Q�e��
	do {
		ifrepeat = true;
		index3 = 0;
		index4 = 0;
		index5 = 0;
		for (int n = 0; n < index; n++) {//step3�G�P�_�O�_�w�����t��
			for (int i = 0; i < index; i++) {
				for (int j = 0; j < index2; j++) {
					tamppointcost2[i][j] = tamppointcost[i][j];
				}
			}
			for (int i = 0; i < index5; i++) {
				for (int j = 0; j < index; j++) {
					tamppointcost2[j][countx[i]] += 1;
				}
				for (int j = 0; j < index2; j++) {
					tamppointcost2[county[i]][j] += 1;
				}
			}
			min = index2 + 1;
			for (int i = 0; i < index; i++) {
				for (int j = 0; j < index2; j++) {
					if (tamppointcost2[i][j] == 0) {
						c++;
					}
				}
				if (c > 0 && min > c) {
					min = c;
					minwhere = i;
				}
				c = 0;
			}
			if (min == index2 + 1) {
				ifrepeat = false;
				break;
			}
			for (int i = 0; i < index2; i++) {
				if (tamppointcost2[minwhere][i] == 0) {
					county[index5] = minwhere;
					countx[index5++] = i;
					break;
				}
			}
		}
		if (ifrepeat) {//�p�G�����t��N���X
			break;
		}
		else {//step4�G�p�G�S�����t��A�γ̤p�u���ƶq�e���Ҧ���0
			for (int i = 0; i < index; i++) {
				for (int j = 0; j < index5; j++) {
					if (i == county[j]) {
						ifcontain = false;
					}
				}
				if (ifcontain) {
					rline[index4++] = i;
				}
				else {
					ifcontain = true;
				}
			}
			do {
				ifcontain = true;
				for (int i = 0; i < index4; i++) {
					for (int j = 0; j < index2; j++) {
						if (tamppointcost[rline[i]][j] == 0) {
							ifrepeat = true;
							for (int k = 0; k < index3; k++) {
								if (cline[k] == j) {
									ifrepeat = false;
									break;
								}
							}
							if (ifrepeat) {
								cline[index3++] = j;
								ifcontain = false;
							}
						}
					}
				}
				for (int i = 0; i < index3; i++) {
					for (int j = 0; j < index5; j++) {
						if (countx[j] == cline[i]) {
							ifrepeat = true;
							for (int k = 0; k < index4; k++) {
								if (rline[k] == county[j]) {
									ifrepeat = false;
									break;
								}
							}
							if (ifrepeat) {
								rline[index4++] = county[j];
								ifcontain = false;
							}
							break;
						}
					}
				}
			} while (!ifcontain);
			//step5
			min = 2000;
			for (int i = 0; i < index; i++) {//���S�Q�������Ȥ��̤p����
				for (int j = 0; j < index2; j++) {
					ifcontain = false;
					for (int row = 0; row < index4; row++) {
						if (rline[row] == i) {
							ifcontain = true;
							break;
						}
					}
					for (int col = 0; col < index3; col++) {
						if (cline[col] == j) {
							ifcontain = false;
							break;
						}
					}
					if (ifcontain) {
						if (min > tamppointcost[i][j]) {
							min = tamppointcost[i][j];
						}
					}
					else {
						ifcontain = true;
					}
				}
			}
			for (int i = 0; i < index; i++) {//�N�S�Q�������Ȫ����C��S�Q�������Ȥ��̤p����
				for (int j = 0; j < index2; j++) {
					ifcontain = false;
					for (int row = 0; row < index4; row++) {
						if (rline[row] == i) {
							ifcontain = true;
							break;
						}
					}
					if (ifcontain) {
						tamppointcost[i][j] -= min;
					}
					else {
						ifcontain = true;
					}
				}
			}
			for (int i = 0; i < index2; i++) {//�N�����t����[�^0
				for (int j = 0; j < index; j++) {
					if (tamppointcost[j][i] < 0) {
						ifcontain = false;
					}
				}
				if (!ifcontain) {
					for (int j = 0; j < index; j++) {
						tamppointcost[j][i] += min;
					}
					ifcontain = true;
				}
			}
		}
	} while (true);
	printf("\t\t\t\t");
	for (int i = 1; i <= index2; i++) {
		printf(" �R�q��%4d��(%4d,%4d) ", i, pointx2[i - 1], pointy2[i - 1]);
	}
	printf("\n");
	for (int i = 0; i < index; i++) {
		printf("\n�q�ʨ�%4d��(%4d,%4d) ", i + 1, pointx[i], pointy[i]);
		for (int j = 0; j < index2; j++) {
			printf("%25.3f", pointcost[i][j]);
		}
	}
	printf("\n�q�ʨ��t�諸�R�q���G\n");
	for (int i = 0; i < index5; i++) {
		printf("�q�ʨ�%4d���t��R�q��%4d���Z��%.3f����\n", county[i]+1, countx[i]+1, pointcost[county[i]][countx[i]]);
	}
	double e = 0;
	for (int i = 0; i < index5; i++) {
		e += pointcost[county[i]][countx[i]]*0.177;
	}
	printf("�C�����ӹq0.1777�סA�`�ӹq�q��%f��\n", e);
	END = clock();
	printf("Time:%.0fms", (END - START));
	delete[]countx;
	delete[]county;
	delete[]cline;
	delete[]rline;
	delete[]pointx;
	delete[]pointy;
	delete[]pointx2;
	delete[]pointy2;
	for (int i = 0; i < index; i++) {//�Nnew��delete��
		delete[]pointcost[i];
	}
	delete[]pointcost;
	for (int i = 0; i <index; i++) {//�Nnew���a��delete��
		delete[]tamppointcost[i];
	}
	delete[]tamppointcost;
	for (int i = 0; i < index; i++) {//�Nnew���a��delete��
		delete[]tamppointcost2[i];
	}
	delete[]tamppointcost2;
	fclose(inputmap);
	system("pause");
	return 0;
}