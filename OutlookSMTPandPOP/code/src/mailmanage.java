
import java.awt.Desktop;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.io.PrintWriter;
import java.net.Socket;
import java.nio.file.Files;
import java.util.LinkedList;
import javax.net.ssl.SSLSocket;
import javax.net.ssl.SSLSocketFactory;
import javax.swing.text.html.HTMLEditorKit;

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/GUIForms/JFrame.java to edit this template
 */

/**
 *
 * @author Sunny
 */
public class mailmanage extends javax.swing.JFrame {

    /**
     * Creates new form mailmanage
     */
    
    private String smtp_jiami;
    private String pop_jiami;
    private String email_addr;
    private String email_password;
    private int pop_port;
    private String pop_server;
    private BufferedReader pop_in;
    private PrintWriter pop_out;
    private Socket pop;
    private int smtp_port;
    private String smtp_server;
    private BufferedReader smtp_in;
    private PrintWriter smtp_out;
    private Socket smtp;
    private LinkedList<String>mails=new LinkedList<String>();
    private LinkedList<String>subject=new LinkedList<String>();
    private LinkedList<String>htmlorplain=new LinkedList<String>();
    private LinkedList<String>senders=new LinkedList<String>();
    private LinkedList<String>replyTos=new LinkedList<String>();
    private LinkedList<String>recipient=new LinkedList<String>();
    private LinkedList<String>dates=new LinkedList<String>();
    private LinkedList<String>subjects=new LinkedList<String>();
    private LinkedList<String>senderNames=new LinkedList<String>();
    private LinkedList<String>designate=new LinkedList<String>();
    private LinkedList<String>signers=new LinkedList<String>();
    private LinkedList<String>securitys = new LinkedList<String>();
    private LinkedList<String>save_mails=new LinkedList<String>();
    private LinkedList<String>save_subject=new LinkedList<String>();
    private LinkedList<String>save_htmlorplain=new LinkedList<String>();
    private LinkedList<String>save_senders=new LinkedList<String>();
    private LinkedList<String>save_replyTos=new LinkedList<String>();
    private LinkedList<String>save_recipient=new LinkedList<String>();
    private LinkedList<String>save_dates=new LinkedList<String>();
    private LinkedList<String>save_subjects=new LinkedList<String>();
    private LinkedList<String>save_senderNames=new LinkedList<String>();
    private LinkedList<String>save_designate=new LinkedList<String>();
    private LinkedList<String>save_signers=new LinkedList<String>();
    private LinkedList<String>save_securitys = new LinkedList<String>();
    private int select=-1;
    private login l;
    private boolean alreadywrite=true;
    private boolean alreadyget=true;
    public mailmanage(login l) {
        initComponents();
        cmd.setText("");
        this.l=l;
        this.email_addr=l.getemail_addr();
        this.email_password=l.getemail_password();
        this.pop_port=l.getpop_port();
        this.pop_server=l.getpop_server();
        this.smtp_port=l.getsmtp_port();
        this.smtp_server=l.getsmtp_server();
        this.smtp_jiami=l.getsmtp_jiami();
        this.pop_jiami=l.getpop_jiami();
        try{
        FileInputStream fin = new FileInputStream("mails.dat");
        ObjectInputStream ois = new ObjectInputStream(fin);
        mails = (LinkedList) ois.readObject();
        subject=(LinkedList) ois.readObject();
        htmlorplain=(LinkedList) ois.readObject();
        senders=(LinkedList) ois.readObject();
        replyTos=(LinkedList) ois.readObject();
        recipient=(LinkedList) ois.readObject();
        dates=(LinkedList) ois.readObject();
        subjects=(LinkedList) ois.readObject();
        senderNames=(LinkedList) ois.readObject();
        designate=(LinkedList) ois.readObject();
        signers=(LinkedList) ois.readObject();
        securitys =(LinkedList) ois.readObject();
        ois.close();
        fin = new FileInputStream("mails.dat");
        ois = new ObjectInputStream(fin);
        save_mails = (LinkedList) ois.readObject();
        save_subject=(LinkedList) ois.readObject();
        save_htmlorplain=(LinkedList) ois.readObject();
        save_senders=(LinkedList) ois.readObject();
        save_replyTos=(LinkedList) ois.readObject();
        save_recipient=(LinkedList) ois.readObject();
        save_dates=(LinkedList) ois.readObject();
        save_subjects=(LinkedList) ois.readObject();
        save_senderNames=(LinkedList) ois.readObject();
        save_designate=(LinkedList) ois.readObject();
        save_signers=(LinkedList) ois.readObject();
        save_securitys=(LinkedList) ois.readObject();
        ois.close();
        }catch(IOException|ClassNotFoundException e){
            
        }
        mail.setModel(new javax.swing.AbstractListModel<String>() {

            public int getSize() {
                return subject.size();
            }

            public String getElementAt(int i) {
                return subject.get(i);
            }
        });
        HTMLEditorKit kit = new HTMLEditorKit();
        content.setEditorKit(kit);
        javax.swing.text.Document doc = kit.createDefaultDocument();
        content.setDocument(doc);
        content.setEditable(false);
        mail.addMouseListener(new MouseAdapter() {
            @Override
            public void mouseClicked(MouseEvent e) {
                File file = new File("mail.html");
                try {
                    if(mail.getSelectedIndex()>=0){
                        select=mail.getSelectedIndex();
                        content.setContentType(htmlorplain.get(mail.getSelectedIndex()));
                        Files.write(file.toPath(), mails.get(mail.getSelectedIndex()).getBytes());
                        Desktop.getDesktop().browse(file.toURI());
                        content.setText(mails.get(mail.getSelectedIndex()));
                        values.setModel(new javax.swing.DefaultComboBoxModel<>(new String[] { "寄件者："+senders.get(mail.getSelectedIndex())+"<"+senderNames.get(mail.getSelectedIndex())+">","回覆至："+replyTos.get(mail.getSelectedIndex()) ,"收件者："+recipient.get(mail.getSelectedIndex()), "日期："+dates.get(mail.getSelectedIndex()), "主旨："+subjects.get(mail.getSelectedIndex()),"寄件人："+designate.get(mail.getSelectedIndex()),"簽署者："+signers.get(mail.getSelectedIndex()),"安全性："+securitys.get(mail.getSelectedIndex())}));
                    }
                } catch (IOException ex) {
                    System.out.println(ex.getCause());
                }
            }
        });
        jScrollPane3.setViewportView(mail);
        jScrollPane4.setViewportView(content);

    }

