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
		inorder(ptr->leftChild);//���L���l��
		printf("%d ", ptr->data.key);//�L�C�Ӥl�𪺾��
		inorder(ptr->rightChild);//��L�k�l��
	}
}
treePointer search(treePointer tree, int key) {
	if (tree && tree->data.key == key) {
		return tree;//�p�G�O��ڡA�h�����^�Ǿ��
	}
	while (tree) {
		
		if (key < tree->data.key) {//�p�G�n�d�ߪ��Ȥ�{�b���`�I���Ȥp
			if (tree->leftChild) {
				if (key == tree->leftChild->data.key) {//�p�G�{�b�`�I�����l��N�O�n�d�ߪ��ȡA�h�^�Ǧ��`�I(�d�ߪ��Ȫ�����)
					return tree;
				}

			}
			
			tree = tree->leftChild;//�p�G�{�b�`�I�����l�𤣬O�n�d�ߪ��ȡA�h�����l���
		}
		else {//�p�G�n�d�ߪ��Ȥ�{�b���`�I���Ȥj
			if (tree->rightChild) {
				if (key == tree->rightChild->data.key) {//�p�G�{�b�`�I���k�l��N�O�n�d�ߪ��ȡA�h�^�Ǧ��`�I(�d�ߪ��Ȫ�����)
					return tree;
				}

			}
			
			tree = tree->rightChild;//�p�G�{�b�`�I�����l�𤣬O�n�d�ߪ��ȡA�h���k�l���
		}
	}
	return NULL;//�䤣��N�^��null
}
treePointer modifiedSearch(treePointer tree, int key) {
	if (!tree) {//�p�G�G���j�M��O�Ū��A�^��NULL
		return NULL;
	}
	while (tree) {
		if (key == tree->data.key) return NULL;//�p�G�ƭȤw�g�s�b�A�^��NULL
		if (key < tree->data.key) {
			if (tree->leftChild) {//�p�G�ƭȤ񦹸`�I���ƭȤp�A������
				
				tree = tree->leftChild;
			}
			else {//�p�G�ƭȤ񦹸`�I���ƭȤp�A���w�g�S����p���ȤF(�S�����l��)�A�N���`�I���ƭȴ��J�᪺����
				break;
			}
			
		}
		else {
			if (tree->rightChild) {//�p�G�ƭȤ񦹸`�I���ƭȤj�A���k��
				tree = tree->rightChild;
			}
			else {//�p�G�ƭȤ񦹸`�I���ƭȤj�A���w�g�S����j���ȤF(�S���k�l��)�A�N���`�I���ƭȴ��J�᪺����
				break;
			}
		}
		
	}return tree;//�^�Ǵ��J�`�I������
}
int setleftsize(treePointer tree) {

	if (!tree) {
		return 0;
	}
	return setleftsize(tree->leftChild) + setleftsize(tree->rightChild) + 1;//�p�G�`�I����/�k�l��D�šA�hleftsize+=1

}
void resetleftsize(treePointer tree) {
	if (tree) {
		tree->data.leftsize = setleftsize(tree->leftChild) + 1;
		resetleftsize(tree->leftChild);
		resetleftsize(tree->rightChild);
	}
}
void insert(treePointer* node, int key) {
	treePointer ptr, //�n���J���`�I
		temp = modifiedSearch(*node, key);//�n���J���`�I������
	if (temp || !(*node)) {//�p�G�𤣬O�Ū��A�B�n���J���`�I������
		ptr = (treePointer)malloc(sizeof(*ptr));
		ptr->data.key = key;//��l�Ʒs���J���`�I
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
		else {//�p�G�G���j�M��O�Ū��A�h��̥u��ptr�A�]��������ptr���N��ʾ�
			*node = ptr;
		}
		
	}
}
void insertFile(treePointer *tree) {
	char s[100];
	FILE* f;
	int key;
	printf("Please input the name of file.>>");
	scanf(" %s", s);//��J�ɮצW��
	char* c;
	c = strstr(s, ".txt");//�P�_�ɮצW�٬O�_���]�t.txt�������ɦW
	while (!c) {//�p�G�����ɦW����A�N�A�n�D�ϥΪ̿�J�@��
		printf("The file extension must be \".txt\".\nPlease input again.>>");
		scanf(" %s", s);
		c = strstr(s, ".txt");
	}
	if ((f = fopen(s, "r")) == NULL) {
		printf("The file do not exist.\n");//�ɮפ��s�b�A���O����
	}
	else {
		while (fscanf(f, "%d", &key)==1) {//�q�ɮ�Ū���ƭȡA����S��Ū����F��
			insert(tree, key);//�CŪ���@�ӼƭȡA�N���J�i�G���j�M��@��

		}
		printf("FINISHED!\n");//����
		fclose(f);
	}
	

}
void insertKey(treePointer* tree) {
	int key;
	char c;
	printf("Please input the key values of nodes.>>");
	do {
		scanf(" %d%c", &key,&c);//Ū���@�ӼƭȩM�@�ӪŮ�άOenter��
		insert(tree, key);//���J�ƭ�
	} while (c != '\n');//�p�Gc�Oenter����'\n'�A�N��Ū�������A���X�j��
	printf("FINISHED!\n");
}
void findSmall(treePointer tree) {
	int leftsize = tree->data.leftsize;//���s����ڪ�leftsize
	int small;
	printf("Which number>>");
	scanf(" %d", &small);//��J�Q�d�ߪ���small�p�ƭ�
	while (true) {
		if (leftsize == small) {
			printf("%drd smallest number is %d.\n", small, tree->data.key);//���F�A�ÿ�X
			break;
		}
		else if (leftsize < small) {
			tree = tree->rightChild;//�ثe���`�I����p�A���k�l���
			if (tree) {//�p�G���k�l��
				leftsize += tree->data.leftsize;//�[�W�k�l��leftsize

			}
			else {//�S���k�l��A�N���s�b��small�p����(���ӬOsmall�j��G���𪺸`�I��)
				printf("NOT FOUND\n");
				break;
			}
			
		}
		else {
			
			if (tree->leftChild) {//�ثe�`�I����j�A�����l���
				leftsize -= tree->data.leftsize;
				tree = tree->leftChild;
				leftsize += tree->data.leftsize;

			}
			else {//�p�G�S�����l��A�N���s�b��small�p����(���ӬOsmall<=0�F)
				printf("NOT FOUND\n");
				break;
			}
			
			
		}
	}
}

