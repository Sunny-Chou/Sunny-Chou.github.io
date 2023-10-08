#define _CRT_SECURE_NO_WARNINGS
#include "stdio.h"
#include "stdlib.h"
#include "time.h"
double Fibonacci(unsigned int);
int main(void) {
	int n;
	double START, END;
	printf("Please input n for Fibonacii number F(n) for recursive algorithm>>");
	scanf("%d", &n);
	START = clock();
	printf("Answer:%.0f\n", Fibonacci(n));
	END = clock();
	printf("Time:%.0fms", (END - START));
	system("pause");
	return 0;
}
double Fibonacci(unsigned int n) {
	if (n <= 1) {
		return n;
	}
	else {
		return Fibonacci(n - 1) + Fibonacci(n - 2);
	}
}