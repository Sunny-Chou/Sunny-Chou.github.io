#define _CRT_SECURE_NO_WARNINGS
#include<stdio.h>
#include<stdlib.h>
#include<string.h>
void getcolnumber(FILE* f, int* colnumber,int*rownumber) {//�o��file����C�ơA�p�G���e�����T�A�N�|�����{��
	char c;
	int element;
	int col=0;
	if (fscanf(f, "%d%c", &element, &c) >= 1) {
		do {
			if (element != 0 && element != 1) {//�p�G�����D0�D1
				printf("The elements of the file should be 0 or 1.");
				fclose(f);
				exit(0);
			}
			col++;
			if (c == '\n') {
				if (*colnumber == 0) {
					*colnumber = col;
				}
				if (col != *colnumber) {
					printf("The row %d of the file is incorrect.",*rownumber);
					fclose(f);
					exit(0);
				}
				col = 0;
				(*rownumber)++;
			}
		} while (fscanf(f, "%d%c", &element, &c) >= 1);
	}
	else {
		printf("The file is empty.");
		fclose(f);
		exit(0);

	}
	if (*colnumber == 0)
	{
		*colnumber = col;
	}
	if (*rownumber != *colnumber) {
		printf("The content of the file is not a square matrix.");
		fclose(f);
		exit(0);
	}
	fseek(f, 0, SEEK_SET);
}
bool allpass(int* pass,int r) {//�O�_�����I���g�L
	for (int index = 0; index < r; index++) {
		if (pass[index] == 0) {
			return true;
		}
	}
	return false;
}

void copy(int* passthrough1, int* passthrough2,int row) {//�o�h���X�����U�@�h�ƻs��o�h
	for (int r = 0; r < row; r++) {
		passthrough1[r] = passthrough2[r];
	}
}

void intitializePass(int* pass,int row) {//��g�L�`�I����l��
	for (int index = 0; index < row; index++) {
		pass[index] = 0;
	}
}


void DFS(int** adjlist,int rownumber,int colnumber) {
	int r = 0;
	int c = 0;
	int* pass = new int[rownumber];//���g�L���I
	int* passthrough = new int[rownumber];//��o�I�����|
	printf("DFS : ");
	do {
		for (bool end = true; r <= rownumber && end; r++) {//���X�o�I
			for (c = 0; c < colnumber; c++) {
				if (r < rownumber&&r != c && adjlist[r][c] == 1) {
					end = false;
					break;
				}
			}
		}
		r--;

		if (r < rownumber) {//�p�G���X�o�I
			
			intitializePass(pass, rownumber);
			intitializePass(passthrough, rownumber);
			pass[r] = 1;//�X�o�I�w�g�L

			int ptop = 0;
			int ptop2 = 0;
			passthrough[ptop] = r;//�X�o�I�O���U��
			while (allpass(pass, rownumber)) {

				if (c >= colnumber) {//�o�����쩳�F
					if (ptop2 > 0) {
						r = passthrough[--ptop2];//�^�h�W�@�I�A�~�򩹤U��
						c = 0;
					}
					else {
						r = passthrough[0]+1;
						break;
					}

				}
				if (adjlist[r][c] == 1 && pass[c] == 0) {//�p�G�S���L�o���I
					pass[c] = 1;//�O�����g�L�o���I
					++ptop2;
					passthrough[++ptop] = c;//�����g�L�F�o���I
					r = c;//�q�o���I�~��X�o
					c = 0;
				}
				else {
					c++;
				}
			}
			if (!allpass(pass, rownumber)) {
				printf("%d", passthrough[0]);
				for (int i = 1; i <= ptop; i++) {
					printf("->%d", passthrough[i]);
				}
				printf("\n");
				break;

			}

		}
		else {
			printf("\n���O�s�q��!!\n");
			break;
		}
	} while (true);
	delete[]pass;
	delete[]passthrough;

}
void BFS(int** adjlist, int rownumber, int colnumber) {
	int r = 0;
	int c = 0;
	int* pass = new int[rownumber];
	int* passthrough1 = new int[rownumber];//�o�h�n�����I
	int* passthrough2 = new int[rownumber];//�o�h�g�L���I
	int* passthrough = new int[rownumber];
	printf("BFS : ");
	do {
		for (bool end = true; r <= rownumber && end; r++) {//���X�o�I
			for (c = 0; c < colnumber; c++) {
				if (r < rownumber&&r != c && adjlist[r][c] == 1) {
					end = false;
					break;
				}
			}
		}
		r--;

		if (r < rownumber) {//���X�o�I
			
			intitializePass(pass, rownumber);
			intitializePass(passthrough1, rownumber);
			intitializePass(passthrough2, rownumber);
			pass[r] = 1;
			int ptop = -1;
			int ptop2 = -1;
			int ptop3 = 0;
			int pathTop = -1;
			passthrough[++pathTop] = r;
			while (allpass(pass, rownumber)) {
				if (c >= colnumber) {
					c = 0;
					if (ptop3 <= ptop) {//�o�h�S����
						r = passthrough1[ptop3++];
					}
					else {//�o�h����
						if (ptop2 >= 0) {
							copy(passthrough1, passthrough2, rownumber);//��U�@�h���I�ƻs���o�h
							ptop3 = 0;
							ptop = ptop2;
							ptop2 = -1;
						}
						else {
							r = passthrough[0]+1;
							break;
						}
					}
				}
				if (adjlist[r][c] == 1 && pass[c] == 0) {
					passthrough[++pathTop] = c;
					passthrough2[++ptop2] = c;//�����o�h���F�����I
					pass[c] = 1;
				}
				c++;
			}
			if (!allpass(pass, rownumber)) {
				printf("%d", passthrough[0]);
				for (int i = 1; i <= pathTop; i++) {
					printf("->%d", passthrough[i]);
				}
				break;
			}

		}
		else {
			printf("\n���O�s�q��!!");
			break;
		}
	} while (true);
	
	delete[]pass;
	delete[]passthrough;
	delete[]passthrough1;
	delete[]passthrough2;
}
int main(void) {
	int rownumber = 1;
	int colnumber = 0;
	FILE* f;
	int element;
	char s[100];
	printf("Please input the name of file.>>");
	scanf(" %s", s);//��J�ɮצW��
	char* c0;
	c0 = strstr(s, ".txt");//�P�_�ɮצW�٬O�_���]�t.txt�������ɦW
	do {
		while (!c0) {//�p�G�����ɦW����A�N�A�n�D�ϥΪ̿�J�@��

			printf("The file extension must be \".txt\".\nPlease input again.>>");
			scanf(" %s", s);
			c0 = strstr(s, ".txt");
		}
		if ((f = fopen(s, "r")) == NULL) {
			printf("The file do not exist.\n");//�ɮפ��s�b�A���O����
		}
		else {
			break;
		}
	} while (true);
	getcolnumber(f, &colnumber,&rownumber);
	int** adjlist = new int*[rownumber];
	for (int c = 0; c < colnumber; c++) {
		adjlist[c] = new int[colnumber];
	}

	for (int r = 0; r < rownumber; r++) {//���ɮפ��e��J��}�C��
		for (int c = 0; c < colnumber; c++) {
			fscanf(f, "%d", &element);
			adjlist[r][c] = element;

		}
		
	}
	fclose(f);
	DFS(adjlist,rownumber,colnumber);
	BFS(adjlist, rownumber, colnumber);
	for (int i = 0; i < colnumber; i++) {
		delete[] adjlist[i];
	}
	delete[]adjlist;
	return 0;
	system("pause");
}