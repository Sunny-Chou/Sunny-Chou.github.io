/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 */

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintWriter;
import java.net.InetAddress;
import java.net.Socket;
import java.net.SocketException;
import java.security.NoSuchAlgorithmException;
import java.util.Vector;
import javax.net.SocketFactory;
import javax.net.ssl.SSLContext;
import javax.net.ssl.SSLSocket;
import javax.net.ssl.SSLSocketFactory;

/**
 *
 * @author Sunny
 */
public class App extends Thread{
    final int port=25;
    private String smtp_jiami;
    private String email_addr;
    private String email_password;
    private int smtp_port;
    private String smtp_server;
    String[] msgs;
    String subject;
    String[]addrs;
    write wr;
    public App(String[] msgs,write wr,String subject,String[]addrs){
        this.msgs=msgs;
        this.email_addr=wr.getemail_addr();
        this.email_password=wr.getemail_password();
        this.smtp_port=wr.getsmtp_port();
        this.smtp_server=wr.getsmtp_server();
        this.smtp_jiami=wr.getsmtp_jiami();
        this.wr=wr;
        this.addrs=addrs;
        this.subject=subject;
    }
    public boolean sendCommandAndResultCheck(Socket smtp,BufferedReader smtp_in,PrintWriter smtp_out,String command,int success_code,String message)throws IOException{
        smtp_out.print(command+"\r\n");
        smtp_out.flush();
        System.out.println("send> "+command);
        return resultCheck(smtp,smtp_in,smtp_out,success_code,message);
    }
    public boolean resultCheck(Socket smtp,BufferedReader smtp_in,PrintWriter smtp_out,int success_code,String message)throws IOException{
        try{
        String res = smtp_in.readLine();
        System.out.println("recv> "+res);
        if(Integer.parseInt(res.substring(0,3))!=success_code){
            smtp.close();
            throw new RuntimeException(res);
        }
        return false;
        }catch(RuntimeException e){
            wr.getcmd().setText("訊息：執行"+message+"時發生錯誤");
            return true;
            
        }
    }

