#define _CRT_SECURE_NO_WARNINGS
#include "stdio.h"
#include "stdlib.h"
#include "time.h"
int main(void) {
	const int mtx[2][2] = { {0,1},{1,1} };
	double arr[2][2] = { {0,1},{1,1} }, temp[2][2] = { {0,1},{1,1} };
	int n;
	double START, END;
	printf("Please input n for Fibonacii number F(n) for sequential algorithm based on [(F(n-1),F(n)),(F(n(,F(n+1)]=[(0,1),(1,1)]^n,n>=1>>");
	scanf("%d", &n);
	START = clock();
	if (n == 0) {
		END = clock();
		printf("Answer:%.0f\n", arr[0][0]);
		printf("Time:%.0fms", (END - START));
	}
	else {
		for (int i = 1; i < n; i++) {
			temp[0][0] = arr[0][0] * mtx[0][0] + arr[0][1] * mtx[1][0];
			temp[0][1] = arr[0][0] * mtx[0][1] + arr[0][1] * mtx[1][1];
			temp[1][0] = arr[1][0] * mtx[0][0] + arr[1][1] * mtx[1][0];
			temp[1][1] = arr[1][0] * mtx[0][1] + arr[1][1] * mtx[1][1];
			arr[0][0] = temp[0][0]; arr[0][1] = temp[0][1]; arr[1][0] = temp[1][0]; arr[1][1] = temp[1][1];
		}
		END = clock();
		printf("Answer:%.0f\n", arr[0][1]);
		printf("Time:%.0fms", (END - START));
	}
	
	system("pause");
	return 0;
}