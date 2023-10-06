package com.example.a8_02;

import android.widget.Button;
import android.widget.EditText;
import android.widget.ScrollView;
import android.widget.TextView;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintWriter;
import java.net.Socket;
import java.util.concurrent.BlockingDeque;
import java.util.concurrent.BlockingQueue;
import java.util.concurrent.LinkedBlockingQueue;
import java.util.logging.Level;
import java.util.logging.Logger;

public class RunClient extends Thread{
    ClientWin window;
    int port;
    String hostname;
    final BlockingQueue<String> queue=new LinkedBlockingQueue<String>();
    public BufferedReader reader;
    public PrintWriter writer;
    public Boolean loop;
    private boolean ifpercent=false;
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
    private Button disconnect;
    public RunClient(ClientWin win,String host,int port){
        this.window=win;
        this.port=port;
        this.hostname=host;
    }
    public void run(){
        percent=(Button) window.findViewById(R.id.percent);
        CE=(Button) window.findViewById(R.id.CE);
        C=(Button) window.findViewById(R.id.C);
        X=(Button) window.findViewById(R.id.X);
        reciprocal=(Button) window.findViewById(R.id.reciprocal);
        sqr=(Button) window.findViewById(R.id.sqr);
        sqrt=(Button) window.findViewById(R.id.sqrt);
        div=(Button) window.findViewById(R.id.div);
        n7=(Button) window.findViewById(R.id.n7);
        n8=(Button) window.findViewById(R.id.n8);
        n9=(Button) window.findViewById(R.id.n9);
        mul=(Button) window.findViewById(R.id.mul);
        n4=(Button) window.findViewById(R.id.n4);
        n5=(Button) window.findViewById(R.id.n5);
        n6=(Button) window.findViewById(R.id.n6);
        min=(Button) window.findViewById(R.id.min);
        n1=(Button) window.findViewById(R.id.n1);
        n2=(Button) window.findViewById(R.id.n2);
        n3=(Button) window.findViewById(R.id.n3);
        plus=(Button) window.findViewById(R.id.plus);
        pm=(Button) window.findViewById(R.id.pm);
        n0=(Button) window.findViewById(R.id.n0);
        dot=(Button) window.findViewById(R.id.dot);
        eql=(Button) window.findViewById(R.id.eql);
        disconnect=(Button) window.findViewById(R.id.disconnect);
        TextView number=window.findViewById(R.id.number);
        TextView expression=window.findViewById(R.id.expression);
        String response;
        try{
            Socket socket=new Socket(hostname,port);
            reader=new BufferedReader(new InputStreamReader(socket.getInputStream()));
            writer=new PrintWriter(socket.getOutputStream(),true);
            loop=true;
            while(loop){
                try{
                    String p=queue.take();
                    if(p.contains("%"))
                        ifpercent=true;
                    writer.println(p);
                }catch (InterruptedException e){
                }
                response=reader.readLine();
                response.trim();
                final String res=response;
                window.runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        number.setText(res);
                        if(expression.getText().toString().length()==1&&(expression.getText().toString().contains("+")||expression.getText().toString().contains("-")||expression.getText().toString().contains("×")||expression.getText().toString().contains("÷"))){
                            expression.setText(number.getText().toString()+expression.getText().toString());
                        }
                        window.setbuttons(true);
                        if(number.getText().toString().equals("無法除以零")||number.getText().toString().equals("溢位")||number.getText().toString().equals("無效的輸入")){
                            window.setbutton(false);
                        }
                        if(ifpercent){
                            ifpercent=false;
                            if(!expression.getText().toString().contains("=")) {
                                int index = 0;
                                if (expression.getText().toString().contains("+")) {
                                    index = expression.getText().toString().indexOf("+");
                                } else if (expression.getText().toString().contains("-")) {
                                    index = expression.getText().toString().indexOf("-");
                                } else if (expression.getText().toString().contains("×")) {
                                    index = expression.getText().toString().indexOf("×");
                                } else if (expression.getText().toString().contains("÷")) {
                                    index = expression.getText().toString().indexOf("÷");
                                }
                                if (index != 0) {
                                    expression.setText(expression.getText().toString().substring(0, index + 1) + number.getText().toString());
                                } else {
                                    expression.setText(number.getText().toString());
                                }
                            }else{
                                expression.setText(number.getText().toString());
                            }
                        }
                        window.setfsize();
                    }
                });
            }
            socket.close();
        }catch (IOException e){
            Logger.getLogger(RunClient.class.getName()).log(Level.SEVERE,null,e);
            window.finish();
        }
    }
    public void write(String message){
        queue.offer(message);
    }
}