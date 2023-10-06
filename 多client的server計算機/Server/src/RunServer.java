/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
import java.io.*;
import java.net.*;
import java.util.*;
import java.util.logging.Level;
import java.util.logging.Logger;
/**
 *
 * @author Sunny
 */
public class RunServer extends Thread{
    private ServerWin window;
    private ServerSocket server_socket;
    private int port;
    public RunServer(int port,ServerWin win)throws IOException{
        this.port=port;
        this.window=win;
        server_socket=new ServerSocket(port);
    }
    public void run(){
        Socket socket;
        window.gettxv().setText("Server is running\n");
        while(true){
            try{
                socket=server_socket.accept();
                int n=window.setn();
                window.gettxv().append("Client "+n+" connected.\n");
                new Handle_Computing(socket,this,n).start();
            }catch(IOException ex){
                Logger.getLogger(RunServer.class.getName()).log(Level.SEVERE,null,ex);
            }
            
        }
        
    }
    public ServerWin getWindow(){
        return this.window;
    }
}
