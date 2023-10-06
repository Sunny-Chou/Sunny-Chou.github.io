
import java.util.Vector;

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/GUIForms/JFrame.java to edit this template
 */

/**
 *
 * @author Sunny
 */
public class forward extends javax.swing.JFrame {
    private String smtp_jiami;
    private String email_addr;
    private String email_password;
    private int smtp_port;
    private String smtp_server;
    private mailmanage o;
    private String senderName;
    private String sender;
    private String recipient;
    private String date;
    private String originsubject;
    private String mails;
    /**
     * Creates new form forward
     */
    public forward(mailmanage o,String senderName,String sender,String recipient,String date,String originsubject,String mails) {
        initComponents();
        setDefaultCloseOperation(javax.swing.WindowConstants.DISPOSE_ON_CLOSE);
        addWindowListener(new java.awt.event.WindowAdapter() {
            @Override
            public void windowClosing(java.awt.event.WindowEvent windowEvent) {
                o.setalreadywrite(true);
                dispose();
            }
        });
        cmd.setText("");
        this.email_addr=o.getemail_addr();
        this.email_password=o.getemail_password();
        this.smtp_port=o.getsmtp_port();
        this.smtp_server=o.getsmtp_server();
        this.smtp_jiami=o.getsmtp_jiami();
        this.o=o;
        this.senderName=senderName;
        this.sender=sender;
        this.recipient=recipient;
        this.date=date;
        this.originsubject=originsubject;
        this.mails=mails;
        subject.setText("Fwd:"+originsubject);
    }

    /**
     * This method is called from within the constructor to initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is always
     * regenerated by the Form Editor.
     */
    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        jLabel1 = new javax.swing.JLabel();
        addr = new javax.swing.JTextField();
        jScrollPane1 = new javax.swing.JScrollPane();
        msgs = new javax.swing.JTextArea();
        subject = new javax.swing.JTextField();
        jLabel2 = new javax.swing.JLabel();
        jLabel3 = new javax.swing.JLabel();
        send = new javax.swing.JButton();
        cmd = new javax.swing.JLabel();

        setDefaultCloseOperation(javax.swing.WindowConstants.EXIT_ON_CLOSE);

        jLabel1.setHorizontalAlignment(javax.swing.SwingConstants.TRAILING);
        jLabel1.setText("收信人：");

        addr.setText("sunny52333325@gmail.com");

        msgs.setColumns(20);
        msgs.setRows(5);
        jScrollPane1.setViewportView(msgs);

        jLabel2.setHorizontalAlignment(javax.swing.SwingConstants.TRAILING);
        jLabel2.setText("標題：");

        jLabel3.setHorizontalAlignment(javax.swing.SwingConstants.TRAILING);
        jLabel3.setText("轉寄新增信件內容：");

        send.setText("送出");
        send.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                sendActionPerformed(evt);
            }
        });

        cmd.setText("jLabel4");

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addGap(23, 23, 23)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.TRAILING)
                    .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING, false)
                        .addComponent(jLabel1, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                        .addComponent(jLabel2, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
                    .addComponent(jLabel3))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING, false)
                    .addGroup(layout.createSequentialGroup()
                        .addComponent(send)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                        .addComponent(cmd, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
                    .addComponent(subject)
                    .addComponent(jScrollPane1, javax.swing.GroupLayout.DEFAULT_SIZE, 520, Short.MAX_VALUE)
                    .addComponent(addr))
                .addContainerGap(63, Short.MAX_VALUE))
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addGap(45, 45, 45)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(addr, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addComponent(jLabel1))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(subject, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addComponent(jLabel2))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                    .addComponent(jLabel3)
                    .addComponent(jScrollPane1, javax.swing.GroupLayout.PREFERRED_SIZE, 329, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(send)
                    .addComponent(cmd))
                .addContainerGap(13, Short.MAX_VALUE))
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

    private void sendActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_sendActionPerformed
        // TODO add your handling code here:
        String[] m=msgs.getText().toString().split("\n");
        String buf="";
        boolean cont = true;
        Vector msgs_list=new Vector();
        String[] msg=null;
        
        try{
            msgs_list.addElement("<div dir=\"ltr\">");
            for(int i=0;i<m.length;i++){
                buf=m[i];
                msgs_list.addElement(buf+"<br>");
            }
            if(sender.equals("")){
                msgs_list.addElement("<br><br><div class=\"gmail_quote\"><div dir=\"ltr\" class=\"gmail_attr\">---------- Forwarded message ---------<br>寄件者： <span dir=\"auto\">&lt;<a href=\"mailto:"+senderName+"\">"+senderName+"</a>&gt;</span><br>");
            }else{
                msgs_list.addElement("<br><br><div class=\"gmail_quote\"><div dir=\"ltr\" class=\"gmail_attr\">---------- Forwarded message ---------<br>寄件者： <span dir=\"auto\"><a href=\"mailto:"+senderName+"\">"+sender+"&lt;"+senderName+"&gt;</a></span><br>");
            }
            msgs_list.add("Date: "+date+"<br>");
            msgs_list.add("Subject: "+originsubject+"<br>");
            msgs_list.add("To: "+recipient+"<br></div><br><br>");
            msgs_list.add(mails+"<br></div></div>");
            msgs_list.addElement(".");
            msg=new String[msgs_list.size()];
            msgs_list.copyInto(msg);
        }catch(Exception e){
            e.printStackTrace();
            System.exit(1);
        }
        String[] addrs=addr.getText().toString().split(",");
        new App2(msg,this,subject.getText(),addrs).start();
    }//GEN-LAST:event_sendActionPerformed
    public String getemail_addr(){
        return email_addr;
    }
    public String getemail_password(){
        return email_password;
    }
    public int getsmtp_port(){
        return smtp_port;
    }
    public String getsmtp_server(){
        return smtp_server;
    }
    public String getsmtp_jiami(){
        return smtp_jiami;
    }
    public javax.swing.JLabel getcmd(){
        return cmd;
    }
    /**
     * @param args the command line arguments
     */

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JTextField addr;
    private javax.swing.JLabel cmd;
    private javax.swing.JLabel jLabel1;
    private javax.swing.JLabel jLabel2;
    private javax.swing.JLabel jLabel3;
    private javax.swing.JScrollPane jScrollPane1;
    private javax.swing.JTextArea msgs;
    private javax.swing.JButton send;
    private javax.swing.JTextField subject;
    // End of variables declaration//GEN-END:variables
}