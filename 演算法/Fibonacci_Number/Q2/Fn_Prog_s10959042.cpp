#define _CRT_SECURE_NO_WARNINGS
#include "stdio.h"
#include "stdlib.h"
#include "time.h"
int main(void) {
	int n;
	double* arr;
	double START, END;
	printf("Please input n for Fibonacii number F(n) for non-recursive definition-based algorithm>>");
	scanf("%d", &n);
	START = clock();
	arr= new double[n+1];
	arr[0] = 0;
	arr[1] = 1;
	for (int i = 2; i <= n; i++) {
		arr[i] = arr[i-1] + arr[i-2];
	}
	END = clock();
	printf("Answer:%.0f\n", arr[n]);
	printf("Time:%.0fms", (END - START));
	system("pause");
	delete[] arr;
	return 0;
}