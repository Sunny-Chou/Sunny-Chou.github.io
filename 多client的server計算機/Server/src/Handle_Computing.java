/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
import java.io.*;
import java.net.*;
import java.util.*;
import java.util.logging.Level;
import java.util.logging.Logger;
import java.lang.String;
import java.math.BigDecimal;
import java.math.MathContext;
/**
 *
 * @author Sunny
 */
public class Handle_Computing extends Thread{
    private Socket socket;
    private RunServer server;
    private ServerWin window;
    private int n;
    private int s=10000;
    public Handle_Computing(Socket socket,RunServer server,int n){
        this.socket=socket;
        this.server=server;
        this.n=n;
    }
    public void flow(BigDecimal n){
        if(Double.isInfinite(n.doubleValue()))
            throw new ArithmeticException("Overflow");
        if(n.compareTo(BigDecimal.ZERO)!=0&&n.doubleValue()==0)
            throw new ArithmeticException("Underflow");
    }
    public void run() {
        Scanner input = null;
        PrintWriter output = null;
        try {
            input = new Scanner(socket.getInputStream());
            output = new PrintWriter(socket.getOutputStream(), true);
            String message;
            BigDecimal a = BigDecimal.ZERO, b = BigDecimal.ZERO;
            int c = 0;
            String o = "";
            MathContext mc = new MathContext(s);
            do {
                message = input.nextLine();
                server.getWindow().gettxv().append("Client " + n + " sent: " + message + "\n");
                if (!message.equals("***CLOSE***")) {
                    try {
                        if (message.contains("(")) {
                            if (message.contains("sqr")) {
                                BigDecimal answer = new BigDecimal(message.substring(4, message.length() - 1));
                                answer = answer.pow(2);
                                flow(answer);
                                output.println(BigDecimal.valueOf(answer.doubleValue()).stripTrailingZeros());
                            } else if (message.contains("√")) {
                                BigDecimal answer = new BigDecimal(message.substring(2, message.length() - 1));
                                answer = answer.sqrt(mc);
                                flow(answer);
                                output.println(BigDecimal.valueOf(answer.doubleValue()).stripTrailingZeros());
                            } else if (message.contains("/")) {
                                BigDecimal answer = new BigDecimal(message.substring(3, message.length() - 1));
                                answer = BigDecimal.ONE.divide(answer,s,BigDecimal.ROUND_HALF_UP);
                                flow(answer);
                                output.println(BigDecimal.valueOf(answer.doubleValue()).stripTrailingZeros());
                            } else if (message.contains("negate")) {
                                BigDecimal answer = new BigDecimal(message.substring(7, message.length() - 1));
                                flow(answer);
                                output.println(BigDecimal.valueOf(answer.multiply(new BigDecimal(-1)).doubleValue()).stripTrailingZeros());
                            }
                        } else if (message.contains("+")) {
                            if (message.length() != 1) {
                                BigDecimal answer = new BigDecimal(message.substring(0, message.length() - 1));
                                if (c == 0) {
                                    a = answer;
                                    c++;
                                } else {
                                    b = answer;
                                    if (o.equals("+")) {
                                        a = a.add(b);
                                    } else if (o.equals("-")) {
                                        a = a.subtract(b);
                                    } else if (o.equals("×")) {
                                        a = a.multiply(b);
                                    } else if (o.equals("÷")) {
                                        a = a.divide(b,s,BigDecimal.ROUND_HALF_UP);
                                    }
                                }
                            }
                            flow(a);
                            output.println(BigDecimal.valueOf(a.doubleValue()).stripTrailingZeros());
                            o = "+";
                        } else if (message.contains("-")&&message.indexOf("-")==message.length()-1) {
                            if (message.length() != 1) {
                                BigDecimal answer = new BigDecimal(message.substring(0, message.length() - 1));
                                if (c == 0) {
                                    a = answer;
                                    c++;
                                } else {
                                    b = answer;
                                    if (o.equals("+")) {
                                        a = a.add(b);
                                    } else if (o.equals("-")) {
                                        a = a.subtract(b);
                                    } else if (o.equals("×")) {
                                        a = a.multiply(b);
                                    } else if (o.equals("÷")) {
                                        a = a.divide(b,s,BigDecimal.ROUND_HALF_UP);
                                    }
                                }
                            }
                            flow(a);
                            output.println(BigDecimal.valueOf(a.doubleValue()).stripTrailingZeros());
                            o = "-";
                        } else if (message.contains("×")) {
                            if (message.length() != 1) {
                                BigDecimal answer = new BigDecimal(message.substring(0, message.length() - 1));
                                if (c == 0) {
                                    a = answer;
                                    c++;
                                } else {
                                    b = answer;
                                    if (o.equals("+")) {
                                        a = a.add(b);
                                    } else if (o.equals("-")) {
                                        a = a.subtract(b);
                                    } else if (o.equals("×")) {
                                        a = a.multiply(b);
                                    } else if (o.equals("÷")) {
                                        a = a.divide(b,s,BigDecimal.ROUND_HALF_UP);
                                    }
                                }
                            }
                            flow(a);
                            output.println(BigDecimal.valueOf(a.doubleValue()).stripTrailingZeros());
                            o = "×";
                        } else if (message.contains("÷")) {
                            if (message.length() != 1) {
                                BigDecimal answer = new BigDecimal(message.substring(0, message.length() - 1));
                                if (c == 0) {
                                    a = answer;
                                    c++;
                                } else {
                                    b = answer;
                                    if (o.equals("+")) {
                                        a = a.add(b);
                                    } else if (o.equals("-")) {
                                        a = a.subtract(b);
                                    } else if (o.equals("×")) {
                                        a = a.multiply(b);
                                    } else if (o.equals("÷")) {
                                        a = a.divide(b,s,BigDecimal.ROUND_HALF_UP);
                                    }

                                }
                            }
                            flow(a);
                            output.println(BigDecimal.valueOf(a.doubleValue()).stripTrailingZeros());
                            o = "÷";
                        } else if (message.contains("%")) {
                            BigDecimal answer = new BigDecimal(message.substring(0, message.length() - 1));
                            if (o.equals("")) {
                                output.println("0");
                            } else if (o.equals("+") || o.equals("-")) {
                                answer=answer.multiply(a).divide(new BigDecimal(100));
                                flow(answer);
                                output.println(BigDecimal.valueOf(answer.doubleValue()).stripTrailingZeros());                      
                            } else {
                                answer=answer.divide(new BigDecimal(100));
                                flow(answer);
                                output.println(BigDecimal.valueOf(answer.doubleValue()).stripTrailingZeros());
                            }

                        } else if (message.contains("C")) {
                            c = 0;
                            a = BigDecimal.ZERO;
                            b = BigDecimal.ZERO;
                            o = "";
                            output.println("0");
                        } else if (message.contains("CE")) {
                            output.println("0");
                        } else if (message.contains("=")) {
                            if (!message.equals("=")) {
                                b = new BigDecimal(message.substring(0, message.length() - 1));
                                if (c == 1) {
                                    if (o.equals("+")) {
                                        a = a.add(b);
                                    } else if (o.equals("-")) {
                                        a = a.subtract(b);
                                    } else if (o.equals("×")) {
                                        a = a.multiply(b);
                                    } else if (o.equals("÷")) {
                                        a = a.divide(b,s,BigDecimal.ROUND_HALF_UP);
                                    }
                                    c--;
                                } else {
                                    a = b;
                                }
                                flow(a);
                                output.println(BigDecimal.valueOf(a.doubleValue()).stripTrailingZeros());
                            } else {
                                if (o.equals("+")) {
                                    a = a.add(b);
                                } else if (o.equals("-")) {
                                    a = a.subtract(b);
                                } else if (o.equals("×")) {
                                    a = a.multiply(b);
                                } else if (o.equals("÷")) {
                                    a = a.divide(b,s,BigDecimal.ROUND_HALF_UP);
                                }
                                flow(a);
                                output.println(BigDecimal.valueOf(a.doubleValue()).stripTrailingZeros());
                            }
                        } else if (message.contains("X")) {
                            if (message.length() == 2||(message.length()==3&&message.contains("-"))) {
                                output.println("0");
                            } else {
                                output.println(message.substring(0, message.length() - 2));
                            }
                        }

                    } catch (ArithmeticException e) {
                        if(e.getMessage().equals("Underflow")||e.getMessage().equals("Overflow")){
                            c = 0;
                            a = BigDecimal.ZERO;
                            b = BigDecimal.ZERO;
                            o = "";
                            output.println("溢位");
                        }else if(e.getMessage().contains("square root of negative")){
                            c = 0;
                            a = BigDecimal.ZERO;
                            b = BigDecimal.ZERO;
                            o = "";
                            output.println("無效的輸入");
                        }else if(e.getMessage().contains("divide by zero")){
                            c = 0;
                            a = BigDecimal.ZERO;
                            b = BigDecimal.ZERO;
                            o = "";
                            output.println("無法除以零");
                        }
                    }
                }
            }while(!message.equals("***CLOSE***"));
            
            server.getWindow().gettxv().append("Client "+n+" disconnected.\n");
        }catch(IOException ex){
            Logger.getLogger(Handle_Computing.class.getName()).log(Level.SEVERE,null,ex);
        }
    }
}