void deletenode(treePointer* tree) {
	int key;
	scanf(" %d", &key);
	treePointer nodeparent = search(*tree, key);//�n�R�����`�I�����˩άO�n�R�����`�I����(���`�I�O��ڮ�)
	treePointer node;
	bool noparent = false;
	
	if (!nodeparent) {//�n�R���������˪��`�I�����ˤ��s�b OR �n�R�����S�����˪��`�I���s�b <=> �n�R�����`�I���s�b
		printf("The key value does not exist.\n");
	}
	else {
		if (nodeparent->leftChild && nodeparent->leftChild->data.key == key) {//�n�R�����`�I�O�������˪����p��
			node = nodeparent->leftChild;
		}
		else if (nodeparent->rightChild && nodeparent->rightChild->data.key == key) {//�n�R�����`�I�O�������˪��k�p��
			node = nodeparent->rightChild;
		}
		else {//�n�R�����`�I�S������(�O���)
			node = nodeparent;
			noparent = true;
		}
		treePointer newnode = node->rightChild;
		if (newnode) {//�����N�Q�R���`�I��m���̤p�k�l�𪺤���(in-order successor)
			treePointer newnodeparent = NULL;
			while (newnode->leftChild) {
				newnodeparent = newnode;
				newnode = newnode->leftChild;//�@���V���A����̤p�Ȫ�����
			}
			if (newnodeparent) {//�p�G��쪺���N�`�I�����ˤ��O�Q�R�����`�I
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
				free(node);//�S�����ˤ]�S���k�l��

			}
			else {
				if (node->leftChild) {
					treePointer freenode = node->leftChild;
					*node = *(node->leftChild);//�����˦��S���k�l��
					free(freenode);
				}
				else {
					//�����˦��O�L�l��
					if (nodeparent->leftChild == node) {
						nodeparent->leftChild = NULL;//����˪����p�ī��VNULL
					}
					else {
						nodeparent->rightChild = NULL; //����˪��k�p�ī��VNULL
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