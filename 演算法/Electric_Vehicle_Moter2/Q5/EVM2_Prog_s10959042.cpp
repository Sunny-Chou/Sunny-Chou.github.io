#define _CRT_SECURE_NO_WARNINGS
#include "math.h"
#include "stdio.h"
#include "stdlib.h"
#include "time.h"
int maxx = 0;
int maxy = 0;
struct point {
	double x;
	double y;
};
struct e;
struct be;
typedef struct bl* bline;
typedef struct bl {
	bline lp, rp;
	point p;
	e* ev;
	be* bev;
	be* bevl;
	be* bevr;
	be* bevd;
};

struct e {
	double y;
	bline b;
	point o;
	bool valid = true;
};
struct be {
	double y;
	bline b1, b2;
	point o;
	bool valid;
};
struct v {
	point p;
	point p1, p2, p3;
};
struct bv {
	point p;
	point p1, p2;
};
point ppop(point* p, int* index);
point ptop(point* p);
e* epop(e** ev, int* index);
e* etop(e** ev);
void d(bline b);
void process_point(point* p, int* index, bline* b, e** ev, int* index3, be** bev, int* index5);
void process_event(e** equeue, int* index3, v* v, int* index4, be** bev, int* index5, bv* bvt, int* index6);
void circle_event(bline* b, double y0, e** equeue, int* index3);
bool circle(point a, point b, point c, double* y, point* o);
void insertion(point p, bline* b);
void insert(point p, bline* b, e** equeue, int* index3, be** bequeue, int* index5);
bool ifintersect(point p1, bline p2);
point intersection(point p1, point p2, double d);
void insertbe(be** bequeue, be* bev, int* index5);
be* bepop(be** bev, int* index);
be* betop(be** bev);
bool boundl(point p1, point p2, double* y, point* o);
bool boundr(point p1, point p2, double* y, point* o);
bool boundu(point p1, point p2, double* y, point* o);
bool boundd(point p1, point p2, double* y, point* o);
void boundu_event(bline* b, be** bequeue, int* index5, double y0);
void process_bevent(be** bequeue, int* index5, bv* bv, int* index6);
void boundu_event(bline* b, be** bequeue, int* index5, double y0);
void boundd_event(bline* b, be** bequeue, int* index5, double y0);
void boundr_event(bline* b, be** bequeue, int* index5, double y0);
void boundl_event(bline* b, be** bequeue, int* index5, double y0);
bool boundl(point p1, point p2, double* y, point* o);
bool boundr(point p1, point p2, double* y, point* o);
bool boundd(point p1, point p2, double* y, point* o);
bool boundu(point p1, point p2, double* y, point* o);
void inserte(e** equeue, e* ev, int* index3);
void print(bv* bvt, int index6, v* vt, int index4);
point dt(v* vt, int* index4, bv* bvt, int* index6, point* p, int index, point* p3, int* index8);
void dv(v* vt, int i, int* index4);
void insertv(point p, point* p2, int* index8);
double dtlong(v* vt, int index4, bv* bvt, int index6, point* p, int index);
void dbv(bv* bvt, int i, int* index6);
void checkdbv(point* p, bv* bvt, int index9, int* index6, int index7);
void checkdv(point* p, v* vt, int index15, int* index4, int index7);
void freeb(bline* b);
int main(void) {
	FILE* map;
	char s[10];
	printf("請輸入檔案名稱(9位元內)>>");
	scanf("%s", s);
	map = fopen(s, "r");
	int in;
	char c;
	int index = 0;
	int ifeof = 1;
	while (ifeof != EOF) {
		ifeof = fscanf(map, "%d ", &in);
		maxx++;
	}
	maxx--;
	fseek(map, 0, SEEK_SET);
	ifeof = 1;
	while (ifeof != EOF) {
		ifeof = c = fgetc(map);
		if (c == '\n') {
			maxy++;
		}
	}
	maxx /= maxy;
	fseek(map, 0, SEEK_SET);
	for (int i = 0; i < maxy; i++) {
		for (int j = 0; j < maxx; j++) {
			fscanf(map, "%d ", &in);
			if (in > 0) {
				index++;
			}
		}
	}
	point* p = new point[index], * p2 = new point[index];
	index = 0;
	int index7 = 0;
	fseek(map, 0, SEEK_SET);
	for (int i = 0; i < maxy; i++) {
		for (int j = 0; j < maxx; j++) {
			fscanf(map, "%d ", &in);
			if (in > 0) {
				p[index].x = j;
				p[index++].y = i;
				p2[index7].x = j;
				p2[index7++].y = i;
			}
		}
	}
	printf("充電站位置：\n");
	for (int i = 0; i < index; i++) {
		printf("(%.0f,%.0f)\n", p[i].x, p[i].y);
	}
	int index2 = 0, index4 = 0, index5 = 0, index6 = 0;
	int index3 = index * (index - 1) * (index - 2) / 6;
	bline beachline = NULL;
	v* vt = new v[index3];
	bv* bvt = new bv[index3];
	e** ev = new e * [index3];
	be** bev = new be * [index3];
	index3 = 0;
	while (index != 0) {
		if (index3 != 0 && etop(ev)->y <= ptop(p).y && etop(ev)->y <= betop(bev)->y) {
			process_event(ev, &index3, vt, &index4, bev, &index5, bvt, &index6);
		}
		else if (index5 == 0 || ptop(p).y <= betop(bev)->y) {
			process_point(p, &index, &beachline, ev, &index3, bev, &index5);
		}
		else if (index5 != 0) {
			process_bevent(bev, &index5, bvt, &index6);
		}
	}
	while (index3 != 0 || index5 != 0) {
		if (index5 == 0 || (index3 != 0 && etop(ev)->y <= betop(bev)->y)) {
			process_event(ev, &index3, vt, &index4, bev, &index5, bvt, &index6);
		}
		else if (index5 != 0) {
			process_bevent(bev, &index5, bvt, &index6);
		}
	}
	printf("點為：\n");
	for (int i = 0; i < index4; i++) {
		printf("(%.2f,%.2f)\n", vt[i].p.x, vt[i].p.y);
	}
	printf("邊界點為：\n");
	for (int i = 0; i < index6; i++) {
		printf("(%.2f,%.2f)\n", bvt[i].p.x, bvt[i].p.y);
	}
	freeb(&beachline);
	print(bvt, index6, vt, index4);
	double k0;
	printf("請輸入最遠距離門檻值(公里)*注意：門檻值太低，數值很可能會overflow或是空間不足計算生產點，如果跑不出來，請將門檻值調大!>>");
	scanf("%lf", &k0);
	int n = 0;
	int number = index7 + round(maxx * maxy / (k0 + 1) / (k0 + 1) + 1);
	int maxxy = 0;
	if (maxx > maxy) {
		maxxy = maxx;
	}
	else {
		maxxy = maxy;
	}
	double START, END;
	START = clock();
	point* p4 = (point*)malloc(number*sizeof(*p4));
	int index10 = 0;
	for (int i = 0; i < index7; i++) {
		p4[index10++] = p2[i];
	}
	int number2 = number * (number - 1) * (number - 2) / 6;
	if (number2 < index6) {
		number2 = index6;
	}
	if (number2 < index4) {
		number2 = index4;
	}
	double k = dtlong(vt, index4, bvt, index6, p4, index10);
	int index11 = 0, index12 = 0, index13 = 0, index14 = 0;
	v* vt2 = (v*)malloc(number2 * sizeof(*vt2));
	bv* bvt2 = (bv*)malloc(number2 * sizeof(*bvt2));
	for (int i = 0; i < index4; i++) {
		vt2[index11++] = vt[i];
	}
	for (int i = 0; i < index6; i++) {
		bvt2[index12++] = bvt[i];
	}
	while (k > k0) {
		point* p3 = (point*)malloc(number * sizeof(*p3));
		int index8 = 0;
		point op = dt(vt2, &index11, bvt2, &index12, p4, index10, p3, &index8);
		e** ev2 = (e**)malloc(number2 * sizeof(*ev2));
		be** bev2 = (be**)malloc(number2 * sizeof(*bev2));
		printf("新增點(%.2f,%.2f)\n", op.x, op.y);
		insertv(op, p4, &index10);
		for (int i = 0; i < index11; i++) {
			if (pow(vt2[i].p.x - vt2[i].p1.x, 2) + pow(vt2[i].p.y - vt2[i].p1.y, 2) > pow(op.x - vt2[i].p.x, 2) + pow(op.y - vt2[i].p.y, 2) || pow(vt2[i].p.x - vt2[i].p2.x, 2) + pow(vt2[i].p.y - vt2[i].p2.y, 2) > pow(op.x - vt2[i].p.x, 2) + pow(op.y - vt2[i].p.y, 2) || pow(vt2[i].p.x - vt2[i].p3.x, 2) + pow(vt2[i].p.y - vt2[i].p3.y, 2) > pow(op.x - vt2[i].p.x, 2) + pow(op.y - vt2[i].p.y, 2)) {
				insertv(vt2[i].p1, p3, &index8);
				insertv(vt2[i].p2, p3, &index8);
				insertv(vt2[i].p3, p3, &index8);
				dv(vt2, i, &index11);
				i--;
			}
		}
		for (int i = 0; i < index12; i++) {
			if (pow(bvt2[i].p.x - bvt2[i].p1.x, 2) + pow(bvt2[i].p.y - bvt2[i].p1.y, 2) > pow(op.x - bvt2[i].p.x, 2) + pow(op.y - bvt2[i].p.y, 2) || pow(bvt2[i].p.x - bvt2[i].p2.x, 2) + pow(bvt2[i].p.y - bvt2[i].p2.y, 2) > pow(op.x - bvt2[i].p.x, 2) + pow(op.y - bvt2[i].p.y, 2)) {
				insertv(bvt2[i].p1, p3, &index8);
				insertv(bvt2[i].p2, p3, &index8);
				dbv(bvt2, i, &index12);
				i--;
			}
		}
		bline b2 = NULL;
		int index9 = index12;
		int index15 = index11;
		while (index8 != 0) {
			if (index13 != 0 && etop(ev2)->y <= ptop(p3).y && etop(ev2)->y <= betop(bev2)->y) {
				process_event(ev2, &index13, vt2, &index11, bev2, &index14, bvt2, &index12);
			}
			else if (index14 == 0 || ptop(p3).y <= betop(bev2)->y) {
				process_point(p3, &index8, &b2, ev2, &index13, bev2, &index14);
			}
			else if (index14 != 0) {
				process_bevent(bev2, &index14, bvt2, &index12);
				
			}
		}
		while (index13 != 0 || index14 != 0) {
			if (index14 == 0 || (index13 != 0 && etop(ev2)->y <= betop(bev2)->y)) {
				process_event(ev2, &index13, vt2, &index11, bev2, &index14, bvt2, &index12);
			}
			else if (index14 != 0) {
				process_bevent(bev2, &index14, bvt2, &index12);
			}
		}
		checkdbv(p4, bvt2, index9, &index12, index10);
		checkdv(p4, vt2, index15, &index11, index10);
		freeb(&b2);
		n++;
		free(p3);
		k = dtlong(vt2, index11, bvt2, index12, p4, index10);
		free(ev2);
		free(bev2);
	}
	printf("充電站位置：\n");
	for (int i = 0; i < index10; i++) {
		printf("(%.2f,%.2f)\n", p4[i].x, p4[i].y);
	}
	printf("總共需新增%d個充電站\n離充電站最遠的距離為%f公里\n點為：\n", n, k);
	for (int i = 0; i < index11; i++) {
		printf("(%.2f,%.2f)\n", vt2[i].p.x, vt2[i].p.y);
	}
	printf("邊界點為：\n");
	for (int i = 0; i < index12; i++) {
		printf("(%.2f,%.2f)\n", bvt2[i].p.x, bvt2[i].p.y);
	}
	print(bvt2, index12, vt2, index11);
	END = clock();
	printf("Time:%.0fms", (END - START));
	delete[]ev;
	delete[]bvt;
	delete[]bev;
	delete[]vt;
	delete[]p;
	delete[]p2;
	free(vt2);
	free(bvt2);
	free(p4);
	fclose(map);
	system("pause");
	return 0;
}
void freeb(bline* b) {
	if (*b == NULL) {
		return;
	}
	freeb(&((*b)->rp));
	free(*b);
}
point dt(v* vt, int* index4, bv* bvt, int* index6, point* p, int index, point* p3, int* index8) {
	double max = 0;
	point o;
	int w = 0;
	int oindex;
	for (int i = 0; i < *index4; i++) {
		if (max <= pow(vt[i].p1.x - vt[i].p.x, 2) + pow(vt[i].p1.y - vt[i].p.y, 2)) {
			bool ife2 = true;
			for (int j = 0; j < index; j++) {
				if (vt[i].p.x == p[j].x && vt[i].p.y == p[j].y) {
					ife2 = false;
					break;
				}
			}
			if (ife2) {
				max = pow(vt[i].p1.x - vt[i].p.x, 2) + pow(vt[i].p1.y - vt[i].p.y, 2);
				o = vt[i].p;
				oindex = i;
			}
		}
	}
	for (int i = 0; i < *index6; i++) {
		if (max <= pow(bvt[i].p1.x - bvt[i].p.x, 2) + pow(bvt[i].p1.y - bvt[i].p.y, 2)) {
			bool ife2 = true;
			for (int j = 0; j < index; j++) {
				if (bvt[i].p.x == p[j].x && bvt[i].p.y == p[j].y) {
					ife2 = false;
					break;
				}
			}
			if (ife2) {
				max = pow(bvt[i].p1.x - bvt[i].p.x, 2) + pow(bvt[i].p1.y - bvt[i].p.y, 2);
				o = bvt[i].p;
				oindex = i;
				w = 1;
			}
		}
	}
	double min = maxx * maxx + maxy * maxy;
	bool ife = true;
	for (int i = 0; i < index; i++) {
		if (p[i].x == 0 && p[i].y == 0) {
			ife = false;
			break;
		}
	}
	if (ife) {
		for (int i = 0; i < index; i++) {
			if (min >= pow(p[i].x, 2) + pow(p[i].y, 2)) {
				min = pow(p[i].x, 2) + pow(p[i].y, 2);
			}
		}
		if (max < min) {
			max = min;
			o.x = 0;
			o.y = 0;
			w = 2;
		}
	}
	ife = true;
	min = maxx * maxx + maxy * maxy;
	for (int i = 0; i < index; i++) {
		if (p[i].x == 0 && p[i].y == maxy) {
			ife = false;
			break;
		}
	}
	if (ife) {
		for (int i = 0; i < index; i++) {
			if (min >= pow(p[i].x, 2) + pow(p[i].y - maxy, 2)) {
				min = pow(p[i].x, 2) + pow(p[i].y - maxy, 2);
			}
		}
		if (max < min) {
			max = min;
			o.x = 0;
			o.y = maxy;
			w = 3;
		}
	}
	ife = true;
	min = maxx * maxx + maxy * maxy;
	for (int i = 0; i < index; i++) {
		if (p[i].x == maxx && p[i].y == maxy) {
			ife = false;
			break;
		}
	}
	if (ife) {
		for (int i = 0; i < index; i++) {
			if (min >= pow(p[i].x - maxx, 2) + pow(p[i].y - maxy, 2)) {
				min = pow(p[i].x - maxx, 2) + pow(p[i].y - maxy, 2);
			}
		}
		if (max <= min) {
			max = min;
			o.x = maxx;
			o.y = maxy;
			w = 4;
		}
	}
	ife = true;
	min = maxx * maxx + maxy * maxy;
	for (int i = 0; i < index; i++) {
		if (p[i].x == maxx && p[i].y == 0) {
			ife = false;
			break;
		}
	}
	if (ife) {
		for (int i = 0; i < index; i++) {
			if (min >= pow(p[i].x - maxx, 2) + pow(p[i].y, 2)) {
				min = pow(p[i].x - maxx, 2) + pow(p[i].y, 2);
			}
		}
		if (max < min) {
			max = min;
			o.x = maxx;
			o.y = 0;
			w = 5;
		}
	}
	insertv(o, p3, index8);
	switch (w) {
	case 0:
		insertv(vt[oindex].p1, p3, index8);
		insertv(vt[oindex].p2, p3, index8);
		insertv(vt[oindex].p3, p3, index8);
		dv(vt, oindex, index4);
		break;
	case 1:
		insertv(bvt[oindex].p1, p3, index8);
		insertv(bvt[oindex].p2, p3, index8);
		dbv(bvt, oindex, index6);
		break;
	case 2:
		for (int i = 0; i < index; i++) {
			if (max == pow(p[i].x, 2) + pow(p[i].y, 2)) {
				insertv(p[i], p3, index8);
			}
		}
		break;
	case 3:
		for (int i = 0; i < index; i++) {
			if (max == pow(p[i].x, 2) + pow(p[i].y - maxy, 2)) {
				insertv(p[i], p3, index8);
			}
		}
		break;
	case 4:
		for (int i = 0; i < index; i++) {
			if (max == pow(p[i].x - maxx, 2) + pow(p[i].y - maxy, 2)) {
				insertv(p[i], p3, index8);
			}
		}
		break;
	case 5:
		for (int i = 0; i < index; i++) {
			if (max == pow(p[i].x - maxx, 2) + pow(p[i].y, 2)) {
				insertv(p[i], p3, index8);
			}
		}
		break;
	}
	return o;
}
void checkdbv(point* p, bv* bvt, int index9, int* index6, int index7) {
	double min;
	for (int i = index9; i < *index6; i++) {
		for (int j = 0; j < index9; j++) {
			if (bvt[i].p.x == bvt[j].p.x && bvt[i].p.y == bvt[j].p.y) {
				dbv(bvt, i--, index6);
				break;
			}
		}
	}
	for (int i = index9; i < *index6; i++) {
		min = pow(bvt[i].p1.x - bvt[i].p.x, 2) + pow(bvt[i].p1.y - bvt[i].p.y, 2);
		for (int j = 0; j < index7; j++) {
			if (bvt[i].p2.x != p[j].x || bvt[i].p2.y != p[j].y) {
				if (min > pow(p[j].x - bvt[i].p.x, 2) + pow(p[j].y - bvt[i].p.y, 2)) {
					dbv(bvt, i--, index6);
					break;
				}
			}
		}
	}
}
void checkdv(point* p, v* vt, int index15, int* index4, int index7) {
	double min;
	for (int i = index15; i < *index4; i++) {
		for (int j = 0; j < index15; j++) {
			if (vt[i].p.x == vt[j].p.x && vt[i].p.y == vt[j].p.y) {
				dv(vt, i--, index4);
				break;
			}
		}
	}
	for (int i = index15; i < *index4; i++) {
		min = pow(vt[i].p1.x - vt[i].p.x, 2) + pow(vt[i].p1.y - vt[i].p.y, 2);
		for (int j = 0; j < index7; j++) {
			if ((vt[i].p2.x != p[j].x || vt[i].p2.y != p[j].y) && (vt[i].p3.x != p[j].x || vt[i].p3.y != p[j].y)) {
				if (min > pow(p[j].x - vt[i].p.x, 2) + pow(p[j].y - vt[i].p.y, 2)) {
					dv(vt, i--, index4);
					break;
				}
			}
		}
	}
}
double dtlong(v* vt, int index4, bv* bvt, int index6, point* p, int index) {
	double max = 0;
	for (int i = 0; i < index4; i++) {
		if (max <= pow(vt[i].p1.x - vt[i].p.x, 2) + pow(vt[i].p1.y - vt[i].p.y, 2)) {
			bool ife2 = true;
			for (int j = 0; j < index; j++) {
				if (vt[i].p.x == p[j].x && vt[i].p.y == p[j].y) {
					ife2 = false;
					break;
				}
			}
			if (ife2) {
				max = pow(vt[i].p1.x - vt[i].p.x, 2) + pow(vt[i].p1.y - vt[i].p.y, 2);
			}
		}
	}
	for (int i = 0; i < index6; i++) {
		if (max <= pow(bvt[i].p1.x - bvt[i].p.x, 2) + pow(bvt[i].p1.y - bvt[i].p.y, 2)) {
			bool ife2 = true;
			for (int j = 0; j < index; j++) {
				if (bvt[i].p.x == p[j].x && bvt[i].p.y == p[j].y) {
					ife2 = false;
					break;
				}
			}
			if (ife2) {
				max = pow(bvt[i].p1.x - bvt[i].p.x, 2) + pow(bvt[i].p1.y - bvt[i].p.y, 2);
			}
		}
	}
	double min = maxx * maxx + maxy * maxy;
	bool ife = true;
	for (int i = 0; i < index; i++) {
		if (p[i].x == 0 && p[i].y == 0) {
			ife = false;
			break;
		}
	}
	if (ife) {
		for (int i = 0; i < index; i++) {
			if (min >= pow(p[i].x, 2) + pow(p[i].y, 2)) {
				min = pow(p[i].x, 2) + pow(p[i].y, 2);
			}
		}
		if (max < min) {
			max = min;
		}
	}
	ife = true;
	min = maxx * maxx + maxy * maxy;
	for (int i = 0; i < index; i++) {
		if (p[i].x == 0 && p[i].y == maxy) {
			ife = false;
			break;
		}
	}
	if (ife) {
		for (int i = 0; i < index; i++) {
			if (min >= pow(p[i].x, 2) + pow(p[i].y - maxy, 2)) {
				min = pow(p[i].x, 2) + pow(p[i].y - maxy, 2);
			}
		}
		if (max < min) {
			max = min;
		}
	}
	ife = true;
	min = maxx * maxx + maxy * maxy;
	for (int i = 0; i < index; i++) {
		if (p[i].x == maxx && p[i].y == maxy) {
			ife = false;
			break;
		}
	}
	if (ife) {
		for (int i = 0; i < index; i++) {
			if (min >= pow(p[i].x - maxx, 2) + pow(p[i].y - maxy, 2)) {
				min = pow(p[i].x - maxx, 2) + pow(p[i].y - maxy, 2);
			}
		}
		if (max <= min) {
			max = min;
		}
	}
	ife = true;
	min = maxx * maxx + maxy * maxy;
	for (int i = 0; i < index; i++) {
		if (p[i].x == maxx && p[i].y == 0) {
			ife = false;
			break;
		}
	}
	if (ife) {
		for (int i = 0; i < index; i++) {
			if (min >= pow(p[i].x - maxx, 2) + pow(p[i].y, 2)) {
				min = pow(p[i].x - maxx, 2) + pow(p[i].y, 2);
			}
		}
		if (max < min) {
			max = min;
		}
	}
	return sqrt(max);
}
void dv(v* vt, int i, int* index4) {
	for (int j = i; j < *index4 - 1; j++) {
		vt[j] = vt[j + 1];
	}
	(*index4)--;
}
void dbv(bv* bvt, int i, int* index6) {
	for (int j = i; j < *index6 - 1; j++) {
		bvt[j] = bvt[j + 1];
	}
	(*index6)--;
}
void insertv(point p, point* p2, int* index8) {
	if (*index8 == 0) {
		p2[(*index8)++] = p;
		return;
	}
	bool ife = true;
	for (int i = 0; i < *index8; i++) {
		if (p2[i].x == p.x && p2[i].y == p.y) {
			ife = false;
			break;
		}
	}
	if (ife) {
		if (p2[*index8 - 1].y < p.y || (p2[*index8 - 1].y == p.y && p2[*index8 - 1].x <= p.x)) {
			p2[(*index8)++] = p;
		}
		else if (p2[0].y > p.y || (p2[0].x >= p.x && p2[0].y == p.y)) {
			for (int i = *index8; i > 0; i--) {
				p2[i] = p2[i - 1];
			}
			p2[0] = p;
			(*index8)++;
		}
		else {
			int x;
			for (int i = 0; i < *index8 - 1; i++) {
				if (p2[i].y < p.y && p2[i + 1].y > p.y) {
					x = i + 1;
					break;
				}
				else if (p2[i].y == p.y && p2[i].x <= p.x && p2[i + 1].y == p.y && p2[i + 1].x >= p.x) {
					x = i + 1;
					break;
				}
				else if (p2[i].y == p.y && p2[i].x <= p.x && p2[i + 1].y > p.y) {
					x = i + 1;
					break;
				}
				else if (p2[i].y < p.y&& p2[i + 1].x >= p.x && p2[i + 1].y == p.y) {
					x = i + 1;
					break;
				}
			}
			for (int i = *index8; i > x; i--) {
				p2[i] = p2[i - 1];
			}
			p2[x] = p;
			(*index8)++;
		}
	}
}
void print(bv* bvt, int index6, v* vt, int index4) {
	bool ife = true;
	for (int i = 0; i < index6; i++) {
		if (bvt[i].p.x == 0 && bvt[i].p.y == 0) {
			ife = false;
		}
	}
	for (int i = 0; i < index4; i++) {
		if (vt[i].p.x == 0 && vt[i].p.y == 0) {
			ife = false;
		}
	}
	if (ife) {
		printf("(0.00,0.00)\n");
	}
	ife = true;
	for (int i = 0; i < index6; i++) {
		if (bvt[i].p.x == 0 && bvt[i].p.y == maxy) {
			ife = false;
		}
	}
	for (int i = 0; i < index4; i++) {
		if (vt[i].p.x == 0 && vt[i].p.y == maxy) {
			ife = false;
		}
	}
	if (ife) {
		printf("(0.00,%d.00)\n", maxy);
	}
	ife = true;
	for (int i = 0; i < index6; i++) {
		if (bvt[i].p.x == maxx && bvt[i].p.y == 0) {
			ife = false;
		}
	}
	for (int i = 0; i < index4; i++) {
		if (vt[i].p.x == maxx && vt[i].p.y == 0) {
			ife = false;
		}
	}
	if (ife) {
		printf("(%d.00,0.00)\n", maxx);
	}
	ife = true;
	for (int i = 0; i < index6; i++) {
		if (bvt[i].p.x == maxx && bvt[i].p.y == maxy) {
			ife = false;
		}
	}
	for (int i = 0; i < index4; i++) {
		if (vt[i].p.x == maxx && vt[i].p.y == maxy) {
			ife = false;
		}
	}
	if (ife) {
		printf("(%d.00,%d.00)\n", maxx, maxy);
	}
}
point ppop(point* p, int* index) {
	point p0 = p[0];
	for (int i = 0; i < *index - 1; i++) {
		p[i] = p[i + 1];
	}
	(*index)--;
	return p0;
}
point ptop(point* p) {
	return p[0];
}
e* epop(e** ev, int* index) {
	e* e0 = ev[0];
	for (int i = 0; i < *index - 1; i++) {
		ev[i] = ev[i + 1];
	}
	(*index)--;
	return e0;
}
e* etop(e** ev) {
	return ev[0];
}
be* bepop(be** bev, int* index) {
	be* be0 = bev[0];
	for (int i = 0; i < *index - 1; i++) {
		bev[i] = bev[i + 1];
	}
	(*index)--;
	return be0;
}
be* betop(be** bev) {
	return bev[0];
}
void d(bline b) {
	if (b->bev) {
		b->bev->valid = false;
		b->bev = NULL;
	}
	if (b->lp->bev) {
		b->lp->bev->valid = false;
		b->lp->bev = NULL;
	}
	if (b->bevd) {
		b->bevd->valid = false;
		b->bevd = NULL;
	}
	if (b->lp->bevd) {
		b->lp->bevd->valid = false;
		b->lp->bevd = NULL;
	}
	if (b->bevr) {
		b->bevr->valid = false;
		b->bevr = NULL;
	}
	if (b->lp->bevr) {
		b->lp->bevr->valid = false;
		b->lp->bevr = NULL;
	}
	if (b->bevl) {
		b->bevl->valid = false;
		b->bevl = NULL;
	}
	if (b->lp->bevl) {
		b->lp->bevl->valid = false;
		b->lp->bevl = NULL;
	}
	if (b->ev) {
		b->ev->valid = false;
		b->ev = NULL;
	}
	if (b->lp->ev) {
		b->lp->ev->valid = false;
		b->lp->ev = NULL;
	}
	if (b->rp->ev) {
		b->rp->ev->valid = false;
		b->rp->ev = NULL;
	}
	if (b->rp && b->lp) {
		b->rp->lp = b->lp;
		b->lp->rp = b->rp;
	}
	else if (b->rp) {
		b->rp->lp = NULL;
	}
	else if (b->lp) {
		b->lp->rp = NULL;
	}
}
void process_point(point* p, int* index, bline* b, e** ev, int* index3, be** bev, int* index5) {
	point p0 = ppop(p, index);
	insert(p0, b, ev, index3, bev, index5);
}
void process_event(e** equeue, int* index3, v* v, int* index4, be** bequeue, int* index5, bv* bvt, int* index6) {
	e* ev = epop(equeue, index3);
	if (ev->valid) {
		if (ev->o.x > maxx || ev->o.x < 0 || ev->o.y > maxy || ev->o.y < 0) {

		}
		else {
			v[*index4].p = ev->o;
			v[*index4].p2 = ev->b->p;
			v[*index4].p1 = ev->b->lp->p;
			v[(*index4)++].p3 = ev->b->rp->p;
		}
		d(ev->b);
		boundu_event(&ev->b->lp, bequeue, index5, ev->y);
		boundd_event(&ev->b->lp, bequeue, index5, ev->y);
		boundr_event(&ev->b->lp, bequeue, index5, ev->y);
		boundl_event(&ev->b->lp, bequeue, index5, ev->y);
		circle_event(&ev->b->lp, ev->y, equeue, index3);
		circle_event(&ev->b->rp, ev->y, equeue, index3);
		if (ev->b->lp) {
			free(ev->b);
		}
		else if (!ev->b->lp && ev->b->rp) {
			ev->b = ev->b->rp;
			free(ev->b->lp);
			ev->b->lp = NULL;
		}
		else {
			ev->b = NULL;
		}
	}
	free(ev);
}
void process_bevent(be** bequeue, int* index5, bv* bv, int* index6) {
	be* bev = bepop(bequeue, index5);
	if (bev->valid) {
		bv[*index6].p = bev->o;
		bv[*index6].p2 = bev->b1->p;
		bv[(*index6)++].p1 = bev->b2->p;
		if (bev->o.y == 0) {
			bev->b1->bev = NULL;
		}
		else if (bev->o.y == maxy) {
			bev->b1->bevd = NULL;
		}
		else if (bev->o.x == 0) {
			bev->b1->bevl = NULL;
		}
		else if (bev->o.x == maxx) {
			bev->b1->bevr = NULL;
		}
	}
	free(bev);
}
void boundu_event(bline* b, be** bequeue, int* index5, double y0) {
	if (!*b || !(*b)->rp) {
		return;
	}
	double y;
	point o;
	be* bev;
	if (boundu((*b)->p, (*b)->rp->p, &y, &o) && y >= y0) {
		if (o.x <= (*b)->p.x) {
			if (!(*b)->lp || intersection((*b)->lp->p, (*b)->rp->p, y).y < o.y) {
			}
			else {
				return;
			}
		}
		else if (o.x >= (*b)->rp->p.x) {
			if (!(*b)->rp->rp || intersection((*b)->p, (*b)->rp->rp->p, y).y < o.y) {
			}
			else {
				return;
			}
		}
		bev = (be*)malloc(sizeof(*bev));
		bev->b1 = *b;
		bev->b2 = (*b)->rp;
		bev->o = o;
		bev->valid = true;
		bev->y = y;
		(*b)->bev = bev;
		insertbe(bequeue, bev, index5);
	}
}
void boundd_event(bline* b, be** bequeue, int* index5, double y0) {
	if (!*b || !(*b)->rp) {
		return;
	}
	double y;
	point o;
	be* bev = NULL;
	if (boundd((*b)->p, (*b)->rp->p, &y, &o) && y >= y0) {
		bev = (be*)malloc(sizeof(*bev));
		bev->b1 = *b;
		bev->b2 = (*b)->rp;
		bev->o = o;
		bev->valid = true;
		bev->y = y;
		(*b)->bevd = bev;
		insertbe(bequeue, bev, index5);
	}
}
void boundr_event(bline* b, be** bequeue, int* index5, double y0) {
	if (!*b || !(*b)->rp) {
		return;
	}
	double y;
	point o;
	be* bev;
	if (boundr((*b)->p, (*b)->rp->p, &y, &o) && y >= y0) {
		bev = (be*)malloc(sizeof(*bev));
		bev->b1 = *b;
		bev->b2 = (*b)->rp;
		bev->o = o;
		bev->valid = true;
		bev->y = y;
		(*b)->bevr = bev;
		insertbe(bequeue, bev, index5);
	}
}
void boundl_event(bline* b, be** bequeue, int* index5, double y0) {
	if (!*b || !(*b)->rp) {
		return;
	}
	double y;
	point o;
	be* bev;
	if (boundl((*b)->p, (*b)->rp->p, &y, &o) && y >= y0) {
		bev = (be*)malloc(sizeof(*bev));
		bev->b1 = *b;
		bev->b2 = (*b)->rp;
		bev->o = o;
		bev->valid = true;
		bev->y = y;
		(*b)->bevl = bev;
		insertbe(bequeue, bev, index5);
	}
}
bool boundl(point p1, point p2, double* y, point* o) {
	if (p1.y >= p2.y) {
		return false;
	}
	double oy = ((p1.x * p1.x + p1.y * p1.y) - (p2.x * p2.x + p2.y * p2.y)) / (2 * (p1.y - p2.y));
	if (oy < maxy && oy > 0) {
		double y0 = (2 * oy + sqrt(4 * oy * oy - 4 * (2 * oy * p1.y - p1.x * p1.x - p1.y * p1.y))) / 2;
		o->x = 0;
		o->y = oy;
		*y = y0;
		return true;
	}
	return false;
}
bool boundr(point p1, point p2, double* y, point* o) {
	if (p1.y <= p2.y) {
		return false;
	}
	double oy = (2 * maxx * (p2.x - p1.x) + p1.x * p1.x + p1.y * p1.y - p2.x * p2.x - p2.y * p2.y) / (2 * (p1.y - p2.y));
	if (oy < maxy && oy > 0) {
		double y0 = (2 * oy + sqrt(4 * oy * oy - 4 * (2 * oy * p1.y + 2 * p1.x * maxx - maxx * maxx - p1.x * p1.x - p1.y * p1.y))) / 2;
		o->x = maxx;
		o->y = oy;
		*y = y0;
		return true;
	}
	return false;
}
bool boundd(point p1, point p2, double* y, point* o) {
	if (p1.x == p2.x) {
		return false;
	}
	double ox = (2 * maxy * (p2.y - p1.y) + p1.x * p1.x + p1.y * p1.y - p2.x * p2.x - p2.y * p2.y) / (2 * (p1.x - p2.x));
	if (ox <= maxy && ox >= 0) {
		double y0 = (2 * maxy + sqrt(4 * maxy * maxy - 4 * (2 * ox * p1.x + 2 * p1.y * maxy - ox * ox - p1.x * p1.x - p1.y * p1.y))) / 2;
		o->x = ox;
		o->y = maxy;
		*y = y0;
		return true;
	}
	return false;
}
bool boundu(point p1, point p2, double* y, point* o) {
	if (p1.x == p2.x) {
		return false;
	}
	double ox = ((p1.x * p1.x + p1.y * p1.y) - (p2.x * p2.x + p2.y * p2.y)) / (2 * (p1.x - p2.x));
	if (ox <= maxx && ox >= 0) {
		double y0 = sqrt(ox * ox - 2 * ox * p1.x + p1.x * p1.x + p1.y * p1.y);
		o->x = ox;
		o->y = 0;
		*y = y0;
		return true;
	}
	return false;
}
void inserte(e** equeue, e* ev, int* index3) {
	if (*index3 == 0) {
		equeue[0] = ev;
		(*index3)++;
		return;
	}
	if (equeue[0]->y >= ev->y) {
		for (int j = *index3; j > 0; j--) {
			equeue[j] = equeue[j - 1];
		}
		equeue[0] = ev;
		(*index3)++;
		return;
	}
	if (equeue[*index3 - 1]->y <= ev->y) {
		equeue[*index3] = ev;
		(*index3)++;
		return;
	}
	for (int i = 0; i < *index3 - 1; i++) {
		if (equeue[i]->y <= ev->y && equeue[i + 1]->y >= ev->y) {
			for (int j = *index3; j > i + 1; j--) {
				equeue[j] = equeue[j - 1];
			}
			equeue[i + 1] = ev;
			(*index3)++;
			break;
		}
	}
}
void insertbe(be** bequeue, be* bev, int* index5) {
	if (*index5 == 0) {
		bequeue[0] = bev;
		(*index5)++;
		return;
	}
	if (bequeue[0]->y >= bev->y) {
		for (int j = *index5; j > 0; j--) {
			bequeue[j] = bequeue[j - 1];
		}
		bequeue[0] = bev;
		(*index5)++;
		return;
	}
	if (bequeue[*index5 - 1]->y <= bev->y) {
		bequeue[*index5] = bev;
		(*index5)++;
		return;
	}
	for (int i = 0; i < *index5 - 1; i++) {
		if (bequeue[i]->y <= bev->y && bequeue[i + 1]->y >= bev->y) {
			for (int j = *index5; j > i + 1; j--) {
				bequeue[j] = bequeue[j - 1];
			}
			bequeue[i + 1] = bev;
			(*index5)++;
			break;
		}
	}
}
void circle_event(bline* b, double y0, e** equeue, int* index3) {
	if (!*b || !(*b)->lp || !(*b)->rp) {
		return;
	}
	double y;
	point o;
	e* ev;
	if (circle((*b)->lp->p, (*b)->p, (*b)->rp->p, &y, &o) && y >= y0) {
		ev = (e*)malloc(sizeof(*ev));
		ev->valid = true;
		ev->y = y;
		ev->o = o;
		ev->b = *b;
		(*b)->ev = ev;
		inserte(equeue, ev, index3);
	}
}
bool circle(point a, point b, point c, double* y, point* o) {
	if ((b.y - a.y) * (c.x - a.x) - (c.y - a.y) * (b.x - a.x) > 0) {
		return false;
	}
	double A = 2 * (b.x - a.x), B = 2 * (b.y - a.y),
		A2 = 2 * (c.x - b.x), B2 = 2 * (c.y - b.y),
		C = b.x * b.x + b.y * b.y - a.x * a.x - a.y * a.y,
		C2 = c.x * c.x + c.y * c.y - b.x * b.x - b.y * b.y,
		D = (A * B2 - A2 * B);
	if (D == 0) {
		return false;
	}
	o->x = (B2 * C - B * C2) / D;
	o->y = (A * C2 - A2 * C) / D;
	*y = o->y + sqrt(pow(a.y - o->y, 2) + pow(a.x - o->x, 2));
	return true;
}
void insertion(point p, bline* b) {
	if ((*b)->bev) {
		(*b)->bev->valid = false;
		(*b)->bev = NULL;
	}
	if ((*b)->bevd) {
		(*b)->bevd->valid = false;
		(*b)->bevd = NULL;
	}
	if ((*b)->bevr) {
		(*b)->bevr->valid = false;
		(*b)->bevr = NULL;
	}
	if ((*b)->bevl) {
		(*b)->bevl->valid = false;
		(*b)->bevl = NULL;
	}
	if ((*b)->ev) {
		(*b)->ev->valid = false;
		(*b)->ev = NULL;
	}
	if ((*b)->rp && (*b)->rp->ev) {
		(*b)->rp->ev->valid = false;
		(*b)->rp->ev = NULL;
	}
	bline i, j = *b;
	i = (bline)malloc(sizeof(*i));
	i->p = p;
	i->lp = i->rp = NULL;
	i->ev = NULL;
	i->bev = NULL;
	i->bevd = NULL;
	i->bevr = NULL;
	i->bevl = NULL;
	i->lp = j;

	if ((*b)->rp) {
		i->rp = j->rp;
		j->rp->lp = i;
	}
	j->rp = i;
}
void insert(point p, bline* b, e** ev, int* index3, be** bev, int* index5) {
	if (!*b) {
		bline a = NULL;
		a = (bline)malloc(sizeof(*a));
		a->p = p;
		a->lp = a->rp = NULL;
		a->ev = NULL;
		a->bev = NULL;
		a->bevd = NULL;
		a->bevr = NULL;
		a->bevl = NULL;
		*b = a;
		return;
	}
	bool iftwo = false;
	int j = 0;
	for (bline i = *b; i; i = i->rp, j++) {
		if (ifintersect(p, i)) {
			if (j == 0) {
				if (intersection(p, i->p, p.y).y > 0) {
					bline a;
					a = (bline)malloc(sizeof(*a));
					a->p = i->p;
					a->lp = a->rp = NULL;
					a->ev = NULL;
					a->bev = NULL;
					a->bevd = NULL;
					a->bevr = NULL;
					a->bevl = NULL;
					a->rp = i;
					i->lp = a;
					insertion(p, &i->lp);
					boundu_event(&i->lp, bev, index5, p.y);
					boundu_event(&i->lp->lp, bev, index5, p.y);
					boundr_event(&i->lp, bev, index5, p.y);
					boundr_event(&i->lp->lp, bev, index5, p.y);
					boundl_event(&i->lp, bev, index5, p.y);
					boundl_event(&i->lp->lp, bev, index5, p.y);
					boundd_event(&i->lp, bev, index5, p.y);
					boundd_event(&i->lp->lp, bev, index5, p.y);
					circle_event(&i, p.y, ev, index3);
					circle_event(&i->lp, p.y, ev, index3);
					*b = i->lp->lp;
				}
				else if (intersection(p, i->p, p.y).x > i->p.x) {
					insertion(p, &i);
					boundu_event(&i, bev, index5, p.y);
					boundu_event(&i->rp, bev, index5, p.y);
					boundd_event(&i, bev, index5, p.y);
					boundd_event(&i->rp, bev, index5, p.y);
					boundr_event(&i, bev, index5, p.y);
					boundr_event(&i->rp, bev, index5, p.y);
					boundl_event(&i, bev, index5, p.y);
					boundl_event(&i->rp, bev, index5, p.y);
					circle_event(&i->rp, p.y, ev, index3);
					circle_event(&i->rp->rp, p.y, ev, index3);
				}
				else {
					bline a;
					a = (bline)malloc(sizeof(*a));
					a->p = p;
					a->lp = a->rp = NULL;
					a->ev = NULL;
					a->bev = NULL;
					a->bevd = NULL;
					a->bevr = NULL;
					a->bevl = NULL;
					a->rp = i;
					i->lp = a;
					boundu_event(&i->lp, bev, index5, p.y);
					boundd_event(&i->lp, bev, index5, p.y);
					boundr_event(&i->lp, bev, index5, p.y);
					boundl_event(&i->lp, bev, index5, p.y);
					circle_event(&i, p.y, ev, index3);
					*b = i->lp;
				}
				return;
			}
			if (!i->rp) {
				if (intersection(i->p, p, p.y).y > 0) {
					insertion(i->p, &i);
					insertion(p, &i);
					boundu_event(&i, bev, index5, p.y);
					boundu_event(&i->rp, bev, index5, p.y);
					boundd_event(&i, bev, index5, p.y);
					boundd_event(&i->rp, bev, index5, p.y);
					boundr_event(&i, bev, index5, p.y);
					boundr_event(&i->rp, bev, index5, p.y);
					boundl_event(&i, bev, index5, p.y);
					boundl_event(&i->rp, bev, index5, p.y);
					circle_event(&i, p.y, ev, index3);
					circle_event(&i->rp, p.y, ev, index3);
				}
				else if (intersection(p, i->p, p.y).x > i->p.x) {
					insertion(p, &i);
					boundu_event(&i, bev, index5, p.y);
					boundd_event(&i, bev, index5, p.y);
					boundr_event(&i, bev, index5, p.y);
					boundl_event(&i, bev, index5, p.y);
					circle_event(&i, p.y, ev, index3);
				}
				else {
					insertion(p, &i->lp);
					boundu_event(&i->lp, bev, index5, p.y);
					boundu_event(&i->lp->lp, bev, index5, p.y);
					boundr_event(&i->lp, bev, index5, p.y);
					boundr_event(&i->lp->lp, bev, index5, p.y);
					boundd_event(&i->lp, bev, index5, p.y);
					boundd_event(&i->lp->lp, bev, index5, p.y);
					boundl_event(&i->lp, bev, index5, p.y);
					boundl_event(&i->lp->lp, bev, index5, p.y);
					circle_event(&i->lp, p.y, ev, index3);
					circle_event(&i->lp->lp, p.y, ev, index3);
				}
				return;
			}
			if (i->rp && intersection(p, i->rp->p, p.y).y < intersection(p, i->p, p.y).y) {
				insertion(i->p, &i);
				iftwo = true;
			}
			insertion(p, &i);
			boundu_event(&i, bev, index5, p.y);
			boundu_event(&i->rp, bev, index5, p.y);
			boundd_event(&i, bev, index5, p.y);
			boundd_event(&i->rp, bev, index5, p.y);
			boundr_event(&i, bev, index5, p.y);
			boundr_event(&i->rp, bev, index5, p.y);
			boundl_event(&i, bev, index5, p.y);
			boundl_event(&i->rp, bev, index5, p.y);
			circle_event(&i->rp, p.y, ev, index3);
			circle_event(&i, p.y, ev, index3);
			circle_event(&i->rp->rp, p.y, ev, index3);
			if (iftwo) {
				boundu_event(&i->rp->rp, bev, index5, p.y);
				boundd_event(&i->rp->rp, bev, index5, p.y);
				boundl_event(&i->rp->rp, bev, index5, p.y);
				boundr_event(&i->rp->rp, bev, index5, p.y);
				circle_event(&i->rp->rp->rp, p.y, ev, index3);
			}
			return;
		}
	}
	insertion(p, b);
	boundu_event(b, bev, index5, p.y);
	boundr_event(b, bev, index5, p.y);
	boundl_event(b, bev, index5, p.y);
	boundd_event(b, bev, index5, p.y);
}
bool ifintersect(point p1, bline p2) {
	if (p2->p.y == p1.y) {
		return false;
	}
	double a, b;
	if (p2->lp) {
		a = intersection(p2->lp->p, p2->p, p1.y).x;
	}
	if (p2->rp) {
		b = intersection(p2->p, p2->rp->p, p1.y).x;
	}
	if ((!p2->lp || a <= p1.x) && (!p2->rp || p1.x <= b)) {
		return true;
	}
	return false;
}
point intersection(point p1, point p2, double d) {//找斷點
	point p;
	if (p1.y == p2.y) {
		p.x = (p1.x + p2.x) / 2;
	}
	else if (p2.y == d) {
		p.x = p2.x;
	}
	else if (p1.y == d) {
		p.x = p1.x;
		p1 = p2;
	}
	else {
		double z0 = 2 * (p1.y - d);
		double z1 = 2 * (p2.y - d);
		double a = 1 / z0 - 1 / z1;
		double b = -2 * (p1.x / z0 - p2.x / z1);
		double c = (p1.x * p1.x + p1.y * p1.y - d * d) / z0 - (p2.x * p2.x + p2.y * p2.y - d * d) / z1;
		double x1 = (-b - sqrt(b * b - 4 * a * c)) / (2 * a);
		double x2 = (-b + sqrt(b * b - 4 * a * c)) / (2 * a);
		if (p1.x == p2.x) {
			if (p1.y < p2.y) {
				if (x1 < x2) {
					p.x = x1;
				}
				else {
					p.x = x2;
				}

			}
			else {
				if (x1 < x2) {
					p.x = x2;
				}
				else {
					p.x = x1;
				}
			}
		}
		else if (p1.x > p2.x) {
			if (p1.y < p2.y) {
				if (x1 < x2) {
					p.x = x1;
				}
				else {
					p.x = x2;
				}
			}
			else {
				if (x1 < x2) {
					p.x = x2;
				}
				else {
					p.x = x1;
				}
			}
		}
		else {
			if (p1.y < p2.y) {
				if (x1 < x2) {
					p.x = x1;
				}
				else {
					p.x = x2;
				}
			}
			else {
				if (x1 < x2) {
					p.x = x2;
				}
				else {
					p.x = x1;
				}
			}
		}
	}
	p.y = (p1.y * p1.y + (p1.x - p.x) * (p1.x - p.x) - d * d) / (2 * p1.y - 2 * d);
	return p;
}