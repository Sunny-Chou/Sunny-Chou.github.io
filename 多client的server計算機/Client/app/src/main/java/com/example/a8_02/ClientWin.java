package com.example.a8_02;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.text.Html;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

public class ClientWin extends AppCompatActivity {
    private int port=2345;
    private String host;
    private RunClient client;
    private TextView expression;
    private TextView number;
    private Button discennect;
    private Button percent;
    private Button CE;
    private Button C;
    private Button X;
    private Button reciprocal;
    private Button sqr;
    private Button sqrt;
    private Button div;
    private Button n7;
    private Button n8;
    private Button n9;
    private Button mul;
    private Button n4;
    private Button n5;
    private Button n6;
    private Button min;
    private Button n1;
    private Button n2;
    private Button n3;
    private Button plus;
    private Button pm;
    private Button n0;
    private Button dot;
    private Button eql;
    private String message;
    private boolean ifn=true;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_client_win);
        percent=(Button) findViewById(R.id.percent);
        CE=(Button) findViewById(R.id.CE);
        C=(Button) findViewById(R.id.C);
        X=(Button) findViewById(R.id.X);
        reciprocal=(Button) findViewById(R.id.reciprocal);
        sqr=(Button) findViewById(R.id.sqr);
        sqrt=(Button) findViewById(R.id.sqrt);
        div=(Button) findViewById(R.id.div);
        n7=(Button) findViewById(R.id.n7);
        n8=(Button) findViewById(R.id.n8);
        n9=(Button) findViewById(R.id.n9);
        mul=(Button) findViewById(R.id.mul);
        n4=(Button) findViewById(R.id.n4);
        n5=(Button) findViewById(R.id.n5);
        n6=(Button) findViewById(R.id.n6);
        min=(Button) findViewById(R.id.min);
        n1=(Button) findViewById(R.id.n1);
        n2=(Button) findViewById(R.id.n2);
        n3=(Button) findViewById(R.id.n3);
        plus=(Button) findViewById(R.id.plus);
        pm=(Button) findViewById(R.id.pm);
        n0=(Button) findViewById(R.id.n0);
        dot=(Button) findViewById(R.id.dot);
        eql=(Button) findViewById(R.id.eql);
        discennect=(Button) findViewById(R.id.disconnect);
        reciprocal.setText(Html.fromHtml("<sup>1</sup>/x"));
        sqr.setText(Html.fromHtml("x<sup>2</sup>"));
        sqrt.setText(Html.fromHtml("<sup>2</sup>√x̄"));
        Intent intent=getIntent();
        this.host=intent.getStringExtra("Host");
        this.client=new RunClient(this,host,port);
        this.client.start();
        expression=findViewById(R.id.expression);
        number=findViewById(R.id.number);
        discennect.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                client.write("***CLOSE***");
                client.loop=false;
                client.interrupt();
                finish();
            }
        });
        plus.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                if(expression.getText().toString().length()!=0&&!ifn&&(expression.getText().toString().indexOf("+")==expression.getText().toString().length()-1||expression.getText().toString().indexOf("-")==expression.getText().toString().length()-1||expression.getText().toString().indexOf("×")==expression.getText().toString().length()-1||expression.getText().toString().indexOf("÷")==expression.getText().toString().length()-1)){
                    message="+";
                }else {
                    message = number.getText().toString() + "+";
                    ifn=false;
                }
                expression.setText("+");
                setbuttons(false);
                client.write(message);
            }
        });
        min.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                if(expression.getText().toString().length()!=0&&!ifn&&(expression.getText().toString().indexOf("+")==expression.getText().toString().length()-1||expression.getText().toString().indexOf("-")==expression.getText().toString().length()-1||expression.getText().toString().indexOf("×")==expression.getText().toString().length()-1||expression.getText().toString().indexOf("÷")==expression.getText().toString().length()-1)){
                    message="-";
                }else {
                    message = number.getText().toString() + "-";
                    ifn=false;
                }
                expression.setText("-");
                setbuttons(false);
                client.write(message);
            }
        });
        mul.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                if(expression.getText().toString().length()!=0&&!ifn&&(expression.getText().toString().indexOf("+")==expression.getText().toString().length()-1||expression.getText().toString().indexOf("-")==expression.getText().toString().length()-1||expression.getText().toString().indexOf("×")==expression.getText().toString().length()-1||expression.getText().toString().indexOf("÷")==expression.getText().toString().length()-1)){
                    message="×";
                }else {
                    message = number.getText().toString() + "×";
                    ifn=false;
                }
                expression.setText("×");
                setbuttons(false);
                client.write(message);
            }
        });
        div.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                if(expression.getText().toString().length()!=0&&!ifn&&(expression.getText().toString().indexOf("+")==expression.getText().toString().length()-1||expression.getText().toString().indexOf("-")==expression.getText().toString().length()-1||expression.getText().toString().indexOf("×")==expression.getText().toString().length()-1||expression.getText().toString().indexOf("÷")==expression.getText().toString().length()-1)){
                    message="÷";
                }else {
                    message = number.getText().toString() + "÷";
                    ifn=false;
                }
                expression.setText("÷");
                setbuttons(false);
                client.write(message);

            }
        });
        n0.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                if(number.getText().toString().equals("無法除以零")||number.getText().toString().equals("無效的輸入")||number.getText().toString().equals("溢位")){
                    setbutton(true);
                    number.setText("0");
                    expression.setText("");
                    ifn = true;
                }else {
                    if (!number.getText().toString().equals("0") && ifn) {
                        if (number.getText().toString().length() < 17)
                            number.setText(number.getText().toString() + "0");
                        else if (number.getText().toString().contains("-") && number.getText().toString().length() == 17) {
                            number.setText(number.getText().toString() + "0");
                        } else if (!number.getText().toString().contains("-") && number.getText().toString().indexOf(".") == 1 && number.getText().toString().substring(0, 1).contains("0") && number.getText().toString().length() == 17) {
                            number.setText(number.getText().toString() + "0");
                        } else if (number.getText().toString().contains("-") && number.getText().toString().indexOf(".") == 2 && number.getText().toString().substring(1, 2).contains("0") && number.getText().toString().length() == 18) {
                            number.setText(number.getText().toString() + "0");
                        }
                    } else {
                        number.setText("0");
                        ifn = true;
                        if (expression.getText().toString().contains("=")) {
                            expression.setText("");
                        }
                        int index = getindex();
                        if (index != 0)
                            expression.setText(expression.getText().toString().substring(0, index + 1));
                    }
                    setfsize();
                }
            }
        });
        n1.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                if(number.getText().toString().equals("無法除以零")||number.getText().toString().equals("無效的輸入")||number.getText().toString().equals("溢位")){
                    setbutton(true);
                    number.setText("1");
                    expression.setText("");
                    ifn = true;
                }else {
                    if (!number.getText().toString().equals("0") && ifn) {
                        if (number.getText().toString().length() < 17)
                            number.setText(number.getText().toString() + "1");
                        else if (number.getText().toString().contains("-") && number.getText().toString().length() == 17) {
                            number.setText(number.getText().toString() + "1");
                        } else if (!number.getText().toString().contains("-") && number.getText().toString().indexOf(".") == 1 && number.getText().toString().substring(0, 1).contains("0") && number.getText().toString().length() == 17) {
                            number.setText(number.getText().toString() + "1");
                        } else if (number.getText().toString().contains("-") && number.getText().toString().indexOf(".") == 2 && number.getText().toString().substring(1, 2).contains("0") && number.getText().toString().length() == 18) {
                            number.setText(number.getText().toString() + "1");
                        }
                    } else {
                        number.setText("1");
                        ifn = true;
                        if (expression.getText().toString().contains("=")) {
                            expression.setText("");
                        }
                        int index = getindex();
                        if (index != 0)
                            expression.setText(expression.getText().toString().substring(0, index + 1));
                    }
                    setfsize();
                }
            }
        });
        n2.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                if(number.getText().toString().equals("無法除以零")||number.getText().toString().equals("無效的輸入")||number.getText().toString().equals("溢位")){
                    setbutton(true);
                    number.setText("2");
                    expression.setText("");
                    ifn = true;
                }else {
                    if (!number.getText().toString().equals("0") && ifn) {
                        if (number.getText().toString().length() < 17)
                            number.setText(number.getText().toString() + "2");
                        else if (number.getText().toString().contains("-") && number.getText().toString().length() == 17) {
                            number.setText(number.getText().toString() + "2");
                        } else if (!number.getText().toString().contains("-") && number.getText().toString().indexOf(".") == 1 && number.getText().toString().substring(0, 1).contains("0") && number.getText().toString().length() == 17) {
                            number.setText(number.getText().toString() + "2");
                        } else if (number.getText().toString().contains("-") && number.getText().toString().indexOf(".") == 2 && number.getText().toString().substring(1, 2).contains("0") && number.getText().toString().length() == 18) {
                            number.setText(number.getText().toString() + "2");
                        }
                    } else {
                        number.setText("2");
                        ifn = true;
                        if (expression.getText().toString().contains("=")) {
                            expression.setText("");
                        }
                        int index = getindex();
                        if (index != 0)
                            expression.setText(expression.getText().toString().substring(0, index + 1));
                    }
                    setfsize();
                }
            }
        });
        n3.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                if(number.getText().toString().equals("無法除以零")||number.getText().toString().equals("無效的輸入")||number.getText().toString().equals("溢位")){
                    setbutton(true);
                    number.setText("3");
                    expression.setText("");
                    ifn = true;
                }else {
                    if (!number.getText().toString().equals("0") && ifn) {
                        if (number.getText().toString().length() < 17)
                            number.setText(number.getText().toString() + "3");
                        else if (number.getText().toString().contains("-") && number.getText().toString().length() == 17) {
                            number.setText(number.getText().toString() + "3");
                        } else if (!number.getText().toString().contains("-") && number.getText().toString().indexOf(".") == 1 && number.getText().toString().substring(0, 1).contains("0") && number.getText().toString().length() == 17) {
                            number.setText(number.getText().toString() + "3");
                        } else if (number.getText().toString().contains("-") && number.getText().toString().indexOf(".") == 2 && number.getText().toString().substring(1, 2).contains("0") && number.getText().toString().length() == 18) {
                            number.setText(number.getText().toString() + "3");
                        }
                    } else {
                        number.setText("3");
                        ifn = true;
                        if (expression.getText().toString().contains("=")) {
                            expression.setText("");
                        }
                        int index = getindex();
                        if (index != 0)
                            expression.setText(expression.getText().toString().substring(0, index + 1));
                    }
                    setfsize();
                }
            }
        });
        n4.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                if(number.getText().toString().equals("無法除以零")||number.getText().toString().equals("無效的輸入")||number.getText().toString().equals("溢位")){
                    setbutton(true);
                    number.setText("4");
                    expression.setText("");
                    ifn = true;
                }else {
                    if (!number.getText().toString().equals("0") && ifn) {
                        if (number.getText().toString().length() < 17)
                            number.setText(number.getText().toString() + "4");
                        else if (number.getText().toString().contains("-") && number.getText().toString().length() == 17) {
                            number.setText(number.getText().toString() + "4");
                        } else if (!number.getText().toString().contains("-") && number.getText().toString().indexOf(".") == 1 && number.getText().toString().substring(0, 1).contains("0") && number.getText().toString().length() == 17) {
                            number.setText(number.getText().toString() + "4");
                        } else if (number.getText().toString().contains("-") && number.getText().toString().indexOf(".") == 2 && number.getText().toString().substring(1, 2).contains("0") && number.getText().toString().length() == 18) {
                            number.setText(number.getText().toString() + "4");
                        }
                    } else {
                        number.setText("4");
                        ifn = true;
                        if (expression.getText().toString().contains("=")) {
                            expression.setText("");
                        }
                        int index = getindex();
                        if (index != 0)
                            expression.setText(expression.getText().toString().substring(0, index + 1));
                    }
                    setfsize();
                }
            }
        });
        n5.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view) {
                if (number.getText().toString().equals("無法除以零")||number.getText().toString().equals("無效的輸入")||number.getText().toString().equals("溢位")) {
                    setbutton(true);
                    number.setText("5");
                    expression.setText("");
                    ifn = true;
                } else {
                    if (!number.getText().toString().equals("0") && ifn) {
                        if (number.getText().toString().length() < 17)
                            number.setText(number.getText().toString() + "5");
                        else if (number.getText().toString().contains("-") && number.getText().toString().length() == 17) {
                            number.setText(number.getText().toString() + "5");
                        } else if (!number.getText().toString().contains("-") && number.getText().toString().indexOf(".") == 1 && number.getText().toString().substring(0, 1).contains("0") && number.getText().toString().length() == 17) {
                            number.setText(number.getText().toString() + "5");
                        } else if (number.getText().toString().contains("-") && number.getText().toString().indexOf(".") == 2 && number.getText().toString().substring(1, 2).contains("0") && number.getText().toString().length() == 18) {
                            number.setText(number.getText().toString() + "5");
                        }
                    } else {
                        number.setText("5");
                        ifn = true;
                        if (expression.getText().toString().contains("=")) {
                            expression.setText("");
                        }
                        int index = getindex();
                        if (index != 0)
                            expression.setText(expression.getText().toString().substring(0, index + 1));
                    }
                    setfsize();
                }
            }
        });
        n6.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view) {
                if (number.getText().toString().equals("無法除以零")||number.getText().toString().equals("無效的輸入")||number.getText().toString().equals("溢位")) {
                    setbutton(true);
                    number.setText("6");
                    expression.setText("");
                    ifn = true;
                } else {
                    if (!number.getText().toString().equals("0") && ifn) {
                        if (number.getText().toString().length() < 17)
                            number.setText(number.getText().toString() + "6");
                        else if (number.getText().toString().contains("-") && number.getText().toString().length() == 17) {
                            number.setText(number.getText().toString() + "6");
                        } else if (!number.getText().toString().contains("-") && number.getText().toString().indexOf(".") == 1 && number.getText().toString().substring(0, 1).contains("0") && number.getText().toString().length() == 17) {
                            number.setText(number.getText().toString() + "6");
                        } else if (number.getText().toString().contains("-") && number.getText().toString().indexOf(".") == 2 && number.getText().toString().substring(1, 2).contains("0") && number.getText().toString().length() == 18) {
                            number.setText(number.getText().toString() + "6");
                        }
                    } else {
                        number.setText("6");
                        ifn = true;
                        if (expression.getText().toString().contains("=")) {
                            expression.setText("");
                        }
                        int index = getindex();
                        if (index != 0)
                            expression.setText(expression.getText().toString().substring(0, index + 1));
                    }
                    setfsize();
                }
            }
        });
        n7.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view) {
                if (number.getText().toString().equals("無法除以零")||number.getText().toString().equals("無效的輸入")||number.getText().toString().equals("溢位")) {
                    setbutton(true);
                    number.setText("7");
                    expression.setText("");
                    ifn = true;
                } else {
                    if (!number.getText().toString().equals("0") && ifn) {
                        if (number.getText().toString().length() < 17)
                            number.setText(number.getText().toString() + "7");
                        else if (number.getText().toString().contains("-") && number.getText().toString().length() == 17) {
                            number.setText(number.getText().toString() + "7");
                        } else if (!number.getText().toString().contains("-") && number.getText().toString().indexOf(".") == 1 && number.getText().toString().substring(0, 1).contains("0") && number.getText().toString().length() == 17) {
                            number.setText(number.getText().toString() + "7");
                        } else if (number.getText().toString().contains("-") && number.getText().toString().indexOf(".") == 2 && number.getText().toString().substring(1, 2).contains("0") && number.getText().toString().length() == 18) {
                            number.setText(number.getText().toString() + "7");
                        }
                    } else {
                        number.setText("7");
                        ifn = true;
                        if (expression.getText().toString().contains("=")) {
                            expression.setText("");
                        }
                        int index = getindex();
                        if (index != 0)
                            expression.setText(expression.getText().toString().substring(0, index + 1));
                    }
                    setfsize();
                }
            }
        });
        n8.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                if(number.getText().toString().equals("無法除以零")||number.getText().toString().equals("無效的輸入")||number.getText().toString().equals("溢位")){
                    setbutton(true);
                    number.setText("8");
                    expression.setText("");
                    ifn = true;
                }else {
                    if (!number.getText().toString().equals("0") && ifn) {
                        if (number.getText().toString().length() < 17)
                            number.setText(number.getText().toString() + "8");
                        else if (number.getText().toString().contains("-") && number.getText().toString().length() == 17) {
                            number.setText(number.getText().toString() + "8");
                        } else if (!number.getText().toString().contains("-") && number.getText().toString().indexOf(".") == 1 && number.getText().toString().substring(0, 1).contains("0") && number.getText().toString().length() == 17) {
                            number.setText(number.getText().toString() + "8");
                        } else if (number.getText().toString().contains("-") && number.getText().toString().indexOf(".") == 2 && number.getText().toString().substring(1, 2).contains("0") && number.getText().toString().length() == 18) {
                            number.setText(number.getText().toString() + "8");
                        }
                    } else {
                        number.setText("8");
                        ifn = true;
                        if (expression.getText().toString().contains("=")) {
                            expression.setText("");
                        }
                        int index = getindex();
                        if (index != 0)
                            expression.setText(expression.getText().toString().substring(0, index + 1));
                    }
                    setfsize();
                }
            }
        });
        n9.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                if(number.getText().toString().equals("無法除以零")||number.getText().toString().equals("無效的輸入")||number.getText().toString().equals("溢位")){
                    setbutton(true);
                    number.setText("9");
                    expression.setText("");
                    ifn = true;
                }else {
                    if (!number.getText().toString().equals("0") && ifn) {
                        if (number.getText().toString().length() < 17)
                            number.setText(number.getText().toString() + "9");
                        else if (number.getText().toString().contains("-") && number.getText().toString().length() == 17) {
                            number.setText(number.getText().toString() + "9");
                        } else if (!number.getText().toString().contains("-") && number.getText().toString().indexOf(".") == 1 && number.getText().toString().substring(0, 1).contains("0") && number.getText().toString().length() == 17) {
                            number.setText(number.getText().toString() + "9");
                        } else if (number.getText().toString().contains("-") && number.getText().toString().indexOf(".") == 2 && number.getText().toString().substring(1, 2).contains("0") && number.getText().toString().length() == 18) {
                            number.setText(number.getText().toString() + "9");
                        }
                    } else {
                        number.setText("9");
                        ifn = true;
                        if (expression.getText().toString().contains("=")) {
                            expression.setText("");
                        }
                        int index = getindex();
                        if (index != 0)
                            expression.setText(expression.getText().toString().substring(0, index + 1));
                    }
                    setfsize();
                }
            }
        });
        dot.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                if(ifn){
                     if(!number.getText().toString().contains(".")) {
                         number.setText(number.getText().toString() + ".");
                     }
                }else {
                    number.setText("0.");
                    ifn = true;
                    if (expression.getText().toString().contains("=")) {
                        expression.setText("");
                    }
                    int index = getindex();
                    if (index != 0)
                        expression.setText(expression.getText().toString().substring(0, index + 1));
                }
                setfsize();
            }
        });
        percent.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                setbuttons(false);
                client.write(number.getText().toString()+"%");
                ifn=false;
            }
        });
        reciprocal.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                if(!expression.getText().toString().contains("=")) {
                    int index = getindex();
                    if (index != 0) {
                        if (index == expression.getText().toString().length() - 1)
                            expression.setText(expression.getText().toString().substring(0, index + 1) + "1/(" + number.getText().toString() + ")");
                        else
                            expression.setText(expression.getText().toString().substring(0, index + 1) + "1/(" + expression.getText().toString().substring(index + 1, expression.getText().toString().length()) + ")");
                    } else {
                        if (expression.getText().toString().equals("")||ifn)
                            expression.setText("1/(" + number.getText().toString() + ")");
                        else
                            expression.setText("1/(" + expression.getText().toString() + ")");
                    }
                }else{
                    expression.setText("1/(" + number.getText().toString() + ")");
                }
                setbuttons(false);
                client.write("1/("+number.getText().toString()+")");
                ifn=false;
            }
        });
        sqr.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                if(!expression.getText().toString().contains("=")) {
                    int index = getindex();
                    if (index != 0) {
                        if (index == expression.getText().toString().length() - 1)
                            expression.setText(expression.getText().toString().substring(0, index + 1) + "sqr(" + number.getText().toString() + ")");
                        else
                            expression.setText(expression.getText().toString().substring(0, index + 1) + "sqr(" + expression.getText().toString().substring(index + 1, expression.getText().toString().length()) + ")");
                    } else {
                        if (expression.getText().toString().equals("")||ifn)
                            expression.setText("sqr(" + number.getText().toString() + ")");
                        else
                            expression.setText("sqr(" + expression.getText().toString() + ")");
                    }
                }else{
                    expression.setText("sqr(" + number.getText().toString() + ")");
                }
                setbuttons(false);
                client.write("sqr("+number.getText().toString()+")");
                ifn=false;
            }
        });
        sqrt.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                if(!expression.getText().toString().contains("=")) {
                    int index = getindex();
                    if (index != 0) {
                        if (index == expression.getText().toString().length() - 1)
                            expression.setText(expression.getText().toString().substring(0, index + 1) + "√(" + number.getText().toString() + ")");
                        else
                            expression.setText(expression.getText().toString().substring(0, index + 1) + "√(" + expression.getText().toString().substring(index + 1, expression.getText().toString().length()) + ")");
                    } else {
                        if (expression.getText().toString().equals("")||ifn)
                            expression.setText("√(" + number.getText().toString() + ")");
                        else
                            expression.setText("√(" + expression.getText().toString() + ")");
                    }
                }else{
                    expression.setText("√(" + number.getText().toString() + ")");
                }
                setbuttons(false);
                client.write("√("+number.getText().toString()+")");
                ifn=false;
            }
        });
        pm.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                if(!expression.getText().toString().contains("=")) {
                    int index = getindex();
                    if (index != 0) {
                        if (index != expression.getText().toString().length() - 1) {
                            expression.setText(expression.getText().toString().substring(0, index + 1) + "negate(" + expression.getText().toString().substring(index + 1, expression.getText().toString().length()) + ")");
                        }
                    } else {
                        if (!expression.getText().toString().equals(""))
                            expression.setText("negate(" + expression.getText().toString() + ")");
                    }
                }else{
                    expression.setText("negate(" + number.getText().toString() + ")");
                }
                message = "negate("+number.getText().toString() + ")";
                setbuttons(false);
                client.write(message);
            }
        });
        X.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                if(number.getText().toString().equals("無法除以零")||number.getText().toString().equals("無效的輸入")||number.getText().toString().equals("溢位")){
                    setbutton(true);
                    expression.setText("");
                    number.setText("0");
                }
                if(ifn) {
                    message = number.getText().toString() + "X";
                    setbuttons(false);
                    client.write(message);
                }
            }
        });
        eql.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view) {
                if (number.getText().toString().equals("無法除以零")||number.getText().toString().equals("溢位")||number.getText().toString().equals("無效的輸入")) {
                    setbutton(true);
                    message = "0=";
                    if(number.getText().toString().equals("無法除以零")) {
                        expression.setText("0=");
                        setbuttons(false);
                        client.write(message);
                    }else {
                        expression.setText("");
                        setbuttons(false);
                        client.write(message);
                    }
                } else {
                    if (expression.getText().toString().contains("=") && (expression.getText().toString().indexOf("=") == expression.getText().toString().length() - 1)) {
                        int index = getindex();
                        message = "=";
                        if(index!=0)
                            expression.setText(number.getText().toString() + expression.getText().toString().substring(index, expression.getText().toString().length()));
                        else
                            expression.setText(number.getText().toString()+"=");
                    } else {
                        message = number.getText().toString() + "=";
                        int index = getindex();
                        if(index!=0)
                            expression.setText(expression.getText().toString().substring(0, index + 1) + number.getText().toString() + "=");
                        else {
                            expression.setText(number.getText().toString()+"=");
                        }
                    }
                    setbuttons(false);
                    client.write(message);
                    ifn=false;
                }

            }
        });
        C.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                if(number.getText().toString().equals("無法除以零")||number.getText().toString().equals("無效的輸入")||number.getText().toString().equals("溢位")){
                    setbutton(true);
                }
                message = "C";
                ifn=true;
                expression.setText("");
                client.write(message);
            }
        });
        CE.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                if(number.getText().toString().equals("無法除以零")||number.getText().toString().equals("無效的輸入")||number.getText().toString().equals("溢位")){
                    setbutton(true);
                    expression.setText("");
                }
                message = "CE";
                ifn=true;
                client.write(message);
            }
        });
    }
    public int getindex(){
        int index=0;
        if(expression.getText().toString().contains("+")){
            index=expression.getText().toString().indexOf("+");
        }else if(expression.getText().toString().contains("-")){
            index=expression.getText().toString().indexOf("-");
        }else if(expression.getText().toString().contains("×")){
            index=expression.getText().toString().indexOf("×");
        }else if(expression.getText().toString().contains("÷")){
            index=expression.getText().toString().indexOf("÷");
        }
        return index;
    }
    public void setfsize(){
        if(number.getText().toString().length()<11){
            number.setTextSize(60);
        }else if(number.getText().toString().length()<15){
            number.setTextSize(60-(number.getText().toString().length()-10)*4);
        }else{
            number.setTextSize(44-(number.getText().toString().length()-14)*2);
        }
    }
    public void setbutton(boolean torf){
        percent.setEnabled(torf);
        reciprocal.setEnabled(torf);
        sqr.setEnabled(torf);
        sqrt.setEnabled(torf);
        pm.setEnabled(torf);
        dot.setEnabled(torf);
        div.setEnabled(torf);
        min.setEnabled(torf);
        plus.setEnabled(torf);
        mul.setEnabled(torf);
    }
    public void setbuttons(boolean torf){
        percent.setEnabled(torf);
        CE.setEnabled(torf);
        C.setEnabled(torf);
        X.setEnabled(torf);
        n0.setEnabled(torf);
        n1.setEnabled(torf);
        n2.setEnabled(torf);
        n3.setEnabled(torf);
        n4.setEnabled(torf);
        n5.setEnabled(torf);
        n6.setEnabled(torf);
        n7.setEnabled(torf);
        n8.setEnabled(torf);
        n9.setEnabled(torf);
        reciprocal.setEnabled(torf);
        sqr.setEnabled(torf);
        sqrt.setEnabled(torf);
        pm.setEnabled(torf);
        dot.setEnabled(torf);
        div.setEnabled(torf);
        min.setEnabled(torf);
        plus.setEnabled(torf);
        mul.setEnabled(torf);
        eql.setEnabled(torf);
    }
    @Override
    protected void onDestroy(){
        client.write("***CLOSE***");
        client.loop=false;
        client.interrupt();
        finish();
        super.onDestroy();
    }
}