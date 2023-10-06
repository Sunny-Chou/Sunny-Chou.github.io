
import java.io.Serializable;
import java.util.LinkedList;
import java.util.Queue;

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */

/**
 *
 * @author Sunny
 */
public class keyword_product implements Serializable{
    private String keyword;
    private Queue<select_product> product=new LinkedList<select_product>();
    public keyword_product(String keyword,Queue<select_product> product){
        this.keyword=keyword;
        this.product=product;
    }
    public String getkeyword(){
        return keyword;
    }
    public Queue<select_product> getproduct(){
        return product;
    }
    public void setkeyword(String keyword){
        this.keyword=keyword;
    }
    public void setproduct(Queue<select_product> product){
        this.product=product;
    }
}
