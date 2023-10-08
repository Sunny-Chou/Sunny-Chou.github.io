#define _CRT_SECURE_NO_WARNINGS
#include "stdio.h"
#include "stdlib.h"
#include "math.h"
int main(void) {
	FILE* input;
	FILE* output;
	FILE* histogram;
	FILE* histogram2;
	char str[100];
	input = fopen("lena.pgm", "r");
	output = fopen("lena2.pgm", "w");
	histogram = fopen("h1.txt", "w");
	histogram2 = fopen("h2.txt", "w");
	fgets(str, 100, input);
	fgets(str, 100, input);
	int h, w;
	int n[256], n2[256];
	double p[256], p2[256];
	double s[256];
	int grayvalue;
	double sk = 0;
	for (int i = 0; i < 256; i++) {
		n[i] = 0;
		n2[i] = 0;
	}
	fscanf(input, "%d ", &h);
	fscanf(input, "%d ", &w);
	fgets(str, 100, input);
	for (int i = 0; i < w; i++) {
		for (int j = 0; j < h; j++) {
			fscanf(input, "%d ", &grayvalue);
			n[grayvalue] += 1;
		}
	}
	for (int i = 0; i < 256; i++) {
		p[i] = (double)n[i] / h / w;
	}
	for (int i = 0; i < 256; i++) {
		sk += p[i] * 255;
		s[i] = sk;
	}
	for (int i = 0; i < 256; i++) {
		n2[(int)round(s[i])] += n[i];
	}
	for (int i = 0; i < 256; i++) {
		p2[i] = (double)n2[i] / h / w;
	}
	fprintf(histogram, "rk \tnk\tpr(rk)\tsk\n");
	for (int i = 0; i < 256; i++) {
		fprintf(histogram, "%3d\t%d\t%3.5f\t%3.2f\n", i, n[i], p[i], s[i]);
	}
	fprintf(histogram2, "rk \tnk\tpr(rk)\n");
	for (int i = 0; i < 256; i++) {
		fprintf(histogram2, "%3d\t%d\t%3.5f\n", i, n2[i], p2[i]);
	}
	fseek(input, 0, SEEK_SET);
	fprintf(output, "%s", fgets(str, 100, input));
	fprintf(output, "%s", fgets(str, 100, input));
	fprintf(output, "%d  %d\n", h, w);
	fprintf(output, "255\n");
	fgets(str, 100, input);
	fgets(str, 100, input);
	int c = 0;
	for (int i = 0; i < w; i++) {
		for (int j = 0; j < h; j++) {
			fscanf(input, "%d ", &grayvalue);
			fprintf(output, "%d ", (int)round(s[grayvalue]));
			c++;
			if (c == 12) {
				fprintf(output, "\n");
				c = 0;
			}
			else {
				fprintf(output, " ");
			}
		}
		fprintf(output, "\n");
	}
	fclose(input);
	fclose(output);
	fclose(histogram);
	fclose(histogram2);
	system("pause");
	return 0;
}