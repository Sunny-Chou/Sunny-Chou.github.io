#define _CRT_SECURE_NO_WARNINGS
#include<stdio.h>
#include<stdlib.h>
#include<math.h>
#include<string.h>
typedef struct {
	int key;
	int leftsize;
}element;
typedef struct node* treePointer;
typedef struct node{
	element data;
	treePointer leftChild, rightChild;
};

void inorder(treePointer ptr) {
	if (ptr) {
		inorder(ptr->leftChild);//先印左子樹
		printf("%d ", ptr->data.key);//印每個子樹的樹根
		inorder(ptr->rightChild);//後印右子樹
	}
}
treePointer search(treePointer tree, int key) {
	if (tree && tree->data.key == key) {
		return tree;//如果是樹根，則直接回傳樹根
	}
	while (tree) {
		
		if (key < tree->data.key) {//如果要查詢的值比現在的節點的值小
			if (tree->leftChild) {
				if (key == tree->leftChild->data.key) {//如果現在節點的左子樹就是要查詢的值，則回傳此節點(查詢的值的父親)
					return tree;
				}

			}
			
			tree = tree->leftChild;//如果現在節點的左子樹不是要查詢的值，則往左子樹找
		}
		else {//如果要查詢的值比現在的節點的值大
			if (tree->rightChild) {
				if (key == tree->rightChild->data.key) {//如果現在節點的右子樹就是要查詢的值，則回傳此節點(查詢的值的父親)
					return tree;
				}

			}
			
			tree = tree->rightChild;//如果現在節點的左子樹不是要查詢的值，則往右子樹找
		}
	}
	return NULL;//找不到就回傳null
}
treePointer modifiedSearch(treePointer tree, int key) {
	if (!tree) {//如果二元搜尋樹是空的，回傳NULL
		return NULL;
	}
	while (tree) {
		if (key == tree->data.key) return NULL;//如果數值已經存在，回傳NULL
		if (key < tree->data.key) {
			if (tree->leftChild) {//如果數值比此節點的數值小，往左找
				
				tree = tree->leftChild;
			}
			else {//如果數值比此節點的數值小，但已經沒有更小的值了(沒有左子樹)，代表此節點為數值插入後的父親
				break;
			}
			
		}
		else {
			if (tree->rightChild) {//如果數值比此節點的數值大，往右找
				tree = tree->rightChild;
			}
			else {//如果數值比此節點的數值大，但已經沒有更大的值了(沒有右子樹)，代表此節點為數值插入後的父親
				break;
			}
		}
		
	}return tree;//回傳插入節點的父親
}
int setleftsize(treePointer tree) {

	if (!tree) {
		return 0;
	}
	return setleftsize(tree->leftChild) + setleftsize(tree->rightChild) + 1;//如果節點的左/右子樹非空，則leftsize+=1

}
void resetleftsize(treePointer tree) {
	if (tree) {
		tree->data.leftsize = setleftsize(tree->leftChild) + 1;
		resetleftsize(tree->leftChild);
		resetleftsize(tree->rightChild);
	}
}
void insert(treePointer* node, int key) {
	treePointer ptr, //要插入的節點
		temp = modifiedSearch(*node, key);//要插入的節點的父親
	if (temp || !(*node)) {//如果樹不是空的，且要插入的節點有父親
		ptr = (treePointer)malloc(sizeof(*ptr));
		ptr->data.key = key;//初始化新插入的節點
		ptr->data.leftsize = 1;
		ptr->leftChild = ptr->rightChild = NULL;
		if (*node) {
			if (key < temp->data.key) {
				temp->leftChild = ptr;
			}
			else {
				temp->rightChild = ptr;
			}
		}
		else {//如果二元搜尋樹是空的，則樹裡只有ptr，因此直接用ptr替代整棵樹
			*node = ptr;
		}
		
	}
}
void insertFile(treePointer *tree) {
	char s[100];
	FILE* f;
	int key;
	printf("Please input the name of file.>>");
	scanf(" %s", s);//輸入檔案名稱
	char* c;
	c = strstr(s, ".txt");//判斷檔案名稱是否有包含.txt的延伸檔名
	while (!c) {//如果延伸檔名不對，就再要求使用者輸入一次
		printf("The file extension must be \".txt\".\nPlease input again.>>");
		scanf(" %s", s);
		c = strstr(s, ".txt");
	}
	if ((f = fopen(s, "r")) == NULL) {
		printf("The file do not exist.\n");//檔案不存在，指令失敗
	}
	else {
		while (fscanf(f, "%d", &key)==1) {//從檔案讀取數值，直到沒有讀取到東西
			insert(tree, key);//每讀取一個數值，就插入進二元搜尋樹一次

		}
		printf("FINISHED!\n");//完成
		fclose(f);
	}
	

}
void insertKey(treePointer* tree) {
	int key;
	char c;
	printf("Please input the key values of nodes.>>");
	do {
		scanf(" %d%c", &key,&c);//讀取一個數值和一個空格或是enter鍵
		insert(tree, key);//插入數值
	} while (c != '\n');//如果c是enter的值'\n'，代表讀取結束，跳出迴圈
	printf("FINISHED!\n");
}
void findSmall(treePointer tree) {
	int leftsize = tree->data.leftsize;//先存取樹根的leftsize
	int small;
	printf("Which number>>");
	scanf(" %d", &small);//輸入想查詢的第small小數值
	while (true) {
		if (leftsize == small) {
			printf("%drd smallest number is %d.\n", small, tree->data.key);//找到了，並輸出
			break;
		}
		else if (leftsize < small) {
			tree = tree->rightChild;//目前的節點比較小，往右子樹找
			if (tree) {//如果有右子樹
				leftsize += tree->data.leftsize;//加上右子樹的leftsize

			}
			else {//沒有右子樹，代表不存在第small小的值(應該是small大於二元樹的節點數)
				printf("NOT FOUND\n");
				break;
			}
			
		}
		else {
			
			if (tree->leftChild) {//目前節點比較大，往左子樹找
				leftsize -= tree->data.leftsize;
				tree = tree->leftChild;
				leftsize += tree->data.leftsize;

			}
			else {//如果沒有左子樹，代表不存在第small小的樹(應該是small<=0了)
				printf("NOT FOUND\n");
				break;
			}
			
			
		}
	}
}

