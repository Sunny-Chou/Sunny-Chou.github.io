#define _CRT_SECURE_NO_WARNINGS
#include<stdio.h>
#include<stdlib.h>
#include<string.h>
void getcolnumber(FILE* f, int* colnumber,int*rownumber) {//得到file的欄列數，如果內容不正確，就會結束程式
	char c;
	int element;
	int col=0;
	if (fscanf(f, "%d%c", &element, &c) >= 1) {
		do {
			if (element != 0 && element != 1) {//如果元素非0非1
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
bool allpass(int* pass,int r) {//是否全部點都經過
	for (int index = 0; index < r; index++) {
		if (pass[index] == 0) {
			return true;
		}
	}
	return false;
}

void copy(int* passthrough1, int* passthrough2,int row) {//這層拜訪完後把下一層複製到這層
	for (int r = 0; r < row; r++) {
		passthrough1[r] = passthrough2[r];
	}
}

void intitializePass(int* pass,int row) {//把經過節點先初始化
	for (int index = 0; index < row; index++) {
		pass[index] = 0;
	}
}


void DFS(int** adjlist,int rownumber,int colnumber) {
	int r = 0;
	int c = 0;
	int* pass = new int[rownumber];//曾經過的點
	int* passthrough = new int[rownumber];//到這點的路徑
	printf("DFS : ");
	do {
		for (bool end = true; r <= rownumber && end; r++) {//找到出發點
			for (c = 0; c < colnumber; c++) {
				if (r < rownumber&&r != c && adjlist[r][c] == 1) {
					end = false;
					break;
				}
			}
		}
		r--;

		if (r < rownumber) {//如果有出發點
			
			intitializePass(pass, rownumber);
			intitializePass(passthrough, rownumber);
			pass[r] = 1;//出發點已經過

			int ptop = 0;
			int ptop2 = 0;
			passthrough[ptop] = r;//出發點記錄下來
			while (allpass(pass, rownumber)) {

				if (c >= colnumber) {//這條走到底了
					if (ptop2 > 0) {
						r = passthrough[--ptop2];//回去上一點，繼續往下走
						c = 0;
					}
					else {
						r = passthrough[0]+1;
						break;
					}

				}
				if (adjlist[r][c] == 1 && pass[c] == 0) {//如果沒走過這個點
					pass[c] = 1;//記錄曾經過這個點
					++ptop2;
					passthrough[++ptop] = c;//紀錄經過了這個點
					r = c;//從這個點繼續出發
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
			printf("\n不是連通圖!!\n");
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
	int* passthrough1 = new int[rownumber];//這層要走的點
	int* passthrough2 = new int[rownumber];//這層經過的點
	int* passthrough = new int[rownumber];
	printf("BFS : ");
	do {
		for (bool end = true; r <= rownumber && end; r++) {//找到出發點
			for (c = 0; c < colnumber; c++) {
				if (r < rownumber&&r != c && adjlist[r][c] == 1) {
					end = false;
					break;
				}
			}
		}
		r--;

		if (r < rownumber) {//找到出發點
			
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
					if (ptop3 <= ptop) {//這層沒走完
						r = passthrough1[ptop3++];
					}
					else {//這層走完
						if (ptop2 >= 0) {
							copy(passthrough1, passthrough2, rownumber);//把下一層的點複製給這層
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
					passthrough2[++ptop2] = c;//紀錄這層走了那些點
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
			printf("\n不是連通圖!!");
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
	scanf(" %s", s);//輸入檔案名稱
	char* c0;
	c0 = strstr(s, ".txt");//判斷檔案名稱是否有包含.txt的延伸檔名
	do {
		while (!c0) {//如果延伸檔名不對，就再要求使用者輸入一次

			printf("The file extension must be \".txt\".\nPlease input again.>>");
			scanf(" %s", s);
			c0 = strstr(s, ".txt");
		}
		if ((f = fopen(s, "r")) == NULL) {
			printf("The file do not exist.\n");//檔案不存在，指令失敗
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

	for (int r = 0; r < rownumber; r++) {//把檔案內容輸入到陣列裡
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