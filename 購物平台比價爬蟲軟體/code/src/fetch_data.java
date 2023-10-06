
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.ObjectOutputStream;
import java.util.Iterator;
import java.util.LinkedList;
import java.util.Queue;
import org.htmlunit.BrowserVersion;
import org.htmlunit.ScriptException;
import org.htmlunit.WebClient;
import org.htmlunit.html.HtmlPage;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */

/**
 *
 * @author Sunny
 */
public class fetch_data extends Thread{
    private String pchome="https://ecshweb.pchome.com.tw/search/v3.3/?q=";
    private String momo="https://www.momoshop.com.tw/search/searchShop.jsp?keyword=";
    private String keyword;
    private window win;
    private Queue<select_product> select=new LinkedList<select_product>();
    public fetch_data(String keyword,window win){
        pchome=pchome+keyword;
        momo=momo+keyword;
        this.keyword=keyword;
        this.win=win;
    }
    private static String loadAndExecuteJs(String url) throws IOException{
        WebClient webClient=new WebClient(BrowserVersion.CHROME);
        webClient.getOptions().setCssEnabled(false);
        webClient.getOptions().setJavaScriptEnabled(true);
        webClient.getOptions().setThrowExceptionOnScriptError(false);
        webClient.getOptions().setTimeout(10000);
        webClient.getOptions().setUseInsecureSSL(true);
        HtmlPage page=webClient.getPage(url);
        webClient.getCurrentWindow().setInnerHeight(3000);
        webClient.waitForBackgroundJavaScript(10000);
        String html = page.asXml();
        webClient.close();
        return html;
    }
    private void parsing(String content,String content2)throws IOException{
        try{
        Document document=Jsoup.parse(content);
        Elements items=document.select("#ItemContainer dl");
        String name="";
        String picture="";
        String link="";
        String price="";
        Queue<select_product> all=new LinkedList<select_product>();
        for(int i=0;i<items.size();i++){
            Element item=items.get(i);
            String tempname=item.select(".prod_name").text();
            String temppicture=item.select(".prod_img > img").attr("src");
            String templink=item.select(".prod_name > a").attr("href");
            String tempprice=item.select(".price").text();
            if(!tempname.equals("")){
                name=tempname;
            }
            if(!temppicture.equals("")){
                picture=temppicture;
            }
            if(!templink.equals("")){
                link=templink;
            }
            if(!tempprice.equals("")){
                price=tempprice;
            }
            if(!name.equals("")&&!picture.equals("")&&!link.equals("")&&!price.equals("")){
                select_product s=new select_product(name,picture,link,Integer.parseInt(price.substring(2,price.length())));
                name="";
                picture="";
                link="";
                price="";
                all.add(s);
            }
        }
        Document document2=Jsoup.parse(content2);
        
        Elements items2=document2.select(".clearfix > li");
        name="";
        picture="";
        link="";
        price="";
        for(int i=0;i<items2.size();i++){
            Element item=items2.get(i);
            String tempname=item.select(".prdName").text();
            String temppicture=item.select(".swiper-slide > img").attr("src");
            String templink=item.select(".goodsUrl").attr("href");
            String tempprice=item.select(".price").text();
            if(!tempname.equals("")){
                name=tempname;
            }
            if(!temppicture.equals("")){
                picture=temppicture;
            }
            if(!templink.equals("")){
                link=templink;
            }
            if(!tempprice.equals("")){
                price=tempprice;
            }
            if(!name.equals("")&&!picture.equals("")&&!link.equals("")&&!price.equals("")){
                String[] pp=price.split(",");
                price="";
                for(int k=0;k<pp.length;k++){
                    price+=pp[k];
                }
                select_product s=new select_product(name,picture.substring(6,picture.length()),"//www.momoshop.com.tw"+link,Integer.parseInt(price.substring(2,price.length())));
                name="";
                picture="";
                link="";
                price="";
                all.add(s);
            }
        }
        for(int j=0;j<30;j++){
            if(all.isEmpty()){
                break;
            }
            int min=Integer.MAX_VALUE;
            Iterator it = all.iterator();
            select_product ssp=(select_product)it.next();
            select_product sp=ssp;
            while(true){
                int p=sp.getprice();
                if(p<min){
                    min=p;
                    ssp=sp;
                }
                if(!it.hasNext())
                    break;
                sp=(select_product)it.next();
            }
            select.add(ssp);
            all.remove(ssp);
        }
        }catch(ScriptException e){
            
        }
    }
    public void run(){
        try{
            String pc = loadAndExecuteJs(pchome);
            String mo = loadAndExecuteJs(momo);
            if (pc != null || mo != null) {
                parsing(pc, mo);
            }
            keyword_product kp = new keyword_product(keyword, select);
            Queue<keyword_product> kpq = win.getbest_results();
            kpq.add(kp);
            win.setbest_results(kpq);
            FileOutputStream fout = new FileOutputStream("best_results.dat");
            ObjectOutputStream oos = new ObjectOutputStream(fout);
            oos.writeObject(kpq);
            oos.close();
            win.setselect_kp(kp);
        } catch (IOException e) {
            System.out.println(e.getCause());
        }
    }
}