void deletenode(treePointer* tree) {
	int key;
	scanf(" %d", &key);
	treePointer nodeparent = search(*tree, key);//要刪掉的節點的父親或是要刪掉的節點本身(當此節點是樹根時)
	treePointer node;
	bool noparent = false;
	
	if (!nodeparent) {//要刪掉的有父親的節點的父親不存在 OR 要刪掉的沒有父親的節點不存在 <=> 要刪掉的節點不存在
		printf("The key value does not exist.\n");
	}
	else {
		if (nodeparent->leftChild && nodeparent->leftChild->data.key == key) {//要刪掉的節點是它的父親的左小孩
			node = nodeparent->leftChild;
		}
		else if (nodeparent->rightChild && nodeparent->rightChild->data.key == key) {//要刪掉的節點是它的父親的右小孩
			node = nodeparent->rightChild;
		}
		else {//要刪掉的節點沒有父親(是樹根)
			node = nodeparent;
			noparent = true;
		}
		treePointer newnode = node->rightChild;
		if (newnode) {//找到替代被刪除節點位置的最小右子樹的父親(in-order successor)
			treePointer newnodeparent = NULL;
			while (newnode->leftChild) {
				newnodeparent = newnode;
				newnode = newnode->leftChild;//一路向左，能找到最小值的父親
			}
			if (newnodeparent) {//如果找到的替代節點的父親不是被刪除的節點
				newnodeparent->leftChild = newnode->rightChild;
				newnode->rightChild = node->rightChild;

			}

			newnode->leftChild = node->leftChild;

			*node = *newnode;
			free(newnode);
		}
		else {
			if (noparent) {
				if (!node->leftChild) {
					*tree = nullptr;
				}
				free(node);//沒有父親也沒有右子樹

			}
			else {
				if (node->leftChild) {
					treePointer freenode = node->leftChild;
					*node = *(node->leftChild);//有父親但沒有右子樹
					free(freenode);
				}
				else {
					//有父親但是無子樹
					if (nodeparent->leftChild == node) {
						nodeparent->leftChild = NULL;//把父親的左小孩指向NULL
					}
					else {
						nodeparent->rightChild = NULL; //把父親的右小孩指向NULL
					}
					free(node);

				}

			}

		}

		printf("OK!\n");
	}
	
	
}

int main(void) {
	treePointer tree=NULL;
	char c;
	int key;
	do {
		printf("---MENU---\n(A)Insert From File : \nInsert key values imported from file in binary tree.(ps. The file extension must be \".txt\".)\n");
		printf("(B)Insert From Keyboard\nInsert key values imported from keyboard.(ps. Key values are separated by \' \'.)\n");
		printf("(C)Search\nSearch whether a specific key value exists in this binary tree.\n");
		printf("(D)Search Smallest\nSearch the nrd smallest key value in the binary tree.\n");
		printf("(E)Delete\nDelete a specific key value in the binary tree.(ps. If the key value does not exist, return it does not exist.)\n");
		printf("(F)Inorder Traversal\nOutput the key values in this binary tree in inorder traversal order.\n");
		printf("(G)EXIT\nEnd this program.\n");
		printf("Input Your Command>>");
		scanf(" %c", &c);
		switch (c) {
		case 'A':printf("---Insert From File---\n"); insertFile(&tree); resetleftsize(tree); break;
		case 'B':printf("---Insert From Keyboard---\n"); insertKey(&tree); resetleftsize(tree); break;
		case 'C':
			printf("---Search---\nKey value>>");
			scanf(" %d", &key); 
			if (search(tree, key)) { 
				printf("EXIST!!\n"); 
			}
			else {
				printf("DO NOT EXIST!!.\n");
			}
			break;
		case 'D':printf("---Search Smallest---\n"); findSmall(tree); break;
		case 'E':printf("---Delete---\n"); deletenode(&tree);
			resetleftsize(tree);
			break;
		case 'F':printf("---Inorder Traversal---\n"); inorder(tree); printf("\n"); 
			break;
		case 'G':printf("---EXIT---\n"); free(tree); return 0; system("pause");
		default:printf("%c is an invalid command!Please input again.\n",c); break;
			
		}
	} while (c != 'G');
	
}