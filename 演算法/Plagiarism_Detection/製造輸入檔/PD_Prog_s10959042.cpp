#define _CRT_SECURE_NO_WARNINGS
#include "stdio.h"
#include "stdlib.h"
#include "math.h"
#include "time.h"
int main(void) {
	int n, x, y;
	FILE* out;
	out = fopen("TestFile.txt", "w");
	srand(time(NULL));
	printf("�п�J�n�X��0~9���ü�>>");
	do {
		scanf("%d", &n);
	} while (n <= 0);
	printf("�п�J�n�X�q>>");
	do {
		scanf("%d", &y);
	} while (y <= 0 || y > n);
	for (int i = 0; i < n - y * floor(n / y); i++) {
		x = rand() % 10;
		fprintf(out, "%d", x);
	}
	for (int i = 0; i < y; i++) {
		for (int j = 0; j < floor(n/y); j++) {
			x = rand() % 10;
			fprintf(out, "%d", x);
		}
		if (i != y - 1) {
			fprintf(out, "\n");
		}
	}
	fclose(out);
	system("pause");
	return 0;
}