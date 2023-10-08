#define _CRT_SECURE_NO_WARNINGS
#include "stdio.h"
#include "stdlib.h"
#include "time.h"
int main(void) {
	double arr[2][2] = { {1,0},{0,1} }, arr2[2][2] = { {0,1},{1,1} }, temp[2][2] = { {0,1},{1,1} };
	int n, i;
	double START, END;
	printf("Please input n for Fibonacii number F(n) for logarithmic algorithm based on [(F(n-1),F(n)),(F(n(,F(n+1)]=[(0,1),(1,1)]^n,n>=1>>");
	scanf("%d", &n);
	START = clock();
	if (n == 0) {
		END = clock();
		printf("Answer:0\nTime:%.0fms", END - START);
	}
	else {
		for (i = n; !(i % 2) && i != 0; i /= 2,
			temp[0][0] = arr2[0][0] * arr2[0][0] + arr2[0][1] * arr2[1][0],
			temp[0][1] = arr2[0][0] * arr2[0][1] + arr2[0][1] * arr2[1][1],
			temp[1][0] = arr2[1][0] * arr2[0][0] + arr2[1][1] * arr2[1][0],
			temp[1][1] = arr2[1][0] * arr2[0][1] + arr2[1][1] * arr2[1][1],
			arr2[0][0] = temp[0][0], arr2[0][1] = temp[0][1], arr2[1][0] = temp[1][0], arr2[1][1] = temp[1][1]) {

		}
		arr[0][0] = arr2[0][0]; arr[0][1] = arr2[0][1]; arr[1][0] = arr2[1][0]; arr[1][1] = arr2[1][1];
		i /= 2;
		for (int j = i; j; j /= 2) {
			temp[0][0] = arr2[0][0] * arr2[0][0] + arr2[0][1] * arr2[1][0];
			temp[0][1] = arr2[0][0] * arr2[0][1] + arr2[0][1] * arr2[1][1];
			temp[1][0] = arr2[1][0] * arr2[0][0] + arr2[1][1] * arr2[1][0];
			temp[1][1] = arr2[1][0] * arr2[0][1] + arr2[1][1] * arr2[1][1];
			arr2[0][0] = temp[0][0]; arr2[0][1] = temp[0][1]; arr2[1][0] = temp[1][0]; arr2[1][1] = temp[1][1];
			if (j % 2) {
				temp[0][0] = arr[0][0] * arr2[0][0] + arr[0][1] * arr2[1][0];
				temp[0][1] = arr[0][0] * arr2[0][1] + arr[0][1] * arr2[1][1];
				temp[1][0] = arr[1][0] * arr2[0][0] + arr[1][1] * arr2[1][0];
				temp[1][1] = arr[1][0] * arr2[0][1] + arr[1][1] * arr2[1][1];
				arr[0][0] = temp[0][0]; arr[0][1] = temp[0][1]; arr[1][0] = temp[1][0]; arr[1][1] = temp[1][1];
			}
		}
		END = clock();
		printf("Answer:%.0f\n", arr[0][1]);
		printf("Time:%.0fms", (END - START));
	}
	system("pause");
	return 0;
}