    public void send() throws IOException {
        try {
            Base64 b = new Base64();
            if (smtp_jiami.equals("STARTTLS")) {
                Socket smtp = new Socket(smtp_server, smtp_port);
                BufferedReader smtp_in = new BufferedReader(new InputStreamReader(smtp.getInputStream()));
                PrintWriter smtp_out = new PrintWriter(smtp.getOutputStream());
                String myname = email_addr.substring(email_addr.indexOf("@") + 1, email_addr.length());
                if (resultCheck(smtp, smtp_in, smtp_out, 220,"連線SMTP server")) {
                    throw new SocketException();
                }
                if (sendCommandAndResultCheck(smtp, smtp_in, smtp_out, "HELO " + myname, 250,"SMTP HELO")) {
                    throw new SocketException();
                }
                if (sendCommandAndResultCheck(smtp, smtp_in, smtp_out, "STARTTLS", 220,"SMTP STARTTLS")) {
                    throw new SocketException();
                }
                SSLContext sslContext = SSLContext.getDefault();
                SSLSocketFactory socketFactory = sslContext.getSocketFactory();
                SSLSocket smtp2 = (SSLSocket) socketFactory.createSocket(smtp, smtp_server, smtp_port, true);
                smtp_in = new BufferedReader(new InputStreamReader(smtp2.getInputStream()));
                smtp_out = new PrintWriter(smtp2.getOutputStream());
                if (sendCommandAndResultCheck(smtp2, smtp_in, smtp_out, "AUTH LOGIN", 334,"SMTP驗證")) {
                    throw new SocketException();
                }
                String id = b.encode(email_addr.getBytes());
                String p = b.encode(email_password.getBytes());
                auth(id, smtp2, smtp_in, smtp_out);
                auth(p, smtp2, smtp_in, smtp_out);
 
                if (sendCommandAndResultCheck(smtp2, smtp_in, smtp_out, "MAIL FROM:<" + email_addr + ">", 250, "將回信位址通知對方")) {
                    throw new SocketException();
                }
                for (int i = 0; i < addrs.length; i++) {
                    if (sendCommandAndResultCheck(smtp2, smtp_in, smtp_out, "RCPT TO:<" + addrs[i] + ">", 250, "指定郵件收信人")) {
                        throw new SocketException();
                    }
                }
                if (sendCommandAndResultCheck(smtp2, smtp_in, smtp_out, "DATA", 354, "通知郵件傳輸開始")) {
                    throw new SocketException();
                }
                smtp_out.print("Subject:" + subject + "\r\n");
                System.out.println("send> " + "Subject:" + subject);
                smtp_out.print("\r\n");
                for (int i = 0; i < msgs.length; i++) {
                    smtp_out.print(msgs[i] + "\r\n");
                    System.out.println("send> " + msgs[i]);
                }
                if (sendCommandAndResultCheck(smtp2, smtp_in, smtp_out, "", 250, "傳輸郵件")) {
                    throw new SocketException();
                }
                if (sendCommandAndResultCheck(smtp2, smtp_in, smtp_out, "QUIT", 221, "結束SMTP對話")) {
                    throw new SocketException();
                }
                smtp.close();
                wr.getcmd().setText("訊息：傳送信件成功");
            } else {
                Socket smtp;
                if (smtp_jiami.equals("SSL/TLS")) {
                    SSLSocketFactory sslSocketFactory = (SSLSocketFactory) SSLSocketFactory.getDefault();
                    smtp = (SSLSocket) sslSocketFactory.createSocket(smtp_server, smtp_port);
                } else {
                    smtp = new Socket(smtp_server, smtp_port);
                }
                BufferedReader smtp_in = new BufferedReader(new InputStreamReader(smtp.getInputStream()));
                PrintWriter smtp_out = new PrintWriter(smtp.getOutputStream());
                String myname = email_addr.substring(email_addr.indexOf("@") + 1, email_addr.length());
                if (resultCheck(smtp, smtp_in, smtp_out, 220, "連線SMTP server")) {
                    throw new SocketException();
                }
                if (sendCommandAndResultCheck(smtp, smtp_in, smtp_out, "HELO " + myname, 250, "SMTP HELO時出錯")) {
                    throw new SocketException();
                }
                if (sendCommandAndResultCheck(smtp, smtp_in, smtp_out, "AUTH LOGIN", 334,"SMTP驗證")) {
                    throw new SocketException();
                }
                String id = b.encode(email_addr.getBytes());
                String p = b.encode(email_password.getBytes());
                auth(id, smtp, smtp_in, smtp_out);
                auth(p, smtp, smtp_in, smtp_out);
                if (sendCommandAndResultCheck(smtp, smtp_in, smtp_out, "MAIL FROM:<" + email_addr + ">", 250, "將回信位址通知對方")) {
                    throw new SocketException();
                }
                for (int i = 0; i < addrs.length; i++) {
                    if (sendCommandAndResultCheck(smtp, smtp_in, smtp_out, "RCPT TO:<" + addrs[i] + ">", 250, "指定郵件收信人")) {
                        throw new SocketException();
                    }
                }
                if (sendCommandAndResultCheck(smtp, smtp_in, smtp_out, "DATA", 354, "通知郵件傳輸開始")) {
                    throw new SocketException();
                }
                smtp_out.print("Subject:" + subject + "\r\n");
                System.out.println("send> " + "Subject:" + subject);
                smtp_out.print("\r\n");
                for (int i = 0; i < msgs.length; i++) {
                    smtp_out.print(msgs[i] + "\r\n");
                    System.out.println("send> " + msgs[i]);
                }
                if (sendCommandAndResultCheck(smtp, smtp_in, smtp_out, "", 250, "傳輸郵件")) {
                    throw new SocketException();
                }
                if (sendCommandAndResultCheck(smtp, smtp_in, smtp_out, "QUIT", 221, "結束SMTP對話")) {
                    throw new SocketException();
                }
                smtp.close();
                wr.getcmd().setText("訊息：傳送信件成功");
            }
        } catch (NoSuchAlgorithmException | SocketException e) {

        }
    }

    public void mainproc() {
        if (addrs.length > 0) {
            try {
                send();
            } catch (IOException e) {
                e.printStackTrace();
            }
        } else {
            wr.getcmd().setText("收信人不能為空");
        }

    }
    public void auth(String s, Socket smtp, BufferedReader smtp_in, PrintWriter smtp_out) throws IOException {
        int response = 0;
        if (smtp_server != null) {
            smtp_out.write(s + "\r\n");
            smtp_out.flush();
            String res = smtp_in.readLine();
            System.out.println(res);
            try {
                if (Integer.parseInt(res.substring(0, 3)) == 50 || Integer.parseInt(res.substring(0, 3)) == 535) {
                    smtp.close();
                    throw new RuntimeException(res);
                }
            } catch (RuntimeException e) {
                wr.getcmd().setText("訊息：執行驗證輸入帳號或密碼時發生錯誤");
                throw new SocketException();
            }
        }
    }

    public void run() {
        mainproc();
    }
}
