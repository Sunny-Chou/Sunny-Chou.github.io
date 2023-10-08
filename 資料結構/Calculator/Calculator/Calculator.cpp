#define _CRT_SECURE_NO_WARNINGS
#include<stdio.h>
#include<stdlib.h>
#include<string.h>
#include<math.h>
int top = -1;
char expr[100], pexpr[100];
double ps[100];

int isp[] = { 0,19,12,12,13,13,13,14,0 };//in-stack precedence
int icp[] = { 20,19,12,12,13,13,13,14,0 };//incoming precedence
typedef enum { lparen, rparen, plus, minus, times, divide, mod, power, eos, dot, operand } precedence;
precedence stack[100];//convert infix to postfix

void stackFull() {
    printf("The calculation is too long.\nPlease be less than 100 characters."); //Ensure that users are foolproof when input a string too long
    exit(EXIT_FAILURE);
}
void push(precedence item) {
    if (top >= 99) {
        stackFull();
    }
    stack[++top] = item;
}//put item in the stack
precedence pop() {
    if (top == -1) {
        printf("The calculation is wrong.(Insufficient operator)"); //Ensure that users are foolproof when inputting insufficient operator
        exit(EXIT_FAILURE);
    }
    return stack[top--];
}//get the operator and delete the item from stack
void ipush(double item) {
    if (top >= 99) {
        stackFull();
    }
    ps[++top] = item;
}//put operator in the stack
double ipop() {
    if (top == -1) {
        printf("The calculation is wrong.(Insufficient operands)");//Ensure that users are foolproof when inputting insufficient operands
        exit(EXIT_FAILURE);
    }
    return ps[top--];
}//get the operand and delete the operand from stack
char convertToken(precedence item) {//convert the operator from type precedence to char

    switch (item) {

    case 0: return'('; break;

    case 1: return')'; break;

    case 2: return'+'; break;

    case 3: return'-'; break;

    case 4: return'*'; break;

    case 5: return'/'; break;

    case 6: return'%'; break;

    case 7: return'^'; break;

    case 8: return' '; break;

    case 9: return'.'; break;

    }
}
precedence getToken(char* symbol, int* n, int w) {//to get the next char from string and convert it to precedence type
    if (w == 0 && ++(*n) < strlen(expr)) {
        *symbol = expr[(*n)];
    }
    else if (w == 1 && ++(*n) < strlen(pexpr)) {
        *symbol = pexpr[(*n)];
    }

    switch (*symbol) {
    case '(':return lparen;
    case ')':return rparen;
    case '+':return plus;
    case '-':return minus;
    case '/':return divide;
    case '*':return times;
    case '%':return mod;
    case '^':return power;
    case ' ':return eos;
    case '.':return dot;
    case '0':
    case '1':
    case '2':
    case '3':
    case '4':
    case '5':
    case '6':
    case '7':
    case '8':
    case '9':return operand; break;
    default:printf("%c isn't an operator or operand.", *symbol); //is foolproof when user input a wrong character
        exit(EXIT_FAILURE);
    }
}
double convertDouble(char* symbol, int* n) {
    double out = 0;
    int i = 0;
    do {
        out = 10 * out + (double)*symbol - (double)'0';
    } while (getToken(symbol, n, 1) == operand);
    (*n)--;
    if (getToken(symbol, n, 1) == dot) {
        while (getToken(symbol, n, 1) == operand) {
            out = (out * pow(10, ++i) + (double)*symbol - (double)'0') / pow(10, i);
        }
        
    }
    (*n)--;
    if (getToken(symbol, n, 1) == dot) {
        printf("Incorrect decimal point position."); //Ensure that users are foolproof when inputting a decimal point on the incorrect position
        exit(EXIT_FAILURE);
    }
    return out;
}
double eval() {
    precedence token;
    char symbol;
    double op1, op2;
    int n = -1;
    top = -1;
    token = getToken(&symbol, &n, 1);
    while (n<strlen(pexpr)) {
        if (token == operand) {
            ipush(convertDouble(&symbol,&n));
        }
        else {
            
            switch (token) {
            case plus:op2 = ipop();op1 = ipop(); ipush(op1 + op2); break;
            case minus:op2 = ipop(); op1 = ipop(); ipush(op1 - op2); break;
            case times:op2 = ipop(); op1 = ipop(); ipush(op1 * op2); break;
            case divide:op2 = ipop(); op1 = ipop(); ipush(op1 / op2); break;
            case mod:op2 = ipop(); op1 = ipop(); ipush(op1 - (double)((int)op1 / (int)op2) * op2); break;
            case power:op2 = ipop(); op1 = ipop(); ipush(pow(op1, op2)); break;
            case dot:printf("Incorrect decimal point position.");exit(EXIT_FAILURE);//Ensure that users are foolproof when inputting a decimal point on the incorrect position
            default:printf("Unpaired parentheses"); exit(EXIT_FAILURE);//Ensure that users are foolproof when inputting just a left parenthese
            }
        }
        token = getToken(&symbol, &n, 1);

    }
    return ipop();
}
void postfix() {
    char symbol;
    precedence token;
    int n = -1;
    int a = 0;
    top = 0;
    stack[0] = eos;
    bool num = false;
    for (token = getToken(&symbol, &n, 0); n < strlen(expr) ; token = getToken(&symbol, &n, 0)) {

        if (token == operand || token == dot) {
            pexpr[a++] = symbol;
            num = true;
        }
        else if (token == eos) {

        }
        else if (token == rparen) {
            if (num) {
                pexpr[a++] = convertToken(eos);
                num = false;
            }
            while (top >= 0 && stack[top] != lparen) {

                pexpr[a++] = convertToken(pop());

            }
            if (top == -1) {
                printf("Unpaired parentheses"); exit(EXIT_FAILURE);//Ensure that users are foolproof when inputting just a right parenthese
            }
            pop();
        }
        else {
            if (num) {
                pexpr[a++] = convertToken(eos);
                num = false;
            }
            
            while (isp[stack[top]] >= icp[token]) {

                pexpr[a++] = convertToken(pop());

            }
            push(token);
        }
    }
    if (num) {
            pexpr[a++] = convertToken(eos);
            num = false;
        }
    while ((token = pop()) != eos) {
        
        pexpr[a++] = convertToken(token);
    }

}
int main(void) {
    printf("Please enter an expression that meets the following requirements\n1. the operand must be a positive number\n2. the operator can only be + - * / %% ^\n(ps: blank keys will be ignored)\n>>");
    scanf(" %[^\n]*%c", expr);//to input a string(can contain blank key to be Foolproof)
    postfix();
    printf("Answer : %f", eval());
    return 0;
    system("pause");
}