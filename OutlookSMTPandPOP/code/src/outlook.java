
import java.awt.BorderLayout;
import java.awt.Desktop;
import java.awt.EventQueue;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import java.awt.event.WindowAdapter;
import java.awt.event.WindowEvent;
import java.io.BufferedReader;
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintStream;
import java.io.PrintWriter;
import java.io.UnsupportedEncodingException;
import java.net.Socket;
import java.nio.charset.StandardCharsets;
import java.nio.file.Files;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.LinkedList;
import java.util.Locale;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import javax.net.ssl.SSLSocket;
import javax.net.ssl.SSLSocketFactory;
import javax.swing.JFrame;
import javax.swing.JTextPane;
import javax.swing.text.html.HTMLEditorKit;
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/GUIForms/JFrame.java to edit this template
 */

/**
 *
 * @author Sunny
 */
public class outlook extends javax.swing.JFrame {

    /**
     * Creates new form outlook
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
    private LinkedList<Integer>no=new LinkedList<Integer>();
    private LinkedList<String>senders=new LinkedList<String>();
    private LinkedList<String>replyTos=new LinkedList<String>();
    private LinkedList<String>recipient=new LinkedList<String>();
    private LinkedList<String>dates=new LinkedList<String>();
    private LinkedList<String>subjects=new LinkedList<String>();
    private LinkedList<String>senderNames=new LinkedList<String>();
    private LinkedList<String>designate=new LinkedList<String>();
    private LinkedList<String>signers=new LinkedList<String>();
    private LinkedList<String>securitys=new LinkedList<String>();
    private mailmanage l;
    private int select=-1;
    public outlook(mailmanage l) {
        initComponents();
        try{
        PrintStream out = new PrintStream(System.out, true, "UTF-8");
        System.setOut(out);
        }catch(UnsupportedEncodingException e){
            
        }
        setDefaultCloseOperation(javax.swing.WindowConstants.DISPOSE_ON_CLOSE);
        addWindowListener(new java.awt.event.WindowAdapter() {
            @Override
            public void windowClosing(java.awt.event.WindowEvent windowEvent) {
                l.setalreadyget(true);
                dispose();
            }
        });
        
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
        int n=0;
        try{
            if(authorization())
                n=getmailnumber("LIST");
        }catch(IOException e){
            
        }
        
        String[]str=new String[12];
        SimpleDateFormat outputFormat = new SimpleDateFormat("yyyy年M月d日 EEEE ahh:mm", Locale.CHINESE);
        SimpleDateFormat inputFormat = new SimpleDateFormat("dd MMM yyyy HH:mm:ss Z", Locale.ENGLISH);
        for (int i = 1; i <= n; i++) {
            try {
                str = getLines("RETR " + i);
                subject.add(str[0]);
                mails.add(str[1]);
                htmlorplain.add(str[2]);
                no.add(i);
                senders.add(str[3]);
                replyTos.add(str[4]);
                recipient.add(str[5]);
                try {
                    int indexofdou = str[6].indexOf(",");
                    if (indexofdou >= 0) {
                        str[6]=str[6].substring(indexofdou + 1, str[6].length());
                    }
                    Date date = inputFormat.parse(str[6]);
                    String outputDate = outputFormat.format(date);
                    dates.add(outputDate);
                } catch (ParseException e) {
                    e.printStackTrace();
                }
                subjects.add(str[7]);
                senderNames.add(str[8]);
                designate.add(str[9]);
                signers.add(str[10]);
                securitys.add(str[11]);
            } catch (IOException ex) {
            }
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
                    if (mail.getSelectedIndex() >= 0) {
                        select = mail.getSelectedIndex();
                        content.setContentType(htmlorplain.get(mail.getSelectedIndex()));
                        Files.write(file.toPath(), mails.get(mail.getSelectedIndex()).getBytes());
                        Desktop.getDesktop().browse(file.toURI());
                        content.setText(mails.get(mail.getSelectedIndex()));
                        values.setModel(new javax.swing.DefaultComboBoxModel<>(new String[]{"寄件者：" + senders.get(mail.getSelectedIndex()) + "<" + senderNames.get(mail.getSelectedIndex()) + ">", "回覆至：" + replyTos.get(mail.getSelectedIndex()), "收件者：" + recipient.get(mail.getSelectedIndex()), "日期：" + dates.get(mail.getSelectedIndex()), "主旨：" + subjects.get(mail.getSelectedIndex()), "寄件人：" + designate.get(mail.getSelectedIndex()), "簽署者：" + signers.get(mail.getSelectedIndex()), "安全性：" + securitys.get(mail.getSelectedIndex())}));
                    }
                } catch (IOException ex) {
                    System.out.println(ex.getCause());
                }
            }
        });
        jScrollPane2.setViewportView(mail);
        
    }
    public String[] getLines(String command) throws IOException {
        boolean cont = true;
        String buf = null;
        pop_out.print(command + "\r\n");
        pop_out.flush();
        String res = pop_in.readLine();
        System.out.println(res);
        if (!("+OK".equals(res.substring(0, 3)))) {
            pop.close();
            throw new RuntimeException(res);
        }
        Base64 b = new Base64();
        boolean content = false;
        boolean qq=false;
        boolean qqs=false;
        boolean content2=false;
        boolean other=false;
        boolean other2=false;
        String mail="";
        String htmlorplain="text/plain";
        String all="";
        while (cont) {
            buf = pop_in.readLine();
            try {
                if (qq && "".equals(buf)) {
                    qqs = true;
                    qq = false;
                    mail = "";
                    all+="\n";
                } else if (buf.contains("Content-Type: ") && buf.indexOf(";") > buf.indexOf("Content-Type: ")) {
                    htmlorplain = buf.substring(buf.indexOf("Content-Type: ") + 14, buf.indexOf(";"));
                    all += buf+"\n";
                } else if (buf.contains("--") && qqs && !buf.contains("<!--") && !buf.contains("-->")) {
                    mail = needsDecoding(mail);
                    qqs = false;
                    all += mail + "\n";
                    all += buf + "\n";
                }else if(qqs){
                    mail+=buf + "\n";
                } else if (buf.toUpperCase().contains("?UTF-8?B?")) {
                    if (!buf.equals("") && Character.isWhitespace(buf.charAt(0))) {
                        //System.out.println("ttttttttttttt:" + buf);
                        buf = buf.trim();
                        int index = all.lastIndexOf("\n");
                        if (index != -1) {
                            all = all.substring(0, index);
                        }
                    }
                    String buf2=buf;
                    
                    while (buf2.toUpperCase().contains("?UTF-8?B?")) {
                        System.out.println(buf2);
                        int start;
                        if (buf2.contains("=?UTF-8?B?")) {
                            start = buf2.indexOf("=?UTF-8?B?");
                            buf2 = buf2.replace("=?UTF-8?B?", "");
                        } else if (buf2.contains("=?UTF-8?b?")) {
                            start = buf2.indexOf("=?UTF-8?b?");
                            buf2 = buf2.replace("=?UTF-8?b?", "");
                        } else if (buf2.contains("=?utf-8?b?")) {
                            start = buf2.indexOf("=?utf-8?b?");
                            buf2 = buf2.replace("=?utf-8?b?", "");
                        } else if (buf2.contains("=?utf-8?B?")) {
                            start = buf2.indexOf("=?utf-8?B?");
                            buf2 = buf2.replace("=?utf-8?B?", "");
                        }else if (buf2.contains("?UTF-8?B?")) {
                            start = buf2.indexOf("?UTF-8?B?");
                            buf2 = buf2.replace("?UTF-8?B?", "");
                        } else if (buf2.contains("?UTF-8?b?")) {
                            start = buf2.indexOf("?UTF-8?b?");
                            buf2 = buf2.replace("?UTF-8?b?", "");
                        } else if (buf2.contains("?utf-8?b?")) {
                            start = buf2.indexOf("?utf-8?b?");
                            buf2 = buf2.replace("?utf-8?b?", "");
                        } else if (buf2.contains("?utf-8?B?")) {
                            start = buf2.indexOf("?utf-8?B?");
                            buf2 = buf2.replace("?utf-8?B?", "");
                        }else{
                            start=0;
                        }
                        
                        int end = buf2.indexOf("?=");
                        buf2 = buf2.replace("?=", "");
                        String temp = buf2.substring(start, end);
                        temp = new String(b.decode(temp), StandardCharsets.UTF_8);
                        System.out.println("temp:"+temp);
                        buf2 = buf2.substring(0, start).trim() + temp.trim() + buf2.substring(end).trim();
                        
                    }
                    all += buf2 + "\n";
                } else if (buf.toLowerCase().contains("=?utf-8?q?")) {
                    if (!buf.equals("") && Character.isWhitespace(buf.charAt(0))) {
                        buf = buf.trim();
                        int index = all.lastIndexOf("\n");
                        if (index != -1) {
                            all = all.substring(0, index);
                        }
                    }
                    String buf2 = buf.replace("=?utf-8?q?", "");
                    buf2 = buf2.replace("=?UTF-8?q?", "");
                    buf2 = buf2.replace("=?UTF-8?Q?", "");
                    buf2 = buf2.replace("=?utf-8?Q?", "");
                    buf2 = buf2.replace("?utf-8?q?", "");
                    buf2 = buf2.replace("?UTF-8?q?", "");
                    buf2 = buf2.replace("?UTF-8?Q?", "");
                    buf2 = buf2.replace("?utf-8?Q?", "");
                    buf2 = buf2.replace("?= ", "");
                    buf2 = buf2.replace("?=", "");
                    all += needsDecoding(buf2) + "\n";
                }else if (buf.toLowerCase().contains("content-transfer-encoding: quoted-printable")) {
                    qq = true;
                    all+=buf+"\n";
                } else if (buf.toLowerCase().contains("content-transfer-encoding: base64")) {
                    content = true;
                    mail = "";
                    all+=buf+"\n";
                } else if(buf.toLowerCase().contains("content-transfer-encoding: ")){
                    other=true;
                    mail="";
                    all+=buf+"\n";
                }else if(other&&buf.equals("")){
                    other2=true;
                    other=false;
                    all+="\n";
                }else if(other2&&buf.contains("--")&&!buf.contains("<!--")&&!buf.contains("-->")){
                    other2=false;
                    all+=buf+"\n";
                }else if(other2){
                    mail+=buf+"\n";
                    all+=buf+"\n";
                }else if (buf.contains("--") && content2) {
                    content2 = false;
                    mail = new String(b.decode(mail), "UTF-8");
                    all+=mail+"\n";
                    all+=buf+"\n";
                }else if(content && buf.equals("")){
                    content2 = true;
                    content = false;
                    all+="\n";
                } else if (content2) {
                    mail += buf;
                } else {
                    if (!buf.equals("") && Character.isWhitespace(buf.charAt(0))) {
                        //System.out.println("ttttttttttttt:" + buf);
                        buf = buf.trim();
                        int index = all.lastIndexOf("\n");
                        if (index != -1) {
                            all = all.substring(0, index);
                        }
                    }
                    all += buf + "\n";
                }
            } catch (ArrayIndexOutOfBoundsException e) {
                all += buf + "\n";
            }
            if (".".equals(buf)) {
                cont = false;
                if(qqs){
                    mail=needsDecoding(mail);
                    all+=mail+"\n";
                }
                if(content2){
                    mail = new String(b.decode(mail), "UTF-8");
                    all+=mail+"\n";
                }
            }
        }
        String sender = extractEmailField(all, "\\r?\\nFrom:(.*?)\\r?\\n").trim();
        String replyTo = extractEmailField(all, "\\r?\\nReply-To:(.*?)\\r?\\n").trim();
        String recipients = extractEmailField(all, "\\r?\\nTo:(.*?)\\r?\\n").trim();
        String date = extractEmailField(all, "\\r?\\nDate: (.*?)\\r?\\n").trim();
        String subject = extractEmailField(all, "\\r?\\nSubject:(.*?)\\r?\\n").trim();
        String senderName = extractEmailField(all, "\\r?\\nFrom:.*?<(.*?)>").trim();
        String designates = extractEmailField(all, "@(.*?) designates").trim();
        String signer = extractEmailField(all, "i=@(.*?) ").trim();
        String security = extractEmailField(all, "\\(version=(.*?) ").trim();
        if(senderName.equals("")){
            senderName=sender;
            sender=sender.substring(0,sender.indexOf("@"));
        }else{
            sender=sender.substring(0,sender.indexOf("<"));
        }
        senderName=senderName.replaceAll("\"", "");
        sender=sender.replaceAll("\"", "");
        while (designates.contains("@")) {
            int indexat=designates.indexOf("@");
            designates = designates.substring(indexat+1);
        }
        System.out.println("Sender: " + sender);
        System.out.println("Reply-To: " + replyTo);
        System.out.println("Recipients: " + recipients);
        System.out.println("Date: " + date);
        System.out.println("Subject: " + subject);
        System.out.println("Sender Name: " + senderName);
        System.out.println("Designates: " + designates);
        System.out.println("Signer: " + signer);
        System.out.println("Security: " + security);
        if(mail.equals("")){
            String extractedField = extractEmailField(all, "\\r?\\n\\r?\\n([\\s\\S]*)");
            mail = extractedField;
        }
        String[] r = {sender + "    " + subject, mail, htmlorplain,sender,replyTo,recipients,date,subject,senderName,designates,signer,security};
        return r;
    }
    private static String extractEmailField(String emailText, String patternString) {
        Pattern pattern = Pattern.compile(patternString);
        Matcher matcher = pattern.matcher(emailText);
        if (matcher.find()) {
            return matcher.group(1);
        }
        return "";
    }
    public int getmailnumber(String command) throws IOException {
        boolean cont = true;
        String buf = null;
        pop_out.print(command + "\r\n");
        pop_out.flush();
        String res = pop_in.readLine();
        System.out.println(res);
        if (!("+OK".equals(res.substring(0, 3)))) {
            pop.close();
            throw new RuntimeException(res);
        }
        int i=0;
        while (cont) {
            buf = pop_in.readLine();
            System.out.println(buf);
            i++;
            if (".".equals(buf)) {
                cont = false;
            }
        }
        return i - 1;
    }

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

    public String needsDecoding(String str) throws UnsupportedEncodingException {
        if (str == null) {
            return "";
        }
        try {
            String str2 = str.replaceAll("=\n", "");
            boolean un=true;
            while(str2.length()>=3){
                int start=str2.indexOf("=");
                if(start==-1||start>str2.length()-3){
                    break;
                }
                try {
                    int u = Character.digit(str2.charAt(start + 1), 16);
                    int l = Character.digit(str2.charAt(start + 2), 16);
                    if (!(u == -1 || l == -1)) {
                        if (u < 10) {
                            //System.out.println("ˋ這串是" + str2.charAt(start + 1) + str2.charAt(start + 2));
                            if (u != 5 || l != 15) {
                                un = true;
                                break;
                            }
                        }
                    }else{
                        un=false;
                    }
                } catch (ArrayIndexOutOfBoundsException e) {
                }
                str2 = str2.substring(start + 3, str2.length());
            }
            str = str.replaceAll("=\n", "");
            byte[] bytes;
            if(un)
            bytes= str.getBytes("UTF-8");
            else
                bytes= str.getBytes("big5");
            /*if(un){
            for (int i = 0; i < bytes.length; i++) {
                byte b = bytes[i];
                if (b != 95) {
                    bytes[i] = b;
                } else {
                    bytes[i] = 32;
                }
            }
            }*/
            if (bytes == null) {
                return "";
            }
            ByteArrayOutputStream buffer = new ByteArrayOutputStream();
            for (int i = 0; i < bytes.length; i++) {
                int b = bytes[i];
                if (b == '=') {
                    try {
                        int u = Character.digit((char) bytes[++i], 16);
                        int l = Character.digit((char) bytes[++i], 16);
                        if (u == -1 || l == -1) {
                            buffer.write(b);
                            continue;
                        }
                        if(!un&&u==5&&l==15){
                            buffer.write(b);
                            continue;
                        }
                        buffer.write((char) ((u << 4) + l));
                    } catch (ArrayIndexOutOfBoundsException e) {
                    }
                } else {
                    buffer.write(b);
                }
            }
            if (un) {
                return new String(buffer.toByteArray(), "UTF-8");
            }
            else{
                return new String(buffer.toByteArray(), "big5");
            }
        
        } catch (Exception e) {
            return "";
        }

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
    /**
     * This method is called from within the constructor to initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is always
     * regenerated by the Form Editor.
     */
    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        jScrollPane2 = new javax.swing.JScrollPane();
        mail = new javax.swing.JList<>();
        jScrollPane3 = new javax.swing.JScrollPane();
        content = new javax.swing.JEditorPane();
        writemail = new javax.swing.JButton();
        reply = new javax.swing.JButton();
        forward = new javax.swing.JButton();
        delete = new javax.swing.JButton();
        getmail = new javax.swing.JButton();
        cmd = new javax.swing.JLabel();
        values = new javax.swing.JComboBox<>();

        setDefaultCloseOperation(javax.swing.WindowConstants.EXIT_ON_CLOSE);

        mail.setModel(new javax.swing.AbstractListModel<String>() {
            String[] strings = { "Item 1", "Item 2", "Item 3", "Item 4", "Item 5" };
            public int getSize() { return strings.length; }
            public String getElementAt(int i) { return strings[i]; }
        });
        jScrollPane2.setViewportView(mail);

        jScrollPane3.setViewportView(content);

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

        getmail.setText("收信");
        getmail.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                getmailActionPerformed(evt);
            }
        });

        cmd.setHorizontalAlignment(javax.swing.SwingConstants.CENTER);
        cmd.setText("jLabel1");

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(javax.swing.GroupLayout.Alignment.TRAILING, layout.createSequentialGroup()
                .addComponent(jScrollPane2, javax.swing.GroupLayout.PREFERRED_SIZE, 219, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING, false)
                    .addGroup(layout.createSequentialGroup()
                        .addComponent(writemail)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(reply)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(forward)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(delete)
                        .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                        .addComponent(getmail))
                    .addComponent(jScrollPane3, javax.swing.GroupLayout.DEFAULT_SIZE, 489, Short.MAX_VALUE)
                    .addComponent(cmd, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                    .addComponent(values, 0, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
                .addContainerGap())
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addContainerGap()
                .addComponent(values, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(jScrollPane3, javax.swing.GroupLayout.PREFERRED_SIZE, 382, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addComponent(cmd)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addGroup(layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(reply)
                    .addComponent(forward)
                    .addComponent(delete)
                    .addComponent(getmail)
                    .addComponent(writemail)))
            .addComponent(jScrollPane2, javax.swing.GroupLayout.PREFERRED_SIZE, 480, javax.swing.GroupLayout.PREFERRED_SIZE)
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

    private void writemailActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_writemailActionPerformed
        // TODO add your handling code here:
        if (l.getalreadywrite()) {
            l.setalreadywrite(false);
            new write(l).setVisible(true);
        }else {
            cmd.setText("已經打開寫信視窗了");
        }
    }//GEN-LAST:event_writemailActionPerformed

    private void deleteActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_deleteActionPerformed
        // TODO add your handling code here:
        try{
            if(select!=-1){
            authorization();
            int selectindex = select+1;
            getSingleLine("DELE " + selectindex);
            update();
            subject.remove(select);
            mails.remove(select);
            htmlorplain.remove(select);
            no.remove(select);
            senders.remove(select);
            replyTos.remove(select);
            recipient.remove(select);
            dates.remove(select);
            subjects.remove(select);
            senderNames.remove(select);
            designate.remove(select);
            signers.remove(select);
            securitys.remove(select);
            mail.setModel(new javax.swing.AbstractListModel<String>() {
                public int getSize() {
                    return subject.size();
                }

                public String getElementAt(int i) {
                    return subject.get(i);
                }
            });

            select=-1;
            cmd.setText("刪除成功！");
            }else{
                cmd.setText("請先選擇哪一封信");
            }
        } catch (IOException e) {

        }
    }//GEN-LAST:event_deleteActionPerformed

    private void forwardActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_forwardActionPerformed
        // TODO add your handling code here:
        if (l.getalreadywrite()&&select!=-1) {
            l.setalreadywrite(false);
            new forward(l, senderNames.get(select), senders.get(select), recipient.get(select), dates.get(select), subjects.get(select), mails.get(select)).setVisible(true);
            cmd.setText("");
        }else {
            if (!l.getalreadywrite()) {
                cmd.setText("已經打開寫信視窗了");
            }else{
                cmd.setText("請先選擇哪一封信");
            }
        }
    }//GEN-LAST:event_forwardActionPerformed

    private void replyActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_replyActionPerformed
        // TODO add your handling code here:
        if (l.getalreadywrite()&&select!=-1) {
            l.setalreadywrite(false);
            new reply(l, senderNames.get(select), senders.get(select), dates.get(select), subjects.get(select), mails.get(select), replyTos.get(select)).setVisible(true);
            cmd.setText("");
        }else {
            if (!l.getalreadywrite()) {
                cmd.setText("已經打開寫信視窗了");
            }else{
                cmd.setText("請先選擇哪一封信");
            }
        }
    }//GEN-LAST:event_replyActionPerformed

    private void getmailActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_getmailActionPerformed
        // TODO add your handling code here:
        try {
            if (select != -1) {
                authorization();
                int selectindex = no.get(select);
                getSingleLine("RETR " + selectindex);
                update();
                LinkedList<String> temp = l.getmails();
                temp.add(mails.get(select));
                l.setmails(temp);
                temp = l.getsubject();
                temp.add(subject.get(select));
                l.setsubject(temp);
                temp = l.gethtmlorplain();
                temp.add(htmlorplain.get(select));
                l.sethtmlorplain(temp);
                temp = l.getsenders();
                temp.add(senders.get(select));
                l.setsenders(temp);
                temp = l.getreplyTos();
                temp.add(replyTos.get(select));
                l.setreplyTos(temp);
                temp = l.getrecipient();
                temp.add(recipient.get(select));
                l.setrecipient(temp);
                temp = l.getdates();
                temp.add(dates.get(select));
                l.setdates(temp);
                temp = l.getsubjects();
                temp.add(subjects.get(select));
                l.setsubjects(temp);
                temp = l.getsenderNames();
                temp.add(senderNames.get(select));
                l.setsenderNames(temp);
                temp = l.getdesignate();
                temp.add(designate.get(select));
                l.setdesignate(temp);
                temp = l.getsigners();
                temp.add(signers.get(select));
                l.setsigners(temp);
                temp = l.getsecuritys();
                temp.add(securitys.get(select));
                l.setsecuritys(temp);
                javax.swing.JList<String> temp2 = l.getmail();
                javax.swing.JEditorPane temp3 = l.getcontent();
                l.setselect(-1);
                temp2.setModel(new javax.swing.AbstractListModel<String>() {
                    public int getSize() {
                        return l.getsubject().size();
                    }

                    public String getElementAt(int i) {
                        return l.getsubject().get(i);
                    }
                });
                HTMLEditorKit kit = new HTMLEditorKit();
                temp3.setEditorKit(kit);
                javax.swing.text.Document doc = kit.createDefaultDocument();
                temp3.setDocument(doc);
                temp3.setEditable(false);
                javax.swing.JComboBox<String> temp4=l.getvalues();
                l.setvalues(temp4);
                subject.remove(select);
                mails.remove(select);
                htmlorplain.remove(select);
                no.remove(select);
                senders.remove(select);
                replyTos.remove(select);
                recipient.remove(select);
                dates.remove(select);
                subjects.remove(select);
                senderNames.remove(select);
                designate.remove(select);
                signers.remove(select);
                securitys.remove(select);
                mail.setModel(new javax.swing.AbstractListModel<String>() {
                    public int getSize() {
                        return subject.size();
                    }

                    public String getElementAt(int i) {
                        return subject.get(i);
                    }
                });
                
                select = -1;
                cmd.setText("收信成功！");
            } else {
                cmd.setText("請先選擇哪一封信");
            }
        } catch (IOException e) {

        }

    }//GEN-LAST:event_getmailActionPerformed

    /**
     * @param args the command line arguments
     */

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JLabel cmd;
    private javax.swing.JEditorPane content;
    private javax.swing.JButton delete;
    private javax.swing.JButton forward;
    private javax.swing.JButton getmail;
    private javax.swing.JScrollPane jScrollPane2;
    private javax.swing.JScrollPane jScrollPane3;
    private javax.swing.JList<String> mail;
    private javax.swing.JButton reply;
    private javax.swing.JComboBox<String> values;
    private javax.swing.JButton writemail;
    // End of variables declaration//GEN-END:variables
}
