
import java.io.Serializable;

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */

/**
 *
 * @author Sunny
 */
public class select_product implements Serializable{
    private String name;
    private String link;
    private String picture;
    private int price;
    public select_product(String name,String picture,String link,int price){
        this.name=name;
        this.picture=picture;
        this.link=link;
        this.price=price;
    }
    public select_product(){
        
    }
    public String getname(){
        return name;
    }
    public String getpicture(){
        return picture;
    }
    public String getlink(){
        return link;
    }
    public int getprice(){
        return price;
    }
    public void setname(String name){
        this.name=name;
    }
    public void setpicture(String picture){
        this.picture=picture;
    }
    public void setlink(String link){
        this.link=link;
    }
    public void setprice(int price){
        this.price=price;
    }
}
