package app17_18;
 import java.awt.*;
 import java.awt.event.*;
public class app {

	//variable
	static String s="DSG Calculator";
	static Frame frm=new Frame(s);
	static Panel pnl=new Panel(new GridLayout(3,3));//put1~9
	static Panel pnl1=new Panel(new GridLayout(4,1));//put+-X/
	static Label lab=new Label("0",Label.RIGHT);//result of calculation
	static Label lab2=new Label(s,Label.CENTER);
	static Font f=new Font(Font.SANS_SERIF,Font.BOLD,30);//font of + - X /
	static private double n[]= new double[2];//two operand waiting for operation
	static private int o=0;//how many operator is waiting for operation
	static private String op[]= {"+","+"};//two operator waiting for operation
	static private String lastop;//if user change the last operator
	static private String num;//to get the number when the user press the number buttons
	static private int top=-1;//the top of operands' stack
	static private int action=0;//The last button that was pressed
	static private boolean isdot=true;//to know if the dot button had been pressed
	//to show the result
	static private void result(double number) {
		if((int)number==number) {
			lab.setText(Integer.toString((int)number));
		}else {
			double n=Math.pow(10, 14-(int)Math.pow(number,0.1));//round the result
			number=Math.round(number*n)/n;
			lab.setText(Double.toString(number));
		}
	}
	//Compare the priority of two operators
	static private void operation(String[] op) {
		switch(op[0]) {
		case "+":
			switch(op[1]) {
			case "x":push(pop()*Double.parseDouble(num));break;
			case "/":push(pop()/Double.parseDouble(num));break;
			default:push(pop()+pop());push(Double.parseDouble(num));op[0]=op[1];break;
			}
			break;
		case "-":
			switch(op[1]) {
		    case "x":push(pop()*Double.parseDouble(num));break;
		    case "/":push(pop()/Double.parseDouble(num));break;
		    default:push(-pop()+pop());push(Double.parseDouble(num));op[0]=op[1];break;
			}
		break;
		case "x":push(pop()*pop());push(Double.parseDouble(num));op[0]=op[1];break;
		case "/":push(1/pop()*pop());push(Double.parseDouble(num));op[0]=op[1];break;
		}
		
	}
	//to pop the stack
	static private double pop() {
		if(top>=0) {
			return n[top--];
		}else {
			return 0;
		}
	}
	//to push item in the stack
	static private void push(double item) {
		if(++top<n.length) {
			n[top]=item;
		}else {
			top--;
		}
	}
	public static void main(String[] args) {
		// TODO Auto-generated method stub

		Click c=new Click();
		frm.addWindowListener(new WindowAdapter() {
			public void windowClosing(WindowEvent e) {System.exit(0);}
		});//to close the frame by clicking X
		//set frame
		frm.setLayout(null);
		frm.setSize(450,300);
		frm.setResizable(false);
		frm.setBackground(new Color(235,235,235));
		//set lab
		lab.setBounds(35,42,267,51);
		lab.setFont(new Font(Font.SERIF,Font.BOLD,30));
		lab.setBackground(Color.pink);
		//set lab2
		lab2.setBounds(321,42,100,51);
		lab2.setFont(new Font(Font.SERIF,Font.ITALIC+Font.BOLD,14));
		//set pnl & pnl1
		pnl.setBounds(35,103,186,120);
		pnl1.setBounds(240,103,62,160);
		//add 1~9 button in pnl
		Button[] bnumber=new Button[9];
		for(int i=1;i<=9;i++) {
			bnumber[i-1]=new Button(Integer.toString(i));
			bnumber[i-1].addActionListener(c);
			pnl.add(bnumber[i-1]);
		}
		
		pnl.setFont(new Font(Font.SERIF,Font.BOLD,20));
		//create + - X / button
		Button bplus=new Button("+");
		bplus.addActionListener(c);
		Button bminus=new Button("-");
		bminus.addActionListener(c);
		Button btimes=new Button("x");
		btimes.addActionListener(c);
		Button bdivide=new Button("/");
		bdivide.addActionListener(c);
		//add + - X / button in pnl1
		pnl1.add(bplus);
		pnl1.add(bminus);
		pnl1.add(btimes);
		pnl1.add(bdivide);
		pnl1.setForeground(Color.BLUE);
		pnl1.setFont(f);
		
		//create "0" button
		Button b0=new Button("0");
		b0.addActionListener(c);
		b0.setBounds(35,223,123,40);
		b0.setFont(new Font(Font.SERIF,Font.BOLD,20));
		//create "." button
		Button bdot=new Button(".");
		bdot.addActionListener(c);
		bdot.setBounds(159,223,62,40);
		bdot.setFont(new Font(Font.SERIF,Font.BOLD,20));
		//create = button
		Button bequal=new Button("=");
		bequal.addActionListener(c);
		bequal.setBounds(321,103,85,75);
		bequal.setForeground(Color.RED);
		bequal.setFont(new Font(Font.SANS_SERIF,Font.BOLD,32));

		//create clear button
		Button bclear=new Button("Clear");
		bclear.addActionListener(c);
		bclear.setBounds(321,188,85,75);
		bclear.setForeground(Color.RED);
		bclear.setFont(new Font(Font.SANS_SERIF,Font.BOLD,20));
		//add all in frame
		frm.add(lab);
		frm.add(lab2);
		frm.add(pnl);
		frm.add(pnl1);
		frm.add(b0);
		frm.add(bdot);
		frm.add(bequal);
		frm.add(bclear);
		frm.setVisible(true);
		
		}
	static class Click implements ActionListener{
		public void actionPerformed(ActionEvent e) {
			//to get the text of button
			switch(e.getActionCommand()) {
			case ".":
				//add a dot in lab and num if and only if the dot button hadn't been pressed
				if(isdot) {
					if(action==1) {
					
					    if(num.length()<14) {
						    lab.setText(lab.getText()+".");
						    num=num+".";
					    }
					
				    }else if(action==3){//foolproof
					    lab.setText(lab.getText()+"0.");
					    num="0.";
				    }else if(action==0) {//foolproof
					    lab.setText("0.");
					    num="0.";
				    }
				    action=2;
				    isdot=false;//mark that the dot have been pressed
				}
				
				break;
			case "+":
				
			case "-":
				
			case "x":
				
			case "/":
				
				if(action!=3) {
					lastop=lab.getText();//save the text of lab to avoid user change the last operator
					if(action==0) {//foolproof
						num="0";
						lab.setText(num);

					}else if(action==2) {//foolproof
						num=num+"0";
					}
					push(Double.parseDouble(num));
					
					if(o==2) {
						operation(op);
						o--;
					}
					
					op[o]=e.getActionCommand();
					lab.setText(lab.getText()+op[o++]);
				}else {
					//user change the operator
					op[--o]=e.getActionCommand();
					lab.setText(lastop+op[o++]);
				}
				action=3;
				isdot=true;
				break;
			case "=":
				//foolproof
				if(action!=3) {
					push(Double.parseDouble(num));
					
				}else {
					o--;
				}
				//Compare the priority of two operators if and only if there are two operator waiting for operation
				if(o==2) {
					operation(op);
					o--;
				}
				
				if(action==2) {//foolproof
					num=num+"0";
				}
				switch(op[0]) {//to do the last operation
				case "+":result(pop()+pop());o=0;break;
				case "-":result(-pop()+pop());o=0;break;
				case "x":result(pop()*pop());o=0;break;
				case "/":result(1/pop()*pop());o=0;break;
				}
				n[0]=0;//initialize
				op[0]="+";
				action=0;
				isdot=true;
				break;
			case "Clear":
				//initialize all things
				o=0;
				top=-1;
				lab.setText("0");
				n[0]=0;
				action=0;
				isdot=true;
				break;
				default:
					if(action==0) {//first press
						lab.setText(e.getActionCommand());
						num=e.getActionCommand();
					}else if(action==3){
						
						
						lab.setText(lab.getText()+e.getActionCommand());
						num=e.getActionCommand();//initial num
					}
					else {
						
						if(num.length()<15) {
							lab.setText(lab.getText()+e.getActionCommand());
							num=num+e.getActionCommand();//add num
						}
						
					}
					
					action=1;
					break;
			}
		}
	}
	

}
