#define _CRT_SECURE_NO_WARNINGS
#include "stdio.h"
#include "stdlib.h"
#include "math.h"
#include "time.h"
int main(void) {
	double START, END;
	int n;
	printf("Please input n for Fibonacii number F(n) for explicit formula algorithm>>");
	scanf("%d", &n);
	START = clock();
	printf("Answer:%.0f\n", (pow((1 + sqrt(5)) / 2, n) - pow((1 - sqrt(5)) / 2, n)) / sqrt(5));
	END = clock();
	printf("Time:%.0fms", (END - START));
	system("pause");
	return 0;
}