    /**
     * This method is called from within the constructor to initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is always
     * regenerated by the Form Editor.
     */
    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        writemail = new javax.swing.JButton();
        reply = new javax.swing.JButton();
        forward = new javax.swing.JButton();
        delete = new javax.swing.JButton();
        getmail = new javax.swing.JButton();
        save = new javax.swing.JButton();
        cmd = new javax.swing.JLabel();
        jScrollPane3 = new javax.swing.JScrollPane();
        mail = new javax.swing.JList<>();
        jScrollPane4 = new javax.swing.JScrollPane();
        content = new javax.swing.JEditorPane();
        values = new javax.swing.JComboBox<>();

        setDefaultCloseOperation(javax.swing.WindowConstants.EXIT_ON_CLOSE);

        writemail.setText("寫信");
        writemail.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                writemailActionPerformed(evt);
            }
        });

        reply.setText("回覆");
        reply.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                replyActionPerformed(evt);
            }
        });

        forward.setText("轉寄");
        forward.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                forwardActionPerformed(evt);
            }
        });

        delete.setText("刪除");
        delete.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                deleteActionPerformed(evt);
            }
        });

        getmail.setText("查詢信件");
        getmail.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                getmailActionPerformed(evt);
            }
        });

        save.setText("儲存");
        save.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                saveActionPerformed(evt);
            }
        });

        cmd.setHorizontalAlignment(javax.swing.SwingConstants.CENTER);
        cmd.setText("jLabel1");

        mail.setModel(new javax.swing.AbstractListModel<String>() {
            String[] strings = { "Item 1", "Item 2", "Item 3", "Item 4", "Item 5" };
            public int getSize() { return strings.length; }
            public String getElementAt(int i) { return strings[i]; }
        });
        jScrollPane3.setViewportView(mail);

        jScrollPane4.setViewportView(content);

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addComponent(jScrollPane3, javax.swing.GroupLayout.PREFERRED_SIZE, 219, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING, false)
                    .addComponent(cmd, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                    .addGroup(layout.createSequentialGroup()
                        .addComponent(writemail)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(reply)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(forward)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(delete)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(save)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(getmail))
                    .addComponent(jScrollPane4, javax.swing.GroupLayout.DEFAULT_SIZE, 489, Short.MAX_VALUE)
                    .addComponent(values, 0, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
                .addContainerGap(javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addContainerGap()
                .addComponent(values, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(jScrollPane4, javax.swing.GroupLayout.PREFERRED_SIZE, 401, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(cmd)
                .addGap(7, 7, 7)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(writemail)
                    .addComponent(reply)
                    .addComponent(forward)
                    .addComponent(delete)
                    .addComponent(getmail)
                    .addComponent(save))
                .addContainerGap(javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
            .addComponent(jScrollPane3, javax.swing.GroupLayout.PREFERRED_SIZE, 495, javax.swing.GroupLayout.PREFERRED_SIZE)
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

    private void writemailActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_writemailActionPerformed
        // TODO add your handling code here:
        if (alreadywrite) {
            alreadywrite = false;
            new write(this).setVisible(true);
            cmd.setText("");
        }else {
            cmd.setText("已經打開寫信視窗了");
        }
    }//GEN-LAST:event_writemailActionPerformed

    private void replyActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_replyActionPerformed
        // TODO add your handling code here:
        if (alreadywrite&&select != -1) {
            alreadywrite = false;
            new reply(this,senderNames.get(select),senders.get(select),dates.get(select),subjects.get(select),mails.get(select),replyTos.get(select)).setVisible(true);
            cmd.setText("");
        }else {
            if (!alreadywrite) {
                cmd.setText("已經打開寫信視窗了");
            }else{
                cmd.setText("請先選擇哪一封信");
            }
        }
    }//GEN-LAST:event_replyActionPerformed

    private void forwardActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_forwardActionPerformed
        // TODO add your handling code here:
        if (alreadywrite&&select != -1) {
            alreadywrite = false;
            new forward(this, senderNames.get(select), senders.get(select), recipient.get(select), dates.get(select), subjects.get(select), mails.get(select)).setVisible(true);
            cmd.setText("");
        } else {
            if (!alreadywrite) {
                cmd.setText("已經打開寫信視窗了");
            }else{
                cmd.setText("請先選擇哪一封信");
            }
        }
    }//GEN-LAST:event_forwardActionPerformed

    private void deleteActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_deleteActionPerformed
        // TODO add your handling code here:
        if (select != -1) {
            boolean ifc = false;
            int index=0;
            for (; index < save_mails.size(); index++) {
                if (save_mails.get(index).equals(mails.get(select)) && save_subject.get(index).equals(subject.get(select)) && save_htmlorplain.get(index).equals(htmlorplain.get(select)) && save_senders.get(index).equals(senders.get(select)) && save_replyTos.get(index).equals(replyTos.get(select)) && save_recipient.get(index).equals(recipient.get(select)) && save_dates.get(index).equals(dates.get(select)) && save_subjects.get(index).equals(subjects.get(select)) && save_senderNames.get(index).equals(senderNames.get(select)) && save_designate.get(index).equals(designate.get(select)) && save_signers.get(index).equals(signers.get(select)) && save_securitys.get(index).equals(securitys.get(select))) {
                    ifc = true;
                    break;
                }
            }
            subject.remove(select);
            mails.remove(select);
            htmlorplain.remove(select);
            senders.remove(select);
            replyTos.remove(select);
            recipient.remove(select);
            dates.remove(select);
            subjects.remove(select);
            senderNames.remove(select);
            designate.remove(select);
            signers.remove(select);
            securitys.remove(select);
            if (ifc) {
                save_subject.remove(index);
                save_mails.remove(index);
                save_htmlorplain.remove(index);
                save_senders.remove(index);
                save_replyTos.remove(index);
                save_recipient.remove(index);
                save_dates.remove(index);
                save_subjects.remove(index);
                save_senderNames.remove(index);
                save_designate.remove(index);
                save_signers.remove(index);
                save_securitys.remove(index);
                try {
                    FileOutputStream fout = new FileOutputStream("mails.dat");
                    ObjectOutputStream oos = new ObjectOutputStream(fout);
                    oos.writeObject(save_mails);
                    oos.writeObject(save_subject);
                    oos.writeObject(save_htmlorplain);
                    oos.writeObject(save_senders);
                    oos.writeObject(save_replyTos);
                    oos.writeObject(save_recipient);
                    oos.writeObject(save_dates);
                    oos.writeObject(save_subjects);
                    oos.writeObject(save_senderNames);
                    oos.writeObject(save_designate);
                    oos.writeObject(save_signers);
                    oos.writeObject(save_securitys);

                } catch (IOException e) {

                }
            }
            cmd.setText("刪除成功！");
            mail.setModel(new javax.swing.AbstractListModel<String>() {
                public int getSize() {
                    return subject.size();
                }

                public String getElementAt(int i) {
                    return subject.get(i);
                }
            });

            select = -1;
        }else{
            cmd.setText("請先選擇哪一封信");
        }
    }//GEN-LAST:event_deleteActionPerformed

    private void getmailActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_getmailActionPerformed
        // TODO add your handling code here:
        if (alreadyget) {
            new outlook(this).setVisible(true);
            alreadyget=false;
            cmd.setText("");
        }else{
            cmd.setText("已經打開收信視窗了");
        }
    }//GEN-LAST:event_getmailActionPerformed

    private void saveActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_saveActionPerformed
        // TODO add your handling code here:
        if (select != -1) {
            boolean ifc = true;
            for (int i = 0; i < save_mails.size(); i++) {
                if (save_mails.get(i).equals(mails.get(select)) && save_subject.get(i).equals(subject.get(select)) && save_htmlorplain.get(i).equals(htmlorplain.get(select)) && save_senders.get(i).equals(senders.get(select)) && save_replyTos.get(i).equals(replyTos.get(select)) && save_recipient.get(i).equals(recipient.get(select)) && save_dates.get(i).equals(dates.get(select)) && save_subjects.get(i).equals(subjects.get(select)) && save_senderNames.get(i).equals(senderNames.get(select)) && save_designate.get(i).equals(designate.get(select)) && save_signers.get(i).equals(signers.get(select)) && save_securitys.get(i).equals(securitys.get(select))) {
                    ifc = false;
                    cmd.setText("已儲存過了");
                    break;
                }
            }
            if (ifc) {
                save_mails.add(mails.get(select));
                save_subject.add(subject.get(select));
                save_htmlorplain.add(htmlorplain.get(select));
                save_senders.add(senders.get(select));
                save_replyTos.add(replyTos.get(select));
                save_recipient.add(recipient.get(select));
                save_dates.add(dates.get(select));
                save_subjects.add(subjects.get(select));
                save_senderNames.add(senderNames.get(select));
                save_designate.add(designate.get(select));
                save_signers.add(signers.get(select));
                save_securitys.add(securitys.get(select));
                try {
                    FileOutputStream fout = new FileOutputStream("mails.dat");
                    ObjectOutputStream oos = new ObjectOutputStream(fout);
                    oos.writeObject(save_mails);
                    oos.writeObject(save_subject);
                    oos.writeObject(save_htmlorplain);
                    oos.writeObject(save_senders);
                    oos.writeObject(save_replyTos);
                    oos.writeObject(save_recipient);
                    oos.writeObject(save_dates);
                    oos.writeObject(save_subjects);
                    oos.writeObject(save_senderNames);
                    oos.writeObject(save_designate);
                    oos.writeObject(save_signers);
                    oos.writeObject(save_securitys);
                    cmd.setText("儲存成功！");
                } catch (IOException e) {

                }
            }
        }else{
            cmd.setText("請先選擇哪一封信");
        }
    }//GEN-LAST:event_saveActionPerformed

    public boolean getSingleLine(String command) throws IOException {
        pop_out.print(command + "\r\n");
        pop_out.flush();
        System.out.println(command);
        String res = pop_in.readLine();
        System.out.println(res);
        if (!("+OK".equals(res.substring(0, 3)))) {
            pop.close();
            return true;
        }
        return false;
    }

    public boolean authorization() throws IOException {
        if (pop_jiami.equals("STARTTLS")) {
            pop = new Socket(pop_server, pop_port);
            pop_in = new BufferedReader(new InputStreamReader(pop.getInputStream()));
            pop_out = new PrintWriter(pop.getOutputStream());
            String res = pop_in.readLine();
            System.out.println("res> " + res);
            if (!("+OK".equals(res.substring(0, 3)))) {
                pop.close();
                return false;
            }
            if (getSingleLine("USER " + email_addr)) {
                pop.close();
                return false;
            }
            if (getSingleLine("PASS " + email_password)) {
                pop.close();
                return false;
            }
            if (getSingleLine("STLS")) {
                pop.close();
                return false;
            }
            return true;
        } else {
            if (pop_jiami.equals("SSL/TLS")) {
                SSLSocketFactory sslSocketFactory = (SSLSocketFactory) SSLSocketFactory.getDefault();
                pop = (SSLSocket) sslSocketFactory.createSocket(pop_server, pop_port);
            } else {
                pop = new Socket(pop_server, pop_port);
            }
            pop_in = new BufferedReader(new InputStreamReader(pop.getInputStream()));
            pop_out = new PrintWriter(pop.getOutputStream());
            String res = pop_in.readLine();
            System.out.println("res> " + res);
            if (!("+OK".equals(res.substring(0, 3)))) {
                pop.close();
                return false;
            }
            if (getSingleLine("USER " + email_addr)) {
                return false;
            }
            if (getSingleLine("PASS " + email_password)) {
                return false;
            }
            return true;
        }
    }

    public void update() throws IOException {
        getSingleLine("QUIT");
        pop.close();
    }
    public String getemail_addr(){
        return email_addr;
    }
    public String getemail_password(){
        return email_password;
    }
    public int getpop_port(){
        return pop_port;
    }
    public String getpop_server(){
        return pop_server;
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
    public String getpop_jiami(){
        return pop_jiami;
    }
    public void setalreadywrite(boolean alreadywrite){
        this.alreadywrite=alreadywrite;
    }
    public boolean getalreadywrite(){
        return alreadywrite;
    }
    public void setalreadyget(boolean alreadyget){
        this.alreadyget=alreadyget;
    }
    public boolean getalreadyget(){
        return alreadyget;
    }
    public javax.swing.JList<String> getmail(){
        return mail;
    }
    public LinkedList<String>getmails(){
        return mails;
    }
    public LinkedList<String>getsubject(){
        return subject;
    }
    public LinkedList<String>gethtmlorplain(){
        return htmlorplain;
    }
    public LinkedList<String>getsenders(){
        return senders;
    }
    public LinkedList<String>getreplyTos(){
        return replyTos;
    }
    public LinkedList<String>getrecipient(){
        return recipient;
    }
    public LinkedList<String>getdates(){
        return dates;
    }
    public LinkedList<String>getsubjects(){
        return subjects;
    }
    public LinkedList<String>getsenderNames(){
        return senderNames;
    }
    public LinkedList<String>getdesignate(){
        return designate;
    }
    public LinkedList<String>getsigners(){
        return signers;
    }
    public LinkedList<String>getsecuritys(){
        return securitys;
    }
    public void setmail(javax.swing.JList<String> mail){
        this.mail=mail;
    }
    public void setmails(LinkedList<String> mails){
        this.mails=mails;
    }
    public void setsubject(LinkedList<String>subject){
        this.subject=subject;
    }
    public void sethtmlorplain(LinkedList<String>htmlorplain){
        this.htmlorplain=htmlorplain;
    }
    public void setsenders(LinkedList<String>senders){
        this.senders=senders;
    }
    public void setreplyTos(LinkedList<String> replyTos){
        this.replyTos=replyTos;
    }
    public void setrecipient(LinkedList<String> recipient){
        this.recipient=recipient;
    }
    public void setdates(LinkedList<String>dates){
        this.dates=dates;
    }
    public void setsubjects(LinkedList<String> subjects){
        this.subjects=subjects;
    }
    public void setsenderNames(LinkedList<String>senderNames){
        this.senderNames=senderNames;
    }
    public void setdesignate(LinkedList<String>designate){
        this.designate=designate;
    }
    public void setsigners(LinkedList<String>signers){
        this.signers=signers;
    }
    public void setsecuritys(LinkedList<String>securitys){
        this.securitys=securitys;
    }
    public javax.swing.JEditorPane getcontent(){
        return content;
    }
    public void setcontent(javax.swing.JEditorPane content){
        this.content=content;
    }
    public void setselect(int select){
        this.select=select;
    }
    public void setvalues(javax.swing.JComboBox<String> values){
        this.values=values;
    }
    public javax.swing.JComboBox<String> getvalues(){
        return values;
    }
    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JLabel cmd;
    private javax.swing.JEditorPane content;
    private javax.swing.JButton delete;
    private javax.swing.JButton forward;
    private javax.swing.JButton getmail;
    private javax.swing.JScrollPane jScrollPane3;
    private javax.swing.JScrollPane jScrollPane4;
    private javax.swing.JList<String> mail;
    private javax.swing.JButton reply;
    private javax.swing.JButton save;
    private javax.swing.JComboBox<String> values;
    private javax.swing.JButton writemail;
    // End of variables declaration//GEN-END:variables
}
